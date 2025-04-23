

@include('pages.messages2')
<div class="row">
    <div class="col-lg-6">
        <h6>Assign Vehicle</h6>
    </div>
</div>
<form id="contact_form" method="POST" action="{{ route('vehicles.forceAssignSave') }}">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <table id="" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <TH>Plate</TH>
                        <TH>Driver</TH>
                        <TH>Action</TH>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="vehicle_id" id="id" class="form-control" required>
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}">{{$vehicle->plate}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="driver_id" id="job_id" required>
                                <option value="">Select Driver</option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->job_id}} - {{$driver->iqama}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button class="btn btn-primary" id="submitForm" type="submit">Submit</button></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</form>
@if (count($pVehicles) > 0)
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <TH>Sr. No</TH>
                <TH>Plate</TH>
                <TH>Driver</TH>
                <TH>Job Id</TH>
                <TH>Status</TH>
                <TH>Action</TH>
            </tr>
        </thead>
        <tbody>
            @foreach($pVehicles as $i => $vehicle)
                <tr>
                    <td>{{$i + 1}}</td>
                    <td>{{$vehicle->plate}}</td>
                    <td>{{$vehicle->fullName}}</td>
                    <td>{{$vehicle->job_id}}</td>
                    <td>{{$vehicle->status}}</td>
                    <td><button class="btn btn-secondary" type="button" onclick="deleteVehicleAssignment({{$vehicle->id}})"><i class="bi bi-trash"></i></button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
