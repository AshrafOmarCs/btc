
<style>
  .form-control,.show_table th{
  margin:0!important;
  font-size: 10px;
  font-weight: bold;
  padding: 0.4rem 0.2rem !important;
  }
  .show_table td{
    font-size: 10px;
   padding: 0.0rem 0.0rem !important;
   vertical-align: middle !important;
  }
  </style>



<center>
              <div style="font-size: 14px;margin-right: 30px"><b>
                {{$name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$dt}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Complete:
                <input  class="complete-checkbox" name="select-all" id="select-all" type="checkbox" >
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Approve:
                <input class="approve-checkbox"  name="approve-all" id="approve-all" type="checkbox" >
              </b></div>




              <form method="POST" action="{{ action('WarehouseDriversController@store') }}" >
@csrf
<table class="table table-bordered">

<input name="warehouseId" type="hidden" value="{{$id}}">
<input name="warehouse_name" type="hidden" value="{{$name}}">
<input name="dt" type="hidden" value="{{$dt}}">
                  <thead>
                    <tr>
                    <TH>Emp ID</TH>
                    <TH>Driver</TH>
                    <TH>T PK</TH>
                    <TH>N PK</TH>
                    <TH>T TP</TH>
                    <TH>N TP</TH>
                    <TH>Attend</TH>
                    <TH>Complete</TH>
                    <TH>Approve</TH>
                    <TH>Load Time</TH>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($UsersMenu as $User_Menu)
  <tr>
    <td>{{$User_Menu->job_id}} </td>
    <td>{{$User_Menu->fullName}} </td>
    <td style="text-align: center !important;background-color: #9ECDE9;"><input  type="text" class="form-control"   style="width:30px;display:inline-block" name="total_out_for_deliver_{{$User_Menu->id}}" id="total_out_for_deliver_{{$User_Menu->id}}" value="{{$User_Menu->total_out_for_deliver}}"></td>
    <td style="text-align: center !important;background-color: #9ECDE9;"><input  type="text" class="form-control"   style="width:30px;display:inline-block" name="total_no_touchpoint_{{$User_Menu->id}}" id="total_no_touchpoint_{{$User_Menu->id}}" value="{{$User_Menu->total_no_touchpoint}}"></td>
    <td style="text-align: center !important;background-color: #E1C1C1;"><input  type="text" class="form-control"   style="width:30px;display:inline-block" name="no_of_deliverd_{{$User_Menu->id}}" id="no_of_deliverd_{{$User_Menu->id}}" value="{{$User_Menu->no_of_deliverd}}"></td>
    <td style="text-align: center !important;background-color: #E1C1C1;"><input  type="text" class="form-control"   style="width:30px;display:inline-block" name="no_of_touch_point_{{$User_Menu->id}}" id="no_of_touch_point_{{$User_Menu->id}}" value="{{$User_Menu->no_of_touch_point}}"></td>


    <td style="text-align: center !important;">
    <input class="flat-red" name="attendence_{{$User_Menu->id}}" id="attendence_{{$User_Menu->id}}" type="checkbox" value="1"   @if ($User_Menu->attendence=='1'){{"  checked " }}@endif>
    </td>
    <td style="text-align: center !important;">
    <input @if ($User_Menu->attendence!='1'){{"  disabled " }}@endif class="complete-checkbox" name="packageStatusId_{{$User_Menu->id}}" id="packageStatusId_{{$User_Menu->id}}" type="checkbox" value="2"   @if ($User_Menu->packageStatusId=='2'){{"  checked " }}@endif>
    </td>
    <td style="text-align: center !important;">
    <input @if ($User_Menu->packageStatusId!='2'){{"  disabled " }}@endif class="approve-checkbox" name="approveStatusId_{{$User_Menu->id}}" id="approveStatusId_{{$User_Menu->id}}" type="checkbox" value="2"   @if ($User_Menu->approveStatusId=='2'){{"  checked " }}@endif>
    </td>
    <td>{{$User_Menu->load_time}} </td>

</tr>
@endforeach
                  </tbody>

</table>
<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('companies.cancel')}}</button>
</div>
           </form>




