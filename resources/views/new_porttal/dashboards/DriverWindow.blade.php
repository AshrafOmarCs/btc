<!doctype html>
<html lang="en">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="Best Bootstrap Admin Dashboards">
		<meta name="author" content="Bootstrap Gallery" />
		<link rel="canonical" href="https://www.bootstrap.gallery/">
		<meta property="og:url" content="https://www.bootstrap.gallery">
		<meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
		<meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
		<meta property="og:type" content="Website">
		<meta property="og:site_name" content="Bootstrap Gallery">
		<link rel="shortcut icon" href="{{asset('assets/images/logo.png')}}">
        <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

		<!-- Title -->

        <title>@yield('title')</title>

		<!-- *************
			************ Common Css Files *************
		************ -->

		<!-- Animated css -->
		<link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">

		<!-- Bootstrap font icons css -->
		<link rel="stylesheet" href="{{asset('assets/fonts/bootstrap/bootstrap-icons.css')}}">

		<!-- Main css -->
		<link rel="stylesheet" href="{{asset('assets/css/main.min.css')}}">


		<!-- *************
			************ Vendor Css Files *************
		************ -->

		<!-- Scrollbar CSS -->
		<link rel="stylesheet" href="{{asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css')}}">
        <!-- Date Range CSS -->
        <link rel="stylesheet" href="{{asset('assets/vendor/daterange/daterange.css')}}">
		@yield('css')
        <!-- Data Tables -->
        <link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs5.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bs5-custom.css')}}" />
        <link rel="stylesheet" href="https://btcdmins.com/AdminLTE/plugins/iCheck/all.css">

	</head>
    @php
    $array = [];
    @endphp
	<body>
		<!-- Page wrapper start -->
		<div class="page-wrapper">
			<div class="main-container">
				<!-- Content wrapper scroll start -->
				<div class="content-wrapper-scroll">
					<!-- Content wrapper start -->
					<div class="content-wrapper">
                        <div class="table-responsive" style="width: 100%;">
                            <table id="customer_data" class="table table-bordered">
                                <thead>
                                <TH>Company</TH>
                                <TH>WarehouseName</TH>
                                <TH>FullName</TH>
                                <TH>Mobile</TH>
                                <TH>Iqama</TH>
                                <TH>Job ID</TH>
                                <TH>Status</TH>
                                <TH>Perivious Balance</TH>
                                <TH>Current Balance</TH>
                                <TH>Action</TH>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
					</div>
					<!-- Content wrapper end -->

					<!-- App Footer start -->
					<div class="app-footer">
						<span>© bander logistic company 2023</span>
					</div>
					<!-- App footer end -->

				</div>
				<!-- Content wrapper scroll end -->

			</div>
			<!-- *************
				************ Main container end *************
			************* -->

		</div>
		<!-- Page wrapper end -->

		<!-- *************
			************ Required JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
		<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('assets/js/modernizr.js')}}"></script>
		<script src="{{asset('assets/js/moment.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


		<!-- *************
			************ Vendor Js Files *************
		************* -->

		<!-- Overlay Scroll JS -->
		<script src="{{asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js')}}"></script>
		<script src="{{asset('assets/vendor/overlay-scroll/custom-scrollbar.js')}}"></script>

		<!-- Date Range JS -->
		<script src="{{asset('assets/vendor/daterange/daterange.js')}}"></script>
		<script src="{{asset('assets/vendor/daterange/custom-daterange.js')}}"></script>
		<!-- Data Tables -->
        <script src="{{asset('assets/vendor/datatables/dataTables.min.js')}}"></script>
        <script src="{{asset('assets/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>

        <!-- Custom Data tables -->
        <script src="{{asset('assets/vendor/datatables/custom/custom-datatables.js')}}"></script>
        <!-- iCheck 1.0.1 -->
        <script src="{{asset("/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
        {{-- !-- Dropify JS --> --}}
        <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
        <script>
            $('.dropify').dropify();
            function set_lang(lang) {
                window.location.href = '/lang/'+lang;
            }
            var selected = [];
            function export_excel() {
                // $('#backButton').hide();
                $('#exportExcelBtn').prop('disabled', true);
                // $('.secondList').hide();
                $('#select_all_second').prop('checked', false);
                // $('#select_all').prop('checked', false);
                // $('.select_options').removeClass('active');
                $('#ExportExcel').modal('toggle');
            }
            function check_uncheck() {
                selected = [];
                var all_array = @json($array);
                $('#forwardBtn').removeClass('disabled');
                $('#reverseBtn').addClass('disabled');
                if ($('#select_all').prop('checked')) {
                    $(".select_options").addClass("active");
                    let i = 0;
                    all_array.forEach(element => {
                        selected.push({ id: i, name: element });
                        i++;
                    });
                } else {
                    $(".select_options").removeClass("active");
                }
            }
            function check_uncheckSecond() {
                selected = [];
                $('#forwardBtn').addClass('disabled');
                $('#reverseBtn').removeClass('disabled');
                var second_array = @json($array);
                if ($('#select_all_second').prop('checked')) {
                    $(".unselect_options").removeClass("active");
                } else {
                    let i = 0;
                    second_array.forEach(element => {
                        selected.push({ id: i, name: element });
                        i++;
                    });
                    $(".unselect_options").addClass("active");
                }
            }

            function selectOption(args, name) {
                $('#forwardBtn').removeClass('disabled');
                $('#reverseBtn').addClass('disabled');

                var option_id = 'option' + args;
                var optionElement = document.getElementById(option_id);
                if (!optionElement) {
                    console.error('Element not found:', option_id);
                    return;
                }
                if (optionElement.classList.contains('active')) {
                    optionElement.classList.remove('active');
                    selected = selected.filter(item => item.name !== name);
                } else {
                    optionElement.classList.add('active');
                    selected.push({ id: args, name: name });
                }
            }
            function selectOptionSecond(args, name) {
                $('#forwardBtn').addClass('disabled');
                $('#reverseBtn').removeClass('disabled');

                var option_id = 'option_' + args;
                var optionElement = document.getElementById(option_id);
                if (!optionElement) {
                    console.error('Element not found:', option_id);
                    return;
                }
                if (optionElement.classList.contains('active')) {
                    optionElement.classList.remove('active');
                    selected = selected.filter(item => item.name !== name);
                } else {
                    optionElement.classList.add('active');
                    selected.push({ id: args, name: name });
                }
            }

            function pushSelected() {
                $('#totalSelected').html(selected.length);
                let html = '';
                selected.forEach(element => {
                    let id = element['id'];

                    $('#option'+id).hide();
                    let name = element['name'];
                    html += `<li class="list-group-item active unselect_options"  id="option_`+id+`" onclick="selectOptionSecond('`+id+`', '`+name+`')" style="cursor: pointer;">`+name+`</li>`;
                });
                if (html != '') {
                    $('#exportExcelBtn').prop('disabled', false);
                    $('.secondList').show();
                    $('#secondListContent').html(html);
                } else {
                    $('#exportExcelBtn').prop('disabled', true);
                    $('.secondList').hide();
                    $('#secondListContent').html('');
                }
            }
            function popSelected() {
                $('#totalSelected').html(selected.length);
                $('.select_options').removeClass('active');
                $('.select_options').show();
                $('.unselect_options').hide();

                selected.forEach(element => {
                    $('#option'+element['id']).addClass('active');
                    $('#option'+element['id']).hide();
                    $('#option_'+element['id']).show();
                });
            }
            function closeAlert() {
                $(".alert").alert('close');
            }
        </script>
		<script>
            $(document).ready(function () {

                fill_datatable();

                function fill_datatable(filter_screenId = '',filter_companyId = '',filter_warehouseId = '', filter_fullName = '', filter_fullName_ar = '', filter_mobileNumber = '', filter_nationality_id = '', filter_iqama = '', filter_iqamaExpireyDate = '', filter_email_id = '', filter_job_id = '', filter_dob = '', filter_status_id = '', filter_termination_reason_id = '', filter_interview_date = '', filter_start_date = '', filter_licenseExpireyDate = '', filter_passportNo = '', filter_passportExpireyDate = '', filter_bank_id = '', filter_accountNumber = '', filter_created_at = '', filter_updated_at = '') {
                    var dataTable = $('#customer_data').DataTable({
                        //searching: false,
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        "pagingType": "full_numbers",
                        "autoWidth": false,
                        "drawCallback": function (settings) {
                            $('[data-toggle="tooltip"]').tooltip();
                        },
                        ajax: {

                            url: "{{ route('Drivers.index') }}",
                            data: {
                                filter_screenId: 'Drivers',
                                filter_companyId: filter_companyId,
                                filter_warehouseId: filter_warehouseId,
                                filter_fullName: filter_fullName,
                                filter_fullName_ar: filter_fullName_ar,
                                filter_mobileNumber: filter_mobileNumber,
                                filter_nationality_id: filter_nationality_id,
                                filter_iqama: filter_iqama,
                                filter_iqamaExpireyDate: filter_iqamaExpireyDate,
                                filter_email_id: filter_email_id,
                                filter_job_id: filter_job_id,
                                filter_dob: filter_dob,
                                filter_status_id: filter_status_id,
                                filter_termination_reason_id: filter_termination_reason_id,
                                filter_interview_date: filter_interview_date
                                , filter_start_date: filter_start_date,
                                filter_licenseExpireyDate: filter_licenseExpireyDate,
                                filter_passportNo: filter_passportNo,
                                filter_passportExpireyDate: filter_passportExpireyDate,
                                filter_bank_id: filter_bank_id,
                                filter_accountNumber: filter_accountNumber,
                                filter_created_at: filter_created_at,
                                filter_updated_at: filter_updated_at,
                            }
                        },

                        columns: [
                            {
                                data: 'companyName',
                                name: 'lkp_company.companyName',
                                //visible:false
                            },
                            {
                                data: 'warehouseName',
                                name: 'warehouse.warehouseName',
                                //visible:false
                            },
                            {
                                data: 'fullName',
                                name: 'fullName'
                            },
                            {
                                data: 'mobileNumber',
                                name: 'mobileNumber'
                            },
                            {
                                data: 'iqama',
                                name: 'iqama'
                            },
                            {
                                data: 'job_id',
                                name: 'job_id'
                            },
                            {
                                data: 'driver_status_en',
                                data: 'lkp_driver_status.driver_status_en',
                                render: function (data, type, row, meta) {
                                    if (row.status_id == "1") {
                                        return '<span class="label label-success">' + row.driver_status_en + '</span>';
                                    } else if (row.status_id == "2") {
                                        return '<span class="label label-warning">' + row.driver_status_en + '</span>';
                                    } else if (row.status_id == "3") {
                                        return '<span class="label label-danger">' + row.driver_status_en + '</span>';
                                    } else if (row.status_id == "4") {
                                        return '<span class="label label-default">' + row.driver_status_en + '</span>';
                                    } else if (row.status_id == "5") {
                                        return '<span class="label label-danger">' + row.driver_status_en + '</span>';
                                    }
                                }
                            },
                            {
                                data: 'per_priod',
                                name: 'balance.per_priod'
                            },
                            {
                                data: 'cur_priod',
                                name: 'balance.cur_priod'
                            },
                            {
                                "orderable": false,
                                "targets": -1,
                                data: 'id',
                                "render": function (data, type, row, meta) {
                                    return '<button onclick="select(' + row.id + ',\'' + row.fullName + '\',' + row.per_priod + ',' + row.cur_priod + ',\'' + row.per_range + '\',\'' + row.cur_range + '\');" type="button" class="btn btn-primary btn-xs">Select</button>'

                                }
                                //onclick=\"document.getElementById('row_id').value='"+data+"'\"
                            }

                        ]
                    });


                }


                $('#filter').click(function () {

                    if ($('#filter_companyId').val() != '' ||$('#filter_warehouseId').val() != '' || $('#filter_fullName').val() != '' || $('#filter_fullName_ar').val() != '' || $('#filter_mobileNumber').val() != '' || $('#filter_nationality_id').val() != '' || $('#filter_iqama').val() != '' || $('#filter_iqamaExpireyDate').val() != '' || $('#filter_email_id').val() != '' || $('#filter_job_id').val() != '' || $('#filter_dob').val() != '' || $('#filter_status_id').val() != '' || $('#filter_termination_reason_id').val() != '' || $('#filter_interview_date').val() != '' || $('#filter_start_date').val() != '' || $('#filter_licenseExpireyDate').val() != '' || $('#filter_passportNo').val() != '' || $('#filter_passportExpireyDate').val() != '' || $('#filter_bank_id').val() != '' || $('#filter_accountNumber').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                        card_change();
                        $('#customer_data').DataTable().destroy();
                        fill_datatable('Drivers',$('#filter_companyId').val(),$('#filter_warehouseId').val(), $('#filter_fullName').val(), $('#filter_fullName_ar').val(), $('#filter_mobileNumber').val(), $('#filter_nationality_id').val(), $('#filter_iqama').val(), $('#filter_iqamaExpireyDate').val(), $('#filter_email_id').val(), $('#filter_job_id').val(), $('#filter_dob').val(), $('#filter_status_id').val(), $('#filter_termination_reason_id').val(), $('#filter_interview_date').val(), $('#filter_start_date').val(), $('#filter_licenseExpireyDate').val(), $('#filter_passportNo').val(), $('#filter_passportExpireyDate').val(), $('#filter_bank_id').val(), $('#filter_accountNumber').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
                    } else {
                        alert('Select filter option');
                    }
                });

                $('#reset').click(function () {
                    $('#filter_companyId').val('');
                    $('#filter_warehouseId').val('');
                    $('#filter_fullName').val('');
                    $('#filter_fullName_ar').val('');
                    $('#filter_mobileNumber').val('');
                    $('#filter_nationality_id').val('');
                    $('#filter_iqama').val('');
                    $('#filter_iqamaExpireyDate').val('');
                    $('#filter_email_id').val('');
                    $('#filter_job_id').val('');
                    $('#filter_dob').val('');
                    $('#filter_status_id').val('');
                    $('#filter_termination_reason_id').val('');
                    $('#filter_interview_date').val('');
                    $('#filter_start_date').val('');
                    $('#filter_licenseExpireyDate').val('');
                    $('#filter_passportNo').val('');
                    $('#filter_passportExpireyDate').val('');
                    $('#filter_bank_id').val('');
                    $('#filter_accountNumber').val('');
                    $('#filter_created_at').val('');
                    $('#filter_updated_at').val('');


                    $('#customer_data').DataTable().destroy();
                    fill_datatable();
                });


            });


            function status() {
                var status_id = document.getElementById('status_id').value;
                if (status_id == "3")
                    document.getElementById("Termination_Reason").style.display = '';
                else
                    document.getElementById("Termination_Reason").style.display = 'none';
            }

            function select(id, name, per_priod, cur_priod, per_range, cur_range) {
                //alert(opener.document.getElementById('driverId_text').innerHTML);
                if (opener.document.getElementById('driverId')) {
                    opener.document.getElementById('driverId_input').value = name;
                    opener.document.getElementById('driverId').value = id;
                }
                if (opener.document.getElementById('filter_driverId')) {
                    opener.document.getElementById('filter_driverId_input').value = name;
                    opener.document.getElementById('filter_driverId').value = id;
                }

                if (opener.document.getElementById('balance')) {

                    if (per_priod == null) per_priod = 0;
                    if (cur_priod == null) cur_priod = 0;
                    opener.document.getElementById('balance').innerHTML = "<table>" +
                        "<tr><TH>Perivious Balance:</TH><td><font color=red>" + per_priod + "</font>  (" + per_range + ")<td></tr>" +
                        "<tr><TH style='text-align: right;'>Current Balance:</TH><td><font color=red>" + cur_priod + "</font>  (" + cur_range + ")<td></tr>" +
                        "</table>";


                }
                close();
            }

            function WarehouseName() {

                var filter_companyId = document.getElementById('filter_companyId').value;

                $('#filter_warehouseId').empty();

                $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                    $('#filter_warehouseId').empty();
                    $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                    $.each(json, function (i, obj) {
                        $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                    });
                });

            }
        </script>
	</body>

</html>
