@extends('AdminLTE')
@section('content')

<!-- Content Header (Page header) -->
<div  style="width:100%;margin: 0px; ">
      <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Deductions</h2></div>
      </div>     
      <div style="float:right;">
      <h2 ><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Deductions</a></h2>
      </div> 
<div class="card card-default" style="width:100%;clear:both;"></div>

<!--w3-table-all w3-card-4-->
<!-- table table-bordered table-striped  -->
<script>
function card_change(){
    if(document.getElementById('card_box').className=="box box-primary")
    {
    document.getElementById('card_box').className="box box-primary collapsed-box";
    document.getElementById('i_box').className="fa fa-plus";
    document.getElementById('box-body').style.display='none';
    }
    else 
    {
    document.getElementById('card_box').className="box box-primary";
    document.getElementById('i_box').className="fa fa-minus";
    document.getElementById('box-body').style.display='';
    }
}
</script>
  <!-- SELECT2 EXAMPLE -->
  <div class="col-md-3" style="width:100%;clear:both;">
          <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">          <button  class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>
             </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box" class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
            <table class="table m-0 search_table" style="width:10px!important;" >
<tr><TH>Driver </TH>  
<td  style="white-space: nowrap;">
          <input name="filter_driverId" id="filter_driverId" type="hidden"  >
           <table style="padding: 0px 0px; !important;"><tr><td>
          <input  class="form-control" name="filter_driverId_input" id="filter_driverId_input"  style="width:200px"  type="text"     data-readonly> 
          </td><td><button onclick="driver_window();" type="button" class="btn btn-primary btn-xs" >Select</button>
          </td></tr></table>
</td>
 <TH>Amount</TH>  
 <td><input  type="text" class="form-control"   style="width:180px;" name="filter_amount" id="filter_amount"   ></td>
 <TH>Journal Date </TH>  
<td>
<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
  <input  class="form-control" style="width:180px;" name="filter_journal_date" id="filter_journal_date" type="text"   >
  <script>
                    $(function() {
                     $('input[name="filter_journal_date"]').daterangepicker({
                      autoUpdateInput: false,
                      opens: 'left',
                        locale: {
                      cancelLabel: 'Cancel'
                       }
                      });
                     $('input[name="filter_journal_date"]').on('apply.daterangepicker', function(ev, picker) {
                     $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                     });
                     $('input[name="filter_journal_date"]').on('cancel.daterangepicker', function(ev, picker) {
                     $(this).val('');
                      });
                     });
                     </script>
                  </div>

  </td>
  </tr>
  <tr>
 <TH>Note</TH>
 <td><input  type="text" class="form-control"    name="filter_note" id="filter_note"   ></td>
 
  
  
   <TH>Created_At</TH><td>
   <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
  <input  class="form-control" name="filter_created_at" id="filter_created_at" type="text"  >
  <script>
                    $(function() {
                     $('input[name="filter_created_at"]').daterangepicker({
                      autoUpdateInput: false,
                      opens: 'left',
                        locale: {
                      cancelLabel: 'Cancel'
                       }
                      });
                     $('input[name="filter_created_at"]').on('apply.daterangepicker', function(ev, picker) {
                     $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                     });
                     $('input[name="filter_created_at"]').on('cancel.daterangepicker', function(ev, picker) {
                     $(this).val('');
                      });
                     });
                     </script>
                  </div>
  </td>
   <TH>Updated_At</TH><td>
   <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
  <input  class="form-control" id="filter_updated_at" name="filter_updated_at" type="text"  >
  <script>
                    $(function() {
                     $('input[name="filter_updated_at"]').daterangepicker({
                      autoUpdateInput: false,
                      opens: 'left',
                        locale: {
                      cancelLabel: 'Cancel'
                       }
                      });
                     $('input[name="filter_updated_at"]').on('apply.daterangepicker', function(ev, picker) {
                     $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                     });
                     $('input[name="filter_updated_at"]').on('cancel.daterangepicker', function(ev, picker) {
                     $(this).val('');
                      });
                     });
                     </script>
                  </div>
  </td>
  </tr>
  </table>

          <div class="card-footer" align="center" >
          <button type="button" name="filter"  class="btn btn-sm btn-info" id="filter">Filter</button>
        
          <button type="button" name="reset"  class="btn btn-sm btn-default" id="reset">Reset</button>
          </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

       
