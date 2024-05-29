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
            style="width:100%;font-size: 14px;font-weight: bold;">New {{$type}}</h2>
</div>

<form method="POST" action="{{ route('ContractsQuotation/update')}}" onkeydown="disableEnterKey(event)" onsubmit="enableDisabledFields()" id="update_form">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$data[0]->id}}"
        <table>
            <tr>
                <td style="vertical-align: top !important;">
                    <table  class="table m-0 show_table" style="width:10px!important;">
                        <tr>
                            <TH>{{__('contractsQuotation.company')}} <font color="red">*</font></TH>
                            <td>
                                <Select class="styled-input" style="width:400px; padding: 0" id="company_id" name="company_id" onchange="change_company(this.value)" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option @if($company->name_en == $data[0]->companyName) selected @endif value="{{$company->id}}">{{$company->name_en}}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </Select>
                            </td>
                        </tr>
                        <tr class="comp_name">
                            <TH>{{__('contractsQuotation.company_name_en')}}<font color="red">*</font></TH>
                            <td><input type="text" class="form-control styled-input" style="width:400px;" id="companyName" name="companyName" value="{{$data[0]->companyName}}" required readonly></td>
                        </tr>
                        <tr class="comp_name">
                            <TH>{{__('contractsQuotation.company_name_ar')}}<font color="red">*</font></TH>
                            <td><input type="text" class="form-control styled-input" style="width:400px;" id="companyName_ar" name="companyName_ar" value="{{$data[0]->companyName_ar}}" required readonly></td>
                        </tr>
                        <tr class="comp_name">
                            <TH>{{__('contractsQuotation.company_email')}} <font color="red">*</font></TH>
                            <td><input type="email" class="form-control styled-input" style="width:400px;" id="companyEmail" name="companyEmail" value="{{$data[0]->companyEmail}}" required readonly></td>
                        </tr>
                        <tr>
                            <TH>{{__('contractsQuotation.contract_type')}} <font color="red">*</font></TH>
                            <td>
                                <Select disabled class="styled-input" style="width:400px; padding: 0" id="contractType" name="contractType" onchange="change_contract_type(this.value)" required>
                                    @foreach($contract_types as $contract_type)
                                        <option @if($contract_type->id == $data[0]->contractType) selected @endif value="{{$contract_type->id}}">{{$contract_type->type}}</option>
                                    @endforeach
                                </Select>
                            </td>
                        </tr>
                        @if($data[0]->status === 0 || $data[0]->status === 5)
                        <input type="hidden" name="reasons_update" value="1">
                        <TH>{{__('contractsQuotation.reject_reasons_by_company')}}: </TH>
                        <td><b>
                            {{$data[0]->reject_reason}}
                            </b>
                        </td>
                        @elseif(sizeof($reject_reasons) > 0)
                        <input type="hidden" name="reasons_update" value="1">
                        <TH>{{__('contractsQuotation.reject_reasons')}}: </TH>
                        <td><b>
                            @foreach ($reject_reasons as $reject_reason)
                                {{$reject_reason->name}}: {{$reject_reason->reject_reason}} <br>
                            @endforeach
                            </b>
                        </td>
                        @endif
                    </table>
                </td>
            </tr>
        </table>
        <div class="col-lg-12">
            <b>{{__('contractsQuotation.body')}} <font color="red">*</font>
                <select id="item_1" class="styled-input items" name="items[]" style="float:left; width: 200px" onchange="change_item(this.value, 1)">
                    @php echo $options; @endphp
                </select>
                <select style="height: 40px;float:right;width: 85px;font-size: 12px;" class="styled-input" id="body_type" onchange="change_body(this.value)">
                    <option value="en">English</option>
                    <option value="ar">Arabic</option>
                </select></b><br>
            <table border="1" id="customer_data" class="table table-bordered items_table" style="width: 100%">
                <thead>
                    <th>{{__('contractsQuotation.item')}}</th>
                    <th>{{__('contractsQuotation.description')}}</th>
                    <th @if($data[0]->contractType == 2) style="display: none" @endif class="cont_type">{{__('contractsQuotation.type')}}</th>
                    <th @if($data[0]->contractType == 2) style="display: none" @endif class="cont_type">{{__('contractsQuotation.vehicle')}}</th>
                    <th @if($data[0]->contractType == 2) style="display: none" @endif class="cont_type">{{__('contractsQuotation.quantity')}}</th>
                    <th>{{__('contractsQuotation.price')}}</th>
                    <th @if($data[0]->contractType == 2) style="display: none" @endif class="cont_type">{{__('contractsQuotation.per_day')}}</th>
                    <th @if($data[0]->contractType == 2) style="display: none" @endif class="cont_type">{{__('contractsQuotation.equation')}}</th>
                </thead>
                <tbody id="en_body">
                    @php $i = 1; @endphp
                    @foreach($items as $item)
                        <tr id="tr_en_{{$i}}">
                            <td>
                                <input type="text" value="{{$item->name}}" id="name_{{$i}}" class="styled-input form-control" placeholder="Add Item" name="name[]" style="width: 100%; margin-top: 5px;" required readonly>
                            </td>
                            <td><textarea name="description[]" id="description_{{$i}}" class="styled-input form-control" placeholder="Add Description" style="width: 100%" required readonly>{{$item->description}}</textarea></td>
                            <td class="cont_type" @if($data[0]->contractType == 2) style="display: none" @endif>
                                <input id="types_{{$i}}" type='hidden' name="types[]" value='{{$item->type}}'>
                                <select id="type_{{$i}}" class="styled-input" name="types[]" style="width: 100%" onchange="change_type(this.value, {{$i}})" required disabled>
                                    <option @if($item->type == 1) selected @endif value="1">Monthly Salary</option>
                                    <option @if($item->type == 2) selected @endif value="2">Per Shipment</option>
                                </select>
                            </td>
                            <td class="cont_type" @if($data[0]->contractType == 2) style="display: none" @endif id="vehicle_td_{{$i}}">
                                @if($item->type == 1 OR $item->type == '')
                                    <input @if($item->vehicle_info_check == 1) checked @endif type="checkbox" id="vehicle_info_check_{{$i}}" name="vehicle_info_check[]" value="1" onclick="vehicle_info_update(this, {{$i}})" disabled> N/A
                                    <textarea id="vehicle_info_{{$i}}" class="styled-input form-control" placeholder="Vehicle Info" name="vehicle_info[]" style="width: 100%; @if($item->vehicle_info_check == 1) display: none @endif" @if($data[0]->contractType == 1 && $item->vehicle_info_check != 1) required @endif readonly>{{$item->vehicle_info}}</textarea>
                                @else
                                    <input type="hidden" name="vehicle_info[]">
                                @endif
                            </td>
                            <td class="cont_type" @if($data[0]->contractType == 2) style="display: none" @endif id="quantity_td_{{$i}}">
                                @if($item->type == 1 OR $item->type == '')
                                    <input type="number" id="quantity_{{$i}}" value="{{$item->quantity}}" class="styled-input form-control" name="quantity[]" style="width: 100%" @if($data[0]->contractType == 1) required @endif>
                                @else
                                    <input type="hidden" name="quantity[]">
                                @endif
                            </td>
                            <td><input type="number" value="{{$item->price}}" id="price_{{$i}}" class="styled-input form-control" placeholder="Add Price" name="price[]" style="width: 100%" onchange="set_pp_day({{$i}})" readonly></td>
                            <td @if($data[0]->contractType == 2) style="display: none" @endif class="cont_type" id="pp_day_{{$i}}">@if($item->type == 1) {{round($item->price / 26)}} SAR @endif</td>
                            <td @if($data[0]->contractType == 2) style="display: none" @endif class="cont_type" id="equation_{{$i}}">@if($item->type == 1) {{$item->price}} / 26 @endif</td>
                        </tr>
                        @php $i += 1; @endphp
                    @endforeach
                </tbody>
                <tbody id="ar_body" style="display: none">
                    @php $i = 1; @endphp
                    @foreach($items as $item)
                        <tr id="tr_ar_{{$i}}">
                            <td><input type="text" value="{{$item->name_ar}}" id="name_ar_{{$i}}" class="styled-input form-control" name="name_ar[]" style="width: 100%" required readonly></td>
                            <td><textarea name="description_ar[]" id="description_ar_{{$i}}" class="styled-input form-control" style="width: 100%" required readonly>{{$item->description_ar}}</textarea></td>
                            <td class="cont_type" @if($data[0]->contractType == 2) style="display: none" @endif></td>
                            <td class="cont_type" @if($data[0]->contractType == 2) style="display: none" @endif id="vehicle_ar_td_{{$i}}">
                                @if($item->type == 1 OR $item->type == '')
                                    <input @if($item->vehicle_info_check == 1) checked @endif type="checkbox" id="vehicle_info_check_ar_{{$i}}" value="1" disabled> N/A
                                    <textarea id="vehicle_info_ar_{{$i}}" class="styled-input form-control" placeholder="Vehicle Info" name="vehicle_info_ar[]" style="width: 100%; @if($item->vehicle_info_check == 1) display: none @endif" @if($data[0]->contractType == 1 && $item->vehicle_info_check != 1) required @endif readonly>{{$item->vehicle_info_ar}}</textarea>
                                @else
                                    <input type="hidden" name="vehicle_info_ar[]">
                                @endif
                            </td>
                            <td class="cont_type" @if($data[0]->contractType == 2) style="display: none" @endif>@if($item->type == 1)<input type="number" id="quantity_ar_{{$i}}" value="" class="styled-input form-control" style="width: 100%" readonly>@endif</td>
                            <td><input type="number" value="" id="price_ar_{{$i}}" class="styled-input form-control" style="width: 100%" readonly readonly></td>
                            <td class="cont_type" @if($data[0]->contractType == 2) style="display: none" @endif id="pp_day_ar_{{$i}}"></td>
                            <td class="cont_type" @if($data[0]->contractType == 2) style="display: none" @endif id="equation_ar_{{$i}}"></td>
                        </tr>
                        @php $i += 1; @endphp
                    @endforeach
                    @php $i -= 1; @endphp
                </tbody>
                <tfoot>
                    <input type="hidden" id="count" value="{{$i}}">
                    <td id="btn"><button type="button" class="btn btn-primary" onclick='add_row({{$i}}, {{$data[0]->id}}, "{{$options}}")'>{{__('contractsQuotation.add_Row')}}</button></td>
                    <td colspan="" id="btn_del"><button type="button" class="btn btn-danger" onclick="delete_row({{$i}}, {{$data[0]->id}})">{{__('contractsQuotation.del_Row')}}</button></td>
                </tfoot>
            </table>
            <!--<textarea id="div_editor1" class="form-control" value="" name="body" required>{{$data[0]->body}}</textarea>-->
        </div>
    </div>
    <div class="modal-footer" id="update_button">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('contractsQuotation.cancel')}}</button>
        <span><button class="btn btn-primary" type="button" id="verification" onclick="open_verify_modal({{$data[0]->id}}, '{{$data[0]->companyName}}')">{{__('contractsQuotation.preview')}}</button></span>
    </div>
</form>

