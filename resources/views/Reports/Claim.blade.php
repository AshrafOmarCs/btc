@extends('AdminLTE')
@section('content')

    <style>
        .show_table th {
            background-color: #7CCBDC;
            white-space: nowrap;
            margin: 0 !important;
            border: solid 1px #535353 !important;
            text-align: center;
        }

        .show_table td {
            background-color: #ffffff;

            vertical-align: middle !important;
            border: solid 1px #535353 !important;
            text-align: center;
        }

        .hidden_row td {
            display: none;
            /* height: 0px; */
            background-color: #E6E6E6;
            border: solid 1px #ffffff !important;
        }

        td.master-control_open {
            background: url('{{asset("/AdminLTE/img/master_open.png")}}') no-repeat center center;
            cursor: pointer;
            background-color: #ffffff;
        }

        td.master-control_close {
            background: url('{{asset("/AdminLTE/img/master_close.png")}}') no-repeat center center;
            cursor: pointer;
            background-color: #ffffff;
        }
    </style>
    <table>
        <tr>
            <td style="font-size: 14px;font-weight: bold;">Claim Report</td>
        </tr>
    </table>
    <br><br>

    <table class="table show_table" id="example" style="width:80%" align="center">
        <thead>
        <tr>
            <th rowspan="2">#</th>
            <TH rowspan="2">الحالة</TH>
            <TH rowspan="2">عدد المناديب</TH>
            <TH colspan="4" style="text-align: center!important;border-bottom: 0px!important;">نواقص غير مدخلة</TH>
            <TH colspan="3" style="text-align: center!important;border-bottom: 0px!important;">مبالغ المطالبات</TH>


        </tr>
        <tr>

            <TH>الهوية</TH>
            <TH>سند الامر</TH>
            <TH>رسوم الشنطة</TH>
            <TH>عمولة بندر</TH>
            <TH>رسوم الشنطة</TH>
            <TH>عمولة بندر</TH>
            <TH>مبلغ ساند</TH>


        </tr>
        </thead>

        <?php
        $CO = 0;$Image_Identity_NOT = 0;$Image_PromissoryNote_NOT = 0;$bag_fee_NOT = 0;$Bander_Commission_NOT = 0;
        $bag_fee = 0;$Bander_Commission = 0;$amount = 0;
        ?>
        @foreach($master as $masterr)
            <tr>
                <td class="master-control_open master_{{$masterr->claim_status_id}}"
                    onclick="master('{{$masterr->claim_status_id}}')"></td>
                <td><b>{{$masterr->status_txt}}</b></td>
                <td style="background-color: #E0E0E0">
                    <b>{{$masterr->CO}}</b></td>
                <td style="background-color: #FFFFFF;color: red">
                    <b>{{$masterr->Image_Identity_NOT}}</b></td>
                <td style="background-color: #FFFFFF;color: red">
                    <b>{{$masterr->Image_PromissoryNote_NOT}}</b></td>
                <td style="background-color: #FFFFFF;color: red">
                    <b>{{$masterr->bag_fee_NOT}}</b></td>
                <td style="background-color: #FFFFFF;color: red">
                    <b>{{$masterr->Bander_Commission_NOT}}</b></td>
                <td style="background-color: #FFFFFFF">
                    <b>{{$masterr->bag_fee}}</b></td>
                <td style="background-color: #FFFFFFF">
                    <b>{{$masterr->Bander_Commission}}</b></td>
                <td style="background-color: #FFFFFFF">
                    <b>{{$masterr->amount}}</b></td>


            </tr>
            <?php
            $CO += $masterr->CO;
            $Image_Identity_NOT += $masterr->Image_Identity_NOT;
            $Image_PromissoryNote_NOT += $masterr->Image_PromissoryNote_NOT;
            $bag_fee_NOT += $masterr->bag_fee_NOT;
            $Bander_Commission_NOT += $masterr->Bander_Commission_NOT;
            $bag_fee += $masterr->bag_fee;
            $Bander_Commission += $masterr->Bander_Commission;
            $amount += $masterr->amount;
            ?>

            @foreach($details as $detail)
                @if ($detail->claim_status_id==$masterr->claim_status_id)
                    <tr class="hidden_row details_{{$detail->claim_status_id}}">
                        <td style="background-color: #ecf0f5;border-bottom: 1px #E6E6E6 !important;border-top: 1px #E6E6E6 !important;border-left: 1px #E6E6E6 !important;"></td>
                        <td><b>{{$detail->warehouseName}}</b></td>
                        <td>{{$detail->CO}}</td>
                        <td>{{$detail->Image_Identity_NOT}}</td>
                        <td>{{$detail->Image_PromissoryNote_NOT}}</td>
                        <td>{{$detail->bag_fee_NOT}}</td>
                        <td>{{$detail->Bander_Commission_NOT}}</td>
                        <td>{{$detail->bag_fee}}</td>
                        <td>{{$detail->Bander_Commission}}</td>
                        <td>{{$detail->amount}}</td>

                    </tr>
                @endif
            @endforeach
        @endforeach



        <tr>
            <th colspan="2"><b>Total ALL</b></th>
            <th ><b>{{$CO}}</b></th>
            <th style="color: red"><b>{{$Image_Identity_NOT}}</b></th>
            <th style="color: red"><b>{{$Image_PromissoryNote_NOT}}</b></th>
            <th style="color: red"><b>{{$bag_fee_NOT}}</b></th>
            <th style="color: red"><b>{{$Bander_Commission_NOT}}</b></th>
            <th ><b>{{$bag_fee}}</b></th>
            <th ><b>{{$Bander_Commission}}</b></th>
            <th ><b>{{$amount}}</b></th>
        </tr>
            </tbody>
    </table>


    <script>

        function master(id) {
            var x = document.getElementsByClassName('master_' + id);
            if (x[0].className === 'master-control_open master_' + id) {
                $('.details_' + id + ' td').slideDown(1000);
                x[0].className = 'master-control_close master_' + id;
            } else {
                $('.details_' + id + ' td').slideUp(1000);
                x[0].className = 'master-control_open master_' + id;
            }
        }


    </script>

@endsection




