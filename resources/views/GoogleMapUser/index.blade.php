@extends('AdminLTE')
@section('content')
    <style>

        .show_table th {
            border: 0px solid;
        }

        .container {
            display: flex;
            width: 1200px;
            text-align: left !important;
            horiz-align: left !important;
            border: 0px solid #ddd;
            margin: 0px 0px;
            padding: 0px 0px;

        }

        .item {
            width: 90px;
            border: 1px solid #000000;
            margin: 0px 0px;
            text-align: center !important;
        }

        .item_in {
            border-right: 1px solid #ddd;
            margin: 0px 0px;
            background-color: green;
            height: 20px;

        }

        .item_out {
            border-right: 1px solid #ddd;
            margin: 0px 0px;
            background-color: red;
            height: 20px;
        }

        .item_none {
            border-right: 1px solid #ddd;
            margin: 0px 0px;
            background-color: #C7C7C7;
            height: 20px;
        }
    </style>
    <br>
    <?php
    function dif_minutes($min1, $min2)
    {
        return (strtotime("2020-03-11 $min2:00") - strtotime("2020-03-11 $min1:00")) / 60;
    }

    function clas($distance_in_km)
    {
        if (intval($distance_in_km) == 0)
            return 'item_in';
        elseif (intval($distance_in_km) > 0)
            return 'item_out';
    }

    ?>





    <form method="GET" action="{{ route('GoogleMapUser.index')}}">
        @csrf
        <table class="table m-0 search_table" style="width:10px!important;">
            <tr>
                <TH>Supervisor:</TH>
                <td>
                    <select name="filter_userId" id="filter_userId"
                            class="form-control" style="width:200px;">
                        <option value="">All</option>
                        @foreach($users as $user)
                            <option
                                value="{{$user->id}}" <?php if ($filter_userId == $user->id) echo " selected ";?>> {{$user->name}}</option>
                        @endforeach
                    </select>
                </td>
                <TH>Tracking Date Range</TH>
                <td>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" value="{{$tracking_date}}" class="form-control" style="width:200px"
                               name="tracking_date" id="tracking_date">
                        <script>
                            $(function () {
                                $('input[name="tracking_date"]').daterangepicker({
                                    autoUpdateInput: true,
                                    <?php
                                        $a = explode(' - ', $tracking_date);
                                        ?>
                                    startDate: '{{$a[0]}}',
                                    endDate: '{{$a[1]}}',
                                    opens: 'left',
                                    locale: {
                                        cancelLabel: 'Cancel',
                                        format: 'DD/MM/YYYY',
                                    }
                                });
                                $('input[name="tracking_date"]').on('apply.daterangepicker', function (ev, picker) {
                                    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                });
                                $('input[name="tracking_date"]').on('cancel.daterangepicker', function (ev, picker) {
                                    $(this).val('');
                                });
                            });
                        </script>
                    </div>

                </td>


                <td>
                    <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">Track</button>
                </td>
            </tr>
        </table>
    </form>
    <table class="show_table" style="width: 100%">
        <tr>
            <TH>Name</TH>
            <TH style="text-align: left !important;">
                <div class="container">
                    <?php
                    for ($i = 7; $i < 20; $i++) {
                        echo '<div class="item" >' . $i . '</div>';
                    }
                    ?>
                </div>
            </TH>
        </tr>
        <?php
        $i = 0;$k = 0;$loc = '';$userId = '';
        $ini_time = '07:00';
        $end_time = '20:00';
        $start_time = $ini_time;
        $name = '';
        foreach ($polygons as $polygon) {


            if ($userId <> $polygon->userId && $i <> 0) {
                echo "<TR><TH>" . $name . "</TH>\n" .
                    "<TH> <div class='container'>" . $loc . "</div></TH></TR>\n";
                $loc = "";
                $start_time = $ini_time;
                $k = 0;
            }
            $name = $polygon->userId;
            $userId = $polygon->userId;
            $length = dif_minutes($start_time, $polygon->HM);
            $start_time = $polygon->HM;
            if ($k == 0 && !empty($polygon->name))
                $loc .= '<div class="item_none" style="width: ' . ($length * 1.5) . 'px;"></div>';

            if (isset($polygons[$i + 1]->userId) && $polygon->userId == $polygons[$i + 1]->userId)
                $last_time = $polygons[$i + 1]->HM;
            else $last_time = $end_time;


            $length = dif_minutes($polygon->HM, $last_time);
            if (empty($polygon->name)) {

            } else {
                if ($length > 0 && $length < 15)
                    $loc .= '<div class="' . clas($polygon->distance_in_km) . '" style="width: ' . ($length * 1.5) . 'px;"></div>';
                elseif ($length >= 15) {
                    $loc .= '<div class="' . clas($polygon->distance_in_km) . '" style="width: ' . (10 * 1.5) . 'px;"></div>';
                    $loc .= '<div class="item_none" style="width: ' . (($length - 10) * 1.5) . 'px;"></div>';
                }
            }


            //$loc .= "[" . $polygon->latitude . "," . $polygon->longitude . ",'" . $polygon->HM . "'],\n";
            $k++;
            $i++;
        }
        echo "<TR><TH>" . $name . "</TH>" .
            "<TH><div class='container'>" . $loc . "</div></TH></TR>";

        /*foreach ($polygons as $polygon) {
            echo "<TR>
             <TH>" . $polygon->name . "</TH>
             <TH>aa</TH>
            </TR>";
            $i++;
        }
        */
        ?>
    </table>








@endsection




