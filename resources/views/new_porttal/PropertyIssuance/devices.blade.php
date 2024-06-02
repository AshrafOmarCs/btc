<style>
    .table-container {
        max-height: 450px;
        overflow-y: auto;
    }
</style>

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{__('properties.devices_information')}}</h2>
</div>
<div class="modal-body">
    <div class="table-container">
        <table  id="customer_data" class="table table-bordered table-striped" style="width: 100%;">
            <tr>
                <th>{{__('properties.sr_no')}}</th>
                <th>{{__('properties.device')}}</th>
                <th>{{__('properties.description')}}</th>
                <th>{{__('properties.action')}}</th>
            </tr>
            <tbody>
                @php $i = 1; @endphp
                @foreach($devices as $device)
                    <tr class="">
                        <td style="text-align: center">
                            {{$i++}}
                        </td>
                        <td>
                            {{$device->name}}
                        </td>
                        <td>
                            {{$device->description}}
                        </td>
                        <td>
                            <a onclick="edit_record({{$device->id}}, 'pro')" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow"> <i class="fa fa-pencil"></i> </a>
                            &nbsp;<a onclick="delete_record({{$device->id}}, 'pro')" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('properties.cancel')}}</button>
</div>
