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
            <td style="font-size: 14px;font-weight: bold;">Jahiz Report</td>
        </tr>
    </table>
    <br><br>

    <table class="table show_table" id="example" style="width:80%" align="center">
        <thead>
        <tr>
            <th rowspan="2">#</th>
            <TH rowspan="2">الشهر</TH>
            <TH colspan="4" style="text-align: center!important;border-bottom: 0px!important;">SANED</TH>
            <TH colspan="2" style="text-align: center!important;border-bottom: 0px!important;">بالعمولة</TH>
            <TH colspan="4" style="text-align: center!important;border-bottom: 0px!important;">بالشهر</TH>

        </tr>
        <tr>

            <TH>عدد التصفيات</TH>
            <TH>عدد المصفي لهم</TH>
            <TH>المبالغ موجب</TH>
            <TH>المبالغ سالب</TH>
            <TH>عدد المناديب</TH>
            <TH>عمولة بندر</TH>
            <TH>عدد المناديب</TH>
            <TH>عمولة بندر</TH>
            <TH>مكمل 150</TH>
            <TH>غير مكمل 150</TH>

        </tr>
        </thead>



        @foreach($master as $masterr)
            <tr>
                <td class="master-control_open master_{{$masterr->ym}}"
                    onclick="master('{{$masterr->ym}}')"></td>
                <td><b>{{$masterr->ym}}</b></td>
                <td >
                    <b>{{$masterr->saned_settlement_CO}}</b></td>
                <td style="background-color: #E0E0E0">
                    <b>{{$masterr->AMP_ID_CO}}</b></td>
                <td style="background-color: #FFFFFF">
                    <b>{{$masterr->SANED_amount_plus}}</b></td>
                <td style="background-color: #FFFFFFF">
                    <b>{{$masterr->SANED_amount_minus}}</b></td>
                <td style="background-color: #E0E0E0">
                    <b>{{$masterr->PerShipment_CO}}</b></td>
                <td style="background-color: #FFFFFFF">
                    <b>{{$masterr->PerShipment_Bander_Commission}}</b></td>
                <td style="background-color: #E0E0E0">
                    <b>{{$masterr->MonthlySalary_CO}}</b></td>
                <td style="background-color: #FFFFFFF">
                    <b>{{$masterr->MonthlySalary_Amount}}</b></td>
                <td style="background-color: #FFFFFFF">
                    <b>{{$masterr->MonthlySalary_Amount_150}}</b></td>
                <td style="background-color: #FFFFFFF">
                    <b>{{$masterr->MonthlySalary_Amount_NOT_150}}</b></td>

            </tr>

            @foreach($details as $detail)
                @if ($detail->ym==$masterr->ym)
                    <tr class="hidden_row details_{{$detail->ym}}">
                        <td style="background-color: #ecf0f5;border-bottom: 1px #E6E6E6 !important;border-top: 1px #E6E6E6 !important;border-left: 1px #E6E6E6 !important;"></td>
                        <td><b>{{$detail->warehouseName}}</b></td>
                        <td>{{$detail->saned_settlement_CO}}</td>
                        <td>{{$detail->AMP_ID_CO}}</td>
                        <td>{{$detail->SANED_amount_plus}}</td>
                        <td>{{$detail->SANED_amount_minus}}</td>
                        <td>{{$detail->PerShipment_CO}}</td>
                        <td>{{$detail->PerShipment_Bander_Commission}}</td>
                        <td>{{$detail->MonthlySalary_CO}}</td>
                        <td>{{$detail->MonthlySalary_Amount}}</td>
                        <td>{{$detail->MonthlySalary_Amount_150}}</td>
                        <td>{{$detail->MonthlySalary_Amount_NOT_150}}</td>

                    </tr>
                    @endif
                    @endforeach
        @endforeach

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




