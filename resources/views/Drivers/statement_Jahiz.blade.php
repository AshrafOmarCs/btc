<style>

    .show_table th {
        padding: 0.3rem 0.3rem !important;
        border: solid 1px !important;
        margin: 0 !important;
        width: 10px;
        text-align: center;
        background-color: #00ca6d;
        white-space: nowrap;
    }

    .show_table td {
        white-space: nowrap;
        padding: 0.0rem 0.3rem !important;
        border: solid 1px !important;
        vertical-align: middle !important;
    }
</style>
<center>
    <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}}</h2>
    </div>

    <table>
        <tr>
            <td style="padding: 0.3rem 2.0rem !important;vertical-align: top;text-align: center;">
                <span style="font-size: 16pt;font-weight: bold;color: red"> SANED</span>
                <table class="show_table" style="width:10px!important;">
                    <tr>
                        <TH>CollectionAmount</TH>
                        <TH>DeliveryPrice</TH>
                        <TH>DriverCredit</TH>
                        <TH>DriverDebit</TH>
                        <TH>Amount</TH>
                        <TH>SettledDate</TH>
                    </tr>

                    @foreach($statement_SANED as $SANED)
                        <tr>
                            <td>{{$SANED->CollectionAmount}}</td>
                            <td>{{$SANED->DeliveryPrice}}</td>
                            <td>{{$SANED->DriverCredit}}</td>
                            <td>{{$SANED->DriverDebit}}</td>
                            <td><b>{{$SANED->SANED_amount}}</b></td>
                            <td>{{$SANED->SettledDate}}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
            <td style="padding: 0.3rem 2.0rem !important;vertical-align: top;text-align: center;">
                <span style="font-size: 16pt;font-weight: bold;color: red"> Bander</span>
                <table class="show_table" style="width:10px!important;">
                    <tr>

                        <TH>Amount</TH>
                        <TH>SettledDate</TH>
                    </tr>

                    @foreach($statement_Bander as $Bander)
                        <tr>
                            <td><b>{{$Bander->Jahiz_Amount}}</b></td>
                            <td>{{$Bander->updated_at}}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
</center>
<br>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>


