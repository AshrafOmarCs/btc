@include('pages.messages')
<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;">
    <h2 style="font-size: 14px;font-weight: bold;">No Liability Certificate</h2>
</div>
    <label style="margin: 10px;" for="emp_id">Employee data</label>
    @if(sizeof($liabilities) == 0)
        <span style="float: right; margin-right: 5px;">
            <button class="btn btn-primary" type="button" onclick="newRequest('{{$id}}')">New Request</button>
        </span>
    @elseif($liabilities[0]->vehicle_status === 1 AND $liabilities[0]->finance_status === 1 AND $liabilities[0]->manager_status === 1)
        <span style="float: right; margin-right: 5px;">
            <button class="btn btn-primary" type="button" onclick="newRequest('{{$id}}')">New Request</button>
        </span>
    @elseif($liabilities[0]->vehicle_status === 0 OR $liabilities[0]->finance_status === 0 OR $liabilities[0]->manager_status === 0)
        <span style="float: right; margin-right: 5px;">
            <button class="btn btn-primary" type="button" onclick="newRequest('{{$id}}')">New Request</button>
        </span>
    @endif
    <table id="customer_data" class="table table-bordered table-striped table-responsive" style="width: 100%;">
        <tr>
            <th>Reference</th>
            <th>Request at</th>
            <th>Request by</th>
            <th>Status</th>
            <th>Issued at</th>
            <th>Note</th>
            <th>Departments</th>
            <th>Done by</th>
            <th>Done at</th>
            <th>Notes</th>
            <th>Action</th>
        </tr>
        <tbody>
            @if(sizeof($liabilities) == 0)
                <tr>
                    <td colspan="11" style="text-align: center">No data found!</td>
                </tr>
            @else
                @foreach($liabilities as $liability)
                    <tr>
                        <td rowspan="3" style="vertical-align: middle;">
                            {{$liability->reference_no}}
                        </td>
                        <td rowspan="3" style="vertical-align: middle;">
                            {{$liability->created_at}}
                        </td>
                        <td rowspan="3" style="vertical-align: middle;">
                            {{$liability->userName}}
                        </td>
                        <td rowspan="3" style="vertical-align: middle;">
                            @if($liability->vehicle_status === 1 AND $liability->finance_status === 1 AND $liability->manager_status === 1)
                                <span class="badge badge-success">Accepted</span>
                            @elseif($liability->vehicle_status === 0 OR $liability->finance_status === 0 OR $liability->manager_status === 0)
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td rowspan="3" style="vertical-align: middle;">
                            @if($liability->vehicle_status === 1 AND $liability->finance_status === 1 AND $liability->manager_status === 1)
                                {{max($liability->manager_done_at, $liability->finance_done_at, $liability->vehicle_done_at)}}
                            @elseif($liability->vehicle_status === 0 OR $liability->finance_status === 0 OR $liability->manager_status === 0)
                                {{max($liability->manager_done_at, $liability->finance_done_at, $liability->vehicle_done_at)}}
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td rowspan="3" style="vertical-align: middle;">
                            {{$liability->note}}
                        </td>
                        <td>
                            Vehicle
                            @if($liability->vehicle_status === 1)
                                <span class="badge badge-success">Accepted</span>
                            @elseif($liability->vehicle_status === 0)
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            {{$liability->vehicle_done_by}}
                        </td>
                        <td>
                            {{$liability->vehicle_done_at}}
                        </td>
                        <td>
                            {{$liability->vehicle_note}}
                        </td>
                        <td rowspan="3" style="vertical-align: middle;">
                            <a href="/liabilityCert/{{$liability->id}}/0" target="_blank">View</a> | <a href="/liabilityCert/{{$liability->id}}/1" target="_blank">Print</a>
                        </td>
                    </tr>

                    <tr class="">
                        <td>
                            Finance
                            @if($liability->finance_status === 1)
                                <span class="badge badge-success">Accepted</span>
                            @elseif($liability->finance_status === 0)
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            {{$liability->finance_done_by}}
                        </td>
                        <td>
                            {{$liability->finance_done_at}}
                        </td>
                        <td>
                            {{$liability->finance_note}}
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            Manager
                            @if($liability->manager_status === 1)
                                <span class="badge badge-success">Accepted</span>
                            @elseif($liability->manager_status === 0)
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            {{$liability->manager_done_by}}
                        </td>
                        <td>
                            {{$liability->manager_done_at}}
                        </td>
                        <td>
                            {{$liability->manager_note}}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" id="filter">Close</button>
    </div>
