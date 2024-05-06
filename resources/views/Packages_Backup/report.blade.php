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
            <td style="font-size: 14px;font-weight: bold;">Packages_Backup</td>
        </tr>
    </table>
    <br><br>

    <table class="table show_table" id="example" style="width:50%" align="center">
        <thead>
        <tr>

            <th>Period</th>
            <th>Drivers</th>
            <th>No_of_TP</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $No_of_TP = 0;
        $CO=0
        ?>
        @foreach($master as $masterr)
            <tr>

                <td><b>{{$masterr->period_from_dt}} - {{$masterr->period_to_dt}}</b></td>
                <td ondblclick="view({{$masterr->period_id}})" >
                    <b>{{$masterr->CO}}</b></td>
                <td ondblclick="view({{$masterr->period_id}})" >
                    <b>{{$masterr->No_of_TP}}</b></td>
            </tr>
            <?php
            $No_of_TP += $masterr->No_of_TP;
            $CO += $masterr->CO;
            ?>
        @endforeach
        <tr>
            <th colspan="1"><b>Total ALL</b></th>
            <th ><b>{{$CO}}</b></th>
            <th ><b>{{$No_of_TP}}</b></th>

        </tr>
        </tbody>
    </table>


    <script>



        function view( id) {
            myWindow1 = window.open("{{URL("/ViewPackages_Drivers/")}}" + "/" + id , "mywin",
                "height=800,width=800,scrollbars=yes,top=1,left=1,status,resizable");
            myWindow1.focus();
        }
    </script>

@endsection




