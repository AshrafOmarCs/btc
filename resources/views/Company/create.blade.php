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
            style="width:100%;font-size: 14px;font-weight: bold;">Company</h2>
</div>

<form method="POST" action="{{ route('Company.store')}}">
    @csrf

    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table  class="table m-0 show_table" style="width:10px!important;">
                    <tr>
                        <TH>companyName <font color="red">*</font></TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="companyName" value="" required></td>
                    </tr>
                    </tr>
                    <tr>
                        <TH>calculation_method<font color="red">*</font></TH>
                        <td>
                            <select id="calculation_method_id" name="calculation_method_id" class="form-control" required>
                                <option value=""></option>
                                @foreach($lkp_calculation_method as $lkp_calculation_methodd)
                                    <option value="{{$lkp_calculation_methodd->id}}">{{$lkp_calculation_methodd->calculation_method}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>period_start <font color="red">*</font></TH>
                        <td><input type="text" class="form-control"  name="period_start" value="" required></td>
                    </tr>
                    <tr>
                        <TH>period_end <font color="red">*</font></TH>
                        <td><input type="text" class="form-control"  name="period_end" value="" required></td>
                    </tr>
                    <tr>
                        <TH>companyFullName_en</TH>
                        <td><input type="text" class="form-control"  name="companyFullName_en" value="" ></td>
                    </tr>
                    <tr>
                        <TH>companyFullName_ar </TH>
                        <td><input type="text" class="form-control"  name="companyFullName_ar" value="" ></td>
                    </tr>
                    <tr>
                        <TH>TaxNumber </TH>
                        <td><input type="text" class="form-control"  name="TaxNumber" value="" ></td>
                    </tr>
                    <tr>
                        <TH>CreditNote_Letter </TH>
                        <td><input type="text" class="form-control"  name="CreditNote_Letter" value="" ></td>
                    </tr>
                    <tr>
                        <TH>Rental Company</TH>
                        <td>
                            <select id="rent_check" name="rent_check" class="form-control" required>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Add</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">Cancel
    </button>
</div>
