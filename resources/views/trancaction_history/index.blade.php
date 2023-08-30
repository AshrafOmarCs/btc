@extends('AdminLTE')
@section('content')
<style>
    th, td{
        text-align: center;
    }
</style>
<div class="card" >
   
  <div class="card-body">
    <h5 class="card-title">Transaction History</h5>
    <p class="card-text">From this page you can pull all trancation related to provided AMP ID or STCPAY Account Deatils .</p> 
  </div>
</div>
<table style="width: 96%; margin: 0 auto;">
    <tr> 
        <th>AMP ID </th>
        <th>STCPAY Identity</th>
        <th>STCPAY Number</th>
        <th>Trancation date</th>
        <th>Trancation Type</th>
        <th> </th>
    </tr>
        <tr> 
        <th><input  class="form-control" type="text" id="amp_id"> </th>
        <th><input  class="form-control" type="number" id="account_number"></th>
        <th><input  class="form-control" type="number" id="id_no"></th>
        <!--<th><input  class="form-control" type="date" id="selected_date"></th>-->
        <th>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control" name="selected_date" id="selected_date" type="text">
                <script>
                    $(function () {
                        $('input[name="selected_date"]').daterangepicker({
                            autoUpdateInput: false,
                            opens: 'left',
                            locale: {
                                cancelLabel: 'Cancel'
                            }
                        }); 2023-06-12
                        $('input[name="selected_date"]').on('apply.daterangepicker', function (ev, picker) {
                            $(this).val(picker.startDate.format('YYYY-MM-DD') + '/' + picker.endDate.format('YYYY-MM-DD'));
                        });
                        $('input[name="selected_date"]').on('cancel.daterangepicker', function (ev, picker) {
                            $(this).val('');
                        });
                    });

                </script>
            </div>
        </th>
        <th>
            <select id="trancation_type">
                <option value="all" selected>ALL</option>
                <option value="salaries">Salaries</option>
                <option value="loans">Loans</option>
                <option value="jahiz">Jahiz Payments</option>
            </select>
        </th>
         <th><button class="btn btn-sm btn-info" onclick="confirmSearch()">Search</button></th>
        
    </tr>
</table>

<hr>
<div class="table-responsive" style="width: 100%;">
    <div style="width:100%;clear:both;" id="response">

    </div>

    <table id="customer_data" class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>  
                <th>STCPAY Identity</th>
                <th>STCPAY Number</th>
                <th>Company</th>
                <th>HUB </th>
                <th>Driver AMP </th>
                <th>Driver Name</th>
                <th>Trancation Date  </th>
                <th>Transaction Total</th>
                <th>Transaction Count</th>
                <th>Driver's dues</th> 
                <th>Trancation Type </th>
            </tr>
        </thead>
        <tbody id="tbl_body">
            
    
        </tbody>
    </table> 
</div>
<hr>
<script>
    $(document).ready(function() {
	    $('#customer_data').DataTable({
	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: 'lBfrtip',
            "buttons": [
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    exportOptions: {

                        modifier: {
                            search: 'applied',
                            order: 'applied'
                        }
                    }
                }
            ],
            //searching: false,
            responsive: true,
            processing: true,
            "pagingType": "full_numbers",
            "autoWidth": false,
	    });
	});
function confirmSearch(){ 
    if($('#amp_id').val() == '' && $('#account_number').val() == '' && $('#id_no').val() == ''){ 
        
        alert('STCPAY Number Can not all Be Empty');
    }else{
        $("#response").show();
        $("#customer_data").hide();
        document.getElementById('response').innerHTML = loader;
        let url = '{{url('Transaction-History/Search')}}';
        let amp_id = $('#amp_id').val();
        var postData = {
            trancation_type:$('#trancation_type').val(),
            amp_id:$('#amp_id').val(),
            account_number:$('#account_number').val(),
            id_no:$('#id_no').val(),
            selected_date:$('#selected_date').val(),
            transaction_date:$('#trancation_type').find(":selected").val(), 
            _token: "{{ csrf_token() }}",
        }; 
        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            data: postData,
            success: function (data) { 
                $('#customer_data').DataTable().clear();
                if (data.length > 0) {
                    for(var i = 0; i < data.length; i++){ 
                        var row = data[i]; 
                        $('#customer_data').DataTable().row.add([
                          row.account_owner_iqama, row.accountNumber, row.companyName, row.warehouseName, row.AMP_ID, row.fullName, row.create_at, row.bank_paid, row.paid, row.bank_sum, row.type
                        ]).draw();
                    }
                } else {
                    $('#customer_data').DataTable().rows.add($(data)).draw();

                    // $('#customer_data').DataTable().row.add([
                        // 'No record found!', '', '', '', '', '', '', '', '', ''
                    // ]).draw();
                }
                $("#response").hide();
                $("#customer_data").show();
            },

            error: function (jqXHR, status, error) {
                alert(status + ": " + error);
            }
        }); 
    }
}
    
</script>



@endsection