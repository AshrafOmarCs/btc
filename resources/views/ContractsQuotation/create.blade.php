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
            style="width:100%;font-size: 14px;font-weight: bold;">New {{$type}}</h2>
</div>

<form method="POST" action="{{ route('ContractsQuotation/store')}}">
    @csrf
    <input type="hidden" name="type" value="{{$type}}"
    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table  class="table m-0 show_table" style="width:10px!important;">
                    <tr>
                        <TH>Company Name <font color="red">*</font></TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="companyName" value="" required></td>
                    </tr>
                    <tr>
                        <TH>Company Email <font color="red">*</font></TH>
                        <td><input type="email" class="form-control" style="width:400px;" name="companyEmail" value="" required></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="col-lg-12">
        <b>Body <font color="red">*</font></b><br>
        <textarea id="div_editor1" class="form-control" value="" name="body" required></textarea>
    </div>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Add</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">Cancel
    </button>
</div>