<!---------------------------------------------------------------------------------------------------------------------->
  <!---------------------------------------------------------------------------------------------------------------------->

  
<form method="POST" action="{{ URL('/DeductionsPost')}}">
                       @csrf
<div class="table-responsive" style="width: 100%;">                        
<table id="customer_data" class="table table-bordered table-striped">
<thead>
  <TH>Driver</TH>
  <TH>Journal Date</TH>
   <TH>Amount</TH>
   <TH>Note</TH>
   <TH>Updated By</TH>
   </thead>
  <tbody>
</tbody>
</table>
</div>

</form>

<!---------------------------------------------------------------------------------------------------------------------->
  <!---------------------------------------------------------------------------------------------------------------------->
  <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;" >
         <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
               <span onclick="document.getElementById('edit_modal').style.display='none'" class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright" title="Close Modal">&times;</span>
            </div>
            
           <div style="width:100%;clear:both;" id="response" >
           
            </div>
           <br>
           <br>
         </div>
      </div>
      <div id="delete_modal" class="w3-modal" >
         <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
               <span onclick="document.getElementById('delete_modal').style.display='none'" class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright" title="Close Modal">&times;</span>
            </div>
            <header class="w3-container w3-text-indigo w3-margin-top-64">
               <h1>Delete</h1>
            </header>
            <form class="w3-container" action="" method="POST" id="delete_form">
            {{method_field('DELETE')}}
               @csrf
              <div class="w3-section">
                  <p>Are you sure, you want to delete <span id ="delete_name"></span> ?</p>
                  <div class="w3-center"><button type="submit" class="w3-btn w3-indigo"> Delete </button></div>
               </div>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
               <button onclick="document.getElementById('delete_modal').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
            </div>
         </div>
      </div>     
<!---------------------------------------------------------------------------------------------------------------------->
  <!---------------------------------------------------------------------------------------------------------------------->

                      
