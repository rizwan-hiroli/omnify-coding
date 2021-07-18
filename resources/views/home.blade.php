@extends('layouts.app')
@push('styles')
    <link href="/admin/vendor/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="/admin/vendor/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">
    <style type="text/css">
        .btn-circle.btn-xl {
          width: 200px;
          height: 200px;
          padding: 10px 16px;
          font-size: 50px;
          line-height: 1.33;
          border-radius: 100px;
        }
    </style>
@endpush
@php
    $payload = [];
@endphp

@section('content')
    	
@endsection

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script src="/admin/vendor/fullcalendar/dist/fullcalendar.min.js"></script>
    <script type="text/javascript">
        
        //Adding colors to caleder button.
        // $('.fc-prev-button').css('color','white');
        // $('.fc-prev-button').css('background-color','#169F85');
        // $('.fc-next-button').css('color','white');
        // $('.fc-next-button').css('background-color','#169F85');
         
    </script>
@endpush