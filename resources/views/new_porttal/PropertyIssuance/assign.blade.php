
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{__('properties.assign_properties')}}</h2>
</div>

<form method="POST" action="{{ route('PropertyIssuance/property_assign')}}" onkeydown="disableEnterKey(event)">
    @csrf
    <div class="modal-body">
        <label style="margin: 10px;" for="emp_id">{{__('properties.empoyee_to_assign_devices')}}</label>
        <span style="float: right; margin-right: 5px;">
            <select id="emp_id" name="emp_id" class="form-control" style="margin-bottom: 5px" required>
                <option value="">Select employee</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </span>
        <table  id="customer_data" class="propert_table table table-bordered table-striped" style="width: 100%;">
            <tr>
                <th>{{__('properties.device')}}</th>
                <th>{{__('properties.description')}}</th>
                <th>{{__('properties.branch')}}</th>
                <th>{{__('properties.available')}}</th>
                <th>{{__('properties.quantity')}}</th>
            </tr>
            <tbody id="property_body">
                @if($branches <> null)
                    @foreach($branches as $branch)
                        <tr class="">
                            <td>
                                {{$branch->device}}
                            </td>
                            <td>
                                {{$branch->description}}
                            </td>
                            <td>
                                {{$branch->branches}}
                            </td>
                            <td>
                                {{$branch->available}}
                            </td>

                            <td style="text-align: center">
                                <input type="hidden" value="{{$branch->description}}" name="descriptions[]">
                                <input type="hidden" value="{{$branch->branches}}" name="branches[]">
                                <input type="number" min="0" max="{{$branch->available}}" id="" name="properties[]" value="">
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="2">No record found!</td></tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="modal-footer">
        @if($branches <> null)
            <button class="btn btn-primary" type="submit">{{__('properties.submit')}}</button>
        @endif
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('properties.cancel')}}</button>
    </div>
</form>

