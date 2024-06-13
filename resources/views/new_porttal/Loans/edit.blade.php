@include('pages.messages')
<form method="POST" action="{{ route('Loans.update',$Loans->id)}}">
    {{method_field("PATCH")}}
    @csrf
    <div class="modal-body">
        <table class="table table-boarded">
            <tr>
                <TH>Driver <font color="red">*</font></TH>
                <td style="white-space: nowrap;">
                    <input name="driverId" id="driverId" type="hidden" value="{{$Loans->driverId}}">
                    <table style="padding: 0px 0px; !important;">
                        <tr>
                            <td>
                                <input class="form-control" name="driverId_input"
                                    id="driverId_input" type="text"
                                    value="{{$Loans->fullName}}" required data-readonly>
                            </td>
                            <td>
                                <button onclick="driver_window();" type="button"
                                        class="btn btn-primary btn-sm">Select
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
                            <td><font color=red>{{$Loans->per_priod}}</font> ({{$Loans->per_range}})
                            <td>
                        </tr>
                        <tr>
                            <TH style='text-align: right;'>Current Balance:</TH>
                            <td><font color=red>{{$Loans->cur_priod}}</font> ({{$Loans->cur_range}})
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
                        <input type="date" class="form-control" name="journal_date"
                                id="journal_date" value="{{$Loans->journalDate}}"
                            required>
                    </div>
                </td>
            </tr>
            <tr>
                <TH>Amount <font color="red">*</font></TH>
                <td><input type="text" class="form-control" name="amount" value="{{$Loans->amount}}"
                        required></td>
            </tr>
            <tr>
                <TH>Note <font color="red">*</font></TH>
                <td><textarea name="note" class="form-control" rows=5 required>{{$Loans->note}} </textarea>
                </td>
            </tr>
            <tr>
                <TH>Status<font color="red">*</font></TH>
                <td>
                    <select id="status_id" name="status_id" class="form-control" required>
                        <option value=""></option>
                        @foreach($lkp_loan_status as $lkp_loan_statuss)
                            <option value="{{$lkp_loan_statuss->id}}"
                                    @if ($Loans->status_id==$lkp_loan_statuss->id){{"  selected " }}:null @endif>{{$lkp_loan_statuss->loan_status}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
        <button class="btn btn-primary" type="submit">{{__('drivers.Submit')}}</button>
    </div>
</form>
