@extends('AdminLTE')
@section('content')

    <section class="content-header">
        <h1>
            Driver Invoices
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Driver Invoices By Supervisors</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="driver_invoice" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <TH>Warehouse</TH>
                                <TH>Warehouse Company</TH>
                                <TH>Supervisor</TH>
                                <TH>driver</TH>
                                <TH>Invoice Company</TH>
                                <TH>Vat Number</TH>
                                <TH>Invoice Number</TH>
                                <TH>Amount</TH>
                                <TH>Date</TH>
                                <TH>Description</TH>
                                <TH>Created_at</TH>
                            </tr>
                            </thead>
                            <tbody></tbody>


                        </table>
                    </div><!-- ./box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
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


    </section>






    <script>
        $(document).ready(function () {

            fill_datatable();

            function fill_datatable(pakage_date = '', filter_companyId = '', filter_cityId = '', filter_warehouseId = '', filter_under_noon_id = '') {
                var dataTable = $('#driver_invoice').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "order": [[3, "desc"]],
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "drawCallback": function (settings) {
                        $('[data-toggle="tooltip"]').tooltip();
                    },

                    ajax: {
                        url: "{{ route('driverInvoices.index') }}",
                    },

                    columns: [
                        {
                            data: 'warehouseName',
                            name: 'warehouseName',
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:Warehouse(' + row.warehouseId + ')">' + data + '</a>';
                            }
                            //visible:false
                        },
                        {
                            data: 'companyName',
                            name: 'lkp_company.companyName',
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:company(' + row.companyId + ')">' + data + '</a>';
                            }
                        },
                        {
                            data: 'name',
                            name: 'name',
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:user(' + row.userId + ')">' + data + '</a>';
                            }
                        },
                        {
                            data: 'fullName',
                            name: 'fullName',
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:driver(' + row.driverId + ')">' + data + '</a>';
                            }
                        },
                        {
                            data: 'invoiceCompany',
                            name: 'invoiceCompany',

                        },

                        {
                            data: 'vatNumber',
                            name: 'vatNumber',
                        },
                        {
                            data: 'invoiceNumber',
                            name: 'invoiceNumber',
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                        },
                        {
                            data: 'date',
                            name: 'date',
                        },
                        {
                            data: 'description_en',
                            name: 'description_en',
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        }

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
                    url: "{{URL('/Warehouses')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.edit', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Warehouses')}}" + "/" + id + "/edit",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.driver', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/WarehouseDrivers')}}" + "/" + id + "/" + document.getElementById('name_' + id).value + "?dt=" + document.getElementById('pakage_date').value,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;
                        var g = document.createElement('script');
                        var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
                        g.text = "$(function () {" +
                            "$('input[type=\"checkbox\"].flat-red, input[type=\"radio\"].flat-red').iCheck({" +
                            "checkboxClass: 'icheckbox_flat-green'," +
                            " radioClass   : 'iradio_flat-green'" +
                            "});" +
                            "$('input[type=\"checkbox\"].complete-checkbox, input[type=\"radio\"].complete-checkbox').iCheck({" +
                            "checkboxClass: 'icheckbox_flat-blue'," +
                            " radioClass   : 'iradio_flat-blue'" +
                            "});" +
                            "$('input[type=\"checkbox\"].approve-checkbox, input[type=\"radio\"].approve-checkbox').iCheck({" +
                            "checkboxClass: 'icheckbox_flat-red'," +
                            " radioClass   : 'iradio_flat-red'" +
                            "});" +
                            "$('#select-all').on('ifChecked ifUnchecked', function (event) {" +
                            "selectall();" +
                            "});" +
                            "$('#approve-all').on('ifChecked ifUnchecked', function (event) {" +
                            "approveall();" +
                            "});" +
                            "$('.flat-red').on('ifChecked ifUnchecked', function (event) {" +
                            "var str = $(this).attr('name');" +
                            "complete(str);" +
                            "});" +
                            "$('.complete-checkbox').on('ifChecked ifUnchecked', function (event) {" +
                            "var str = $(this).attr('name');" +
                            "approve(str);" +
                            "});" +
                            "});";

                        s.parentNode.insertBefore(g, s);

                    }
                });

            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Warehouses')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';


            });

            $('#filter').click(function () {
                if ($('#pakage_date').val() != '' & $('#filter_companyId').val() != '') {
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#pakage_date').val(), $('#filter_companyId').val(), $('#filter_cityId').val(), $('#filter_warehouseId').val(), $('#filter_under_noon_id').val());
                } else {
                    alert('Select Company and pakage_date');
                }
            });


        });


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
        function user(id) {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Users")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;

                }
            });
        }

        function Warehouse(id) {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Warehouses")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;

                }
            });
        }

        function company(id) {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Company")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;

                }
            });
        }
    </script>


@endsection
