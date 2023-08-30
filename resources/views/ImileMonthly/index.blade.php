@extends('AdminLTE')
@section('title', 'Update Salary & Shipment')
@section('content')

<style>
    .w3-table-all td, th { 
        text-align: center;
        border-left:none;
        border-right: none;
        
    }
    .descTd td{
        border: 1px solid;
        padding: 3px;
    }
    .descTh th{
        background-color: #ffdb00;
        text-align: left;
        border: 1px solid black;
        border: 1px solid;
        padding: 3px;
    }
    th,td{
        padding: 6px;
    }
</style>

<div class="container" style="width:90%"> 
    <h5>Update Companies invoice To the system </h5>
    <p>Here you can (Update,Review,and migrate) DA'S Dayload Recoreds</p>
    <!--<h4 style="direction: rtl;margin: 0;">تصدير الفواتير للنظام </h4>-->
    <table style="direction: ltr; width: 90%;background-color: white;">
        <tr>
           <th colspan="3" style="text-align: right;">  </th>
        </tr>
        <form action="{{url('i-mile/preview')}}" method="post"   enctype="multipart/form-data">
            @csrf
            <tr>
                <td colspan="2" style="padding: 7px;">
                    <br>
                    <label><span>1-</span> Select File To upload</label><br>
                    <div class="input-group date" style="max-width: 212px;float: left;" >
                        
                      <input style="float: left;" type="file" name="csv" required id="" accept=".csv">
                        <small>Allowded extensions is :<span style="color: red; margin: 2px;">CSV</span></small>
                         
                         
                       </div>
                    </div>
                   
                </td>
                <td colspan="2">
                    <label><span>2-</span> Journal Date</label><br>
                    <div class="input-group date" style="max-width: 212px;float: left;" data-provide="datepicker">
                        
                       <input type="text" class="form-control" name="journal_date" required>
                       <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                       </div> 
                    </div>
                    
                </td>
                
            </tr>
             <tr>
                <td colspan="2" style="padding: 7px;">
                    <br>
                    <label><span>3-</span>Link Method </label><br>
                    <div class="form-check" style="margin-top: 13px;">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" checked name="optradio"><span style="margin-left: 9px;">LINK BY (AMP or JOB_ID)</span>
                        <input type="radio" class="form-check-input" disabled name="optradio" style="margin-left: 10px;"><span style="margin-left: 9px;">LINK BY (DA name & Warehouse_id)</span>
                      </label>
                    </div>
                    <!--<div class="input-group date" style="max-width: 212px;float: left;" >-->
                    <!--    <input type="radiobutton"/>By AMP_ID,JOB_ID-->
                    <!--    <input type="radiobutton"/>By DA Name & Warehose_id-->
                    <!--    <small>Link DA in Report with BTC DATABASE<span style="color: red; margin: 2px;"></span></small>-->
                         
                         
                    <!--   </div>-->
                    </div>
                   
                </td>
               
               
            </tr>
            
            <tr> 
               <td  colspan="5"> <input class="btn btn-success" style="float:right" type="submit" value="Preview"></td>
            </tr>
        </form>

    </table>
    <table style="width: 90%;">
        <tr>
                <td colspan="5" style="padding: 9px;">
                      
                     <div>
                        <p style="margin: 0; margin-top: 12px; float: left;">You can download The formated Excel File The Following Links As(<a href="{{asset('storage/docsFormat/imileExcelFormat.xlsm')}}">XLSX</a>,<a href="{{asset('storage/docsFormat/ImileInvoiceFormat.csv')}}">CSV</a>)</p> 
                         <p style="margin: 0; margin-top: 12px; float: right;direction:rtl"> يمكن تحميل ملف الاكسل بالترتيب المطلوب من الروابط التالية(<a href="{{asset('storage/docsFormat/imileExcelFormat.xlsm')}}">XLSX</a>,<a href="{{asset('storage/docsFormat/ImileInvoiceFormat.csv')}}">CSV</a>) </p>
                          
                    </div>
                     
                </td>
            </tr> 
    </table>
    <table style="width: 90%;">
                <tr>
            <tr>
                <th colspan="5" style="text-align: left;color:red"> 
                    <p style="width: 50%; float: left;">Data Sequence should be like following</p>
                    <p style="direction: rtl; float: right;">ترتيب البيانات يجب ان يكون على النحو التالي : </p>
                
                </th>
            </tr> 
            <tr>
                <th colspan="5"  class="table-cell-package" style="background-color:#ffb6004d; ">
                    <!--<img src="{{asset('storage/images/inileExample.JPG')}}" width="100%" height="65">-->
                    <p style="direction: ltr;">HUB Name <span style="color:red">*</span> | APM <span style="color:red">*</span> | Name <span style="color:red">*</span> | Total Number Of TP <span style="color:red">*</span> | Number of days <span style="color:red">*</span> | driver Type <span style="color:red">*</span> | Rate (optional) | Net Salary <span style="color:red">*</span></p>
                    
                </th>
            </tr>
            <td colspan="5">
            <tr>
                <td>
                     <label>Data Description </label>  
                </td> 
            </tr>
            <tr class="descTh">
                 <th>Parameter Or Cell Name</th>
                 <th>Desc</th>
                 <th>Data Type</th>
                 <th>Constant </th>
                 <th> Note </th>
             </tr>
            <tr class="descTd">
                 <td>HUB NAME</td>
                 <td>Warehose Name from <a href="{{url('Warehouses')}}">Here  </a></td>
                 <td>TEXT</td>
                 <td>Mandatory</td>
                 <td>Ex: Riyadh station</td>
            </tr>
            <tr class="descTd">
                 <td>APM</td>
                 <td>Driver identifier (ID,APM)</td>
                 <td>TEXT</td>
                 <td>Mandatory</td>
                 <td>Ex: D2101234</td>
            </tr>
            <tr class="descTd">
                 <td>NAME</td>
                 <td>Driver Full name</td>
                 <td>TEXT</td>
                 <td>Mandatory</td>
                 <td>Ex: Mohammed Ali</td>
            </tr>
            <tr class="descTd">
                 <td>Total Number Of TP</td>
                 <td>Total deliverd Shipments</td>
                 <td>NUMBER</td>
                 <td>Mandatory</td>
                 <td>Case no No_Of_TP Enter 1</td>
            </tr>
            <tr class="descTd">
                 <td>Number of days</td>
                 <td>Total daily attendance</td>
                 <td>NUMBER</td>
                 <td>Mandatory</td>
                 <td>Case no attendance Enter 1</td>
            </tr>
            <tr class="descTd">
                <td>Driver Type</td>
                <td>Driver Contract Type</td>
                <td>TEXT</td>
                <td>Mandatory</td>
                <td>Ex: (salary,per shipment)</td>
            </tr>
            <tr class="descTd">
                 <td>Net Salary</td>
                 <td>The Net amount salary </td>
                 <td>NUMBER</td>
                 <td>Mandatory</td>
                 <td>Ex: 100.00</td>
            </tr>  
        </tr>
    </table>
</div>

 

@endsection