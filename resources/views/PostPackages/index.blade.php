@extends('AdminLTE')
@section('content')

<!-- Content Header (Page header) -->
<div  style="width:100%;margin: 0px; ">
      <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">PostPackages</h2></div>
      
</div>      
<div class="card card-default" style="width:100%;clear:both;"></div>

<!--w3-table-all w3-card-4-->
<!-- table table-bordered table-striped  -->

<form method="POST" action="{{ route('PostPackages.store')}}">
                       @csrf
<!-- SELECT2 EXAMPLE -->
<div class="col-md-3" style="width:100%;clear:both;">
          <div id="card_box" class="box box-primary ">
            <div class="box-header with-border">
              <h3 class="box-title">     <button  class="button_search" ><i class="fa fa-search"></i></button>
             </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box" class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
            
            <table class="table m-0 search_table" style="width:10px!important;">
<tr><TH>PacKages Date </TH>  
<td>
<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
  <input  class="form-control" name="filter_pakage_date" id="filter_pakage_date" type="text"  value="" required>
  <script>
                    $(function() {
                     $('input[name="filter_pakage_date"]').daterangepicker({
                      autoUpdateInput: false,
                      opens: 'left',
                        locale: {
                      cancelLabel: 'Cancel'
                       }
                      });
                     $('input[name="filter_pakage_date"]').on('apply.daterangepicker', function(ev, picker) {
                     $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                     });
                     $('input[name="filter_pakage_date"]').on('cancel.daterangepicker', function(ev, picker) {
                     $(this).val('');
                      });
                     });
                     </script>
                  </div>

  </td>
</tr>
 <tr><TH>CompanyName </TH>   
 <td>                      
<select  name="filter_companyId" id="filter_companyId" onchange="CityName()" class="form-control" style="width:200px;" required>
                   <option value=""></option>
                   @foreach($lkp_company as $lkpcompany) 
                   <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                   @endforeach
                   </select>    
</td></tr>  
 <tr><TH>CityName </TH>  
 <td>  
<select  name="filter_cityId" id="filter_cityId"  onchange="Warehouse()"  class="form-control" >
                 
                   </select>    
</td></tr>
<tr>
 <TH>Warehouse </TH>  
 <td> 
 <select  name="filter_warehouseId" id="filter_warehouseId"    class="form-control" >
                 
                   </select>    

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


<!-- select all boxes -->
<table style="width:100%"><tr><td align=right>
<input class="flat-red" type="checkbox" name="select-all"  id="select-all" >&nbsp;&nbsp;Select All
</td></tr></table>

<div class="table-responsive" style="width: 100%;">
<table id="customer_data" class="table table-bordered table-striped">
<thead>
  
  <TH>CompanyName</TH>
   <TH>CityName</TH>
   <TH>WarehouseName</TH>
   <TH>No Of Deliverd</TH>
   <TH>CostBy No Of Deliverd(SAR)</TH>
   <TH>No Of Touch Point</TH>
   <TH>CostBy No Of Touch Point(SAR)</TH>
   <TH>Day Range</TH>
   <TH>Action</TH>
   <TH>View Driver</TH>
  </thead>
  <tbody>
</tbody>
</table>
<center>
<button type="submit" name="filter"  class="btn btn-sm btn-info" id="filter">Post To Journal</button>
</center>
</form>
</div>

<!---------------------------------------------------------------------------------------------------------------------->
  <!---------------------------------------------------------------------------------------------------------------------->
  
<!---------------------------------------------------------------------------------------------------------------------->
  <!---------------------------------------------------------------------------------------------------------------------->

                      
