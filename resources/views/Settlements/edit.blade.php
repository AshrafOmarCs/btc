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
        style="width:100%;font-size: 14px;font-weight: bold;">Settlements</h2>
</div>

<form method="POST" action="{{ route('Settlements.update',$Settlements->id)}}">
    {{method_field("PATCH")}}
    @csrf

    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table class="table m-0 show_table" style="width:10px!important;">
                    <tr>
                        <TH>Driver <font color="red">*</font></TH>
                        <td style="white-space: nowrap;">
                            <input name="driverId" id="driverId" type="hidden" value="{{$Settlements->driverId}}">
                            <table style="padding: 0px 0px; !important;">
                                <tr>
                                    <td>
                                        <input class="form-control" name="driverId_input" id="driverId_input"
                                               style="width:250px" type="text" value="{{$Settlements->fullName}}"
                                               required data-readonly>
                                    </td>
                                    <td>
                                        <button onclick="driver_window();" type="button" class="btn btn-primary btn-sm">
                                            Select
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <Tr>
                        <TH colspan=2 id="balance">
                            <table>
                                <tr>
                                    <TH>Perivious Balance:</TH>
                                    <td><font color=red>{{$Settlements->per_priod}}</font> ({{$Settlements->per_range}})
                                    <td>
                                </tr>
                                <tr>
                                    <TH style='text-align: right;'>Current Balance:</TH>
                                    <td><font color=red>{{$Settlements->cur_priod}}</font> ({{$Settlements->cur_range}})
                                    <td>
                                </tr>
                            </table>

                        </TH>
                    </tr>
                    <tr>
                        <TH>journal Date <font color="red">*</font></TH>
                        <td>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="journal_date"
                                       placeholder="dd/mm/yyyy" id="journal_date" value="{{$Settlements->journal_date}}"
                                       required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <TH>Credit <font color="red">*</font></TH>
                        <td><input type="text" class="form-control" name="credit" value="{{$Settlements->credit +0}}"
                                   required></td>
                    </tr>
                    <tr>
                        <TH>Debit <font color="red">*</font></TH>
                        <td><input type="text" class="form-control" name="debit" value="{{$Settlements->debit +0}}"
                                   required></td>
                    </tr>
                    <tr>
                        <TH>Note</TH>
                        <td><textarea name="note" class="form-control" rows=5>{{$Settlements->note}}</textarea></td>
                    </tr>
                    </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Update</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>
