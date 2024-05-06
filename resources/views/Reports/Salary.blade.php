@extends('AdminLTE')
@section('content')
    <style>
        .show_table th {
            background-color: #7CCBDC;
            white-space: nowrap;
            margin: 0 !important;
            border: solid 1px #535353 !important;
            text-align: center;
            padding: 8px 3px !important;
        }

        .show_table td {
            background-color: #ffffff;
            white-space: nowrap;
            vertical-align: middle !important;
            border: solid 1px #535353 !important;
            text-align: center;
            padding: 2px !important;
        }

        .hidden_row td {
            display: none; /* height: 0px; */
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
            <td style="font-size: 14px;font-weight: bold;">Salary Report</td>
        </tr>
    </table>    <br><br>    <br><br>
    <div class="table-responsive" style="width: 100%;">
        <table class="table show_table" id="example" style="width: auto !important;" align="center">
            <thead>
            <tr>
                <th rowspan="2" width="40px">#</th>
                <th rowspan="2" width="160px">Company</th>
                <th rowspan="2">DA</th>
                <th colspan="2">Paid</th>
                <th rowspan="2" style="background-color: #A0EFA3">Daily Load</th>
                <th rowspan="2" style="background-color: #E8A8B1">Loan</th>
                <th rowspan="2" style="background-color: #E8A8B1">CreditNote</th>
                <th rowspan="2" style="background-color: #E8A8B1">Deduction</th>
                <th rowspan="2" style="background-color: #E8A8B1">Bank</th>
                <th colspan="2">Gaps</th>
                <th colspan="2">Settlements</th>
                <th rowspan="2" style="background-color: #E8A8B1">Salary</th>
                <th colspan="5">Total</th>
                <th colspan="2">Carried Down</th>
                <th colspan="2">Brought Down</th>
            </tr>
            <tr>
                <th>Yes</th>
                <th>No</th>
                <th style="background-color: #A0EFA3">Credit</th>
                <th style="background-color: #E8A8B1">Debit</th>
                <th style="background-color: #A0EFA3">Credit</th>
                <th style="background-color: #E8A8B1">Debit</th>
                <th style="background-color: #A0EFA3">Credit</th>
                <th style="background-color: #E8A8B1">Debit</th>
                <th>Total</th>
                <th>Total+</th>
                <th>Total-</th>
                <th style="font-family: Arial">+</th>
                <th style="font-family: Arial">-</th>
                <th style="font-family: Arial">+</th>
                <th style="font-family: Arial">-</th>
            </tr>
            </thead>
            <tbody>
            <?php $CO = 0;
            $Daily_Load = 0;
            $Loan = 0;
            $CreditNote = 0;
            $Deduction = 0;
            $Bank_Transfer = 0;
            $Gaps_credit = 0;
            $Gaps_debit = 0;
            $Settlements_credit = 0;
            $Settlements_debit = 0;
            $Salary = 0;
            $credit = 0;
            $debit = 0;
            $brought_down_plus = 0;
            $brought_down_minus = 0;
            $brought_down = 0;
            $Paid = 0;?>
            @foreach($master as $masterr)
                <tr>
                    <td class="master-control_open master_{{$masterr->companyId}}"
                        onclick="master({{$masterr->companyId}})"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td><b>{{$masterr->companyName}}</b></td>
                    <td><b>{{$masterr->CO}}</b></td>
                    <td><b>{{$masterr->Paid}}</b></td>
                    <td><b>{{$masterr->CO-$masterr->Paid}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},2,6)"><b>{{$masterr->Daily_Load}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},4,1)"><b>{{$masterr->Loan}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},1,3)"><b>{{$masterr->CreditNote}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},5,5)"><b>{{$masterr->Deduction}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},8,8)"><b>{{$masterr->Bank_Transfer}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},4,4.1)"><b>{{$masterr->Gaps_credit}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},4,4.2)"><b>{{$masterr->Gaps_debit}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},7,7.1)"><b>{{$masterr->Settlements_credit}}</b>
                    </td>
                    <td ondblclick="view('m',{{$masterr->companyId}},7,7.2)"><b>{{$masterr->Settlements_debit}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},2,2)"><b>{{$masterr->Salary}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},2)" style="background-color: #A0EFA3">
                        <b>{{$masterr->credit}}</b></td>
                    <td ondblclick="view('m',{{$masterr->companyId}},2)" style="background-color: #E8A8B1">
                        <b>{{$masterr->debit}}</b></td>
                    <th ondblclick="view('m',{{$masterr->companyId}},2)"><b>{{$masterr->brought_down}}</b></th>
                    <th ondblclick="view('m',{{$masterr->companyId}},2)"><b>{{$masterr->brought_down_plus}}</b></th>
                    <th ondblclick="view('m',{{$masterr->companyId}},2)"><b>{{$masterr->brought_down_minus}}</b></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                $CO += $masterr->CO;
                $Daily_Load += $masterr->Daily_Load;
                $Loan += $masterr->Loan;
                $CreditNote += $masterr->CreditNote;
                $Deduction += $masterr->Deduction;
                $Bank_Transfer += $masterr->Bank_Transfer;
                $Gaps_credit += $masterr->Gaps_credit;
                $Gaps_debit += $masterr->Gaps_debit;
                $Settlements_credit += $masterr->Settlements_credit;
                $Settlements_debit += $masterr->Settlements_debit;
                $Salary += $masterr->Salary;
                $credit += $masterr->credit;
                $debit += $masterr->debit;
                $brought_down_plus += $masterr->brought_down_plus;
                $brought_down_minus += $masterr->brought_down_minus;
                $brought_down += $masterr->brought_down;
                $Paid += $masterr->Paid;
                ?>
                @foreach($details as $detail)
                    @if ($detail->companyId==$masterr->companyId)
                        <tr class="hidden_row details_{{$detail->companyId}}">
                            <td style="background-color: #ecf0f5;border-bottom: 1px #E6E6E6 !important;border-top: 1px #E6E6E6 !important;border-left: 1px #E6E6E6 !important;"></td>
                            <td>{{$detail->journal_period}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},'All',22)">{{$detail->CO}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},'Paid',22)">{{$detail->Paid}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},'Unpaid',22)">{{$detail->CO-$detail->Paid}}</td>
                            <td>{{$detail->Daily_Load}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},4,1)">{{$detail->Loan}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},1,3)">{{$detail->CreditNote}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},5,5)">{{$detail->Deduction}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},8,8)">{{$detail->Bank_Transfer}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},4,4.1)">{{$detail->Gaps_credit}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},4,4.2)">{{$detail->Gaps_debit}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},7,7.1)">{{$detail->Settlements_credit}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},7,7.2)">{{$detail->Settlements_debit}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},2,2)">{{$detail->Salary}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},2)">{{$detail->credit}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},2)">{{$detail->debit}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},2)">{{$detail->brought_down}}</td>
                            <td></td>
                            <td></td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},'carried_down_plus',22)"
                                style="color: blue">{{$detail->carried_down_plus}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},'carried_down_minus',22)"
                                style="color: red">{{$detail->carried_down_minus}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},'cumulative_total_plus',22)"
                                style="color: blue">{{$detail->cumulative_total_plus}}</td>
                            <td ondblclick="view('{{$detail->journal_period}}',{{$masterr->companyId}},'cumulative_total_minus',22)"
                                style="color: red">{{$detail->cumulative_total_minus}}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
            <tr>
                <th colspan="2"><b>Total ALL</b></th>
                <th ondblclick="view('m','m',1)"><b>{{$CO}}</b></th>
                <th ondblclick="view('m','m',1)"><b>{{$Paid}}</b></th>
                <th ondblclick="view('m','m',1)"><b>{{$CO-$Paid}}</b></th>
                <th ondblclick="view('m','m',1)"><b>{{$Daily_Load}}</b></th>
                <th ondblclick="view('m','m',4,1)"><b>{{$Loan}}</b></th>
                <th ondblclick="view('m','m',1,3)"><b>{{$CreditNote}}</b></th>
                <th ondblclick="view('m','m',5,5)"><b>{{$Deduction}}</b></th>
                <th ondblclick="view('m','m',8,8)"><b>{{$Bank_Transfer}}</b></th>
                <th ondblclick="view('m','m',4,4.1)"><b>{{$Gaps_credit}}</b></th>
                <th ondblclick="view('m','m',4,4.2)"><b>{{$Gaps_debit}}</b></th>
                <th ondblclick="view('m','m',7,7.1)"><b>{{$Settlements_credit}}</b></th>
                <th ondblclick="view('m','m',7,7.2)"><b>{{$Settlements_debit}}</b></th>
                <th ondblclick="view('m','m',2,2)"><b>{{$Salary}}</b></th>
                <th ondblclick="view('m','m',1)"><b>{{$credit}}</b></th>
                <th ondblclick="view('m','m',1)"><b>{{$debit}}</b></th>
                <th ondblclick="view('m','m',1)"><b>{{$brought_down}}</b></th>
                <th ondblclick="view('m','m',1)"><b>{{$brought_down_plus}}</b></th>
                <th ondblclick="view('m','m',1)"><b>{{$brought_down_minus}}</b></th>
            </tr>
            </tbody>
        </table>
    </div>
    <script>
        function master(id) {
            var x = document.getElementsByClassName('master_' + id);
            if (x[0].className === 'master-control_open master_' + id) {
                $('.details_' + id + ' td').slideDown(100);
                x[0].className = 'master-control_close master_' + id;
            } else {
                $('.details_' + id + ' td').slideUp(100);
                x[0].className = 'master-control_open master_' + id;
            }
        }

        function view(m, id, type, journal) {
            if (journal == 1) myWindow1 = window.open("{{URL("/ViewLoan/")}}" + "?m=" + m + "&id=" + id + "&type=" + type, "mywin", "height=900,width=1300,scrollbars=yes,top=1,left=1,status,resizable");
            else if (journal == 3) myWindow1 = window.open("{{URL("/ViewCreditNote/")}}" + "?m=" + m + "&id=" + id + "&type=" + type, "mywin", "height=900,width=1300,scrollbars=yes,top=1,left=1,status,resizable");
            else if (journal == 2 || journal == 5 || journal == 8 || journal == 4.1 || journal == 4.2 || journal == 7.1 || journal == 7.2) myWindow1 = window.open("{{URL("/ViewJournal/")}}" + "?m=" + m + "&id=" + id + "&type=" + type + "&journal=" + journal, "mywin", "height=900,width=1300,scrollbars=yes,top=1,left=1,status,resizable");
            if (journal == 22) myWindow1 = window.open("{{URL("/ViewSalary/")}}" + "?m=" + m + "&id=" + id + "&type=" + type, "mywin", "height=900,width=1500,scrollbars=yes,top=1,left=1,status,resizable");
            myWindow1.focus();
        }
    </script>
@endsection
