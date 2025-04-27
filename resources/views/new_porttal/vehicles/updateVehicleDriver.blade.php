@include('pages.messages2')
<div class="row">
    <div class="col-lg-6">
        <h4>Transfer Vehicle</h4>
    </div>
</div>
<form id="contact_form" method="POST" action="{{ route('New-Portal.vehicles.updateVehicleDriverSave') }}">
    @csrf
    <input type="hidden" name="delegation_id" value="{{$delegation_id}}">
    <input type="hidden" name="vehicle_id" value="{{$vehicle_id}}">
    <div class="row">
        <div class="col-lg-12">
            <table id="customer_data" class="table table-bordered">
                <thead>
                    <tr>
                        <TH>Plate</TH>
                        <TH>Driver</TH>
                        <TH>Request By</TH>
                        <TH>Action</TH>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{$plate}}
                        </td>
                        <td>
                            <select name="driver_id" id="job_id" class="form-control" required>
                                <option value=""></option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->job_id}} - {{$driver->iqama}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" class="form-control" name="transferRequestBy" ></td>
                        <td><button type="submit" class="btn btn-primary">Submit</button></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</form>
<div class="modal-footer">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
</div>

