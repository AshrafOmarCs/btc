@extends('layout2')
@section('content')
@section('title', 'Vehicles Fuel')
<form method="POST" action="{{ url('vehicles/fuel/link')}}">
    @csrf
    <div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.Filter')}} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- Card start -->
                            <div class="card">
                                <div class="card-body">
                                    <!-- Row start -->
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="country" class="form-label">Month </label>
                                                <select name="filter_month" id="filter_month" onchange="loadVehicles(this.value)" class="form-control" required>
                                                    <option value="">Select Month</option>
                                                    <option value="8-2024">08-2024</option>
                                                    <option value="9-2024">09-2024</option>
                                                    <option value="10-2024">10-2024</option>
                                                    <option value="11-2024">11-2024</option>
                                                    <option value="12-2024">12-2024</option>
                                                    <option value="1-2025">01-2025</option>
                                                    <option value="2-2025">02-2025</option>
                                                    <option value="3-2025">03-2025</option>
                                                    <option value="4-2025">04-2025</option>
                                                    <option value="5-2025">05-2025</option>
                                                    <option value="6-2025">06-2025</option>
                                                    <option value="7-2025">07-2025</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="country" class="form-label">Plate </label>
                                                <select id="filter_vehicleId" name="filter_vehicleId" class="form-control" required>
                                                    <option value="">Select Vehicle</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>
                            </div>
                            <!-- Card end -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="reset" class="btn btn-dark" data-bs-dismiss="modal" onclick="reset_records()">{{__('drivers.Reset')}}</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-12">
            <div id="message"></div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Vehicles Fuel</div>
                </div>
                <!-- Card start -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 16px;">From this page you can link Vehicles fuel details with driver. </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-btn-group">
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                    <button type="button" style="padding: 10px" class="btn btn-sm btn-info" onclick="downloadReport()">Upload Fuel</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div id="loader" style="display:none;">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="customer_data" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <TH>#</TH>
                                        <TH >Plate</TH>
                                        <TH >Fuel Tag</TH>
                                        <TH >Fuel Price</TH>
                                        <TH >Date</TH>
                                        <TH >Job ID</TH>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <TH>#</TH>
                                        <TH >Plate</TH>
                                        <TH >Fuel Tag</TH>
                                        <TH >Fuel Price</TH>
                                        <TH >Date</TH>
                                        <TH >Job ID</TH>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Card end -->
                </div>
            <!-- Card end -->
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    @section('javascript')
        <!-- Main Js Required -->
        <script src="{{asset('assets/js/main.js')}}"></script>
        <script>
            $(document).ready(function () {
                var dataTable = $('#customer_data').DataTable({
                    lengthMenu: [[10, 25, 50, 100, 10000], [10, 25, 50, 100, "All"]],
                    processing: true,
                    // serverSide: true,
                    dom: 'lBfrtip',
                    "buttons": [
                        {
                            extend: 'excel',
                            text: 'Export to Excel',
                            exportOptions: {

                                modifier: {
                                    search: 'applied',
                                    order: 'applied'
                                }
                            }
                        }
                    ],
                    order: [1, 'asc'],
                });
                $('#filter').click(function () {
                    var date = filter_vehicleId = '';
                    date = $('#filter_month').val();
                    filter_vehicleId = $('#filter_vehicleId').val();
                    if (date == '' || filter_vehicleId == '') {
                        alert("Please select criteria!");
                        return false;
                    }
                    $('#pre_loader').show();
                    $.ajax({
                        type: 'POST',
                        url: "{{url('Vehicles/Vehicles')}}",
                        cache: false,
                        data: {
                            ACTION: 'table',
                            date: date,
                            filter_vehicleId: filter_vehicleId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            $('#pre_loader').hide();
                            $('#customer_data').DataTable().clear().draw();
                            $('#customer_data').DataTable().destroy();
                            $('#customer_data').DataTable().rows.add($(data)).draw();
                        }
                    });
                });
            });
            function reset_records() {
                $('#filter_month').val('');
                $('#filter_vehicleId').empty();
            }
            function loadVehicles(date) {
                if (date != '') {
                    $.ajax({
                        type: 'POST',
                        url: "{{url('Vehicles/Vehicles')}}",
                        cache: false,
                        data: {
                            date: date,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            document.getElementById('filter_vehicleId').innerHTML = data;
                        }
                    });
                }
            }
        </script>

    @stop
@endsection

