

<form method="POST" action="{{ route('automation/settlementAccept')}}">
    @csrf
    <input type="hidden" name="id" value="{{$action[0]->id}}">
    <div class="modal-body">
        <table class="table table-bordered" style="border: 2px solid;">
            <tr>
                <TH>Procedure</TH>
                <td>
                    {{$action[0]->module}}
                </td>
                <TH>Proof File</TH>
                <td>
                    <a target="_blank" href="/storage/paid/saned/{{$action[0]->prof_file}}"><i class="bi bi-eye bi-lg" aria-hidden="true"></i></a>
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
        <table class="mt-5 table table-bordered show_table_data">
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
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
        <button type="submit" class="btn btn-success"
            data-bs-dismiss="modal">Accept</button>
    </div>
</form>

