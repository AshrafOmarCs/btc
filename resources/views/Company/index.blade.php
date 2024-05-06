@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Company</h2>
        </div>
        <div style="float:right;">
            <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Company</a>
            </h2>
        </div>
    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->


    <script>
        function card_change() {
            if (document.getElementById('card_box').className == "box box-primary") {
                document.getElementById('card_box').className = "box box-primary collapsed-box";
                document.getElementById('i_box').className = "fa fa-plus";
                document.getElementById('box-body').style.display = 'none';
            } else {
                document.getElementById('card_box').className = "box box-primary";
                document.getElementById('i_box').className = "fa fa-minus";
                document.getElementById('box-body').style.display = '';
            }
        }
    </script>
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>
                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box"
                                                                                             class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
                <table class="table m-0 search_table" style="width:10px!important;">
                    <tr>
                        <TH>CompanyName</TH>
                        <td><input type="text" class="form-control" style="width:180px;" name="filter_companyName"
                                   id="filter_companyName"></td>

                        <TH>calculation_method</TH>
                        <td>
                            <select id="filter_calculation_method_id" name="filter_calculation_method_id"
                                    class="form-control"
                                    style="width:180px;">
                                <option value=""></option>

                                @foreach($lkp_calculation_method as $lkp_calculation_methodd)
                                    <option value="{{$lkp_calculation_methodd->id}}">{{$lkp_calculation_methodd->calculation_method}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>period_start</TH>
                        <td><input type="text" class="form-control" name="filter_period_start" id="filter_period_start">
                        </td>
                    </tr>
                    <tr>
                        <TH>period_end</TH>
                        <td><input type="text" class="form-control" name="filter_period_end" id="filter_period_end">
                        </td>
                        <TH>companyFullName_en</TH>
                        <td><input type="text" class="form-control" style="width:180px;"
                                   name="filter_companyFullName_en"
                                   id="filter_companyFullName_en" value=""></td>
                        <TH>companyFullName_ar</TH>
                        <td><input type="text" class="form-control" style="width:180px;"
                                   name="filter_companyFullName_ar"
                                   id="filter_companyFullName_ar" value=""></td>
                    </tr>
                    <tr>

                        <TH>TaxNumber</TH>
                        <td><input type="text" class="form-control" name="filter_TaxNumber" id="filter_TaxNumber"
                                   value=""></td>
                        <TH>CreditNote_Letter</TH>
                        <td><input type="text" class="form-control" name="filter_CreditNote_Letter"
                                   id="filter_CreditNote_Letter" value=""></td>

                    </tr>
                    <tr>
                        <TH>Created_At</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" name="filter_created_at" id="filter_created_at" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_created_at"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_created_at"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_created_at"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });
                                </script>
                            </div>
                        </td>
                        <TH>Updated_At</TH>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control" id="filter_updated_at" name="filter_updated_at" type="text">
                                <script>
                                    $(function () {
                                        $('input[name="filter_updated_at"]').daterangepicker({
                                            autoUpdateInput: false,
                                            opens: 'left',
                                            locale: {
                                                cancelLabel: 'Cancel'
                                            }
                                        });
                                        $('input[name="filter_updated_at"]').on('apply.daterangepicker', function (ev, picker) {
                                            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                        });
                                        $('input[name="filter_updated_at"]').on('cancel.daterangepicker', function (ev, picker) {
                                            $(this).val('');
                                        });
                                    });
                                </script>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="card-footer" align="center">
                    <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Filter</button>

                    <button type="button" name="reset" class="btn btn-sm btn-default" id="reset">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->


    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->


    <?php //echo Hash::make('password');?>
    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
            <TH>companyName</TH>
            <TH>calculation_method</TH>
            <TH>period_start</TH>
            <TH>period_end</TH>
            <TH>companyFullName_en</TH>
            <TH>companyFullName_ar</TH>
            <TH>TaxNumber</TH>
            <TH>CreditNote_Letter</TH>
            <TH>updated_by</TH>
            <TH>updated_at</TH>
            <TH>Action</TH>
            </thead>
            <tbody></tbody>

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


            function fill_datatable(filter_companyName = '', filter_calculation_method_id = '', filter_period_start = '', filter_period_end = '', filter_companyFullName_en = '', filter_companyFullName_ar = '', filter_TaxNumber = '', filter_CreditNote_Letter = '', filter_created_at = '', filter_updated_at = '') {
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
                        url: "{{ route('Company.index') }}",
                        data: {
                            filter_companyName: filter_companyName,
                            filter_calculation_method_id: filter_calculation_method_id,
                            filter_period_start: filter_period_start,
                            filter_period_end: filter_period_end,
                            filter_companyFullName_en: filter_companyFullName_en,
                            filter_companyFullName_ar: filter_companyFullName_ar,
                            filter_TaxNumber: filter_TaxNumber,
                            filter_CreditNote_Letter: filter_CreditNote_Letter,
                            filter_created_at: filter_created_at,
                            filter_updated_at: filter_updated_at,
                        }
                    },

                    columns: [
                        {
                            data: 'companyName',
                            name: 'companyName'
                        },
                        {
                            data: 'calculation_method',
                            name: 'lkp_calculation_method.calculation_method'
                        },
                        {
                            data: 'period_start',
                            name: 'period_start'
                        },
                        {
                            data: 'period_end',
                            name: 'period_end'
                        },

                        {
                            data: 'companyFullName_en',
                            name: 'companyFullName_en'
                        },
                        {
                            data: 'companyFullName_ar',
                            name: 'companyFullName_ar'
                        },
                        {
                            data: 'TaxNumber',
                            name: 'TaxNumber'
                        },
                        {
                            data: 'CreditNote_Letter',
                            name: 'CreditNote_Letter',
                        },
                        {
                            data: 'updated_users',
                            name: 'updated_users.name'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            data: 'id',
                            "render": function (data, type, row, meta) {
                                return '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>';

                            }
                            //onclick=\"document.getElementById('row_id').value='"+data+"'\"
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
                    url: "{{URL('/Company')}}" + "/" + id,
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
                    url: "{{URL('/Company')}}" + "/" + id + "/edit",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });

            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Company')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';
            });

            $('#filter').click(function () {
                if ($('#filter_companyName').val() != '' || $('#filter_calculation_method_id').val() != '' || $('#filter_period_start').val() != '' || $('#filter_period_end').val() != '' || $('#filter_companyFullName_en').val() != '' || $('#filter_companyFullName_ar').val() != '' || $('#filter_TaxNumber').val() != '' || $('#filter_CreditNote_Letter').val() != '' || $('#filter_created_at').val() != '' || $('#filter_updated_at').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyName').val(), $('#filter_calculation_method_id').val(), $('#filter_period_start').val(), $('#filter_period_end').val(), $('#filter_companyFullName_en').val(), $('#filter_companyFullName_ar').val(), $('#filter_TaxNumber').val(), $('#filter_CreditNote_Letter').val(), $('#filter_created_at').val(), $('#filter_updated_at').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {

                $('#filter_companyName').val('');
                $('#filter_calculation_method_id').val('');
                $('#filter_period_start').val('');
                $('#filter_period_end').val('');
                $('#filter_period_end_input').val('');
                $('#filter_companyFullName_en').val('');
                $('#filter_companyFullName_ar').val('');
                $('#filter_TaxNumber').val('');
                $('#filter_CreditNote_Letter').val('');
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
                url: "{{URL("/Company/create")}}",
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


    </script>

@endsection




