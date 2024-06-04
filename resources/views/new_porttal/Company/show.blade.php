

<table class="table m-0 show_table" style="width:95%!important;">
    <tr>
        <TH>{{__('companies.companyName')}} </TH>
        <td>{{$Company->companyName}}</td>
        <TH>{{__('companies.calculation_method')}}</TH>
        <td>{{$Company->calculation_method}}</td>
    </tr>
    <tr>
        <TH>{{__('companies.period_start')}} </TH>
        <td>{{$Company->period_start}}</td>
        <TH>{{__('companies.period_end')}} </TH>
        <td>{{$Company->period_end}}</td>
    </tr>
    <tr>
        <TH>{{__('companies.companyFullName_en')}}</TH>
        <td>{{$Company->companyFullName_en}}</td>
        <TH>{{__('companies.companyFullName_ar')}}</TH>
        <td>{{$Company->companyFullName_ar}}</td>
    </tr>
    <tr>
        <TH>{{__('companies.TaxNumber')}}</TH>
        <td>{{$Company->TaxNumber}}</td>
        <TH>{{__('companies.CreditNote_Letter')}}</TH>
        <td>{{$Company->CreditNote_Letter}}</td>
    </tr>
    <tr>
        <TH>{{__('companies.Created_by')}}</TH>
        <td>{{$Company->created_users}}</td>
        <TH>{{__('companies.updated_by')}}</TH>
        <td>{{$Company->updated_users}}</td>
    </tr>
    <tr>
        <TH>{{__('companies.Created_At')}}</TH>
        <td>{{$Company->created_at}}</td>
        <TH>{{__('companies.updated_by')}}</TH>
        <td>{{$Company->updated_at}}</td>
    </tr>
    <tr>
        <TH>{{__('companies.rental_company')}}</TH>
        <td>
            @if($Company->rent_check == 1)
                <span class="label label-success">Yes</span>
            @else
                <span class="label label-warning">No</span>
            @endif
        </td>
        <TH>{{__('companies.status')}}</TH>
        <td>
            @if($Company->status == 'active')
                <span class="label label-success">Active</span>
            @else
                <span class="label label-danger">Inactive</span>
            @endif
        </td>
    </tr>
</table>


<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('companies.cancel')}}</button>
</div>
