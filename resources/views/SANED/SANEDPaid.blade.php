@extends('AdminLTE')
@section('content')
    @include('pages.messages2')
    <div class="container" style="width:95%">


        <form method="post" enctype="multipart/form-data" action="{{ url('/SANEDPaidSave') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <table class="table" border="0">

                    <tr>

                        <td colspan="6"><h3 align="center">Import <b>SANED Paid</b> Excel File </h3></td>
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
                <TH rowspan="2">#</TH>
                <TH rowspan="2">Paid Amount</TH>
                <TH rowspan="2">Iqama</TH>
                <TH rowspan="2">Account Number</TH>
                <TH rowspan="2">SANED Date</TH>
                <TH rowspan="2">City</TH>
                <TH rowspan="2">EMP ID</TH>
                <TH rowspan="2">Driver</TH>
                <TH rowspan="2">Paid</TH>
                <TH rowspan="2">SANED Amount</TH>
                <TH rowspan="2">Bander Amount</TH>
                <TH rowspan="2">Bander Date</TH>
                <TH rowspan="2">Bander Commission</TH>
                <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">تسليم</TH>


            </tr>
            <tr>

                <TH>Bank</TH>
                <TH>Cash</TH>
                <TH>Bank</TH>
                <TH>Cash</TH>

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
                    <td rowspan="{{$rowspan}}">{{$Paid_db->bank_minus_plus}}</td>
                    <td rowspan="{{$rowspan}}">{{$Paid_db->account_owner_iqama}}</td>
                    <td rowspan="{{$rowspan}}">{{$Paid_db->accountNumber}}</td>
                    <?php
                    echo "<td>" . explode(";", $Paid_db->SettledDate)[0] . "</td>
                            <td>" . explode(";", $Paid_db->warehouseName)[0] . "</td>
                            <td>" . explode(";", $Paid_db->AMP_ID)[0] . "</td>
                            <td>" . explode(";", $Paid_db->fullName)[0] . "</td>
                            <td style='text-align: center'>";
                    if (explode(";", $Paid_db->drivers_jahiz_clearing_paid_id)[0] <> "")
                        echo "<span class='label label-success'>Yes</span>";
                    else
                        echo "<span class='label label-danger'>No</span>";
                    echo "</td><td>" . explode(";", $Paid_db->SANED_amount)[0] . "</td>
                            <td>" . explode(";", $Paid_db->Jahiz_Amount)[0] . "</td>
                            <td>" . explode(";", $Paid_db->updated_at)[0] . "</td>
                            <td>" . explode(";", $Paid_db->Bander_Commission)[0] . "</td>
                            <td>" . explode(";", $Paid_db->bank_plus)[0] . "</td>
                            <td>" . explode(";", $Paid_db->cash_plus)[0] . "</td>
                            <td>" . explode(";", $Paid_db->bank_minus)[0] . "</td>
                            <td>" . explode(";", $Paid_db->cash_minus)[0] . "</td>";
                    ?>
                </tr>
                <?php
                $td = explode(";", $Paid_db->SettledDate);
                for ($i = 1; $i < count($td); $i++) {
                    echo "<tr><td>" . explode(";", $Paid_db->SettledDate)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->warehouseName)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->AMP_ID)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->fullName)[$i] . "</td>
                                <td style='text-align: center'>";
                    if (explode(";", $Paid_db->drivers_jahiz_clearing_paid_id)[$i] <> "")
                        echo "<span class='label label-success'>Yes</span>";
                    else
                        echo "<span class='label label-danger'>No</span>";
                    echo "</td><td>" . explode(";", $Paid_db->SANED_amount)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->Jahiz_Amount)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->updated_at)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->Bander_Commission)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->bank_plus)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->cash_plus)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->bank_minus)[$i] . "</td>
                                <td>" . explode(";", $Paid_db->cash_minus)[$i] . "</td>
                          </tr>";
                }
                ?>
            @endforeach
        </table>
    </div>


@endsection
