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
    <div class="col-lg-10">
        <h4 id="info_title">{{$title}}</h4>
        <p>{{$small}}</p>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table id="customer_data" class="table table-bordered table-striped table-responsive" style="width: 95%;">
                <thead>
                    @php $colspan = 2; $colspan_no = 4; @endphp
                    <th>Sr. No</th></th>
                    <th>City</th>
                    @if($type == 'done_attendance' || $type == 'pending_attendance' || $type == 'present' || $type == 'absent_ex' || $type == 'absent_no_ex')
                    <th>Company</th>
                    <th>Warehouse</th>
                    <th>Supervisor(s)</th>
                    @php $colspan = 5; $colspan_no = 7; @endphp
                    @endif
                    <th>Vehicle Count</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @php $no = $total = 0; @endphp
                    @if (sizeof($information) > 0)
                        @foreach($information as $info)
                        @php $total += $info->vehicle_count; @endphp
                        <tr>
                            <td>{{++$no}}</td>
                            <td>{{$info->city_name}}</td>
                            @if($type == 'done_attendance' || $type == 'pending_attendance' || $type == 'present' || $type == 'absent_ex' || $type == 'absent_no_ex')
                            <td>{{$info->companyName}}</td>
                            <td>{{$info->warehouseName}}</td>
                            <td>{{$info->user_names}}</td>
                            @endif
                            <td>{{$info->vehicle_count}}</td>
                            <td>
                                @if($type == 'total')
                                    <a onclick="show_vehicles('{{$info->city_name}}')" target="_blank" data-original-title="view info" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green">
                                     <i class="fa fa-eye" title="view info"></i> 
                                    </a>
                                @elseif($type == 'done_attendance' || $type == 'pending_attendance' || $type == 'present' || $type == 'absent_ex' || $type == 'absent_no_ex')
                                    <a onclick="show_vehicles('{{$info->city_name}}', '{{$type}}', '{{$info->companyName}}','{{$info->warehouseName}}')" target="_blank" data-original-title="view info" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green">
                                     <i class="fa fa-eye" title="view info"></i> 
                                    </a>
                                @else
                                    <a onclick="show_vehicles('{{$info->city_name}}', '{{$type}}')" target="_blank" data-original-title="view info" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green">
                                     <i class="fa fa-eye" title="view info"></i> 
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan = '{{$colspan_no}}' style="text-align: center">No Record Found!</td>
                            
                        </tr>
                    @endif
                    <tfoot>
                    <tr>
                        <th colspan="{{$colspan}}" style="text-align: center">Total</th>
                        <th colspan="2">{{$total}}</th>
                    </tr>
                    </tfoot>
                </tbody>
            </table>
        </div>
        
    </div>
    
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('info_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>
