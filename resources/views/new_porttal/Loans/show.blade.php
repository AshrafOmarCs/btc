<div class="modal-body">
    <table class="table table-boarded">
        <tr><TH>Driver</TH>
            <td>{{$Loans->fullName}}</td>
        </tr>
        <tr><TH>Journal Date</TH>
            <td>{{$Loans->journal_date}}</td>
        </tr>
        <tr><TH>Amount </TH>
            <td>{{$Loans->amount}}</td>
        </tr>
        <tr><TH>Note</TH>
            <td>{{$Loans->note}}</td>
        </tr>
        <tr><TH>Status</TH>
            <td>
                <?php
                if($Loans->status_id=="1") echo '<span class="label label-warning">'.$Loans->loan_status.'</span>';
                else if($Loans->status_id=="2") echo '<span class="label label-danger">'.$Loans->loan_status.'</span>';
                else if($Loans->status_id=="3") echo '<span class="label label-primary">'.$Loans->loan_status.'</span>';
                else if($Loans->status_id=="4") echo '<span class="label label-success">'.$Loans->loan_status.'</span>';
                else if($Loans->status_id=="5") echo '<span class="label label-info">'.$Loans->loan_status.'</span>';
                ?>
            </td>
        </tr>
        <tr><TH>Create By </TH>
            <td>{{$Loans->name_created}}</td>
        </tr>
        <tr><TH>Update By </TH>
            <td>{{$Loans->name_updated}}</td>
        </tr>
        <tr><TH>Created At</TH>
            <td>{{$Loans->created_at}}</td>
        </tr>
        <tr><TH>Updated At</TH>
            <td>{{$Loans->updated_at}}</td>
        </tr>
    </table>
</div>
