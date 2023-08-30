<style>
    .show_table th {
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
    }
    .w3-table-all td, th {
        border: 0px !important;
    }
    th, td {
        text-align: center;
    }
</style>


@include('pages.messages2')

<h4>Assign Warehouses to {{ $name }}</h4>
<form id="assign_form" method="POST" onsubmit="return validateAssignForm()">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <input type="hidden" name="name" value="{{$name}}">
    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
            <TH>Sr. No</TH>
            <TH>Company</TH>
            <TH>Warehouse</TH>
            <TH>City</TH>
            <TH>Assign</TH>
            </thead>
            <tbody>
                @php $no = 0; @endphp
                @foreach($results as $result)
                    @php 
                        $warehouses = $result->allowed_warehouse_attendance;
                        $warehouses = json_decode($warehouses);
                    @endphp
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $result->companyName }}</td>
                        <td>{{ $result->warehouseName }}</td>
                        <td>{{ $result->name_en }}</td>
                        <td><input type="checkbox" @php if ($result->allowed_warehouse_attendance != '' AND in_array($result->id, $warehouses)) echo 'checked'; @endphp name="warehouses[]" value="{{ $result->id }}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" id="submitForm" type="submit">Update</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button
        onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
        type="button" class="w3-btn w3-red">Cancel
    </button>
</div>




