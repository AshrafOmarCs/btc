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
            <td style="font-size: 14px;font-weight: bold;">Attachments Report</td>
        </tr>
    </table>
    <br><br>

    <table class="table show_table" id="example" style="width:80%" align="center">
        <thead>
        <tr>
            <th>#</th>
            <th width="200px">Company</th>
            <th>Drivers Count</th>
            <th>Image_Identity</th>
            <th>Image_Passport</th>
            <th>Image_DrivingLicence</th>
            <th>Image_VehiclesRegistration</th>
            <th>Image_JobContract</th>
            <th>Image_PromissoryNote</th>

        </tr>
        </thead>
        <tbody>
        <?php
        $Image_Identity = 0;$Image_Passport = 0;$Image_DrivingLicence = 0;$Image_VehiclesRegistration = 0;$Image_JobContract = 0;$Image_PromissoryNote = 0;$CO = 0;
        ?>
        @foreach($master as $masterr)
            <tr>
                <td class="master-control_open master_{{$masterr->companyId}}"
                    onclick="master({{$masterr->companyId}})"></td>
                <td><b>{{$masterr->companyName}}</b></td>
                <td style="background-color: #7CCBDC">
                    <b>{{$masterr->CO}}</b></td>
                <td style="background-color: #FFFFFF">
                    <b>{{$masterr->Image_Identity}}</b></td>
                <td style="background-color: #FFFFFF">
                    <b>{{$masterr->Image_Passport}}</b></td>
                <td style="background-color: #FFFFFFF">
                    <b>{{$masterr->Image_DrivingLicence}}</b></td>
                <td style="background-color: #FFFFFF">
                    <b>{{$masterr->Image_VehiclesRegistration}}</b></td>
                <td style="background-color: #FFFFFF">
                    <b>{{$masterr->Image_JobContract}}</b></td>
                <td style="background-color: #FFFFFF">
                    <b>{{$masterr->Image_PromissoryNote}}</b></td>

            </tr>
            <?php
            $Image_Identity += $masterr->Image_Identity;
            $Image_Passport += $masterr->Image_Passport;
            $Image_DrivingLicence += $masterr->Image_DrivingLicence;
            $Image_VehiclesRegistration += $masterr->Image_VehiclesRegistration;
            $Image_JobContract += $masterr->Image_JobContract;
            $Image_PromissoryNote += $masterr->Image_PromissoryNote;
            $CO += $masterr->CO;
            ?>

            @foreach($details as $detail)
                @if ($detail->companyId==$masterr->companyId)
                    <tr class="hidden_row details_{{$detail->companyId}}">
                        <td style="background-color: #ecf0f5;border-bottom: 1px #E6E6E6 !important;border-top: 1px #E6E6E6 !important;border-left: 1px #E6E6E6 !important;"></td>
                        <td>{{$detail->warehouseName}}</td>
                        <td><b>{{$detail->CO}}</b></td>
                        <td>{{$detail->Image_Identity}}</td>
                        <td>{{$detail->Image_Passport}}</td>
                        <td>{{$detail->Image_DrivingLicence}}</td>
                        <td>{{$detail->Image_VehiclesRegistration}}</td>
                        <td>{{$detail->Image_JobContract}}</td>
                        <td>{{$detail->Image_PromissoryNote}}</td>

                    </tr>
                @endif
            @endforeach
        @endforeach
        <tr>
            <th colspan="2"><b>Total ALL</b></th>
            <th><b>{{$CO}}</b></th>
            <th><b>{{$Image_Identity}}</b></th>
            <th><b>{{$Image_Passport}}</b></th>
            <th><b>{{$Image_DrivingLicence}}</b></th>
            <th><b>{{$Image_VehiclesRegistration}}</b></th>
            <th><b>{{$Image_JobContract}}</b></th>
            <th><b>{{$Image_PromissoryNote}}</b></th>

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




