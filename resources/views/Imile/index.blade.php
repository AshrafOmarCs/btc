@extends('AdminLTE')
@section('content')

<style>
    .w3-table-all td, th { 
        text-align: center;
        border-left:none;
        border-right: none;
    }
</style>
<div class="container" style="width:90%">
    <table style="direction: rtl; width: 90%;">
        <tr>
           <th colspan="2" style="text-align: right;">تصدير الفواتير لنظام بندر</th>
           
           <th><img style="max-width: 155px;    float: left;padding: 30px;" src="#" alt="" srcset=""></th>
        </tr>
        <!-- <tr>
            <td colspan="3">
                <ul>
                    <li> الخطوة الاولى : تجهيز ملف الاكسل قبل رفعة لشاشةالعرض, يمكنك الاطلاع على خطوات تجهيز الملف من <a href="#"> هنا  <i class="fa fa-info" aria-hidden="true"></i> </a> . </li>
                    <li>الخطوة الثانية : اختيار تاريخ الرواتب المراد رفعها .</li>
                    <li>الخطوة الثالثة : تحديد الملف من جهاز الكمبيوتر بعد تجهيزة كما هو موضح في الخطوة الاولى.</li>
                    <li>الخطوة الرابعة : الضغط على زر Preview سوف يتم توجيهك لشاشة عرض لتأكد من البيانات للمرة الاخيرة .</li>
                    <li>الخطوة الخامسة : بعد مراجعة البيانات الرجاء الضغط على زر Confirm .</li>
                </ul>
            </td>
        </tr> -->
        <form action="{{url('import_excel/i-mile/preview')}}" method="post"   enctype="multipart/form-data">
            @csrf
        <tr>
            <th>الرجاء اختيار الفاتورة <span style="color:red">*</span> </th>
           <th >
               <div class="input-group date" style="max-width: 212px;margin-top: 35px; float: right;" data-provide="datepicker">
                  <input type="text" class="form-control" name="journal_date" required>
               <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
               </div>
           </th>
          <th></th>
        </tr>
       
        <tr>
        <th colspan="3" style="text-align: left;color:red">Data Sequence should be like following</th>
        </tr>
        <tr>
            <th colspan="3"  class="table-cell-package" >Hub name | APM ID | driver name |Amount</th>
        </tr>
        <tr>
            <th>
                اختيار الملف <span style="color:red">*</span> 
            </th>
            <th colspan="1">
                <input style="float: left;" type="file" name="csv" required id="" accept=".csv">
                <small>Allowded extensions is :csv</small>
            </th>
        </tr>
        <tr>
           <td  colspan="3"> <input class="btn btn-success" style="float:left" type="submit" value="Preview"></td>
        </tr>
        </form>

    </table>

</div>

 

@endsection