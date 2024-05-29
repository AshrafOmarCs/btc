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
</style>

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{__('contractsQuotation.contract_information')}}</h2>
</div>
    <form action="{{ route('ContractsQuotation/sendContract')}}" method="POST" enctype="multipart/form-data" style="padding: 19px;">

    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table  class="table m-0 show_table" style="width:10px!important;">
                    @if($data[0]->iqama_number != '')
                    <tr>
                        <TH>{{__('contractsQuotation.contract_start_date')}}</TH>
                        <td><input type="date" class="form-control" style="width:400px;" name="cont_start_date" value="{{$data[0]->cont_start_date}}" @if($data[0]->client_ip != '') readonly @endif required></td>
                    </tr>
                    @endif
                    <tr>
                        <TH>{{__('contractsQuotation.company_name_en')}}</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="companyName" value="{{$data[0]->companyName}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>{{__('contractsQuotation.company_name_ar')}}</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="companyName_ar" value="{{$data[0]->companyName_ar}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>{{__('contractsQuotation.company_email')}}</TH>
                        <td><input type="email" class="form-control" style="width:400px;" name="companyEmail" value="{{$data[0]->companyEmail}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>{{__('contractsQuotation.contract_type')}}</TH>
                        <td>
                            <Select class="styled-input" style="width:400px; padding: 0" id="contractType" name="contractType" disabled>
                                @foreach($contract_types as $contract_type)
                                    <option @if($contract_type->id == $data[0]->contractType) selected @endif value="{{$contract_type->id}}">{{$contract_type->type}}</option>
                                @endforeach
                            </Select>
                        </td>
                    </tr>

                    @if($data[0]->iqama_number != '')
                        <tr>
                            <TH>{{__('contractsQuotation.owner_name')}}</TH>
                            <td><input type="text" class="form-control" style="width:400px;" name="info_person_name" value="{{$data[0]->info_person_name}}" readonly></td>
                        </tr>
                        <tr>
                            <TH>{{__('contractsQuotation.owner_mobile')}}</TH>
                            <td><input type="text" class="form-control" style="width:400px;" name="info_person_phone_no" value="{{$data[0]->info_person_phone_no}}" readonly></td>
                        </tr>
                        <tr>
                            <TH>{{__('contractsQuotation.owner_Iqama')}}</TH>
                            <td><input type="text" class="form-control" style="width:400px;" name="iqama_number" value="{{$data[0]->iqama_number}}" readonly></td>
                        </tr>
                        @if($data[0]->iqama_check != 1)
                        <tr id="iqama_check">
                            <TH>{{__('contractsQuotation.owner_Iqama')}}</TH>
                            <td>
                                <a target="_blank" title="View" href="javascript:void(0);" onclick="window.open('/storage/CompanyQuotation/{{ $data[0]->iqama }}', 'mywindow', 'width=600,height=400');" ><i class="fa fa-eye fa-lg"></i></a>
                                @if($data[0]->ceo_ip == '')
                                    <a onclick="reject_it({{$data[0]->id}}, 'iqama_check')" title="Reject" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if($data[0]->freelance_cert_check != 1 AND $data[0]->freelance_cert != '')
                        <tr id="freelance_cert_check">
                            <TH>{{__('contractsQuotation.owner_Iqama')}}</TH>
                            <td>
                                <a target="_blank" title="View" href="javascript:void(0);" onclick="window.open('/storage/CompanyQuotation/{{ $data[0]->freelance_cert }}', 'mywindow', 'width=600,height=400');" ><i class="fa fa-eye fa-lg"></i></a>
                                @if($data[0]->ceo_ip == '')
                                    <a onclick="reject_it({{$data[0]->id}}, 'freelance_cert_check')" title="Reject" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                                @endif
                            </td>
                        </tr>
                        @endif
                    @endif
                    @if($data[0]->reg_number != '')
                    <tr>
                        <TH>{{__('contractsQuotation.national_address_en')}}</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="national_address_en" value="{{$data[0]->national_address_en}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>{{__('contractsQuotation.national_address_ar')}}</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="national_address_ar" value="{{$data[0]->national_address_ar}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>{{__('contractsQuotation.registration_number')}}</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="reg_number" value="{{$data[0]->reg_number}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>{{__('contractsQuotation.IBAN_number')}}</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="iban_number" value="{{$data[0]->iban_number}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>{{__('contractsQuotation.VAT_registration_number')}}</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="vat_certificate_number" value="{{$data[0]->vat_certificate_number}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>{{__('contractsQuotation.information_provided_by')}}</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="info_person" value="{{$data[0]->info_person=='0'? 'Owner' : 'Authorized Person'}}" readonly></td>
                    </tr>

                    @if($data[0]->reg_certificate_check != 1)
                    <tr id="reg_certificate_check">
                        <TH>{{__('contractsQuotation.registration_certificate')}}</TH>
                        <td>
                            <a target="_blank" title="View" href="javascript:void(0);" onclick="window.open('/storage/CompanyQuotation/{{ $data[0]->reg_certificate }}', 'mywindow', 'width=600,height=400');" ><i class="fa fa-eye fa-lg"></i></a>
                            @if($data[0]->ceo_ip == '')
                                <a onclick="reject_it({{$data[0]->id}}, 'reg_certificate_check')" title="Reject" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @if($data[0]->address_check != 1)
                    <tr id="address_check">
                        <TH>{{__('contractsQuotation.address')}}</TH>
                        <td>
                            <a target="_blank" title="View" href="javascript:void(0);" onclick="window.open('/storage/CompanyQuotation/{{ $data[0]->address }}', 'mywindow', 'width=600,height=400');" ><i class="fa fa-eye fa-lg"></i></a>
                            @if($data[0]->ceo_ip == '')
                                <a onclick="reject_it({{$data[0]->id}}, 'address_check')" title="Reject" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @if($data[0]->chamber_file_check != 1)
                    <tr id="chamber_file_check">
                        <TH>{{__('contractsQuotation.chamber_file')}}</TH>
                        <td>
                            <a target="_blank" title="View" href="javascript:void(0);" onclick="window.open('/storage/CompanyQuotation/{{ $data[0]->chamber_file }}', 'mywindow', 'width=600,height=400');" ><i class="fa fa-eye fa-lg"></i></a>
                            @if($data[0]->ceo_ip == '')
                                <a onclick="reject_it({{$data[0]->id}}, 'chamber_file_check')" title="Reject" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                            @endif
                        </td>
                    </tr>
                    @endif

                    @if($data[0]->vat_certificate_check != 1)
                    <tr id="vat_certificate_check">
                        <TH>{{__('contractsQuotation.VAT_cert')}}</TH>
                        <td>
                            <a title="View" href="javascript:void(0);" onclick="window.open('/storage/CompanyQuotation/{{ $data[0]->vat_certificate }}', 'mywindow', 'width=600,height=400');"><i class="fa fa-eye fa-lg"></i></a>
                            @if($data[0]->ceo_ip == '')
                                <a onclick="reject_it({{$data[0]->id}}, 'vat_certificate_check')" title="Reject" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                            @endif
                        </td>

                    </tr>
                    @endif
                    @if($data[0]->iban_certificate_check != 1)
                    <tr id="iban_certificate_check">
                        <TH>{{__('contractsQuotation.IBAN_cert')}}</TH>
                        <td>
                            <a target="_blank" title="View" href="javascript:void(0);" onclick="window.open('/storage/CompanyQuotation/{{ $data[0]->iban_certificate }}', 'mywindow', 'width=600,height=400');" ><i class="fa fa-eye fa-lg"></i></a>
                            @if($data[0]->ceo_ip == '')
                                <a onclick="reject_it({{$data[0]->id}}, 'iban_certificate_check')" title="Reject" class="btnaction btn menu-icon vd_bd-red vd_red"> <i class="fa fa-times"></i> </a>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @if($data[0]->info_person == 1)
                    <tr>
                        <TH>{{__('contractsQuotation.authentication_letter')}}</TH>
                        <td><a target="_blank" title="View" href="javascript:void(0);" onclick="window.open('/storage/CompanyQuotation/{{ $data[0]->auth_letter }}', 'mywindow', 'width=600,height=400');" ><i class="fa fa-eye fa-lg"></i></a></td>
                    </tr>
                    <tr>
                        <TH>{{__('contractsQuotation.id_mage')}}</TH>
                        <td><a target="_blank" title="View" href="javascript:void(0);" onclick="window.open('/storage/CompanyQuotation/{{ $data[0]->iqama_image }}', 'mywindow', 'width=600,height=400');" ><i class="fa fa-eye fa-lg"></i></a></td>
                    </tr>
                    @endif
                    @endif
                </table>
            </td>
        </tr>
    </table>
    <div style="padding: 15px;">
        <!--<b>Body<br>-->
        <table class="table table-bordered" id="customer_data" style="width: 100%">
            <thead>
                @if($data[0]->contractType == 1)
                    <th style="border: 1px solid rgb(69, 161, 222); text-align: right; padding: 8px; background-color: #C7E3F5;">Calculation<br>(معادلة)</th>
                    <th style="border: 1px solid rgb(69, 161, 222); text-align: right; padding: 8px; background-color: #C7E3F5;">Per Day<br>(في اليوم)</th>
                @endif
                <th style="border: 1px solid rgb(69, 161, 222); text-align: right; padding: 8px; background-color: #C7E3F5;">Price<br>(السعر)</th>
                @if($data[0]->contractType == 1)
                    <th style="border: 1px solid rgb(69, 161, 222); text-align: right; padding: 8px; background-color: #C7E3F5;">Quantity<br>(الكمية)</th>
                    <th style="border: 1px solid rgb(69, 161, 222); text-align: right; padding: 8px; background-color: #C7E3F5;">Vehicle<br>(المركبة)</th>
                @endif
                <th style="border: 1px solid rgb(69, 161, 222); text-align: right; padding: 8px; background-color: #C7E3F5;">Type<br>(النوع)</th>
                <th style="border: 1px solid rgb(69, 161, 222); text-align: right; padding: 8px; background-color: #C7E3F5;">Description<br>(الوصف)</th>
                <th style="border: 1px solid rgb(69, 161, 222); text-align: right; padding: 8px; background-color: #C7E3F5;">Items<br>(الصنف)</th>
            </thead>
            <tbody style="direction: rtl">
                @php $total = 0; @endphp
                    @foreach($items as $item)
                        <tr>
                            @if($data[0]->contractType == 1)
                                <td>@if($item->type==1) {{$item->price}} / 26 @else N/A @endif</td>
                                <td>@if($item->type==1) {{round($item->price / 26)}} @else N/A @endif</td>
                            @endif
                            <td>{{$item->price}}</td>
                            @if($data[0]->contractType == 1)
                                <td>@if($item->type==1) {{$item->quantity}} @else N/A @endif</td>
                                <td>@if($item->type==1) @if($item->vehicle_info_check == 1) N/A @else {{$item->vehicle_info}} @endif @else N/A @endif</td>
                                <td>@if($item->type==1) Monthly Salary @else Per Shipment @endif</td>
                            @else
                                <td>Per Shipment</td>
                            @endif
                            <td>{{$item->description}}</td>
                            <td>{{$item->name}}</td>
                        </tr>
                        @php $total += $item->price; @endphp
                    @endforeach
            </tbody>
        </table>
        <!--<h4 style="direction: rtl"><b>المجموع: {{$total}}</b></h4>-->

    </div>
    @if($data[0]->iqama_number != '' && $data[0]->ceo_ip == '')
        @csrf
        <input type="hidden" name="id" value="{{$data[0]->id}}">
        <label class="radio-inline">
          <input type="radio" name="quot_status" onclick="fun_contract_file(1)" value="1" required>{{__('contractsQuotation.accept')}}
        </label>
        <label class="radio-inline">
          <input type="radio" name="quot_status" value="0" onclick="fun_contract_file(0)" required>{{__('contractsQuotation.reject')}}
        </label>
        <div class="w3" id="contract_reject_div" style="display: none">
            {{__('contractsQuotation.reason')}}<br>
            <textarea name="reject_reason" id="reject_reason" rows="5" style="width: 100%;"></textarea>
        </div>

        <div class="w3-row" id="update_button">
            <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">{{__('contractsQuotation.submit')}}</button>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">{{__('contractsQuotation.submit')}}</button>
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('contractsQuotation.cancel')}}</button>
        </div>
    </form>
    @else
        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('contractsQuotation.cancel')}}</button>
        </div>
    @endif