<script>
$(document).ready(function(){

    fill_datatable();

        
        

        function fill_datatable(filter_driverId='',filter_journal_date='',filter_amount='',filter_note='',filter_created_at='',filter_updated_at='')
    {
        var dataTable = $('#customer_data').DataTable({
           //searching: false,
            responsive: true,
            processing: true,
            serverSide: true,
            "pagingType": "full_numbers",
            "autoWidth": false,
            "drawCallback": function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
            },
            ajax:{
                url: "{{ route('Deductions.index') }}",
        data:{
          filter_driverId:filter_driverId,
        filter_journal_date:filter_journal_date,
        filter_amount:filter_amount,
        filter_note:filter_note,
        filter_created_at:filter_created_at,
        filter_updated_at:filter_updated_at,
              }
                  },

            columns: [
                 
                {
                    data:'fullName',
                    
                    render: function(data, type, row, meta) {
                      return '<a href="javascript:driver('+row.driverId+')">'+data+'</a>';
                    } 
                    
                },
                {
                    data:'journal_date',
                    name:'journal_date'
                },
                {
                    data:'amount',
                    name:'amount'
                },
                
                {
                    data:'note',
                    name:'note'
                },
                {
                    data:'name',
                    name:'name'
                },
                
                
          ]
        });
        
        
    }
$('#customer_data tbody').on( 'click', '.view', function (e) {
e.preventDefault();
document.getElementById('response').innerHTML=loader;
document.getElementById('edit_modal').style.display='block';
var id = $(this).attr('id');
$.ajax({
        type: 'GET',
         url: "{{URL('/Deductions')}}"+"/"+id,
         contentType: "html",
         dataType : 'html',
         success: function (data) {
        
         document.getElementById('response').innerHTML=data;
        
        }
    });
} );
$('#customer_data tbody').on( 'click', '.edit', function (e) {
e.preventDefault();
document.getElementById('response').innerHTML=loader;
document.getElementById('edit_modal').style.display='block';
var id = $(this).attr('id');
$.ajax({
        type: 'GET',
         url: "{{URL('/Deductions')}}"+"/"+id+"/edit",
         contentType: "html",
         dataType : 'html',
         success: function (data) {
         
         document.getElementById('response').innerHTML=data;
var g = document.createElement('script');
var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
g.text = "$('#journal_date').datepicker({"+
      "format: 'dd/mm/yyyy',"+ 
      "autoclose: true,"+
      "autoHide: true,"+
        "zIndex: 9999,"+
"});"
s.parentNode.insertBefore(g, s);           
        
        }
    });
} );
$('#customer_data tbody').on( 'click', '.privilage', function (e) {
e.preventDefault();
var id = $(this).attr('id');
alert(id);
} );
$('#customer_data tbody').on( 'click', '.delete', function (e) {
e.preventDefault();
var id = $(this).attr('id');
         document.getElementById('delete_form').action="{{URL('/Deductions')}}"+"/"+id;
         document.getElementById('delete_modal').style.display='block';
        
        
      
} );


$('#filter').click(function(){
    
       if($('#filter_driverId').val() !=''||$('#filter_journal_date').val() !=''||$('#filter_amount').val() !=''||$('#filter_note').val() !=''||$('#filter_created_at').val() !=''||$('#filter_updated_at').val() !='')
        {
         card_change();
         $('#customer_data').DataTable().destroy();
         fill_datatable($('#filter_driverId').val(),$('#filter_journal_date').val(),$('#filter_amount').val(),$('#filter_note').val(),$('#filter_created_at').val(),$('#filter_updated_at').val());
        }
        else
        {
            alert('Select filter option');
        }
    });

    $('#reset').click(function(){
     
       $('#filter_driverId').val('');
        $('#filter_driverId_input').val('');
        $('#filter_journal_date').val('');
        $('#filter_amount').val('');
        $('#filter_note').val('');
        $('#filter_created_at').val('');
        $('#filter_updated_at').val('');
       

        $('#customer_data').DataTable().destroy();
        fill_datatable();
    });


});

function driver_window(){
  myWindow1 = window.open( "{{URL("/DriverWindow")}}", "",
                          "height=650,width=900,scrollbars=yes,top=1,left=1,status,resizable" );
}
function driver(id){
  document.getElementById('response').innerHTML=loader;
  document.getElementById('edit_modal').style.display='block';
  $.ajax({
        type: 'GET',
         url: "{{URL("/Drivers")}}"+"/"+id,
         contentType: "html",
         dataType : 'html',
         success: function (data) {
         
         document.getElementById('response').innerHTML=data;
        
        }
    });
}

function add(){
  document.getElementById('response').innerHTML=loader;
  document.getElementById('edit_modal').style.display='block';
  $.ajax({
        type: 'GET',
         url: "{{URL("/Deductions/create")}}",
         contentType: "html",
         dataType : 'html',
         success: function (data) {
        
         document.getElementById('response').innerHTML=data;
var g = document.createElement('script');
var s = document.getElementsByTagName('script')[0];
//g.text = "alert(\"hi\");"
g.text = "$('#journal_date').datepicker({"+
      "format: 'dd/mm/yyyy',"+ 
      "autoclose: true,"+
      "autoHide: true,"+
        "zIndex: 9999,"+
"});"
s.parentNode.insertBefore(g, s);  

         }
    });
}
</script>

@endsection


 

