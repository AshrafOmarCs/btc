
<form method="POST" action="{{ route('Settlements.store')}}">
    @csrf
    <div class="modal-body">
        <table>
            <tr>
                <td style="vertical-align: top !important;">
                    <table>
                        <tr>
                            <TH>Driver <font color="red">*</font></TH>
                            <td style="white-space: nowrap;">
                                <input name="driverId" id="driverId" type="hidden" value="">
                                <table style="padding: 0px 0px; !important;">
                                    <tr>
                                        <td>
                                            <input class="form-control" name="driverId_input" id="driverId_input" type="text" value="" required readonly>
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
                                <input type="date" class="form-control pull-right" name="journal_date" id="journal_date" value="" required>
                            </td>
                        </tr>
                        <tr>
                            <TH>Credit <font color="red">*</font></TH>
                            <td><input type="text" class="form-control" name="credit" value="" required></td>
                        </tr>
                        <tr>
                            <TH>Debit <font color="red">*</font></TH>
                            <td><input type="text" class="form-control" name="debit" value="" required></td>
                        </tr>
                        <tr>
                            <TH>Note <font color="red">*</font></TH>
                            <td><textarea name="note" class="form-control" rows=5 required></textarea></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
        <button type="submit" class="btn btn-success">Add</button>
    </div>
</form>
