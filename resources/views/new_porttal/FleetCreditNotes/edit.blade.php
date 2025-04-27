<form method="POST" action="{{ route('CreditNotes.update',$CreditNotes->id)}}">
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
                                <input name="driverId" id="driverId" type="hidden" value="{{$CreditNotes->driverId}}">
                                <table style="padding: 0px 0px; !important;">
                                    <tr>
                                        <td>
                                            <input class="form-control" name="driverId_input" id="driverId_input"
                                                style="width:230px" type="text" value="{{$CreditNotes->fullName}}"
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
                        <tr>
                            <TH colspan=2></TH>
                        </tr>

                        <Tr>
                            <TH colspan=2 id="balance">
                                <table>
                                    <tr>
                                        <TH>Perivious Balance:</TH>
                                        <td><font color=red>{{$CreditNotes->per_priod}}</font> ({{$CreditNotes->per_range}})
                                        <td>
                                    </tr>
                                    <tr>
                                        <TH style='text-align: right;'>Current Balance:</TH>
                                        <td><font color=red>{{$CreditNotes->cur_priod}}</font> ({{$CreditNotes->cur_range}})
                                        <td>
                                    </tr>
                                </table>

                            </TH>
                        </tr>
                        <tr>
                            <TH colspan=2></TH>
                        </tr>
                        <tr>
                            <TH>journal Date <font color="red">*</font></TH>
                            <td>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" name="journal_date"
                                        id="journal_date" value="{{$CreditNotes->journalDate}}"
                                        required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <TH colspan=2></TH>
                        </tr>
                        <tr>
                            <TH>Amount <font color="red">*</font></TH>
                            <td><input type="text" class="form-control" name="amount" value="{{$CreditNotes->amount +0}}"
                                    required></td>
                        </tr>
                        <tr>
                            <TH colspan=2></TH>
                        </tr>
                        <tr>
                            <th>File(s) </th>
                            <td><input type="file" class="form-control" name="files[]" multiple=""></td>
                        </tr>
                        <tr>
                            <TH colspan=2></TH>
                        </tr>
                        <tr>
                            <TH>Note <font color="red">*</font></TH>
                            <td><textarea name="note" class="form-control" rows=5 required>{{$CreditNotes->note}}</textarea></td>
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
