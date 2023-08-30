<style>
    .show_table th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
    }
    .rte-floatpanel-paragraphop {
        display: none !important;
    }

    /* Style the input field */
    .styled-input {
        width: 300px; /* Adjust the width as needed */
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none; /* Remove the default input outline */
    }

    /* Style the input field on focus */
    .styled-input:focus {
        border-color: #007bff; /* Change border color on focus */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add a subtle box shadow on focus */
    }

    /* Style a label for the input (optional) */
    .input-label {
        font-size: 14px;
        color: #555;
    }
</style>

<div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">Update {{$type}}</h2>
</div>

<form method="POST" action="{{ route('ContractsQuotation/update')}}">
    @csrf
    <input type="hidden" name="id" value="{{$data[0]->id}}"
    <table>
        <tr>
            <td style="vertical-align: top !important;">
                <table  class="table m-0 show_table" style="width:10px!important;">
                    <tr>
                        <TH>Company Name <font color="red">*</font></TH>
                        <td><input type="text" class="form-control" style="width:400px;" name="companyName" value="{{$data[0]->companyName}}" required></td>
                    </tr>
                    <tr>
                        <TH>Company Email <font color="red">*</font></TH>
                        <td><input type="email" class="form-control" style="width:400px;" name="companyEmail" value="{{$data[0]->companyEmail}}" required></td>
                    </tr>

                    @if($data[0]->status === 0)
                    <input type="hidden" name="reasons_update" value="1">
                    <TH>Reject Reasons by Company: </TH>
                    <td><b>
                        {{$data[0]->reject_reason}}
                        </b>
                    </td>
                    @elseif(sizeof($reject_reasons) > 0)
                    <input type="hidden" name="reasons_update" value="1">
                    <TH>Reject Reasons: </TH>
                    <td><b>
                        @foreach ($reject_reasons as $reject_reason)
                            {{$reject_reason->name}}: {{$reject_reason->reject_reason}} <br>
                        @endforeach
                        </b>
                    </td>
                    @endif
                </table>
            </td>
        </tr>
    </table>
    <div class="col-lg-12">
        <b>Body <font color="red">*</font></b><br>
        <table border="1" id="customer_data" class="items_table" style="width: 100%">
            <thead>
                <th>Item</th>
                <th>Description</th>
                <th>Price</th>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" id="name_1" class="styled-input" placeholder="Add Item" name="name[]" style="width: 100%"></td>
                    <td><textarea name="description[]" id="description_1" class="styled-input" placeholder="Add Description" style="width: 100%"></textarea></td>
                    <td><input type="number" id="price_1" class="styled-input" placeholder="Add Price" name="price[]" style="width: 100%"></td>
                </tr>
            </tbody>
            <tfoot>
                <td colspan="3" id="btn"><button type="button" class="btn btn-primary" onclick="add_row(1, {{$data[0]->id}})">Add Row</button></td>
            </tfoot>
        </table>
        <!--<textarea id="div_editor1" class="form-control" value="" name="body" required>{{$data[0]->body}}</textarea>-->
    </div>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="button" id="verification" onclick="open_verify_modal({{$data[0]->id}})">Verify</button>
    </div>
</form>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
    <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'"
            type="button" class="w3-btn w3-red">Cancel
    </button>
</div>
