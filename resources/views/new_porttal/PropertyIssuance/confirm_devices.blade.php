
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{__('properties.confirm_devices')}} {{$devices[0]->user_name}}</h2>
</div>

<form method="POST" action="{{ route('PropertyIssuance/confirm_devices_for_emp')}}" onkeydown="disableEnterKey(event)">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="user_id" value="{{$devices[0]->user_id}}">
        <input type="hidden" name="reference_no" value="{{$devices[0]->reference_no}}">
        <table  id="customer_data" class="table table-bordered table-striped" style="width: 100%;">
            <tr>
                <th>{{__('properties.device')}}</th>
                <th>{{__('properties.description')}}</th>
            </tr>
            <tbody>
                @foreach($devices as $device)
                    <tr class="">
                        <td>
                            {{$device->name}}
                        </td>
                        <td>
                            {{$device->description}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        &nbsp;&nbsp;<input type="checkbox" name="check" value="1" required>&nbsp; {{__('properties.ack_text')}} <b>{{$devices[0]->user_name}}</b>.
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="submit">{{__('properties.submit')}}</button>
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('properties.cancel')}}</button>
    </div>
</form>
