<style>

    .show_table th {
        padding: 4px !important;
        font-size: 12px;
        font-family: "Segoe UI";
        background-color: #7CCBDC;

    }

    .show_table td {
        padding: 4px !important;

    }


</style>


@if ($Driver->driver_type_id <> 2 && $Driver->driver_type_id <> 3)

    <table border="0" width="100%" align="center">
        <tr>
            <td style="font-family: Arial;font-size: 26px; font-weight: bold;" align="center">
                <br>
                <br>

                الرجاء تعديل نوع المندوب
                <br>
                <br>
            </td>
        </tr>
    </table>
    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button
            onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">Cancel
        </button>
    </div>
    <?php
    exit;
    ?>
@endif
<center>
    <div style="margin-top: 2px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;"><font color="blue">Jahiz
                - {{$Driver->warehouseName}} - {{$Driver->job_id}}</font></h2>
    </div>
    <div style="margin-top: 2px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}}</h2>
    </div>
    <div style="margin-top: 2px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">
            نوع المندوب :
            <?php
            if ($Driver->driver_type_id == 2) echo "شهري";
            elseif ($Driver->driver_type_id == 3) echo "عمولة";
            ?>
        </h2>
    </div>
</center>


<div style="margin: 10px !important; ">
    <table dir="rtl" style="float: right;margin: 10px !important;">
        <tr>

            <td>


                <a href="javascript:AddDriversSettlement({{$Driver->id}});" class="btn btn-sm btn-info "
                   style="font-size: 12px;font-family: 'Segoe UI' !important;font-weight: bold"><i
                        class="fa fa-plus"></i>
                    اضافة تصفية جديدة</a>


            </td>
        </tr>
    </table>
    <br>
    <form method="POST">

        @csrf
        <table id="customer_data" class="table table-bordered table-striped show_table">

            <thead>
            <tr>
                <TH rowspan="2">Update At</TH>
                <TH rowspan="2">Driver Type</TH>
                <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">Jahiz Amount</TH>
                <TH colspan="7" style="text-align: center!important;border-bottom: 0px!important;">Week</TH>
                <TH rowspan="2">Bander Commission</TH>
                @if (Auth::user()->user_type_id == 1)
                    <TH colspan="3" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                @else
                    <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">استلام</TH>
                @endif

                <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">تسليم</TH>
                <TH rowspan="2">Action</TH>

            </tr>
            <tr>
                <TH>+</TH>
                <TH>-</TH>
                <TH>Month</TH>
                <TH>1</TH>
                <TH>2</TH>
                <TH>3</TH>
                <TH>4</TH>
                <TH>All</TH>
                <TH>By Days</TH>
                <TH>Bank</TH>
                <TH>Cash</TH>
                @if (Auth::user()->user_type_id == 1)
                <TH>ATM</TH>
                @endif
                <TH>Bank</TH>
                <TH>Cash</TH>


            </tr>
            </thead>
            @foreach($drivers_jahiz_clearing as $jahiz_clearing)
                <tr>
                    <?php

                    $row = explode(";", $jahiz_clearing->jahiz_montly);
                    $rowspan = count($row);
                    ?>
                    <td rowspan="{{$rowspan}}">{{$jahiz_clearing->updated_at}}</td>
                    <td rowspan="{{$rowspan}}">{{$jahiz_clearing->driver_type}}</td>
                    <td rowspan="{{$rowspan}}"
                        class="table-cell-load">@if ($jahiz_clearing->Jahiz_Amount_Sign==1){{$jahiz_clearing->Jahiz_Amount }} @endif</td>
                    <td rowspan="{{$rowspan}}"
                        class="table-cell-touchpoint">@if ($jahiz_clearing->Jahiz_Amount_Sign==2){{$jahiz_clearing->Jahiz_Amount }} @endif</td>
                    <?php
                    $td = explode("_", $row[0]);
                    if ($row[0] <> '') {
                        echo "
                         <td><b>$td[0]</b></td>
                        <td>$td[1]</td>
                        <td>$td[2]</td>
                        <td>$td[3]</td>
                        <td>$td[4]</td>
                        <td>$td[5]</td>
                        <td>$td[6]</td>
                          ";
                    } else
                        echo "
                         <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                          ";
                    ?>
                    <td rowspan="{{$rowspan}}">{{$jahiz_clearing->Bander_Commission}}</td>
                    <td rowspan="{{$rowspan}}"
                        class="table-cell-load">@if ($jahiz_clearing->clearing_type_id==1){{$jahiz_clearing->bank }} @endif</td>
                    <td rowspan="{{$rowspan}}"
                        class="table-cell-load">@if ($jahiz_clearing->clearing_type_id==1){{$jahiz_clearing->cash }} @endif</td>
                        @if (Auth::user()->user_type_id == 1)
                            <td rowspan="{{$rowspan}}"
                                class="table-cell-load">@if ($jahiz_clearing->clearing_type_id==1){{$jahiz_clearing->ATM }} @endif</td>
                        @endif
                    <td rowspan="{{$rowspan}}"
                        class="table-cell-touchpoint">@if ($jahiz_clearing->clearing_type_id==2){{$jahiz_clearing->bank }} @endif</td>
                    <td rowspan="{{$rowspan}}"
                        class="table-cell-touchpoint">@if ($jahiz_clearing->clearing_type_id==2){{$jahiz_clearing->cash }} @endif</td>

                    <td rowspan="{{$rowspan}}" style="white-space: nowrap !important;">
                        @if ($jahiz_clearing->paid_id=="")
                            <a href="javascript:EditDriversSettlement({{$jahiz_clearing->driverId}},{{$jahiz_clearing->id}});"
                               class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit_jahiz_clearing"> <i
                                    class="fa fa-pencil"></i> </a>
                            &nbsp;<a
                                href="javascript:DeleteDriversSettlement({{$jahiz_clearing->driverId}},{{$jahiz_clearing->id}});"
                                class="btnaction btn menu-icon vd_bd-red vd_red "> <i
                                    class="fa fa-times"></i> </a>
                        @endif
                    </td>


                </tr>
                <?php
                for ($i = 1; $i < count($row); $i++) {
                    $td = explode("_", $row[$i]);
                    echo "<tr>
                         <td><b>$td[0]</b></td>
                        <td>$td[1]</td>
                        <td>$td[2]</td>
                        <td>$td[3]</td>
                        <td>$td[4]</td>
                        <td>$td[5]</td>
                        <td>$td[6]</td>
                          </tr>";
                }
                ?>
            @endforeach
        </table>
    </form>
</div>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>

