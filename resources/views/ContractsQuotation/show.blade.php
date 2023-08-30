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
</style>

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">Contract Information</h2>
</div>

    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table  class="table m-0 show_table" style="width:10px!important;">
                    <tr>
                        <TH>Company Name</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="companyName" value="{{$data[0]->companyName}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>Company Email</TH>
                        <td><input type="email" class="form-control" style="width:400px;" name="companyEmail" value="{{$data[0]->companyEmail}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>Registration Number</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="reg_number" value="{{$data[0]->reg_number}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>IBAN Number</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="iban_number" value="{{$data[0]->iban_number}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>Information Provided by</TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="info_person" value="{{$data[0]->info_person}}" readonly></td>
                    </tr>
                    <tr>
                        <TH>Registration Certificate</TH>
                        <td><a target="_blank" title="Download" href="/storage/CompanyQuotation/{{ $data[0]->reg_certificate }}"><i class="fa fa-download fa-lg"></i></a></td>
                    </tr>
                    <tr>
                        <TH>Address</TH>
                        <td><a target="_blank" title="Download" href="/storage/CompanyQuotation/{{ $data[0]->address }}"><i class="fa fa-download fa-lg"></i></a></td>
                    </tr>
                    <tr>
                        <TH>Chamber File</TH>
                        <td><a target="_blank" title="Download" href="/storage/CompanyQuotation/{{ $data[0]->chamber_file }}"><i class="fa fa-download fa-lg"></i></a></td>
                    </tr>
                    <tr>
                        <TH>Iqama</TH>
                        <td><a target="_blank" title="Download" href="/storage/CompanyQuotation/{{ $data[0]->iqama }}"><i class="fa fa-download fa-lg"></i></a></td>
                    </tr>
                    <tr>
                        <TH>VAT Certificate</TH>
                        <td><a target="_blank" title="Download" href="/storage/CompanyQuotation/{{ $data[0]->vat_certificate }}"><i class="fa fa-download fa-lg"></i></a></td>
                    </tr>
                    <tr>
                        <TH>IBAN Certificate</TH>
                        <td><a target="_blank" title="Download" href="/storage/CompanyQuotation/{{ $data[0]->iban_certificate }}"><i class="fa fa-download fa-lg"></i></a></td>
                    </tr>
                    @if($data[0]->info_person == 1)
                    <tr>
                        <TH>Authentication Letter</TH>
                        <td><a target="_blank" title="Download" href="/storage/CompanyQuotation/{{ $data[0]->auth_letter }}"><i class="fa fa-download fa-lg"></i></a></td>
                    </tr><tr>
                        <TH>Iqama Image</TH>
                        <td><a target="_blank" title="Download" href="/storage/CompanyQuotation/{{ $data[0]->iqama_image }}"><i class="fa fa-download fa-lg"></i></a></td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
    <div style="padding: 15px;">
        <b>Body</b><br>
        <textarea id="div_editor1" class="form-control" value="" name="body" readonly>{{$data[0]->body}}</textarea>
    </div>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">Cancel
    </button>
</div>
