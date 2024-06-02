
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{__('properties.get_devices_from')}} {{$devices[0]->user_name}}</h2>
</div>

<form method="POST" action="{{ route('PropertyIssuance/get_devices_from_emp')}}" onkeydown="disableEnterKey(event)">
    @csrf
    <input type="hidden" name="user_id" value="{{$devices[0]->user_id}}">
    <div class="modal-body">
        <table  id="customer_data" class="table table-bordered table-striped" style="width: 100%;">
            <tr>
                <th></th>
                <th>{{__('properties.device')}}</th>
                <th>{{__('properties.description')}}</th>
            </tr>
            <tbody>
                @foreach($devices as $device)
                    <tr class="">
                        <td style="text-align: center">
                            <input type="checkbox" id="dev_{{$device->id}}" name="devices[]" value="{{$device->id}}">
                        </td>
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
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="submit">{{__('properties.submit')}}</button>
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('properties.cancel')}}</button>
    </div>
</form>

