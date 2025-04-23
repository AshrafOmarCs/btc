<table style=" width:95%;margin-top: 5px;margin-left: 20px;">
    <tr>
        <td style="width:100%;font-size: 14px;font-weight: bold;">{{__('drivers.driver')}}</td>
    </tr>
</table>

@include('pages.messages2')

    <div class="table-responsive">
        <table id="customer_data" class="customer_data table table-bordered">
            <thead id="header">
                <TH>Sr. No</TH>
                <TH >Company</TH>
                <TH >Warehouse</TH>
                <TH >Job Id</TH>
                <TH >Driver</TH>
                <TH >Phone</TH>
                <TH >Iqama</TH>
                <TH >Amount</TH>
                <TH >Action</TH>
            </thead>
            <tbody>
                @php
                    $i = 0;
                @endphp
                @foreach($results as $result)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$result->companyName}}</td>
                        <td>{{$result->warehouseName}}</td>
                        <td>{{$result->job_id}}</td>
                        <td>{{$result->fullName}}</td>
                        <td>{{$result->mobileNumber}}</td>
                        <td>{{$result->iqama}}</td>
                        <td>{{round($result->t_credit - $result->t_debit)}}</td>
                        <td>
                            <a onclick=loadStatement({{$result->id}}) data-original-title="Statement" title="Statement" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-blue vd_blue statement" aria-describedby="tooltip{{$result->t_debit}}"> <i class="bi bi-bar-chart-line-fill"></i> </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



