
<form method="POST" action="{{ route('Company.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.companyName')}} <font color="red">*</font></label>
                            <input type="text" class="form-control" name="companyName" value="" required>
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
                                    <option value="{{$lkp_calculation_methodd->id}}">{{$lkp_calculation_methodd->calculation_method}}</option>
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
                            <input type="text" class="form-control"  name="period_start" value="" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.period_end')}} <font color="red">*</font></label>
                            <input type="text" class="form-control"  name="period_end" value="" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.companyFullName_en')}} <font color="red">*</font></label>
                            <input type="text" class="form-control"  name="companyFullName_en" value="" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.companyFullName_ar')}}</label>
                            <input type="text" class="form-control"  name="companyFullName_ar" value="" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.TaxNumber')}}</label>
                            <input type="text" class="form-control"  name="TaxNumber" value="" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.CreditNote_Letter')}}</label>
                            <input type="text" class="form-control"  name="CreditNote_Letter" value="" >
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
                                <option value="0">No</option>
                                <option value="1">Yes</option>
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
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="m-0">
                            <label class="form-label">{{__('companies.logo')}}</label>
                            <input type="file" class="form-control"  name="company_logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('companies.cancel')}}</button>
        <button class="btn btn-success" type="submit">{{__('companies.add')}}</button>
    </div>
</form>