<script>
$(document).ready(function(){

    fill_datatable();
        
    function fill_datatable(filter_companyId='',filter_cityId='',filter_pakage_date='',filter_warehouseId='')
    {
        var dataTable = $('#customer_data').DataTable({
           //searching: false,
            responsive: true,
            processing: true,
            serverSide: true,
            "order": [[ 5, "desc" ]],
            "pagingType": "full_numbers",
            "autoWidth": false,
           
            "fnDrawCallback": function() {
             $('[data-toggle="tooltip"]').tooltip();
             $(function () {
             $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
             checkboxClass: 'icheckbox_flat-green',
             radioClass   : 'iradio_flat-green'
             });
             

             $('#select-all').on('ifChecked ifUnchecked', function (event) {
              if (document.getElementById('select-all').checked)
              { 
                
              $('.flat-red').iCheck('check')
              }
              else 
              $('.flat-red').iCheck('uncheck');
              });
            }); 
            },
            ajax:{
                url: "{{ route('PostPackages.index') }}",
                data:{
                  filter_companyId:filter_companyId,
                  filter_cityId:filter_cityId,
                  filter_pakage_date:filter_pakage_date,
                  filter_warehouseId:filter_warehouseId,
      
              }
            },

            columns: [

                {
                    data:'companyName',
                    name:'companyName'
                },
                {
                    data:'name_en',
                    name:'name_en'
                },
                {
                    data:'warehouseName',
                    name:'warehouseName',
                    //visible:false
                },
                {
                    data:'no_of_deliverd',
                    render: function(data, type, row, meta) { 
                    if(row.calculation_method_id=="2"&&row.no_of_deliverd) 
                    return row.no_of_deliverd; 
                    else return '';
                  } 
                
                },
                {
                  data:'no_of_deliverd',
                  render: function(data, type, row, meta) { 
                    if(row.calculation_method_id=="2"&&row.no_of_deliverd) 
                    return row.CostBy_no_of_deliverd; 
                    else return '';
                  } 
                  
                },
                {
                  
                  data:'no_of_touch_point',
                     render: function(data, type, row, meta) { 
                     if(row.calculation_method_id=="1"&&row.no_of_touch_point) 
                     return row.no_of_touch_point; 
                     else return '';
                   }
                 },
                 {
                  data:'no_of_touch_point',
                     render: function(data, type, row, meta) { 
                     if(row.calculation_method_id=="1"&&row.no_of_touch_point) 
                     return row.CostBy_no_of_touch_point; 
                     else return '';
                     }
                 },
                {
                  data:'day_count',
                  render: function(data, type, row, meta) { 
                    if(row.calculation_method_id=="1"&&row.no_of_touch_point) 
                    return row.day_count;
                    else if(row.calculation_method_id=="2"&&row.no_of_deliverd) 
                    return row.day_count; 
                    else return '';
                  } 

                },
                 
                {"orderable": false,
                  className: "dt-nowrap",
                  data:'calculation_method_id', 
                  
                    render: function(data, type, row, meta) { 
                    if(data=="1"&&row.no_of_touch_point) 
                    return'<input class="flat-red" name="warehouseId_'+row.id+'" type="checkbox" value="1">'
                    else if(data=="2"&&row.no_of_deliverd) 
                    return'<input class="flat-red" name="warehouseId_'+row.id+'" type="checkbox" value="1">'
                    else return '';
                    }
                          //onclick=\"document.getElementById('row_id').value='"+data+"'\"
                },
                {"orderable": false,
                  className: "dt-nowrap",
                    "targets": -1,
                    //"data": 'id',
                  "render": function (data, type, row, meta) {
                    if(row.no_of_touch_point||row.no_of_deliverd)
                    return'&nbsp;<a href="javascript:drivers('+row.CostBy_no_of_touch_point_html+')" id='+row.id+' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green"> <i class="fa fa-eye"></i> </a>';
                    else
                    return '';
                    }
                          //onclick=\"document.getElementById('row_id').value='"+data+"'\"
                }

            ]
        });
        
        
    }




    
$('#filter').click(function(){
  if($('#filter_companyId').val() !=''&&$('#filter_pakage_date').val() !='')
        {
         
         $('#customer_data').DataTable().destroy();
         fill_datatable($('#filter_companyId').val(),$('#filter_cityId').val(),$('#filter_pakage_date').val(),$('#filter_warehouseId').val());
        }
        else
        {
            if ( $('#filter_pakage_date').val() =='')
            alert('Select pakage_date range');
            else if  ($('#filter_companyId').val() =='')
            alert('Select Company');
        }
    });

    $('#reset').click(function(){
     
        $('#filter_pakage_date').val(''); 
        $('#filter_companyId').val('');
        $('#filter_cityId').empty();
        $('#filter_warehouseId').empty();
      
        

        $('#customer_data').DataTable().destroy();
        fill_datatable();
    });


});

function CityName()
{
  var filter_companyId=document.getElementById('filter_companyId').value;
  if (filter_companyId=="")
  {
  $('#filter_cityId').empty();
  $('#filter_warehouseId').empty();
  }
  else
  {
    $.getJSON("{{URL("/getCityName")}}"+"/"+filter_companyId, function(json){
      $('#filter_cityId').empty();
      $('#filter_warehouseId').empty();
      $('#filter_cityId').append($('<option>').text("Select ....").attr('value', ''));
            $.each(json, function(i, obj){
              $('#filter_cityId').append($('<option>').text(obj.name).attr('value', obj.id));
            });
    });
  }
}
function Warehouse()
{
  var filter_cityId=document.getElementById('filter_cityId').value;
  if (filter_cityId=="")
  $('#filter_warehouseId').empty();
  else
  {
    $.getJSON("{{URL("/getWarehouse")}}"+"/"+filter_cityId, function(json){
      $('#filter_warehouseId').empty();
      $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
            $.each(json, function(i, obj){
              $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
            });
    });
  }
}

function drivers(companyId,warehouseId,date){
  myWindow1 = window.open( "{{URL("/PostPackagesWindow")}}?companyId="+companyId+"&warehouseId="+warehouseId+"&date="+date, "",
                          "height=650,width=900,scrollbars=yes,top=1,left=1,status,resizable" );
}

          
</script>

@endsection


 

