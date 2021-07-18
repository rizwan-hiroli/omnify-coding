<div id="step-2-form" style="display:none">
   <form method="POST" id="reservationForm">
      @csrf
      <div class="form-row ">
        <div class="col-md-4 mb-3 mt-5">
          <h3 class="text-center">Reservation</h2>
        </div>
      </div>
      <div class="form-row">
         <div class="col-md-4 mb-3">
            <label for="validationServer01">Users</label>
            <select  name="name"  class="js-data-example-ajax form-control is-valid" multiple="multiple" id="name" placeholder="Enter User Ids"  required></select>
            <div class="valid-feedback error-name is-invalid">
            </div>
            <div class="error-user_ids" ></div>
         </div>
         <div class="col-md-4 mb-3">
            <label for="validationServer02">Date</label>
            <input type="text" name="date" id="date" class="form-control datepicker" id="date" placeholder="Enter Date" required>
            <div class="valid-feedback is-invalid">
               Looks good!
            </div>
            <div class="error-date"></div>
         </div>
         <div class="col-md-4 mb-3">
            <div class="alert alert-primary" role="alert" id="server-message" style="display:none"></div>
         </div>
         <div class="control-group form-horizontal ">
            <div><pre id="jsonDisplay" class="d-none"></pre></div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
      </div>
    </form>
</div>