

<form method="POST" action="{{ route('Company.update',$Company->id)}}">
    {{method_field("PATCH")}}
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.companyName')}} <font color="red">*</font></label>
                            <input type="text" class="form-control" name="companyName" value="{{$Company->companyName}}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.calculation_method')}} <font color="red">*</font></label>
                            <select id="calculation_method_id" name="calculation_method_id" class="form-control" required>
                                <option value=""></option>
                                @foreach($lkp_calculation_method as $lkp_calculation_methodd)
                                    <option @if ($lkp_calculation_methodd->id==$Company->calculation_method_id){{"  selected " }}:{{""}} @endif value="{{$lkp_calculation_methodd->id}}">{{$lkp_calculation_methodd->calculation_method}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.period_start')}} <font color="red">*</font></label>
                            <input type="text" class="form-control"  name="period_start" value="{{$Company->period_start}}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.period_end')}} <font color="red">*</font></label>
                            <input type="text" class="form-control"  name="period_end" value="{{$Company->period_end}}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.companyFullName_en')}} <font color="red">*</font></label>
                            <input type="text" class="form-control"  name="companyFullName_en" value="{{$Company->companyFullName_en}}" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.companyFullName_ar')}}</label>
                            <input type="text" class="form-control"  value="{{$Company->companyFullName_ar}}" value="" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.TaxNumber')}}</label>
                            <input type="text" class="form-control"  name="TaxNumber" value="{{$Company->TaxNumber}}" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.CreditNote_Letter')}}</label>
                            <input type="text" class="form-control"  name="CreditNote_Letter" value="{{$Company->CreditNote_Letter}}" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.rental_company')}}</label>
                            <select id="rent_check" name="rent_check" class="form-control" required>
                                <option @if($Company->rent_check == 0) selected @endif value="0">No</option>
                                <option @if($Company->rent_check == 1) selected @endif value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.status')}}</label>
                            <select id="status" name="status" class="form-control" required>
                                <option @if($Company->status == 'active') selected @endif value="active">Active</option>
                                <option @if($Company->status == 'inactive') selected @endif value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('companies.cancel')}}</button>
        <button class="btn btn-success" type="submit">{{__('companies.update')}}</button>
    </div>
</form>


