
<form method="POST" action="{{ route('Loans.store')}}" id="form_submit">
    @csrf
    <div class="modal-body">
        <table class="table table-boarded">
            <tr>
                <TH>Driver <font color="red">*</font></TH>
                <td style="white-space: nowrap;">
                    <input name="driverId" id="driverId" type="hidden" value="">
                    <table style="padding: 0px 0px; !important;">
                        <tr>
                            <td>
                                <input class="form-control" name="driverId_input" id="driverId_input"
                                type="text" value="" required readonly>
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
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control" name="journal_date" id="journal_date" value="{{date('Y-m-d')}}" required>
                    </div>
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
            <tr>
                <TH>Status<font color="red">*</font></TH>
                <td>
                    <select id="status_id" name="status_id" class="form-control" required>
                        @foreach($lkp_loan_status as $lkp_loan_statuss)
                            <option
                                value="{{$lkp_loan_statuss->id}}">{{$lkp_loan_statuss->loan_status}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <TH>Proof File</TH>
                <td><input type="file" class="form-control" name="proof_file"></td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
        <button class="btn btn-primary" type="submit">{{__('drivers.Submit')}}</button>
    </div>
</form>
