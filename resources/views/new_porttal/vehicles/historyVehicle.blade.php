<div class="row" style="padding: 10px;">
    <div class="col-lg-6">
        <h6>Vehicle History</h6>
    </div>
</div>
    <div class="row" style="padding: 10px;">
        <div class="col-lg-12">
            <table id="" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Delegation Qty</th>
                        <th>Drivers Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($results) > 0)
                        @foreach($results as $result)
                            <tr>
                                <td>{{$result->firstDay . ' - ' . $result->lastDay}}</td>
                                <td>{{$result->del_count}}</td>
                                <td>{{$result->driver_count}}</td>
                                <td><a href="#" onclick="driversInfo({{$vehicle_id}}, '{{$result->firstDay}}', '{{$result->lastDay}}')">View</a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center;">No data available!</td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>



