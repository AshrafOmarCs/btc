@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">
                Attendance</h2>
        </div>

    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->

    <!-- SELECT2 EXAMPLE -->

    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary ">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search"><i class="fa fa-search"></i></button>
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
                    </tr>
                    <tr>
                        <TH>Month</TH>
                        <td>
                            <select name="filter_Month" id="filter_Month" class="form-control">
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    echo "<option value='" . $i . "'";
                                    if ($i == date('n')) echo " selected ";
                                    echo ">" . $i . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>

                <div class="card-footer" align="center">
                    <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Filter</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <center>
        <div id="year_month"></div>
    </center>

    <style>

        #customer_data th {
            border: 1px solid #C4C4C4;

        }
        #customer_data td {
            border: 1px solid #C4C4C4;
            FONT-WEIGHT: bold;

        }
    </style>
    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped" >
            <thead>
            <tr>
            <TH>Name</TH>
            <TH>IdentityNo</TH>
            <TH>Warehouses</TH>
            <?php
            for($i=1;$i<= 31;$i++)
                echo"<TH>$i</TH>\n";
            ?>

            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>

            <div style="width:100%;clear:both;" id="response">

            </div>
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

            function fill_datatable(filter_Year = '', filter_Month = '') {
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "pageLength": 100,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "fnDrawCallback": function () {



                        //------------------------------------------------------------------------------------
                        var api = this.api()
                        var json = api.ajax.json();
                        $('#year_month').html(json.year_month);

                        for(i=3+Number(json.Last_Day);i<=2+31;i++)
                        {
                            //alert(i);
                            dataTable.column(i).visible(false);
                        }


                    },
                    ajax: {
                        url: "{{ route('Attendance.index') }}",
                        data: {
                            filter_Year: filter_Year,
                            filter_Month: filter_Month,

                        }
                    },

                    columns: [
                        {
                            data: 'name',
                            name: 'name',
                            //visible:false
                        },
                        {
                            data: 'IdentityNo',
                            name: 'IdentityNo'
                        },

                        {
                            data: 'warehouses',
                            name: 'warehouse.warehouseName'
                        },

                        <?php
                        for($i=1;$i<= 31;$i++)
                            echo"{
                            data: 'A_".$i."',
                            name: 'A_".$i."'
                        },\n";
                        ?>

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
                    url: "{{URL('/Attendance')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });

            $('#filter').click(function () {
                $('#customer_data').DataTable().destroy();
                fill_datatable($('#filter_Year').val(), $('#filter_Month').val());

            });

        });


    </script>
@endsection




