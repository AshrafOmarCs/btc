
<center>
 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}}</h2>
</div>

<table class="table table-bordered" style="width: 95%">
    <tr>
        <TH>Journal Period</TH>
        <TH>Carried Down</TH>
        <TH>Credit</TH>
        <TH>Debit</TH>
        <TH>Brought Down</TH>
        <TH>Balance Sheet</TH>
    </tr>
<?php
    $carried_down=0;
    $Brought_Down=0;
?>
    @foreach($statement as $q)
        <?php
        $carried_down=$Brought_Down;
        $Brought_Down=$carried_down + $q->credit - $q->debit;
        ?>
        <tr>
            <td>{{$q->journal_period}}</td>
            <td>{{$carried_down}}</td>
            <td>{{$q->credit}}</td>
            <td>{{$q->debit}}</td>
            <td>{{$Brought_Down}}</td>
            <td><a href="javascript:sheet({{$q->id}},'<?php echo str_replace(' - ','*',$q->journal_period);?>')">Sheet</a></td>
        </tr>
@endforeach
</table>
</center>


