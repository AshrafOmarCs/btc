<style>
  .show_table th{
   padding-left: 20px !important;
   white-space: nowrap;
   border:none !important;
  margin:0!important;
  }
  .show_table td{
   padding: 0.0rem 0.0rem !important;
   border:none !important;
   vertical-align: middle !important;
  }
  </style>

 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Packages</h2>
</div>

<form method="POST" action="{{ route('Packages.update',$Packages->id)}}"    >
                    {{method_field("PATCH")}}
                       @csrf

 <table >
 <tr>
 <td style="vertical-align: top !important;">
<table class="table m-0 show_table" style="width:10px!important;" >
<tr><TH>Driver <font color="red">*</font></TH>
<td  style="white-space: nowrap;">
          <input name="driverId" id="driverId" type="hidden" value="{{$Packages->driverId}}" >
           <table style="padding: 0px 0px; !important;"><tr><td>
          <input  class="form-control" name="driverId_input" id="driverId_input"  style="width:170px"  type="text" value="{{$Packages->fullName}}"  required  data-readonly>
          </td><td><button onclick="driver_window();" type="button" class="btn btn-primary btn-sm" >Select</button>
          </td></tr></table>
</td>
 </tr>
 <tr><TH>total_out_for_deliver</TH>
 <td><input  type="text" class="form-control"   style="width:200px;" name="total_out_for_deliver" value="{{$Packages->total_out_for_deliver}}"  ></td>
 </tr>
 <tr><TH>total_no_touchpoint </TH>
 <td><input  type="text" class="form-control"   name="total_no_touchpoint" value="{{$Packages->total_no_touchpoint}}"  ></td>
 </tr>
 <tr><TH>no_of_deliverd</TH>
 <td><input  type="text" class="form-control"   name="no_of_deliverd" value="{{$Packages->no_of_deliverd}}"  ></td>
 </tr>
 <tr><TH>no_of_touch_point</TH>
 <td><input  type="text" class="form-control"   name="no_of_touch_point" value="{{$Packages->no_of_touch_point}}"  ></td>
 </tr>
    <tr><TH>unit_cost</TH>
        <td><input  type="text" class="form-control"   name="unit_cost" value="{{$Packages->unit_cost}}"  ></td>
    </tr>
    <tr><TH>No_of_TP</TH>
        <td><input  type="text" class="form-control"   name="No_of_TP" value="{{$Packages->No_of_TP}}"  ></td>
    </tr>
<tr><TH>attendence <font color="red">*</font></TH>
 <td>
<select  name="attendence"    class="form-control" required>
                   <option value=""></option>
<option value="0" @if ($Packages->attendence=="0"){{"  selected " }}:{{""}} @endif>Absent</option>
<option value="1" @if ($Packages->attendence=="1"){{"  selected " }}:{{""}} @endif>Attend</option>
                   </select>
</td></tr>
<tr><TH>pakage_date <font color="red">*</font></TH>
 <td>
 <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="pakage_date" placeholder="dd/mm/yyyy" id="pakage_date" value="{{$Packages->pakage_date}}" required>
                </div>
 </td>
 </tr>
 <tr><TH>Complete<font color="red">*</font></TH><td>
   <select id="packageStatusId" name="packageStatusId" class="form-control" required>
     <option value=""></option>
          @foreach($lkp_package_status as $lkp_package_statuss)
          <option value="{{$lkp_package_statuss->id}}" @if ($Packages->packageStatusId==$lkp_package_statuss->id){{"  selected " }}:null @endif>{{$lkp_package_statuss->status}}</option>
        @endforeach
     </select>
   </td></tr>
   <tr><TH>Approve<font color="red">*</font></TH><td>
   <select id="approveStatusId" name="approveStatusId" class="form-control" required>
     <option value=""></option>
          @foreach($lkp_packageapprovestatus as $lkp_packageapprovestatuss)
          <option value="{{$lkp_packageapprovestatuss->id}}" @if ($Packages->approveStatusId==$lkp_packageapprovestatuss->id){{"  selected " }}:null @endif>{{$lkp_packageapprovestatuss->approvestatus}}</option>
        @endforeach
     </select>
   </td></tr>
  </table>
</td>
</tr></table>
           <div class="w3-row">
                 <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Update</button>
              </div>
</form>
           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
           </div>
