<div id="step-1-form">
   <form class="text justify-content-center" id="settingForm">
      @csrf
      <div class="form-row ">
        <div class="col-md-4 mb-3 mt-5">
          <h3 class="text-center">Reservation Settings</h3>
        </div>
      </div>
      <div class="form-row">
         <div class="col-md-4 mb-3">
            <label for="validationServer01">n</label>
            <input type="text" name="n" id="n" class="form-control " id="validationServer01" placeholder="Enter n"  required>
            <div class="valid-feedback"></div>
            <div class="error-n is-invalid"></div>
         </div>
         <div class="col-md-4 mb-3">
            <label for="validationServer01">d</label>
            <select class="form-control form-control form-select" name="d" id="d">
               <option value="day">Day</option>
               <option value="month">Month</option>
               <option value="year">Year</option>
            </select>
            <div class="valid-feedback">
               Looks good!
            </div>
            <div class="error-d is-invalid"></div>
         </div>
      </div>
      <div class="form-row">
         <div class="col-md-4 mb-3">
            <label for="validationServer01">g</label>
            <select class="form-control form-control form-select" name="g" id="g">
               <option value="individual">Individual</option>
               <option value="group">Group</option>
            </select>
            <div class="error-g is-invalid"></div>
         </div>
         <div class="col-md-4 mb-3">
            <label for="">tz</label>
            <input type="text" class="form-control " name="tz" id="tz" placeholder="Enter tz" >
            <div class="invalid-feedback"></div>
            <div class="error-tz is-invalid"></div>
         </div>
      </div>
      <div class="form-row">
         <div class="col-md-4">
            <button class="btn btn-primary" type="submit" id="continue-button">Next</button>
         </div>
      </div>
   </form>
</div>