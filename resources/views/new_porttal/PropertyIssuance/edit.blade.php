<style>
    .show_table th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
    }
    .rte-floatpanel-paragraphop {
        display: none !important;
    }

    /* Style the input field */
    .styled-input {
        width: 300px; /* Adjust the width as needed */
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none; /* Remove the default input outline */
    }

    /* Style the input field on focus */
    .styled-input:focus {
        border-color: #007bff; /* Change border color on focus */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add a subtle box shadow on focus */
    }

    /* Style a label for the input (optional) */
    .input-label {
        font-size: 14px;
        color: #555;
    }
</style>

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{__('properties.update_property')}}</h2>
</div>

<form method="POST" action="{{ route('PropertyIssuance/update')}}" onkeydown="disableEnterKey(event)">
    @csrf
    <input type="hidden" name="id" value="{{$property[0]->id}}"
    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table  class="table m-0 show_table" style="width:10px!important;">
                    <tr>
                        <TH>{{__('properties.name')}} <font color="red">*</font></TH>
                        <td><input type="text" class="form-control styled-input" style="width:400px;" id="name" name="name" value="{{$property[0]->name}}" required></td>
                    </tr>
                    <tr>
                        <TH>{{__('properties.property_type')}} <font color="red">*</font></TH>
                        <td>
                            <Select class="styled-input" style="width:400px; padding: 0" id="property_id" name="property_id" required>
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option @if($category->id == $property[0]->property_id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </Select>
                        </td>
                    </tr>
                    <tr>
                        <TH>{{__('properties.description')}} <font color="red">*</font></TH>
                        <td><textarea class="form-control styled-input" style="width:400px;" id="description" name="description" required>{{$property[0]->description}}</textarea></td>
                    </tr>
                    <tr>
                        <TH>{{__('properties.price')}} <font color="red">*</font></TH>
                        <td><input type="number" min="0" class="form-control styled-input" style="width:400px;" id="price" name="price" value="{{$property[0]->price}}" required></td>
                    </tr>
                    <tr>
                        <TH>{{__('properties.status')}} <font color="red">*</font></TH>
                        <td>
                            <select class="styled-input" style="width:400px; padding: 0" id="status_id" name="status_id" required>
                                <option value="">Select status</option>
                                @foreach($status as $sta)
                                    <option @if($sta->id == $property[0]->status_id) selected @endif value="{{$sta->id}}">{{$sta->status}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>{{__('properties.branch')}} <font color="red">*</font></TH>
                        <td>
                            <select class="styled-input" style="width:400px; padding: 0" id="branches" name="branches" required onchange="add_new_branch(this.value)">
                                <option value="">Select branch</option>
                                @foreach($branches as $branch)
                                    <option @if($branch->branches == $property[0]->branches) selected @endif value="{{$branch->branches}}">{{$branch->branches}}</option>
                                @endforeach
                                <option value="other">Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="new_branch" style="display: none">
                        <TH>{{__('properties.branch_name')}} <font color="red">*</font></TH>
                        <td><input type="text" class="form-control styled-input" style="width:400px;" id="new_branches" name="new_branches" value=""></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">{{__('properties.update')}}</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">{{__('properties.cancel')}}
    </button>
</div>
