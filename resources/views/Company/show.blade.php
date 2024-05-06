<style>

    .show_table th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
        width: 10px;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
    }
</style>

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">Company</h2>
</div>

<table class="table m-0 show_table" style="width:95%!important;">
    <tr>
        <TH>companyName </TH>
        <td>{{$Company->companyName}}</td>
    </tr>
    <tr>
        <TH>calculation_method</TH>
        <td>{{$Company->calculation_method}}</td>
    </tr>
    <tr>
        <TH>period_start </TH>
        <td>{{$Company->period_start}}</td>
    </tr>
    <tr>
        <TH>period_end </TH>
        <td>{{$Company->period_end}}</td>
    </tr>
    <tr>
        <TH>companyFullName_en</TH>
        <td>{{$Company->companyFullName_en}}</td>
    </tr>
    <tr>
        <TH>companyFullName_ar</TH>
        <td>{{$Company->companyFullName_ar}}</td>
    </tr>
    <tr>
        <TH>TaxNumber</TH>
        <td>{{$Company->TaxNumber}}</td>
    </tr>
    <tr>
        <TH>CreditNote_Letter</TH>
        <td>{{$Company->CreditNote_Letter}}</td>
    </tr>
    <tr>
        <TH>createdby</TH>
        <td>{{$Company->created_users}}</td>
    </tr>
    <tr>
        <TH>updatedby</TH>
        <td>{{$Company->updated_users}}</td>
    </tr>
    <tr>
        <TH>Created At</TH>
        <td>{{$Company->created_at}}</td>
    <tr>
        <TH>Updated At</TH>
        <td>{{$Company->updated_at}}</td>
    </tr>
</table>

<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">Close
    </button>
</div>
