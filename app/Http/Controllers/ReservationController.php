<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Reservation;
use App\Models\RestrictionSetting;
use App\Models\User;
use \Carbon\Carbon;

class ReservationController extends Controller
{    
    /*
        Form rules to validate reservations
    */
    protected $rules = [
                        'user_ids'=>'required',
                        'date'=>'required|date',
                        ];

    /*
        Form rules to validate settings
    */
    protected $settingRules = [
        'n'=>'required|integer',
        'd'=>'required|in:day,week,year',
        'g'=>'required|in:individual,group',
        'tz'=>'required|max:255',
    ];

    /**
     * book reservations
     *
     * @return void
    */
    public function index()
    {
        return view('reservation');
    }

    /**
     * get all users for booking
     *
     * @param Request $request
     * @return void
    */
    public function getUsers(Request $request)
    {
        $searchTerm = $request->search;
        $users = User::select('name as text','id')->where('name', 'LIKE', "%{$searchTerm}%")->get()->toArray();
        return response()->json(['results'=>$users]);
    }
   
    /**
     *  Add new reservations 
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            $response['result'] = 'validation-error';
            $response['messages'] = $validator->errors()->toArray();
            return response()->json($response);
        }
        $userIds = $request->user_ids;
        $date = Carbon::parse($request->date)->timestamp;
        $reservations = Reservation::where('reservation_timestamp_utc',$date)
                                    ->whereIn('user_id',$userIds)->pluck('user_id')
                                    ->toArray();

        if(empty($reservations)){
            return response()->json($this->addReservations($userIds,$date));
        }else{
            return response()->json($this->getRestrictedUsers($userIds,$reservations));
        }
    }

    /**
     * funtction to ad new reservations
     *
     * @param [type] $userIds - all users to be reserved
     * @param [type] $date - date of booking.
     * @return void
    */
    protected function addReservations($userIds,$date)
    {
        $data = [];
        foreach($userIds as $key => $userId){
            $data[$key]['user_id'] = $userId;
            $data[$key]['reservation_timestamp_utc'] = $date; 
        }
        $reservationInserted = Reservation::insert($data);
        
        if($reservationInserted)
            $response = ['result'=>'success','message'=>'Reservation added sucessfully'];
        else
            $response = ['result'=>'failure','message'=>'Something went wrong'];

        return $response;
    }

    /**
     * function to get user that cannot book reservations
     *
     * @param [type] $userIds - list of all users
     * @param [type] $reservations - list of booked users
     * @return void
    */
    protected function getRestrictedUsers($userIds,$reservations)
    {
        $bookedUsers = array_intersect($userIds,$reservations);
        $response['result'] = 'failure';
        $response['message'] = 'Booking cannot processed for few users.';
        $response['data']['is_booking_restricted'] = true;
        $response['data']['restricted_user_ids'] = $bookedUsers;
        return $response;
    }

    /**
     * function to update reservation settings
     *
     * @param Request $request
     * @return void
    */
    public function addReservationSetting(Request $request)
    {
        $validator = Validator::make($request->all(), $this->settingRules);
        if($validator->fails()){
            $response['result'] = 'validation-error';
            $response['messages'] = $validator->errors()->toArray();
            return response()->json($response);
        }

        $result = RestrictionSetting::pluck('id')->first();        
        RestrictionSetting::whereId($result)->update($request->except('_token'));
        return response()->json(['result'=>'success','message'=>'Settings updated sucessfully.']);
    }

}
