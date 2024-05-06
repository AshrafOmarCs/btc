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
    <table style="direction: rtl; width: 100%;">
        <tr>
           <th colspan="2" style="text-align: right;">تصدير فاتورة نون الشهرية لنظام بندر</th>
           
           <th><img style="max-width: 155px;    float: left;padding: 30px;" src="{{asset('images/noonlogo.png')}}" alt="" srcset=""></th>
        </tr>
        <tr>
            <td colspan="3">
                <ul>
                    <li> الخطوة الاولى : تجهيز ملف الاكسل قبل رفعة لشاشةالعرض, يمكنك الاطلاع على خطوات تجهيز الملف من <a href="#"> هنا  <i class="fa fa-info" aria-hidden="true"></i> </a> . </li>
                    <li>الخطوة الثانية : اختيار تاريخ الرواتب المراد رفعها .</li>
                    <li>الخطوة الثالثة : تحديد الملف من جهاز الكمبيوتر بعد تجهيزة كما هو موضح في الخطوة الاولى.</li>
                    <li>الخطوة الرابعة : الضغط على زر Preview سوف يتم توجيهك لشاشة عرض لتأكد من البيانات للمرة الاخيرة .</li>
                    <li>الخطوة الخامسة : بعد مراجعة البيانات الرجاء الضغط على زر Confirm .</li>
                </ul>
            </td>
        </tr>
        <form action="{{url('import_excel/noon/store')}}" method="post"   enctype="multipart/form-data">
                   @csrf
        <tr>
            <th>الرجاء اختيار الفاتورة <span style="color:red">*</span> </th>
           <th >
               <div class="input-group date" style="max-width: 212px;margin-top: 35px;
    float: right;" data-provide="datepicker">
                  <input type="text" class="form-control" name="journal_date" required>
               <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
               </div>
           </th>
          <th></th>
        </tr>
        <tr>
            <th>الرجاْ اختيار الفترة</th>
            <th>
                <select class="btn btn-primary" required name="journal_period">
                <option value="#">الرجاء اختيار فترة من القائمة</option>
                    @foreach($journal_periods as $journal_period)
                       <option value="{{$journal_period->id}}">{{$journal_period->period_from_dt}} - {{$journal_period->period_to_dt}}</option>
                    @endforeach
                </select>
                <button class="btn btn-success">اضافة فترة جديدة</button>
            </th>
            <th>
                
            </th>
        </tr>
        <tr>
        <th colspan="3" style="text-align: left;color:red">Data Sequence should be like following</th>
        </tr>
        <tr>
            <th colspan="3"  class="table-cell-package" >Hub Code | Username | Emp ID |  Driver name | Driver type | Vendor | No of Delivered | No of CIR | Total Delivery/Pickup | No of TouchPoint | Type | Rate Card | Amount | Net-Salart</th>
        </tr>
        <tr>
            <th>
                اختيار الملف <span style="color:red">*</span> 
            </th>
            <th colspan="1">
                <input style="float: left;" type="file" name="csv" required id="" accept=".csv">
                <small>allowded extensionsis :csv</small>
            </th>
        </tr>
        <tr>
           <td  colspan="3"> <input class="btn btn-success" style="float:left" type="submit" value="Preview"></td>
        </tr>
        </form>

    </table>

</div>

 

@endsection