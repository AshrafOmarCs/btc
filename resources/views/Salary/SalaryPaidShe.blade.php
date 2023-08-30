@extends('AdminLTE')
@section('content')
    @include('pages.messages2')
    <div class="container" style="width:95%">


        <form method="post" enctype="multipart/form-data" action="{{ url('/SalaryPaidSaveShe') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <table class="table" border="0">

                    <tr>

                        <td colspan="6"><h3 align="center">Import <b>Salary Paid</b> Excel File </h3></td>
                    </tr>
                    <tr>
                        <td width="40%" align="right"><label>Select File for Upload .xls, .xslx</label></td>
                        <td width="30">
                            <input type="file" name="select_file" required/>
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
    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">

            <thead>
            <tr>
                <TH>#</TH>
                <TH>Paid Amount</TH>
                <TH>Iqama</TH>
                <TH>Account Number</TH>
                <TH>Journal Date</TH>
                <TH>Company</TH>
                <TH>warehouse</TH>
                <TH>EMP ID</TH>
                <TH>Driver</TH>
                <TH>Paid</TH>
                <TH>Salary Amount</TH>


            </tr>

            </thead>
            <?php
            $co = 0;
            ?>
            @foreach($Paid_DB as $Paid_db)
                <tr>
                    <?php
                    $co++;
                    $row = explode(";", $Paid_db->AMP_ID);
                    $rowspan = count($row);
                    ?>
                    <td rowspan="{{$rowspan}}">{{$co}}</td>
                    <td rowspan="{{$rowspan}}">{{$Paid_db->bank_sum}}</td>
                    <td rowspan="{{$rowspan}}">{{$Paid_db->account_owner_iqama}}</td>
                    <td rowspan="{{$rowspan}}">{{$Paid_db->accountNumber}}</td>
                    <?php
                    echo "<td>" . explode(";", $Paid_db->journal_date)[0] . "</td>
                            <td>" . explode(";", $Paid_db->companyName)[0] . "</td>
                            <td>" . explode(";", $Paid_db->warehouseName)[0] . "</td>
                            <td>" . explode(";", $Paid_db->AMP_ID)[0] . "</td>
                            <td>" . explode(";", $Paid_db->fullName)[0] . "</td>
                            <td style='text-align: center'>";
                    if (explode(";", $Paid_db->paid)[0] == "1")
                        echo "<span class='label label-success'>Yes</span>";
                    else
                        echo "<span class='label label-danger'>No</span>";
                    echo "</td><td>" . explode(";", $Paid_db->salary_amount)[0] . "</td>";
                    ?>
                </tr>
                <?php
                $td = explode(";", $Paid_db->journal_date);
                for ($i = 1; $i < count($td); $i++) {
                    echo "<tr><td>" . explode(";", $Paid_db->journal_date)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->companyName)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->warehouseName)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->AMP_ID)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->fullName)[$i] . "</td>
                                <td style='text-align: center'>";
                    if (explode(";", $Paid_db->paid)[$i] == "1")
                        echo "<span class='label label-success'>Yes</span>";
                    else
                        echo "<span class='label label-danger'>No</span>";
                    echo "</td><td>" . explode(";", $Paid_db->salary_amount)[$i] . "</td>

                          </tr>";
                }
                ?>
            @endforeach
        </table>
    </div>


@endsection
