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

    .Font-Green {
        color: green;
        font-weight: bold;
    }

    .Font-Red {
        color: red;
        font-weight: bold;
    }
</style>
<table border="0" style="font-size: 14px;font-weight: bold;">
    <tr>
        <td style="width: 300px">Salary</td>
        <td style="width: 200px">Company :<span style="color: red; "> {{$companyName}}</span></td>


        <td style="width: 300px">Period :

            <div id="salary_range" style="display: inline !important;"></div>
            <input name="companyId" id="companyId" type="hidden" value="">
            <input name="Period" id="Period" type="hidden" value="">

        </td>


    </tr>
</table>
<!-- Content Header (Page header) -->

<div class="table-responsive" style="width: 100%;">
    <table id="customer_data" class="table table-bordered table-striped">
        <thead>
        <tr>

            <TH>City</TH>
            <TH>Whouse</TH>
            <TH>Driver</TH>
            <TH>ID</TH>
            <TH>30 Pack</TH>
            <TH>Final Pack</TH>
            <TH>Match</TH>
            <TH>GAP</TH>
            <TH>Days</TH>
            <TH>Carried Down</TH>
            <TH>Credit</TH>
            <TH>Debit</TH>
            <TH>Loan</TH>
            <TH>CN</TH>
            <TH>IND</TH>
            <TH>Bank</TH>
            <TH>Expected Salary</TH>
            <TH>Paid Salary</TH>
            <TH>T</TH>
            <TH>Brought Down</TH>
            <TH>Action</TH>
            <TH style="display:none;">Bank Name</TH>
            <TH style="display:none;">AccountNumber</TH>
            <TH style="display:none;">DriverId</TH>
            <TH style="display:none;">Account Owner Iqama</TH>
        </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
        <tr>
            <TH colspan='4'>Total</TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
            <TH></TH>
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

        <div style="width:100%;clear:both;padding: 0.0rem 1.0rem !important;" id="response">
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

        function fill_datatable(filter_companyId = '', filter_cityId = '', filter_warehouseId = '', filter_Period = '', filter_PaidType = '') {
            var dataTable = $('#customer_data').DataTable({

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


                //searching: false,
                responsive: true,
                processing: true,
                serverSide: true,
                "order": [[10, "desc"]],
                "pagingType": "full_numbers",
                "autoWidth": false,

                "fnDrawCallback": function () {
                    $('[data-toggle="tooltip"]').tooltip();
                    $(function () {
                        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                            checkboxClass: 'icheckbox_flat-green',
                            radioClass: 'iradio_flat-green'
                        });


                        $('#select-all').on('ifChecked ifUnchecked', function (event) {
                            if (document.getElementById('select-all').checked) {

                                $('.flat-red').iCheck('check')
                            } else
                                $('.flat-red').iCheck('uncheck');
                        });
                    });

                    //------------------------------------------------------------------------------------
                    var api = this.api()
                    var json = api.ajax.json();
                    $('#salary_range').html(json.salary_range);
                    $('#Period').val(json.Period);
                    $('#companyId').val(json.companyId);

                    $(api.column(4).footer()).html(json.total_No_of_TP);
                    $(api.column(5).footer()).html(json.No_of_TouchPoint);
                    $(api.column(6).footer()).html(json.matching);

                    $(api.column(7).footer()).html(json.GAP);

                    $(api.column(9).footer()).html(json.carried_down);
                    $(api.column(10).footer()).html(json.credit_now);
                    $(api.column(11).footer()).html(json.debit_now);

                    $(api.column(12).footer()).html(json.Loan);
                    $(api.column(13).footer()).html(json.CreditNote);
                    $(api.column(14).footer()).html(json.IND);
                    $(api.column(15).footer()).html(json.BANK_TRANSFER);
                    $(api.column(16).footer()).html(json.expected_salary);
                    $(api.column(17).footer()).html(json.paid_salary);
                    $(api.column(18).footer()).html(json.matching_transaction);
                    $(api.column(19).footer()).html(json.brought_down);

                },
                ajax: {
                    url: "{{ route('Salary.index') }}",
                    data: {
                        <?php
                            if ($id <> 'm') {
                                echo "filter_companyId: " . $id . ",\n";
                            } else
                                echo "filter_companyId: filter_companyId,\n";
                            ?>
                        filter_cityId: filter_cityId,
                        filter_warehouseId: filter_warehouseId,

                        <?php
                            if ($m <> 'm') {
                                echo "filter_Period: '" . $m . "',\n";
                            } else
                                echo "filter_Period: filter_Period,\n";
                            ?>
                        filter_PaidType: '{{$type}}',

                    }
                },

                columns: [

                    {
                        data: 'city_name',
                        name: 'city_name'
                    },
                    {
                        data: 'warehouseName',
                        name: 'warehouseName',
                    },
                    {
                        data: 'fullName',

                        render: function (data, type, row, meta) {
                            return '<a href="javascript:driver(' + row.driverId + ')">' + data + '</a>';
                        }

                    },
                    {
                        data: 'job_id',
                        name: 'job_id'
                    },
                    {
                        data: 'total_No_of_TP',
                        name: 'total_No_of_TP',
                    },
                    {
                        data: 'No_of_TouchPoint',
                        name: 'No_of_TouchPoint',
                    },
                    {
                        data: 'matching',
                        render: function (data, type, row, meta) {
                            if (data == "Yes") {
                                return '<span class="label label-success">' + row.matching + '</span>';
                            } else if (data == "No") {
                                return '<span class="label label-danger">' + row.matching + '</span>';
                            }
                        }
                    },
                    {
                        data: 'GAP',
                        name: 'GAP',
                    },
                    {
                        data: 'daycount',
                        name: 'daycount',
                    },
                    {
                        data: 'carried_down',
                        render: function (data, type, row, meta) {
                            if (row.carried_down > 0) {
                                return '<span class="Font-Green">' + row.carried_down + '</span>';
                            } else if (row.carried_down < 0) {
                                return '<span class="Font-Red">' + row.carried_down + '</span>';
                            } else return '';
                        }
                    },
                    {
                        className: "Font-Green",
                        data: 'credit_now',
                        name: 'credit_now',
                    },
                    {
                        className: "Font-Red",
                        data: 'debit_now',
                        name: 'debit_now',
                    },
                    {
                        data: 'Loan',
                        name: 'Loan',
                    },
                    {
                        data: 'CreditNote',
                        name: 'CreditNote',
                    },
                    {
                        data: 'IND2',
                        render: function (data, type, row, meta) {
                            if (row.IND)
                                return row.IND;
                            else {
                                if (row.under_sopnsorship_id == "1") {
                                    return '200<input name="IND_' + meta.row + '" type="hidden" class="form-control" style="width:25px" value="200">'
                                } else return '';
                            }
                        }
                    },
                    {
                        data: 'BANK_TRANSFER2',
                        render: function (data, type, row, meta) {
                            if (row.BANK_TRANSFER)
                                return row.BANK_TRANSFER;
                            else {
                                if (row.bank_id != "2") {
                                    return '10<input name="BANK_TRANSFER_' + meta.row + '" type="hidden" class="form-control" style="width:25px" value="10">'

                                } else
                                    return '';
                            }
                        }
                    },
                    {
                        data: 'expected_salary',
                        name: 'expected_salary',
                    },
                    {
                        className: "dt-nowrap",
                        data: 'paid_salary',
                        render: function (data, type, row, meta) {
                            if (!row.paid_salary)
                                return '<input name="paid_salary_' + meta.row + '" type="text" class="form-control" style="width:50px" value="' + row.edit_salary + '">' +
                                    '&nbsp;<input class="flat-red" name="ID_' + meta.row + '" type="checkbox" value="' + row.driverId + '">'
                            else return row.paid_salary;
                        }
                    },
                    {
                        data: 'matching_transaction',
                        render: function (data, type, row, meta) {
                            if (data == "Yes") {
                                return '<span class="label label-success">' + row.matching_transaction + '</span><b>' + row.amount + '</b>';
                            } else if (data == "No") {
                                return '<span class="label label-danger">' + row.matching_transaction + '</span><b>' + row.amount + '</b>';
                            } else if (data == "Null") {
                                return '<span class="label label-warning">' + row.matching_transaction + '</span><b>' + row.amount + '</b>';
                            }
                        }
                    },
                    {
                        data: 'brought_down',
                        render: function (data, type, row, meta) {
                            if (row.brought_down > 0) {
                                return '<span class="Font-Green">' + row.brought_down + '</span>';
                            } else if (row.brought_down < 0) {
                                return '<span class="Font-Red">' + row.brought_down + '</span>';
                            } else return '';
                        }
                    },
                    {
                        "orderable": false,
                        "searchable": false,
                        className: "dt-nowrap",
                        "targets": -1,
                        //"data": 'id',
                        "render": function (data, type, row, meta) {
                            return '<a id=' + row.driverId + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>' +
                                '&nbsp;<a id=' + row.driverId + ' data-original-title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement"> <i class="fa fa-bars"></i> </a>';


                        }
                        //onclick=\"document.getElementById('row_id').value='"+data+"'\"
                    },

                    {
                        visible: false,
                        data: 'bank_name_en',
                        name: 'bank_name_en',
                    },
                    {
                        visible: false,
                        data: 'accountNumber',
                        name: 'accountNumber',
                    },
                    {
                        visible: false,
                        data: 'driverId',
                        name: 'driverId',
                    },
                    {
                        visible: false,
                        data: 'iqama',
                        name: 'iqama',
                    },

                ]
            });


        }

        $('#customer_data tbody').on('click', '.view', function (e) {
            //alert("{{URL('/SalaryShow')}}" + "/" + id + "/" + document.getElementById('Period').value);
            e.preventDefault();
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';

            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: "{{URL('/SalaryShow')}}" + "/" + id + "/" + document.getElementById('Period').value,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;

                }
            });
        });

        $('#customer_data tbody').on('click', '.statement', function (e) {
            e.preventDefault();
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: "{{URL('/statement')}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;


                }
            });

        });

        $('#filter').click(function () {
            if ($('#filter_companyId').val() != '' && $('#filter_Period').val() != '') {

                $('#customer_data').DataTable().destroy();
                fill_datatable($('#filter_companyId').val(), $('#filter_cityId').val(), $('#filter_warehouseId').val(), $('#filter_Period').val());
            } else {
                if ($('#filter_companyId').val() == '')
                    alert('Select Company');
                else if ($('#filter_Period').val() == '')
                    alert('Select Period');
            }
        });

        $('#reset').click(function () {
            $('#companyId').val('');
            $('#Period').val('');

            $('#filter_companyId').val('');
            $('#filter_cityId').empty();
            $('#filter_warehouseId').empty();
            $('#filter_Period').empty();


            $('#customer_data').DataTable().destroy();
            fill_datatable();
        });

    });


    function selectall() {

        if (document.getElementById('select-all').checked) {

            $('.aprove-checkbox').iCheck('check');

        } else
            $('.aprove-checkbox').iCheck('uncheck');
    }

    function CityName() {
        var filter_companyId = document.getElementById('filter_companyId').value;
        if (filter_companyId == "") {
            $('#filter_cityId').empty();
            $('#filter_warehouseId').empty();
            $('#filter_Period').empty();
        } else {

            $.getJSON("{{URL("/getPeriod")}}" + "/" + filter_companyId, function (json) {
                $('#filter_Period').empty();
                $('#filter_warehouseId').empty();
                //$('#filter_Period').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {
                    $('#filter_Period').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });
            //----------------------------------------------------------------------------------------------------------------------
            $.getJSON("{{URL("/getCityName")}}" + "/" + filter_companyId, function (json) {
                $('#filter_cityId').empty();
                $('#filter_warehouseId').empty();
                $('#filter_cityId').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {
                    $('#filter_cityId').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });
        }
    }

    function Warehouse() {
        var filter_cityId = document.getElementById('filter_cityId').value;
        if (filter_cityId == "")
            $('#filter_warehouseId').empty();
        else {
            $.getJSON("{{URL("/getWarehouse")}}" + "/" + filter_cityId, function (json) {
                $('#filter_warehouseId').empty();
                $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {
                    $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                });
            });
        }
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

    function sheet(id, Period) {
        myWindow1 = window.open("{{URL('/SalaryShow')}}" + "/" + id + "/" + Period, "",
            "height=1000,width=650,scrollbars=yes,top=1,left=1,status,resizable");
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


