@php $total = 0; @endphp
@foreach($response as $resp)
    @php $total += $resp->fuel_price; @endphp
    <input type="hidden" name="filter_month" id="filter_month" value="{{$resp->month}}-{{$resp->year}}">
    <input type="hidden" name="filter_vehicleId[]" id="filter_vehicleId" value="{{$resp->vehicle_id}}">
    <tr>
        <td>{{$resp->plate}}</td>
        <td>{{$resp->day}}</td>
        <td>{{$resp->month}}</td>
        <td>{{$resp->year}}</td>
        <td>{{$resp->fuel_price}}</td>
        <td><input type="text" name="jobId_{{$resp->id}}" value="{{$resp->driver_id}}"></td>
    </tr>
@endforeach
<tr>
    <th colspan="4">Total</th>
    <th colspan="2">{{$total}}</th>
</tr>
