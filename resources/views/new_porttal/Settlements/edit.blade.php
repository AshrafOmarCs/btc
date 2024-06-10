
<form method="POST" action="{{ route('Settlements.update',$Settlements->id)}}">
    {{method_field("PATCH")}}
    @csrf
    <div class="modal-body">
    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table>
                    <tr>
                        <TH>Driver <font color="red">*</font></TH>
                        <td style="white-space: nowrap;">
                            <input name="driverId" id="driverId" type="hidden" value="{{$Settlements->driverId}}">
                            <table style="padding: 0px 0px; !important;">
                                <tr>
                                    <td>
                                        <input class="form-control" name="driverId_input" id="driverId_input"
                                               style="width:250px" type="text" value="{{$Settlements->fullName}}"
                                               required readonly>
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
                            <input type="date" class="form-control pull-right" name="journal_date" id="journal_date" value="{{$Settlements->journalDate}}" required>
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
                        <TH>Note <font color="red">*</font></TH>
                        <td><textarea name="note" class="form-control" rows=5 required>{{$Settlements->note}}</textarea></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</form>
