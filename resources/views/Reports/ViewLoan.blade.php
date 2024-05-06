<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Almashwar</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/bootstrap.min.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/font-awesome/font-awesome.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/ionicons.min.css")}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.css")}}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
          href="{{asset("/AdminLTE/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")}}">
    <!-- Theme style -->
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/plugins/iCheck/all.css")}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/_all-skins.min.css")}}">
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/dataTables.bootstrap.css")}}">
    <!--<link href="https://datatables.yajrabox.com/css/datatables.bootstrap.css" rel="stylesheet">-->
    <!--<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/w3.css")}}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/customize.css")}}">
</head>
@include('pages.loader')


<style>
    body {
        padding: 1.3rem 2.0rem !important;
    }
</style>
<!-- Content Header (Page header) -->
<table border="0" style="font-size: 14px;font-weight: bold;">
    <tr>
        <td style="width: 300px">Loans</td>
        <td style="width: 200px">Company :<span style="color: red; "> {{$companyName}}</span></td>
        <td style="width: 200px">StatusType :<span style="color: red; "> <?php
                switch ($type) {
                    case 1:
                        echo "Pending";
                        break;
                    case 2:
                        echo "Rejected";
                        break;
                    case 5:
                        echo "Approved_by_Supervisor";
                        break;
                    case 3:
                        echo "Approved";
                        break;
                    case 4:
                        echo "Paid";
                        break;
                    case 10:
                        echo "All ";
                        break;
                }
                ?></span></td>
        @if ($m<>'m')
            <td style="width: 300px">Period :<span style="color: red; "> {{$m}}</span></td>
        @else
            <td style="width: 300px">Period :<span style="color: red; "> All</span></td>
        @endif

    </tr>
</table>

<!--w3-table-all w3-card-4-->
<!-- table table-bordered table-striped  -->


<!-- Content Header (Page header) -->
<!---------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------->


<?php //echo Hash::make('password');?>
<div class="table-responsive" style="width: 100%;">
    <table id="customer_data" class="table table-bordered table-striped">
        <thead>
        <TH>Create</TH>
        <TH>Comp</TH>
        <TH>WHouse</TH>
        <TH>Job ID</TH>
        <TH>Driver</TH>
        <TH>previous Balance</TH>
        <TH>Current Balance</TH>
        <TH>Journal Date</TH>
        <TH>Journal Period</TH>
        <TH>Amount</TH>
        <TH>Note</TH>
        <TH>Status</TH>

        <TH>Updated At</TH>

        <TH style="display:none;">DriverId</TH>
        <TH style="display:none;">Account Owner Iqama</TH>
        </thead>
        <tbody></tbody>
        <tfoot>
        <tr>
            <TH colspan='9'>Total</TH>
            <TH></TH>
            <TH colspan='5'></TH>
        </tr>
        </tfoot>
    </table>
</div>
<!---------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------->
<div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
        <div class="w3-center"><br>
            <span onclick="document.getElementById('edit_modal').style.display='none'"
                  class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                  title="Close Modal">&times;</span>
        </div>

        <div style="width:100%;clear:both;" id="response">

        </div>
        <br>
        <br>
    </div>
</div>
<div id="delete_modal" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
        <div class="w3-center"><br>
            <span onclick="document.getElementById('delete_modal').style.display='none'"
                  class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                  title="Close Modal">&times;</span>
        </div>
        <header class="w3-container w3-text-indigo w3-margin-top-64">
            <h1>Delete</h1>
        </header>
        <form class="w3-container" action="" method="POST" id="delete_form">
            {{method_field('DELETE')}}
            @csrf
            <div class="w3-section">
                <p>Are you sure, you want to delete <span id="delete_name"></span> ?</p>
                <div class="w3-center">
                    <button type="submit" class="w3-btn w3-indigo"> Delete</button>
                </div>
            </div>
        </form>
        <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
            <button onclick="document.getElementById('delete_modal').style.display='none'" type="button"
                    class="w3-btn w3-red">Cancel
            </button>
        </div>
    </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------->


