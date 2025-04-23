
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;">
    <h2 style="font-size: 14px;font-weight: bold;">No Liability Request</h2>
</div>

<form id="tRequestForm" method="POST" action="{{ route('Drivers.tRequest')}}" enctype="multipart/form-data" onsubmit="return validateTRequestForm('{{$id}}')">
    @csrf
    <div class="modal-body">
        <label style="margin: 10px;" for="emp_id">Employee data form</label>
        <table class="table m-0" style="width:90%!important;">
            <input type="hidden" name="id" value="{{$id}}">
            <tr>
                <TH>Name </TH>
                <td>
                    <input id="text" type="text" class="form-control" name="name" value="{{$driver->fullName}}" readonly>
                </td>
            </tr>
            <tr>
                <TH>Iqama <font color="red">*</font></TH>
                <td>
                    <input id="iqama" type="number" class="form-control" name="iqama" value="{{$driver->iqama}}" required>
                </td>
            </tr>
            <tr>
                <TH>Job <font color="red">*</font></TH>
                <td>
                    <input name="job_title" type="text" class="form-control" name="" value="Driver" required>
                </td>
            </tr>
            <tr>
                <TH>Phone Number <font color="red">*</font></TH>
                <td>
                    <input id="" type="text" class="form-control" name="mobileNumber" value="{{$driver->mobileNumber}}" required>
                </td>
            </tr>
            <tr>
                <TH>Nationality <font color="red">*</font></TH>
                <td>
                    <input id="nationality" type="text" class="form-control" name="nationality" value="" required>
                </td>
            </tr>
            <tr>
                <TH>Date <font color="red">*</font></TH>
                <td>
                    <input id="date" type="date" class="form-control" name="date" value="" required>
                </td>
            </tr>
            <tr>
                <TH>Note <font color="red">*</font></TH>
                <td>
                    <textarea class="form-control" name="note" value="" rows="5" required></textarea>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="reset">Save</button>
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" id="filter">Close</button>
    </div>
</form>

