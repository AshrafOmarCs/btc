<style>
    .show_table th {
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
    }
    .w3-table-all td, th {
        border: 0px !important;
    }
    .row {
        margin-left: 0px !important;
    }
</style>


@include('pages.messages2')
<div class="row">
    <div class="col-lg-6">
        <h4>Edit Vehicle</h4>
    </div>
</div>
<form id="contact_form" method="POST" onsubmit="return validateUpdateForm()">
    @csrf
    <input type="hidden" name="vehicle_id" value="{{$vehicle[0]->id}}">
    
    
    
    <div class="row">
        <div class="col-lg-6">
            <b>Plate</b> 
            <input type="text" class="form-control" style="width:200px;" name="plate" id="edit_plate"
                       value="{{$vehicle[0]->plate}}" placeholder="Enter Plate Number" required>
        </div>
        <div class="col-lg-6">
            <b>Otometer</b> 
            <input type="text" class="form-control" style="width:200px;" name="otometer" id="edit_otometer"
                       value="{{$vehicle[0]->otometer}}" placeholder="Enter Plate Otometer" {{$vehicle[0]->otometer == '0' ? '' : 'disabled'}} required>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <b>Extra Otometer Charge</b> 
            <input type="text" class="form-control" style="width:200px;" name="extraOtometerCharge" id="edit_extraOtometerCharge"
                       value="{{$vehicle[0]->extraOtometerCharge}}" placeholder="Enter extra Otometer Charge" >
        </div>
        <div class="col-lg-6">
            <b>Free Extra Otometer</b> 
            <input type="text" class="form-control" style="width:200px;" name="freeExtraOtometer" id="edit_freeExtraOtometer"
                       value="{{$vehicle[0]->freeExtraOtometer}}" placeholder="Enter free Extra Otometer" >
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <b>Registertion type</b> 
            <input type="text" class="form-control" style="width:200px;" name="registertion_type" id="edit_registertion_type"
                       value="{{$vehicle[0]->registertion_type}}" placeholder="Enter Registertion type" >
        </div>
        <div class="col-lg-6">
            <b>Vehicle Model</b>
            <select name="vehicle_model_id" id="vehicle_model_id" class="form-control" style="width:200px;" required="">
                @foreach($vehicle_models as $vehicle_model)
                    <option value="{{$vehicle_model->id}}"
                            @if ($vehicle[0]->vehicle_model_id==$vehicle_model->id){{"  selected " }} @endif>{{$vehicle_model->name_en}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <b>Vehicle Operator</b>
            <select name="vehicle_opreater_id" id="edit_vehicle_opreater_id" class="form-control" style="width:200px;" @if($vehicle[0]->current_status == 'availabe') onchange="show_rent(this.value)" @endif required="">
                @foreach($vehicle_opreators as $vehicle_opreator)
                    <option value="{{$vehicle_opreator->id}}"
                        @if ($vehicle[0]->vehicle_opreater_id==$vehicle_opreator->id){{"  selected " }} @endif>{{$vehicle_opreator->name_en}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6">
            <b>SNno</b> 
            <input type="text" class="form-control" style="width:200px;" name="SNno" id="edit_SNno" required
                       value="{{$vehicle[0]->SNno}}" placeholder="Enter Registertion type" >
        </div>
    </div>
    
    <div class="row rent_div" @if($vehicle[0]->current_status != 'availabe' OR $vehicle[0]->rent_type == '') style="display: none" @endif>
        <div class="col-lg-6">
            <b>Rent Type</b><br>
            <label class="radio-inline">
              <input type="radio" name="rent_type" class="rent_type" value="0" {{$vehicle[0]->rent_type == '0' ? 'checked' : ''}} onclick="change_rent_type_text(this.value)">Individual
            </label>
            <label class="radio-inline">
              <input type="radio" name="rent_type" class="rent_type" value="1" {{$vehicle[0]->rent_type == '1' ? 'checked' : ''}} onclick="change_rent_type_text(this.value)">Company
            </label>
        </div>
        <div class="col-lg-6 individual_div" @if($vehicle[0]->rent_individual == '') style="display:none;" @endif>
            <b id="rent_type_text">Individual Name</b> 
            <input type="text" class="form-control" style="width:200px;" name="rent_individual" id="rent_individual"
                       value="{{$vehicle[0]->rent_individual}}" placeholder="Enter Name" >
        </div>
        <div class="col-lg-6 company_div" @if($vehicle[0]->rent_company_id == '') style='display:none;' @endif>
            <b id="rent_type_text">Company</b> 
            <select name="rent_company_id" id="rent_company_id" class="form-control" style="width:200px;" {{$vehicle[0]->current_status == 'delegeted' ? 'disabled' : ''}}>
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{$company->id}}"
                            @if ($vehicle[0]->rent_company_id==$company->id){{"  selected " }} @endif>{{$company->companyName}}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <b>Checkup id</b> 
            <input type="text" class="form-control" style="width:200px;" name="checkup_id" id="edit_checkup_id"
                       value="{{$vehicle[0]->checkup_id}}" placeholder="Enter checkup id" >
        </div>
        <div class="col-lg-6">
            <b>City</b>
            <select name="city_id" id="edit_city_id" class="form-control" style="width:200px;" required="" {{$vehicle[0]->current_status == 'delegeted' ? 'disabled' : ''}}>
                @foreach($cities as $city)
                    <option value="{{$city->id}}"
                            @if ($vehicle[0]->city_id==$city->id){{"  selected " }} @endif>{{$city->name_en}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <b>Body number</b> 
            <input type="text" class="form-control" style="width:200px;" name="body_number" id="edit_body_number"
                       value="{{$vehicle[0]->body_number}}" placeholder="Enter body number" >
        </div>
        <div class="col-lg-6">
            <b>Color</b> 
            <input type="text" class="form-control" style="width:200px;" name="color" id="color"
                       value="{{$vehicle[0]->color}}" placeholder="Enter color" >
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <b>Insurance Type</b> 
            <select name="insurance_type" id="edit_insurance_type" class="form-control" style="width:200px;" required="">
                <option {{$vehicle[0]->insurance_type == 'full' ? 'selected' : ''}} value="full">full</option>
                <option {{$vehicle[0]->insurance_type == 'Third_party_insurance' ? 'selected' : ''}} value="Third_party_insurance">Third_party_insurance</option>0
            </select>
        </div>
        <div class="col-lg-6">
            <b>Vehicle Maintenance Location</b> 
            <input type="text" class="form-control" style="width:200px;" name="maintenance_location" id="edit_maintenance_location"
                       value="{{$vehicle[0]->maintenance_location}}" placeholder="Vehicle Maintenance Location">
       </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <b>Status</b> 
            <select name="current_status" id="edit_current_status" class="form-control" style="width:200px;" required="" {{$vehicle[0]->current_status == 'delegeted' ? 'disabled' : ''}}>
                <option {{$vehicle[0]->current_status == 'availabe' ? 'selected' : ''}} value="availabe">availabe</option>
                <option {{$vehicle[0]->current_status == 'damaged' ? 'selected' : ''}} value="damaged">damaged</option>
                <option {{$vehicle[0]->current_status == 'delegeted' ? 'selected' : ''}} value="delegeted">delegeted</option>
                <option {{$vehicle[0]->current_status == 'maintenance' ? 'selected' : ''}} value="maintenance">maintenance</option>
            </select>
        </div>
        <div class="col-lg-6">
            <b>Feul Type</b> 
            <select name="feulType" id="edit_feulType" class="form-control" style="width:200px;" required="">
                <option {{$vehicle[0]->feulType == '91' ? 'selected' : ''}} value="91">91</option>
                <option {{$vehicle[0]->feulType == 'diesel' ? 'selected' : ''}} value="diesel">diesel</option>0
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <b>Amount of Endurance</b> 
            <input type="text" class="form-control" style="width:200px;" name="amount_of_endurance" id="edit_amount_of_endurance"
                       value="{{$vehicle[0]->amount_of_endurance}}" placeholder="Enter Amount of Endurance" >
       </div>
        <div class="col-lg-6">
            <b>Vehicle Registration expire date</b> 
            <input type="text" class="form-control" style="width:200px;" name="vehicle_registration_expire_date" id="edit_vehicle_registration_expire_date" required
                       value="{{$vehicle[0]->vehicle_registration_expire_date}}" >
       </div>
    </div>
    <div class="row">
       <div class="col-lg-6">
            <b>Vehicle recive date</b> 
            <input type="text" class="form-control" style="width:200px;" name="recive_date" id="edit_recive_date"
                       value="{{$vehicle[0]->recive_date}}" >
       </div>
       <div class="col-lg-6" style="display:{{$vehicle[0]->current_status == 'delegeted' ? '' : 'none'}}">
            <b>Vehicle Maintenance Status</b> 
            <select name="maintenance_status" id="edit_maintenance_status" class="form-control" style="width:200px;" >
                <option value="">None</option>
                @foreach($maintenance_statuses as $maintenance_status)
                    <option value="{{$maintenance_status->id}}"
                            @if ($vehicle[0]->maintenance_status==$maintenance_status->id){{"  selected " }} @endif>{{$maintenance_status->name}}</option>
                @endforeach
            </select>
       </div>
    </div>
    @if($vehicle[0]->current_status == 'delegeted')
    <div class="row">
       <div class="col-lg-6">
            <b>Vehicle Delegation expiry</b> 
            <input type="date" class="form-control" style="width:200px;" name="vehicle_expiry_date" id="vehicle_expiry_date"
            value="{{$vehicle[0]->vehicle_expiry_date}}">
       </div>
   </div>
   @endif
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" id="submitForm" type="submit">Update</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>