<script>
    $(document).ready(function () {

        fill_datatable();


        function fill_datatable(filter_companyId = '', filter_warehouseId = '', filter_job_id = '', filter_driverId = '', filter_journal_date = '', filter_amount = '', filter_status_id = '', filter_note = '', filter_updatedby_id = '', filter_updated_usertypeid = '', filter_created_at = '', filter_updated_at = '') {
            var dataTable = $('#customer_data').DataTable({

                //searching: false,
                responsive: true,
                processing: true,
                serverSide: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
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
                "order": [[12, "desc"]],
                "pagingType": "full_numbers",
                "autoWidth": false,
                "drawCallback": function (settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                    var api = this.api()
                    var json = api.ajax.json();
                    $(api.column(9).footer()).html(json.amount);

                },
                ajax: {
                    url: "{{ route('Loans.index') }}",
                    data: {
                        <?php
                            if ($id <> 'm') {
                                echo "filter_companyId: " . $id . ",\n";
                            } else
                                echo "filter_companyId: filter_companyId,\n";
                            ?>
                        filter_warehouseId: filter_warehouseId,
                        filter_job_id: filter_job_id,
                        filter_driverId: filter_driverId,
                        <?php
                            if ($m <> 'm') {
                                $date = explode(" - ", $m);
                                $start = explode("-", $date[0]);
                                $end = explode("-", $date[1]);
                                $d = $start[2] . '/' . $start[1] . '/' . $start[0] . ' - ' . $end[2] . '/' . $end[1] . '/' . $end[0];
                                echo "filter_journal_date: '" . $d . "',\n";
                            } else
                                echo "filter_journal_date: filter_journal_date,\n";
                            ?>
                        filter_amount: filter_amount,
                        <?php
                            if ($type <> '10')
                                echo "filter_status_id: " . $type . ",\n";
                            else
                                echo "filter_status_id: filter_status_id,\n";
                            ?>
                        filter_note: filter_note,
                        filter_updatedby_id: filter_updatedby_id,
                        filter_updated_usertypeid: filter_updated_usertypeid,
                        filter_created_at: filter_created_at,
                        filter_updated_at: filter_updated_at,
                    }
                },

                columns: [
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'companyName',
                        name: 'lkp_company.companyName'
                    },
                    {
                        data: 'warehouseName',
                        name: 'warehouse.warehouseName'
                    },
                    {
                        data: 'job_id',
                        name: 'drivers.job_id'
                    },
                    {
                        data: 'fullName',
                        name: 'drivers.fullName',
                        render: function (data, type, row, meta) {
                            return '<a href="javascript:driver(' + row.driverId + ')">' + data + '</a>';
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
                        data: 'journal_date',
                        name: 'journal_date'
                    },
                    {
                        data: 'journal_period',
                        name: 'journal_period',
                        bSearchable: false
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'note',
                        name: 'note'
                    },
                    {
                        data: 'loan_status',
                        name: 'lkp_loan_status.loan_status',
                        render: function (data, type, row, meta) {
                            if (row.status_id == "1") {
                                return '<span class="label label-warning">' + row.loan_status + '</span>';
                            } else if (row.status_id == "2") {
                                return '<span class="label label-danger">' + row.loan_status + '</span>';
                            } else if (row.status_id == "3") {
                                return '<span class="label label-primary">' + row.loan_status + '</span>';
                            } else if (row.status_id == "4") {
                                return '<span class="label label-success">' + row.loan_status + '</span>';
                            } else if (row.status_id == "5") {
                                return '<span class="label label-info">' + row.loan_status + '</span>';
                            }
                        }
                    },


                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },

                    {
                        visible: false,
                        data: 'driverId',
                        name: 'loan.driverId',
                    },
                    {
                        visible: false,
                        data: 'iqama',
                        name: 'drivers.iqama',
                    },

                ]
            });


        }

        $('#customer_data tbody').on('click', '.view', function (e) {
            e.preventDefault();
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: "{{URL('/Loans')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;

                }
            });
        });
        $('#customer_data tbody').on('click', '.edit', function (e) {

            var id = $(this).attr('id');
            myWindow1 = window.open("{{URL('/Loans')}}" + "/" + id + "/edit", "",
                "height=650,width=600,scrollbars=yes,top=1,left=1,status,resizable");


        });
        $('#customer_data tbody').on('click', '.updatePaid', function (e) {

            var id = $(this).attr('id');
            myWindow1 = window.open("{{URL('/LoanPaid')}}" + "/" + id, "",
                "height=650,width=600,scrollbars=yes,top=1,left=1,status,resizable");

        });

        $('#customer_data tbody').on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            document.getElementById('delete_form').action = "{{URL('/Loans')}}" + "/" + id;
            document.getElementById('delete_modal').style.display = 'block';
        });

        $('#filter').click(function () {
            if ($('#filter_companyId').val() != '' || $('#filter_warehouseId').val() != '' || $('#filter_job_id').val() != '' || $('#filter_driverId').val() != '' || $('#filter_journal_date').val() != '' || $('#filter_amount').val() != '' || $('#filter_status_id').val() != '' || $('#filter_note').val() != '' || $('#filter_updatedby_id').val() != '' || $('#filter_updated_usertypeid').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                card_change();
                $('#customer_data').DataTable().destroy();
                fill_datatable($('#filter_companyId').val(), $('#filter_warehouseId').val(), $('#filter_job_id').val(), $('#filter_driverId').val(), $('#filter_journal_date').val(), $('#filter_amount').val(), $('#filter_status_id').val(), $('#filter_note').val(), $('#filter_updatedby_id').val(), $('#filter_updated_usertypeid').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
            } else {
                alert('Select filter option');
            }
        });

        $('#reset').click(function () {

            $('#filter_companyId').val('');
            $('#filter_warehouseId').val('');
            $('#filter_job_id').val('');
            $('#filter_driverId').val('');
            $('#filter_driverId_input').val('');
            $('#filter_journal_date').val('');
            $('#filter_amount').val('');
            $('#filter_status_id').val('');
            $('#filter_note').val('');
            $('#filter_updatedby_id').val('');
            $('#filter_updated_usertypeid').val('');
            $('#filter_created_at').val('');
            $('#filter_updated_at').val('');


            $('#customer_data').DataTable().destroy();
            fill_datatable();
        });


    });


    function add() {
        document.getElementById('response').innerHTML = loader;
        document.getElementById('edit_modal').style.display = 'block';
        $.ajax({
            type: 'GET',
            url: "{{URL("/Loans/create")}}",
            contentType: "html",
            dataType: 'html',
            success: function (data) {

                document.getElementById('response').innerHTML = data;
                var g = document.createElement('script');
                var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
                g.text = "$('#journal_date').datepicker({" +
                    "format: 'dd/mm/yyyy'," +
                    "autoclose: true," +
                    "autoHide: true," +
                    "zIndex: 9999," +
                    "});"
                s.parentNode.insertBefore(g, s);
            }
        });
    }

    function status() {
        var status_id = document.getElementById('status_id').value;
        if (status_id == "3")
            document.getElementById("Termination_Reason").style.display = '';
        else
            document.getElementById("Termination_Reason").style.display = 'none';
    }

    function driver_window() {
        myWindow1 = window.open("{{URL("/DriverWindow")}}", "",
            "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
    }

    function driver(id) {
        document.getElementById('response').innerHTML = loader;
        document.getElementById('edit_modal').style.display = 'block';
        $.ajax({
            type: 'GET',
            url: "{{URL("/Drivers")}}" + "/" + id,
            contentType: "html",
            dataType: 'html',
            success: function (data) {

                document.getElementById('response').innerHTML = data;

            }
        });
    }

    function WarehouseName() {

        var filter_companyId = document.getElementById('filter_companyId').value;
        if (filter_companyId == "")
            $('#filter_warehouseId').empty();
        else {
            $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                $('#filter_warehouseId').empty();
                $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {
                    $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });
        }
    }
</script>

<!-- ./wrapper -->

<!-- jQuery 3 -->

<script src="{{asset("/AdminLTE/js/jquery.min.js")}}"></script>


<script src="{{asset("/AdminLTE/js/select2.full.min.js")}}"></script>
<!-- Bootstrap 3.3.7 -->

<script src="{{asset("/AdminLTE/js/bootstrap.min.js")}}"></script>
<!-- date-range-picker -->
<script src="{{asset("/AdminLTE/moment/min/moment.min.js")}}"></script>
<script src="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.js")}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset("/AdminLTE/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")}}"></script>


<script src="{{asset("/AdminLTE/js/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/AdminLTE/js/dataTables.bootstrap.min.js")}}"></script>

<!--<script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>-->


<script src="{{asset("/AdminLTE/js/dataTables.buttons.min.js")}}"></script>
<script src="{{asset("/AdminLTE/js/buttons.html5.js")}}"></script>


<script src="{{asset("/AdminLTE/js/jszip.min.js")}}"></script>


<!-- FastClick -->
<script src="{{asset("/AdminLTE/js/fastclick.js")}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset("/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("/AdminLTE/js/adminlte.min.js")}}"></script>







