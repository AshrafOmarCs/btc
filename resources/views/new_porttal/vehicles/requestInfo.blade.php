<span id="requestData">
    <form method="POST" action="{{ url('New-Portal/Vehicles/maintenanceApproveRequest')}}">
        @csrf
        <input type="hidden" name="request_id" value="{{$request_id}}">
        <div class="row">
            <div class="col-md-12">
                <p>
                    <b style="font-size: 14px;">Request Type: Maintenance</b>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <b>Vehicle:</b> {{$data->color}}, {{$data->vehicle_manufacturer_name}}, {{$data->vName}}, {{$data->manufacturer_date}}
            </div>
            <div class="col-md-4">
                <b>Driver:</b> {{$data->fullName}},  <span style="color:red">{{$data->job_id}}</span>
            </div>
            <div class="col-md-4">
                <b>Plate:</b> {{$data->plate}}
            </div>
            <div class="col-md-4">
                <b>Project:</b> {{$data->companyName}}
            </div>
            <div class="col-md-4">
                <b>City:</b> {{$data->city_name}}
            </div>
            <div class="col-md-4">
                <b>Request Source:</b> App
            </div>
            <div class="col-md-4">
                <b>Supervisor Note:</b> {{$data->sup_note}}
            </div>
            <div class="col-md-4">
                <b>Created By:</b> {{$data->userName}}
            </div>
            <div class="col-md-4">
                <b>Created At:</b> {{ \Carbon\Carbon::parse($data->request_issue_date)->format('j F, Y') }}
            </div>
            <div class="col-md-4">
                <b>Maintenance Shop</b> <font color="red">*</font>: &nbsp;
                <select id="company_name" name="company_id" style="width: 138px;" onchange="typeChange('{{$data->id}}', this.value)" @if($page == 'maintenance') disabled @endif required>
                    <option value="">Select Shop</option>
                    @foreach($mainCompanies as $mainCompany)
                        <option value="{{$mainCompany->id}}" @if($mainCompany->id == $data->maintenance_company_id) selected @endif>{{$mainCompany->company_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <b>Maintenance Type</b> <font color="red">*</font>:
                <label class="radio-inline" id="cashRadio">
                    <input type="radio" onclick="checkChange('cash', '{{$data->id}}')" id="cashCheck" name="transfer_type" value="cash" @if($page == 'maintenance') disabled @endif @if($data->transfer_type == 'cash') checked @endif>Cash
                </label>
                <label class="radio-inline" id="insuranceRadio">
                    <input type="radio" onclick="checkChange('insurance', '{{$data->id}}')" name="transfer_type" value="insurance" @if($page == 'maintenance') disabled @endif @if($data->transfer_type == 'insurance') checked @endif>Insurance
                </label>
            </div>
            <div class="col-md-4" id="claimIdDiv">
                <b>Claim ID</b> <font color="red">*</font>:
                <input type="text" id="claim_id" name="claim_id" value="{{$data->claim_id}}" class="" @if($data->transfer_type == 'cash' OR $page == 'maintenance') disabled @endif>
                <small id="msg" style="color: red; display: none;">After clicking on the approve button the request will be sent to maintenance company.</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8" style="margin-top: 20px">
                <table id="customer_data" class="table table-bordered">
                    <thead>
                        <th>Part Name</th>
                        <th>Last Maintenance</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($parts as $part)
                            <tr>
                                <td>{{$part->name}}</td>
                                <td>{{$part->date}}</td>
                                @if($page == 'maintenance')
                                    <td>Approved</td>
                                @else
                                    <td style="text-align: center"><i class="bi bi-x" style="cursor: pointer;" title="Reject" onclick="deletePart({{$part->id}}, {{$request_id}})"></i></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-4" style="margin-top: 15px">
                <label>External Note:</label>
                <textarea rows="10" id="external_note" name="external_note" class="form-control" style="border-radius: 10px;" @if($page == 'maintenance') disabled @endif></textarea>
            </div>
        </div>
        @if($page != 'maintenance')
            <input type="submit" style="" class="btn btn-primary" value="Approve">
        @endif
    </form>
</span>
<style>
    .attachment-card {
        position: relative;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        display: grid;
        margin-top: 5px;
    }
    .attachment-card img, embed {
        max-width: 100%;
        height: 90px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>
<span id="attachmentsData" style="display: none">
    <div class="row">
        @foreach($files as $file)
            <div class="col-md-4" style="height: 135px;">
                <div class="attachment-card">
                    <a href="#" onclick="openViewVehicleModal('/storage/Vehicles/vehicleMaintenanceFiles/{{$file->file}}')"><img src="/storage/Vehicles/vehicleMaintenanceFiles/{{$file->file}}"></a>
                    {{substr($file->file, 0, 20)}}
                    @if($page != 'maintenance')
                        <i class="bi bi-x" style="position: absolute;top: -10px;right: -5px;cursor: pointer;" title="Delete" onclick="deleteFile({{$file->id}}, {{$request_id}})"></i>
                    @endif
                </div>
            </div>
        @endforeach
        @if($page != 'maintenance')
            <div class="col-md-4" style="display:none;">
                <div class="attachment-card" style="height: 135px;">
                    <form method="POST" id="others_form" action="{{ url('New-Portal/Vehicles/maintenanceFiles')}}" enctype='multipart/form-data' onsubmit="return validateOthersForm({{$request_id}})">
                        @csrf
                        <input type="file" onchange="previewImagee(event)" accept=".jpg,.jpeg,.png" name="others" id="click_on_submit_dropify" data-height="90" data-width="50" required>
                        <input type="hidden" name="request_id" class="plateCard" value="{{$request_id}}" required>
                        <input type="submit" style="padding: 5px" class="btn btn-primary" value="Save" id="save_btn_dropify">
                    </form>
                </div>
            </div>
            <div class="col-md-4" onclick="click_on_submit_btn()" style="cursor: pointer">
                <div class="attachment-card" style="height: 135px;">
                    <center>
                        <img id="previewImage" src="https://cdn.pixabay.com/photo/2016/01/03/00/43/upload-1118929_1280.png" alt="Pdf file uploaded" style="width:100px; height:auto;">
                    </center>
                    Click here to upload file

                </div>
            </div>
            <div class="col-md-4 position-relative bg-light p-3">
                <button type="button" class="btn btn-primary position-absolute" style="bottom: 0; left: 0;" onclick="click_on_save_btn_dropify()" id="submitBtn" style="display:none;">Save</button>
            </div>
        @endif
    </div>
</span>
