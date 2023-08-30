@extends('AdminLTE')
@section('content')
    @include('pages.messages2')
    <style>
        .show_table th {
            white-space: nowrap;
            border: none !important;
            margin: 0 !important;
        }

        .show_table td {
            padding: 0.0rem 0.0rem !important;
            border: none !important;
            vertical-align: middle !important;
        }
    </style>

<center>
    <table style=" width:100%;margin-top: 5px;">
        <tr>
            <td style="width:100%;font-size: 14px;font-weight: bold;text-align: center"> تسجيل حضور المناديب كارفور ليوم :
                {{date("Y-m-d")}}
            </td>
        </tr>
    </table>

    <form method="POST" action="{{ URL('/DriversAttendSave')}}">
        @csrf
        <style>

            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
                border: 0.5px solid #808080;
            }
            .table-bordered {
                border: 0.5px solid #808080;
            }
        </style>
        <div class="table-responsive" style="width:auto!important;">
        <table id="customer_data" class="table table-bordered table-striped" style="width:auto!important;border: 0.5px solid #808080;!important;">
            <thead>
            <tr>
                <th>#</th>
                <th>FullName</th>
                <th>Attend</th>
                <th>Time</th>
            </tr>
            </thead>
            <?php
            $i = 0;
            ?>
            @foreach($Drivers as $Driver)
                <?php
                $i++;
                ?>
                <tr>
                    <td style="text-align: center!important;">{{$i}}</td>
                    <td>{{$Driver->fullName}}</td>
                    <td style="text-align: center!important;"><input class="icheckbox_flat-green" name="ID_{{$i}}" type="checkbox" value="{{$Driver->id}}"
                        <?php
                            if ($Driver->created_at<>'') echo " checked ";
                        ?>
                        ></td>
                    <td>{{$Driver->created_at}}</td>
                </tr>
            @endforeach
        </table>
        </div>
</center>
        <div class="w3-row">
            <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Save Attendance</button>
        </div>
    </form>
<script>
    $(function () {
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-green'
        });
    });

</script>

@endsection
