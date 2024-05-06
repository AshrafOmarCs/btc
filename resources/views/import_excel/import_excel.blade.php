
@extends('AdminLTE')
@section('content')

<div class="container" style="width:95%">


    @if(count($errors) > 0)
        <div class="alert alert-danger">
            Upload Validation Error<br><br>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="post" enctype="multipart/form-data" action="{{ url('/import_excel/import') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group">
            <table class="table" border="0">

                <tr>
                    <td rowspan="3"><img src="{{asset("/AdminLTE/img/noon.jpg")}}" width="260px" height="159px"></td>
                    <td colspan="6"> <h3 align="center">Import Excel File </h3></td></tr>
                <tr>
                    <td width="40%" align="right"><label>Select File for Upload .xls, .xslx</label></td>
                    <td width="30">
                        <input type="file" name="select_file" required/>
                    </td>
                <TH style="white-space: nowrap;">PacKages Date </TH>
                    <td>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" style="width:200px" class="form-control pull-right" name="pakage_date" id="pakage_date" placeholder="dd/mm/yyyy"   required>
                        </div>

                    </td>

                    <td width="30%" align="left">
                        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                    </td>
                </tr>

                <tr><td colspan="6"> <div style="text-align: center;color:red;font-size: 14px;font-weight: bold">{{$pakage_date->report_date}}</div></td></tr>
            </table>
        </div>
    </form>


    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Drivers Data</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <TH>#</TH>
                        <th>Location</th>
                        <th>Email</th>
                        <th>No_of_D</th>
                        <th>CIR</th>
                        <th>No_of_TP</th>
                        <th>Total_OFD</th>
                        <th class="table-cell-package">FullName</th>
                        <th class="table-cell-package">EMP ID</th>
                        <th class="table-cell-package">No_of_D</th>
                        <th class="table-cell-package">CIR</th>
                        <th class="table-cell-package">No_of_TP</th>
                        <th class="table-cell-package">Total_OFD</th>
                        <th class="table-cell-package">Status</th>
                    </tr>
                    <?php $i=0?>
                    @foreach($data as $row)
                        <?php
                        if($row->packageStatusId=="2" )
                            $class='style="background-color: #B3F0B7"';
                        elseif($row->packageStatusId=="3" )
                            $class='style="background-color: #FF9393"';
                        elseif($row->packageStatusId=="4" )
                            $class='style="background-color: #FFFFB3"';
                        elseif($row->packageStatusId=="5" )
                            $class='style="background-color: #CECECE"';
                            elseif($row->packageStatusId=="6" )
                            $class='style="background-color: #CAE4FF"';
                             else $class="";
                            ?>
                        <?php $i++?>
                        <tr <?php echo $class;?>>
                            <td>{{ $i }}</td>
                            <td>{{ $row->Location }}</td>
                            <td>{{ $row->Email }}</td>
                            <td>{{ $row->NoFD }}</td>
                            <td>{{ $row->No_of_CIR }}</td>
                            <td style="font-size: 14px;"><b>{{ $row->NoFTP }}</b></td>
                            <td>{{ $row->Total_OFD }}</td>
                            <td class="table-cell-package">{{ $row->fullName }}</td>
                            <td class="table-cell-package">{{ $row->job_id }}</td>
                            <td>{{ $row->no_of_deliverd }}</td>
                            <td>{{ $row->return_no_of_touch_point }}</td>
                            <td style="font-size: 14px;"><b>{{ $row->no_of_touch_point }}</b></td>
                            <td>{{ $row->total_out_for_deliver }}</td>
                            <td>{{ $row->status }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


















    </div>
</body>
</html>
<script>
    $(function () {
        $('#pakage_date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            autoHide: true,
            zIndex: 9999,
        });
    });
</script>
@endsection
