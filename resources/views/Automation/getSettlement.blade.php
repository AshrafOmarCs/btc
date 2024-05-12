
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">Accept Settlement(s)</h2>
</div>

<form method="POST" action="{{ route('automation/settlementAccept')}}">
    @csrf
    <input type="hidden" name="id" value="{{$action[0]->id}}">
    
        <table class="table m-0 show_table" style="float:left;margin-top: 5px;margin-left: 20px;width:95%; border: 2px solid;">
            <tr>
                <TH>Procedure</TH>
                <td>
                    {{$action[0]->module}}
                </td>
                <TH>Proof File</TH>
                <td>
                    <a target="_blank" href="https://btcdmins.com/storage/paid/saned/{{$action[0]->prof_file}}"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
                </td>
            </tr>
            <tr>
                <TH>Created by</TH>
                <td>
                    {{$action[0]->name}}
                </td>
                <TH>Created at</TH>
                <td>
                    {{$action[0]->created_at}}
                </td>
            </tr>
            <tr>
                <TH>Period</TH>
                <td>
                    {{$action[0]->period}}
                </td>
                <TH></TH>
                <td></td>
                
            </tr>
        </table>
        <table id="customer_data" class="table m-0 show_table show_table_data" style="float:left;margin-top: 5px;margin-left: 20px;width:95%;">
            <thead>
                <tr>
                    <TH>Saned Date</TH>
                    <TH>City</TH>
                    <TH>Emp ID</TH>
                    <TH>Driver</TH>
                    <TH>Cash</TH>
                    <TH>Clearing Type</TH> 
                </tr>
            </thead>
            <tbody>
                @php $total = $i = 0; @endphp
                @foreach($settlements as $settlement)
                    <tr>
                        <td>{{$settlement->SettledDate}}</td>
                        <td>{{$settlement->warehouseName}}</td>
                        <td>{{$settlement->AMP_ID}}</td>
                        <td>{{$settlement->DriverName}}</td>
                        <td>{{$jahizs[$i]->cash}}</td>
                        <td>استلام</td>
                    </tr>
                    @php 
                    $total += $jahizs[$i]->cash;
                    $i++;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <TH colspan="4" style="text-align: center;">Total</TH>
                    <TH>{{$total}}</TH>
                    <TH></TH>
                </tr>
            </tfoot>
        </table>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Accept</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">{{__('contractsQuotation.cancel')}}
    </button>
</div>

