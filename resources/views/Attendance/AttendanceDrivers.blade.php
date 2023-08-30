@extends('AdminLTE')
@section('content')


    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Attendance
                Drivers</h2>
        </div>

    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>
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
    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->
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
                        <TH>Year</TH>
                        <td>
                            <select name="filter_Year" id="filter_Year" class="form-control" style="width:200px;"
                                    required>
                                <option value="{{date('Y')}}">{{date('Y')}}</option>
                                <option value="{{date('Y')-1}}">{{date('Y')-1}}</option>
                            </select>
                        </td>
                        <TH>Warehouse</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;">

                                <option value=""></option>
                                @foreach($warehouse as $warehousee)
                                    <option value="{{$warehousee->id}}"> {{$warehousee->warehouseName}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Month</TH>
                        <td>
                            <select name="filter_Month" id="filter_Month" onchange="Days()" class="form-control">
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    echo "<option value='" . $i . "'";
                                    if ($i == date('n')) echo " selected ";
                                    echo ">" . $i . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <TH>Active</TH>
                        <td>
                            <select name="filter_status_id" id="filter_status_id"
                                    class="form-control">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <TH>Day</TH>
                        <td>
                            <select id="filter_Day" name="filter_Day" class="form-control"
                                    style="width:180px;">

                                <option value=""></option>
                                <?php
                                $cal_days_in_month = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));


                                for ($i = 1; $i <= $cal_days_in_month; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <TH>Bander Car</TH>
                        <td>
                            <select name="filter_bander_car_id" id="filter_bander_car_id" class="form-control"
                                    style="width:180px;">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info">Filter</button>


                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->



    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <!-- select all boxes -->
    <center>
        <div id="year_month"></div>
    </center>

    <style>

        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 0.25px solid #808080 !important;
            background-clip: padding-box !important;

        }


    </style>
    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped cell-border"
               style="border-collapse: collapse!important;">
            <thead>
            <tr>
                <TH>warehouse Name</TH>
                <TH>Full Name</TH>
                <TH>Active</TH>
                <TH>Bander Car</TH>
                <?php
                for ($i = 1; $i <= 31; $i++)
                    echo "<TH>$i</TH>\n";
                ?>

            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


    <script>
        $(document).ready(function () {

            fill_datatable();

            function fill_datatable(filter_Year = '', filter_Month = '', filter_Day = '', filter_warehouseId = '', filter_status_id = '', filter_bander_car_id = '') {
                var dataTable = $('#customer_data').DataTable({
                    dom: 'lBfrtip',
                    "buttons": [
                        {
                            extend: 'excel',
                            title: null,
                            text: 'Export to Excel',
                            exportOptions: {
                                columns: [':visible'],
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
                    "pageLength": 1000,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {


                        //------------------------------------------------------------------------------------
                        var api = this.api()
                        var json = api.ajax.json();
                        $('#year_month').html(json.year_month);
                        if (json.filter_Day != null) {
                            //alert(json.filter_Day);
                            for (i = 4; i <=  Number(json.filter_Day)+2; i++) {
                                //alert(i);
                                dataTable.column(i).visible(false);
                            }
                            for (i = 4 + Number(json.filter_Day); i <= 3 + 31; i++) {
                                //alert(i);
                                dataTable.column(i).visible(false);
                            }
                        } else {
                            for (i = 4 + Number(json.Last_Day); i <= 3 + 31; i++) {
                                //alert(i);
                                dataTable.column(i).visible(false);
                            }
                        }


                    },
                    ajax: {
                        url: "{{ URL('/AttendanceDrivers')}}",
                        data: {
                            filter_Year: filter_Year,
                            filter_Month: filter_Month,
                            filter_Day: filter_Day,
                            filter_warehouseId: filter_warehouseId,
                            filter_status_id: filter_status_id,
                            filter_bander_car_id: filter_bander_car_id,

                        }
                    },

                    columns: [
                        {

                            data: 'warehouseName',
                            name: 'warehouseName',
                            //visible:false
                        },
                        {

                            data: 'fullName',
                            name: 'fullName'
                        },

                        {
                            //data: 'driver_status_en',
                            name: 'status_id',
                            render: function (data, type, row, meta) {
                                if (row.status_id == "1") {
                                    return '<span class="label label-success">Yes</span>';

                                } else if (row.status_id >1) {
                                    return '<span class="label label-danger">No</span>';
                                }
                                else return '';
                            }
                        },
                        {
                            //data: 'driver_status_en',
                            name: 'bander_car_id',
                            render: function (data, type, row, meta) {
                                if (row.bander_car_id == "1") {
                                    return '<span class="label label-success">Yes</span>';

                                } else if (row.bander_car_id =="2") {
                                    return '<span class="label label-danger">No</span>';
                                }
                                else return '';
                            }
                        },

                        <?php
                        for ($i = 1; $i <= 31; $i++)
                            echo "{
                            data: 'A_" . $i . "',
                            name: 'A_" . $i . "'
                        },\n";
                        ?>

                    ]
                });


            }


            $('#filter').click(function () {
                card_change();
                $('#customer_data').DataTable().destroy();
                fill_datatable($('#filter_Year').val(), $('#filter_Month').val(), $('#filter_Day').val(), $('#filter_warehouseId').val(), $('#filter_status_id').val(), $('#filter_bander_car_id').val());

            });

        });

        function Days() {


            $('#filter_Day').empty();

            $.getJSON("{{URL("/getDays")}}" + "/" + document.getElementById('filter_Year').value + "/" + document.getElementById('filter_Month').value, function (json) {
                $('#filter_Day').empty();
                $('#filter_Day').append($('<option>').text("Select ....").attr('value', ''));
                $.each(json, function (i, obj) {

                    $('#filter_Day').append($('<option>').text(obj).attr('value', obj));
                });
            });

        }
    </script>
@endsection




