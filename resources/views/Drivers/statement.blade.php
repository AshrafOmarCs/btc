<style>

    .show_table th{
        padding: 0.0rem 0.3rem !important;
        border:solid 1px !important;
        margin:0!important;
        width:10px;
        white-space: nowrap;
    }
    .show_table td{
        white-space: nowrap;
        padding: 0.0rem 0.3rem !important;
        border:solid 1px !important;
        vertical-align: middle !important;
    }
</style>
<center>
 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}}</h2>
</div>

<table class="table m-0 show_table" style="width:10px!important;">
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
<br>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>


