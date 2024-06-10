<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="modal-body">
    <center>
        <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;font-size: 14px;font-weight: bold;">
            {{$company->companyName}}  -  {{$company->warehouseName}}   -   {{$company->fullName}}
        </div>
        <div>
            <b>
                <font color="red">
                    {{$company->amount}}
                </font>
             </b>
         </div>
        <div>
            <b>
                <font color="red">
                    {{$from}}  -  {{$to}}
                </font>
            </b>
        </div>

        <table class="table table-bordered">
            <tr>
                <TH>Date</TH>
                <TH>DayName</TH>
                <TH style="width: 100px !important">Journal_Type</TH>
                <TH>Create By</TH>
                @if ($company->calculation_method_id==2)
                <TH>No_Of_Deliverd</TH>
                 @endif
                @if ($company->calculation_method_id==1)
                <TH>No_Of_TP</TH>
                @endif
                <TH>Unit_Cost</TH>
                <TH>Credit</TH>
                <TH>Debit</TH>
                <TH>Brought_Down</TH>
            </tr>

            <?php $t_days = $t_credit = $t_debit = $carried_down = $no_of_touch_point = 0;?>
            @foreach($qq as $q)
                <?php $carried_down+=$q->Carried_Down;
                    $no_of_touch_point+=$q->no_of_touch_point;
                    $note = '';
                    $t_credit += round($q->credit, 2);
                    $t_debit += round($q->debit, 2);
                    if($q->journal_type == 'Daily Load') {
                        $t_days++;
                    } else if($q->journal_type != '' AND $q->note != '') {
                        $note = " (".$q->note.")
                        <a onclick=\"show_record('".$q->post_id."', '".$q->journal_type."')\" id='".$q->post_id."' data-original-title='view' data-toggle='tooltip' data-placement='top' class='btnaction btn menu-icon vd_bd-green vd_green view'> <i class='bi bi-eye-fill'></i> </a>
                        ";
                    }
                ?>
                <tr>
                    <td>{{$q->date}}</td>
                    <td>{{$q->dayname}}</td>
                    <td style="width: 100px !important">
                        @php echo $q->journal_type . $note;@endphp
                    </td>
                    <td>
                        {{$q->created_by}}
                    </td>
                    @if ($company->calculation_method_id==2)
                    <td>{{$q->no_of_deliverd}}</td>
                     @endif
                    @if ($company->calculation_method_id==1)
                    <td>{{$q->no_of_touch_point}}</td>
                    @endif
                    <td><?php if (isset($q->unit_cost)) echo floatval($q->unit_cost);else echo ""; ?></td>
                    <td><?php if (isset($q->credit)) echo floatval($q->credit);else echo ""; ?></td>
                    <td><?php if (isset($q->debit)) echo floatval($q->debit);else echo ""; ?></td>
                    <td>{{round($carried_down +0)}}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan=4>Month Balance</th>
                <th>{{$no_of_touch_point+0}}</th>
                <th></th>
                <th>{{$t_credit}}</th>
                <th>{{$t_debit}}</th>
                <th>{{round($carried_down+0)}}</th>
            </tr>
            <tr>
                <th colspan=8>Carried Down</th>
                <th>{{round($Carried_Down->carried_down+0)}}</th>
            </tr>
            <tr>
                <th colspan=8>Brought Down</th>
                <th>{{round($Carried_Down->carried_down+$carried_down+0)}}</th>
            </tr>
            <tr>
                <th colspan=8>T.Days</th>
                <th>{{$t_days}}</th>
            </tr>
        </table>

    </center>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
