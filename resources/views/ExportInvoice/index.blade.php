@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">
                ExportInvoice</h2></div>
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
                        <TH>Period</TH>
                        <td>
                            <select name="filter_Period" id="filter_Period" onchange="WarehouseName()"
                                    class="form-control" style="width:200px;" required>
                                <option value=""></option>
                                @foreach($lkp_journal_period as $lkp_journal_periodd)
                                    <option
                                        value="{{$lkp_journal_periodd->id}}"> {{$lkp_journal_periodd->period}}</option>
                                @endforeach
                            </select>
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


    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
            <TH>Period</TH>
            <TH>Warehouse</TH>
            <TH>Total Of TouchPoint</TH>
            <TH>Invoice Number</TH>
            <TH>Unit Cost</TH>
            <TH>Vat</TH>
            <TH>Amount</TH>
            <TH>Vat Amount</TH>
            <TH>Total Amount</TH>
            <TH>Print</TH>
            </thead>
            <tbody></tbody>
            <tfoot>
            <tr>
                <TH colspan='2'>Total</TH>
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


            function fill_datatable(filter_Period = '') {
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "aoColumnDefs": [
                        {"bSortable": false, "aTargets": [0, 1, 2, 3, 4]},

                    ],
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "drawCallback": function (settings) {
                        $('[data-toggle="tooltip"]').tooltip();
                        var api = this.api()
                        var json = api.ajax.json();
                        $(api.column(2).footer()).html(json.No_of_TouchPoint);
                        $(api.column(6).footer()).html(json.amount);
                        $(api.column(7).footer()).html(json.vat_amount);
                        $(api.column(8).footer()).html(json.total_amount);


                    },
                    ajax: {
                        url: "{{ route('ExportInvoice.index') }}",
                        data: {
                            filter_Period: filter_Period,

                        }
                    },

                    columns: [

                        {
                            data: 'period',
                            name: 'period',
                            //visible:false
                        },
                        {
                            data: 'New_warehouseName',
                            name: 'New_warehouseName',
                            //visible:false
                        },
                        {
                            data: 'No_of_TouchPoint',
                            name: 'No_of_TouchPoint'
                        },
                        {
                            data: 'invoice_number',
                            name: 'invoice_number'
                        },
                        {
                            data: 'unit_cost',
                            name: 'unit_cost'
                        },
                        {
                            data: 'vat',
                            name: 'vat'
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            data: 'vat_amount',
                            name: 'vat_amount'
                        },
                        {
                            data: 'total_amount',
                            name: 'total_amount'
                        },
                        {
                            "orderable": false,
                            "searchable": false,
                            className: "dt-nowrap text-center",
                            "targets": -1,
                            "render": function (data, type, row, meta) {
                                var d = '';
                                if(row.print==1)
                                d = d + '&nbsp;<a href="javascript:print(' + row.New_warehouseId + ',' + row.period_id + ');"  data-original-title="print" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue print"> <i class="fa fa-print" aria-hidden="true"></i> </a>';
                                return d;
                            }
                        }

                    ]
                });


            }


            $('#filter').click(function () {


                if ($('#filter_Period').val() != '') {
                    card_change();
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_Period').val());
                } else {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function () {

                $('#filter_Period').val('');


                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });


        });


        function print(New_warehouseId, period_id) {
            //alert(New_warehouseId);
            myWindow1 = window.open("{{URL("ExportInvoicePrint")}}" + "/" + New_warehouseId + "/" + period_id, "mywin",
                "height=900,width=1000,scrollbars=yes,top=1,left=1,status,resizable");
            myWindow1.focus();
        }


    </script>

@endsection




