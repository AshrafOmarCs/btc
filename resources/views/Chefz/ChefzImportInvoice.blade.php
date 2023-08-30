@extends('AdminLTE')
@section('content')
    @include('pages.messages2')
    <div class="container" style="width:95%">


        <form method="post" enctype="multipart/form-data" action="{{ url('/ChefzImportInvoiceSave') }}" autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group">
                <table class="table" border="0">

                    <tr>

                        <td colspan="10"><h3 align="center">Import <b> Chefz Invoice</b> Excel File </h3></td>
                    </tr>
                    <tr>
                        <td width="40%" align="right"><label>Select File for Upload .xls, .xslx</label></td>
                        <td width="30">
                            <input type="file" name="select_file" required/>
                        </td>

                        <td style="white-space: nowrap;">Invoice From Date </td>
                        <td>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" style="width:100px" class="form-control pull-right" name="Invoice_From_Date" id="Invoice_From_Date" placeholder="dd/mm/yyyy"   required>
                            </div>

                        </td>
                        <td style="white-space: nowrap;">Invoice To Date </td>
                        <td>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" style="width:100px" class="form-control pull-right" name="Invoice_To_Date" id="Invoice_To_Date" placeholder="dd/mm/yyyy"   required>
                            </div>

                        </td>
                        <td width="30%" align="left">
                            <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                        </td>
                    </tr>


                </table>
            </div>
        </form>

    </div>
    <style>

        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 0.5px solid #808080;
        }
        .table-bordered {
            border: 0.5px solid #808080;
        }
    </style>
    <?php
    if (isset($table)) echo $table;
    ?>

    <script>
        $(function () {
            $('#Invoice_From_Date').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                autoHide: true,
                zIndex: 9999,
            });
        });
        $(function () {
            $('#Invoice_To_Date').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                autoHide: true,
                zIndex: 9999,
            });
        });
    </script>
@endsection
