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

<form method="POST" action="{{ route('ContractsQuotation/store')}}" onkeydown="disableEnterKey(event)" onsubmit="enableDisabledFields()">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="type" value="{{$type}}"
        <table>
            <tr>
                <td style="vertical-align: top !important;">
                    <table  class="table m-0 show_table" style="width:10px!important;">
                        <tr>
                            <TH>{{__('contractsQuotation.company')}} <font color="red">*</font></TH>
                            <td>
                                <Select class="styled-input" style="width:400px; padding: 0" id="company_id" name="company_id" onchange="change_company(this.value)">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name_en}}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </Select>
                            </td>
                        </tr>
                        <tr style="display: none" class="comp_name">
                            <TH>{{__('contractsQuotation.company_name_en')}} <font color="red">*</font></TH>
                            <td><input type="text" class="form-control styled-input" style="width:400px;" name="companyName" id="companyName" value="" required></td>
                        </tr>
                        <tr style="display: none" class="comp_name">
                            <TH>{{__('contractsQuotation.company_name_ar')}}<font color="red">*</font></TH>
                            <td><input type="text" class="form-control styled-input" style="width:400px;" name="companyName_ar" id="companyName_ar" value="" required></td>
                        </tr>
                        <tr style="display: none" class="comp_name">
                            <TH>{{__('contractsQuotation.company_email')}} <font color="red">*</font></TH>
                            <td><input type="email" class="form-control styled-input" style="width:400px;" name="companyEmail" id="companyEmail" value="" required></td>
                        </tr>
                        <tr>
                            <TH>{{__('contractsQuotation.contract_type')}} <font color="red">*</font></TH>
                            <td>
                                <Select class="styled-input" style="width:400px; padding: 0" id="contractType" name="contractType" onchange="change_contract_type(this.value)" required>
                                    @foreach($contract_types as $contract_type)
                                        <option value="{{$contract_type->id}}">{{$contract_type->type}}</option>
                                    @endforeach
                                </Select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="col-lg-12">
            <b>{{__('contractsQuotation.company')}} <font color="red">*</font>
            <select id="item_1" class="styled-input items" name="items[]" style="float:left; width: 200px" onchange="change_item(this.value, 1)" required>
                @php echo $options; @endphp
            </select>
            <select style="height: 40px;float:right;width: 85px;font-size: 12px;" class="styled-input" id="body_type" onchange="change_body(this.value)">
                <option value="en">English</option>
                <option value="ar">Arabic</option>
            </select></b><br>
            <table id="customer_data" class="table table-bordered items_table" style="width: 100%">
                <thead>
                    <th>{{__('contractsQuotation.item')}}</th>
                    <th>{{__('contractsQuotation.description')}}</th>
                    <th class="cont_type">{{__('contractsQuotation.type')}}</th>
                    <th class="cont_type">{{__('contractsQuotation.vehicle')}}</th>
                    <th class="cont_type">{{__('contractsQuotation.quantity')}}</th>
                    <th>{{__('contractsQuotation.price')}}</th>
                    <th class="cont_type">{{__('contractsQuotation.per_day')}}</th>
                    <th class="cont_type">{{__('contractsQuotation.equation')}}</th>
                </thead>
                <tbody id="en_body">
                    @php $i = 1; @endphp
                    <tr>
                        <td>
                            <input type="text" id="name_1" class="styled-input form-control" placeholder="Add Item" name="name[]" style="width: 100%;" required>
                        </td>
                        <td><textarea name="description[]" id="description_1" class="styled-input form-control" placeholder="Add Description" style="width: 100%" required></textarea></td>
                        <td class="cont_type">
                            <select id="type_1" class="styled-input" name="types[]" style="width: 100%" onchange="change_type(this.value, 1)" required>
                                <option value="1">Monthly Salary</option>
                                <option value="2">Per Shipment</option>
                            </select>
                        </td>
                        <td class="cont_type" id="vehicle_td_1">
                            <input type="checkbox" id="vehicle_info_check_1" name="vehicle_info_check[]" value="1" onclick="vehicle_info_update(this, 1)"> N/A
                            <textarea id="vehicle_info_1" class="styled-input form-control" placeholder="Vehicle Info" name="vehicle_info[]" style="width: 100%" required></textarea>
                        </td>
                        <td class="cont_type" id="quantity_td_1"><input type="number" id="quantity_1" class="styled-input form-control" name="quantity[]" style="width: 100%" required></td>
                        <td><input type="number" id="price_1" class="styled-input form-control" name="price[]" style="width: 100%" required onchange="set_pp_day(1)"></td>
                        <td class="cont_type" id="pp_day_1"></td>
                        <td class="cont_type" id="equation_1"></td>
                    </tr>
                </tbody>
                <tbody id="ar_body" style="display: none">
                    @php $i = 1; @endphp
                    <tr>
                        <td><input type="text" id="name_ar_1" class="styled-input form-control" placeholder="اضافة عنصر" name="name_ar[]" style="width: 100%" required></td>
                        <td><textarea name="description_ar[]" id="description_ar_1" class="styled-input form-control" placeholder="اضف وصفا" style="width: 100%" required></textarea></td>
                        <td class="cont_type"></td>
                        <td class="cont_type" id="vehicle_ar_td_1">
                            <input type="checkbox" id="vehicle_info_check_ar_1" value="1"> N/A
                            <textarea id="vehicle_info_ar_1" class="styled-input form-control" placeholder="معلومات المركبة" name="vehicle_info_ar[]" style="width: 100%" required></textarea>
                        </td>
                        <td class="cont_type"><input type="number" id="quantity_ar_1" class="styled-input form-control" style="width: 100%" readonly></td>
                        <td><input type="number" id="price_ar_1" class="styled-input form-control" style="width: 100%" readonly></td>
                        <td class="cont_type" id="pp_day_ar_1"></td>
                        <td class="cont_type" id="equation_ar_1"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <input type="hidden" id="count" value="{{$i}}">
                    <td id="btn"><button type="button" class="btn btn-primary" onclick='add_row({{$i}}, "", "{{$options}}")'>{{__('contractsQuotation.add_Row')}}</button></td>
                    <td colspan="" id="btn_del"></td>
                </tfoot>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('contractsQuotation.cancel')}}</button>
            <button class="btn btn-success" type="submit">{{__('contractsQuotation.submit')}}</button>
        </div>
    </div>
</form>

