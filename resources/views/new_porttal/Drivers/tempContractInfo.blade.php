
   <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;">
        <h2 style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}}</h2>
    </div>
<form method="POST" action="{{ URL('/tempContractSave')}}"    >
    @csrf
    <div class="modal-body">
        <table class="table m-0 " style="width:90%!important;">
            <input type="hidden" name="id" value="{{$Driver->id}}">
            <tr><TH>Name <font color="red">*</font></TH>
                <td>
                    <input id="text" type="text" class="form-control" name="name" value="{{$driver[0]->name}}" required>
                </td></tr>
            <tr><TH>Iqama <font color="red">*</font></TH>
                <td>
                    <input id="iqama" type="number" class="form-control" name="iqama" value="{{$driver[0]->iqama}}" required>
                </td>
            </tr>
            <tr><TH>Project <font color="red">*</font></TH>
                <td>
                    <input id="project" type="text" class="form-control" name="project" value="{{$driver[0]->project}}" required>
                </td>
            </tr>
            <tr><TH>Nationality <font color="red">*</font></TH>
                <td>
                    <input id="nationality" type="text" class="form-control" name="nationality" value="{{$driver[0]->nationality}}" required>
                </td>
            </tr>
            <tr><TH>Region <font color="red">*</font></TH>
                <td>
                    <input id="region" type="text" class="form-control" name="region" value="{{$driver[0]->region}}" required>
                </td>
            </tr>
            <tr><TH>Date <font color="red">*</font></TH>
                <td>
                    <input id="date" type="date" class="form-control" name="date" value="{{$driver[0]->date}}" required>
                </td>
            </tr>
            @if($driver[0]->name != '' AND $driver[0]->iqama != '' AND $driver[0]->project != '' AND $driver[0]->nationality != '' AND $driver[0]->region != '' AND $driver[0]->date != '')
                <tr>
                    <TH>Preview <font color="red">*</font></TH>
                    <td>
                        <a href="/driverTempContract/{{base64_encode($driver[0]->driver_id)}}" target="_blank"><i class="bi bi-eye" style="font-size: x-large;"></i></a>
                    </td>
                </tr>
            @endif
        </table>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="reset">Save</button>
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" id="filter">Close</button>
    </div>
</form>


