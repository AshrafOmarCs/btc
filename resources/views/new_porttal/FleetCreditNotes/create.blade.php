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
        style="width:100%;font-size: 14px;font-weight: bold;">Deduction</h2>
</div>

<form method="POST" action="{{ route('FleetCreditNotes.store')}}">
    @csrf
    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table class="table m-0 show_table" style="width:10px!important;">
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
                        <TH>Vehicle <font color="red">*</font></TH>
                        <td>
                            <select class="form-control" name="vehicle_name" id="vehicle_name" required>
                                <option value="">Select Vehicle</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <TH colspan=2 id="balance"></TH>
                    </tr>
                    <tr>
                        <TH>Journal Date <font color="red">*</font></TH>
                        <td>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="journal_date"
                                       placeholder="dd/mm/yyyy" id="journal_date" value="" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <TH>Amount <font color="red">*</font></TH>
                        <td><input type="number" min="0" step=".01" class="form-control" name="amount" value="" required></td>
                    </tr>
                    <tr>
                        <TH>Type <font color="red">*</font></TH>
                        <td>
                            <select class="form-control" name="type" required>
                                <option value="">Select Type</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>File(s) </th>
                        <td><input type="file" class="form-control" name="files[]" multiple=""></td>
                    </tr>
                    <tr>
                        <TH>Note <font color="red">*</font></TH>
                        <td><textarea name="note" class="form-control" rows=5 required></textarea></td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
        <button type="submit" class="btn btn-success">Add</button>
    </div>
</form>
