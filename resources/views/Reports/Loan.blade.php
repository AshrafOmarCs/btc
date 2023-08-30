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
            <td style="font-size: 14px;font-weight: bold;">Loans Report</td>
        </tr>
    </table>
    <br><br>

    <table class="table show_table" id="example" style="width:80%" align="center">
        <thead>
        <tr>
            <th>#</th>
            <th width="200px">Company</th>
            <th>Pending</th>
            <th>Rejected</th>
            <th>Approved By Supervisor</th>
            <th>Approved</th>
            <th>Paid</th>
            <th>Paid Amount</th>
            <th>Count All</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $Pending = 0;$Rejected = 0;$Approved_by_Supervisor = 0;$Approved = 0;$Paid = 0;$Paid_amount = 0;$CO = 0;
        ?>
        @foreach($master as $masterr)
            <tr>
                <td class="master-control_open master_{{$masterr->companyId}}"
                    onclick="master({{$masterr->companyId}})"></td>
                <td><b>{{$masterr->companyName}}</b></td>
                <td ondblclick="view('m',{{$masterr->companyId}},1)" style="background-color: #F9EFAE">
                    <b>{{$masterr->Pending}}</b></td>
                <td ondblclick="view('m',{{$masterr->companyId}},2)" style="background-color: #FF9B9B">
                    <b>{{$masterr->Rejected}}</b></td>
                <td ondblclick="view('m',{{$masterr->companyId}},5)" style="background-color: #8282FF">
                    <b>{{$masterr->Approved_by_Supervisor}}</b></td>
                <td ondblclick="view('m',{{$masterr->companyId}},3)" style="background-color: #8282FF">
                    <b>{{$masterr->Approved}}</b></td>
                <td ondblclick="view('m',{{$masterr->companyId}},4)" style="background-color: #28FF94">
                    <b>{{$masterr->Paid}}</b></td>
                <td ondblclick="view('m',{{$masterr->companyId}},4)" style="background-color: #FFFFFF">
                    <b>{{$masterr->Paid_amount}}</b></td>
                <td ondblclick="view('m',{{$masterr->companyId}},10)" style="background-color: #7CCBDC">
                    <b>{{$masterr->CO}}</b></td>
            </tr>
            <?php
            $Pending += $masterr->Pending;
            $Rejected += $masterr->Rejected;
            $Approved_by_Supervisor += $masterr->Approved_by_Supervisor;
            $Approved += $masterr->Approved;
            $Paid += $masterr->Paid;
            $Paid_amount += $masterr->Paid_amount;
            $CO += $masterr->CO;
            ?>

            @foreach($details as $detail)
                @if ($detail->companyId==$masterr->companyId)
                    <tr class="hidden_row details_{{$detail->companyId}}">
                        <td style="background-color: #ecf0f5;border-bottom: 1px #E6E6E6 !important;border-top: 1px #E6E6E6 !important;border-left: 1px #E6E6E6 !important;"></td>
                        <td>{{$detail->journal_period}}</td>
                        <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},1)">{{$detail->Pending}}</td>
                        <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},2)">{{$detail->Rejected}}</td>
                        <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},5)">{{$detail->Approved_by_Supervisor}}</td>
                        <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},3)">{{$detail->Approved}}</td>
                        <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},4)">{{$detail->Paid}}</td>
                        <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},4)">{{$detail->Paid_amount}}</td>
                        <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},10)">{{$detail->CO}}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach
        <tr>
            <th colspan="2"><b>Total ALL</b></th>
            <th ondblclick="view('m','m',1)"><b>{{$Pending}}</b></th>
            <th ondblclick="view('m','m',2)"><b>{{$Rejected}}</b></th>
            <th ondblclick="view('m','m',5)"><b>{{$Approved_by_Supervisor}}</b></th>
            <th ondblclick="view('m','m',3)"><b>{{$Approved}}</b></th>
            <th ondblclick="view('m','m',4)"><b>{{$Paid}}</b></th>
            <th ondblclick="view('m','m',4)"><b>{{$Paid_amount}}</b></th>
            <th ondblclick="view('m','m',10)"><b>{{$CO}}</b></th>
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

        function view(m, id, type) {
            myWindow1 = window.open("{{URL("/ViewLoan/")}}" + "?m=" + m + "&id=" + id + "&type=" + type, "mywin",
                "height=900,width=1300,scrollbars=yes,top=1,left=1,status,resizable");
            myWindow1.focus();
        }
    </script>

@endsection




