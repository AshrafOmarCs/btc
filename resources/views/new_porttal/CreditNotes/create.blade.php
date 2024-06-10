<form method="POST" action="{{ route('CreditNotes.store')}}">
    @csrf
    <div class="modal-body">
        <table>
            <tr>
                <td style="vertical-align: top !important;">
                    <tr>
                        <TH>Driver <font color="red">*</font></TH>
                        <td style="white-space: nowrap;">
                            <input name="driverId" id="driverId" type="hidden" value="">
                            <table style="padding: 0px 0px; !important;">
                                <tr>
                                    <td>
                                        <input class="form-control" name="driverId_input" id="driverId_input"
                                            style="width:230px" type="text" value="" required data-readonly>
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
                        <TH>Journal Date <font color="red">*</font></TH>
                        <td>
                            <input type="date" class="form-control" name="journal_date" id="journal_date" value="" required>
                        </td>
                    </tr>
                    <tr>
                        <TH>Amount <font color="red">*</font></TH>
                        <td><input type="text" class="form-control" name="amount" value="" required></td>
                    </tr>
                    <tr>
                        <TH>Note <font color="red">*</font></TH>
                        <td><textarea name="note" class="form-control" rows=5 required></textarea></td>
                    </tr>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
        <button type="submit" class="btn btn-success">Add</button>
    </div>
</form>
