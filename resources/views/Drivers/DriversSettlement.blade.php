<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Bander</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/bootstrap.min.css")}}">

    <!-- Font Awesome -->
<!--<link rel="stylesheet" href="{{asset("/AdminLTE/font-awesome/font-awesome.min.css")}}">-->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/font-awesome.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/ionicons.min.css")}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/plugins/iCheck/all.css")}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.css")}}">
    <!-- Theme style -->

    <link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/_all-skins.min.css")}}">
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/dataTables.bootstrap.min.css")}}">
    <!--<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
    <link rel="stylesheet" href="{{asset("/AdminLTE/css/customize.css")}}">

</head>
<body style="margin:30PX;padding:0" dir="rtl">

<style>

    .show_table th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
        font-size: 12px !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
        font-size: 12px !important;
    }
</style>
@include('pages.messages_jahiz')
<?php
if ($Driver->driver_type_id <> 2 && $Driver->driver_type_id <> 3) {
    echo '<table  border="0" width="100%" align="center">
     <tr><td style="font-family: Arial;font-size: 26px; font-weight: bold;" align="center">
     الرجاء تعديل نوع المندوب
     </td></tr>
    </table>';
    exit;
}
?>
<center>
    <div style="margin-top: 2px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;"><font color="blue">Jahiz
                - {{$Driver->warehouseName}} - {{$Driver->job_id}}</font></h2>
    </div>
    <div style="margin-top: 2px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}}</h2>
    </div>
    <div style="margin-top: 2px;width:100%;"><h2
            style="width:100%;font-size: 14px;font-weight: bold;">
            نوع المندوب :
            <?php
            if ($Driver->driver_type_id == 2) echo "شهري";
            elseif ($Driver->driver_type_id == 3) echo "عمولة";
            ?>
        </h2>
    </div>
</center>
<br>
<?php
if ($jahiz_clearing_id == "0") $action = "DriversSettlementSave"; else  $action = "DriversSettlementUpdate";
?>
<form method="POST" onsubmit="return validateForm()" action="{{ URL('/'.$action)}}">
    @csrf

    <table class="table m-0 show_table" style="width:auto!important;">
        <input type="hidden" name="driverId" id="driverId" value="{{$Driver->id}}">
        <input type="hidden" name="driver_type_id" value="{{$Driver->driver_type_id}}">
        <input type="hidden" name="clearing_type_id" id="clearing_type_id">
        @if ($jahiz_clearing_id<>"0")
            <input type="hidden" name="jahiz_clearing_id" value="{{$jahiz_clearing_id}}">
        @endif

        <tr>
            <TH>المبلغ المسجل في جاهز</TH>
            <td style="padding: 0.0rem 0.0rem !important;">
                <input type="text" class="form-control" style="width: 100px;display: inline;!important;"
                       name="Jahiz_Amount"
                       value="@if ($jahiz_clearing_id<>"0"){{$drivers_jahiz_clearing->Jahiz_Amount}} @endif"
                       id="Jahiz_Amount" oninput="calculate()">
                &nbsp;&nbsp;

                موجب
                <label>
                    <input type="radio" value="1" name="Jahiz_Amount_Sign" class="flat-red"
                    @if ($jahiz_clearing_id=="0"){{" checked "}} @endif
                    @if ($jahiz_clearing_id<>"0" &&$drivers_jahiz_clearing->Jahiz_Amount_Sign=="1"){{" checked "}} @endif
                    >
                </label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                سالب
                <label>
                    <input type="radio" value="2" name="Jahiz_Amount_Sign" class="flat-red"
                    @if ($jahiz_clearing_id<>"0" &&$drivers_jahiz_clearing->Jahiz_Amount_Sign=="2"){{" checked "}} @endif>
                </label>
            </td>
            <td>

            </td>
        </tr>
        <!---------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------->
        <tr>
            <td style="padding: 1.5rem 0.0rem !important;" colspan="2"></td>
        </tr>
        <tr>
            <TH>عمولة الشركة (بندر)</TH>

            <td style="font-size: 16px !important;font-weight: bold" id="td_Bander_Commission">
                @if ($jahiz_clearing_id<>"0" && $Driver->driver_type_id==2){{$drivers_jahiz_clearing->Bander_Commission}} @endif
                @if($Driver->driver_type_id==3)
                    <input type="text" class="form-control" style="width: 100px;" name="Bander_Commission"
                           id="Bander_Commission" oninput="calculate()"
                           value="@if ($jahiz_clearing_id<>"0" ){{$drivers_jahiz_clearing->Bander_Commission}} @endif">
                @endif
            </td>

        </tr>


        <tr>
            <td></td>
            <td colspan="2" style="padding-top: 20px!important;">
                @if($Driver->driver_type_id==2)
                    <input type="hidden" name="Bander_Commission" id="Bander_Commission" value="0">
                    <input type="hidden" name="rownum" id="rownum" value="0">
                    <b>
                        الشهر
                        :
                    </b>
                    <select name="jahiz_period_id" id="jahiz_period_id"
                            class="form-control" style="width:120px;display: inline;!important;">
                        <option value=""></option>
                        @foreach($lkp_jahiz_period as $lkp_jahiz_periodd)
                            <option value="{{$lkp_jahiz_periodd->id}}"> {{$lkp_jahiz_periodd->ym}}</option>
                        @endforeach
                    </select>
                    &nbsp;
                    &nbsp;



                    <a href="javascript:addRow('dataTable');" class="btn btn-sm btn-info "
                       style="font-size: 12px;font-family: 'Segoe UI' !important;font-weight: bold">
                        اضافة شهر
                        <i class="fa fa-plus"></i> </a>


            </td>

            <style>
                #dataTable {
                    border-collapse: collapse !important;
                }

                .dataTable th {
                    border: #1c2529 solid 0.5px !important;
                    margin: 0 !important;
                    font-size: 12px;
                    font-weight: bold;
                    text-align: center;
                    padding: 0.4rem 0.2rem !important;
                    vertical-align: middle !important;
                }

                .dataTable td {
                    border: #1c2529 solid 0.5px !important;
                    font-size: 10px;
                    padding: 0.4rem 0.2rem !important;
                    vertical-align: middle !important;
                    text-align: center !important;
                }

                .TB_amount_by_days td {
                    border: #1c2529 solid 0.5px !important;
                    font-size: 10px;
                    padding: 0.0rem 0.1rem !important;
                    vertical-align: middle !important;
                    text-align: center !important;
                }
            </style>
        <tr>
            <td></td>
            <td>
                <TABLE id="dataTable" class="table table-striped dataTable" style="width: 550px" dir="rtl">
                    <TR>
                        <th>حذف</th>
                        <th>الشهر</th>
                        <th style="background-color: #B1F1F0">الاسبوع(1)
                            <br>
                            40 ريال
                        </th>
                        <th style="background-color: #B1F1F0">الاسبوع(2)
                            <br>
                            40 ريال
                        </th>
                        <th style="background-color: #B1F1F0">الاسبوع(3)
                            <br>
                            35 ريال
                        </th>
                        <th style="background-color: #B1F1F0">الاسبوع(4)
                            <br>
                            35 ريال
                        </th>

                        <th style="background-color: #56E0DA">كل العمولة
                            <br>
                            150 ريال
                        </th>
                        <th style="background-color: #CD9BFF">المبلغ بالايام</th>

                    </TR>
                    @if ($jahiz_clearing_id<>"0")
                        <?php $rownum = 0;?>
                        @foreach($drivers_jahiz_montly as $drivers_jahiz_montlyy)
                            <?php $rownum++;?>
                            <tr>
                                <td><input type="button" name="button{{$rownum}}"
                                           class="btnaction btn menu-icon vd_bd-red vd_red delete"
                                           value="حذف" onclick="removeRow('button{{$rownum}}');"></td>
                                <td>
                                    <input type='hidden' name='ID_{{$rownum}}'
                                           id='ID_{{$rownum}}'
                                           value='{{$drivers_jahiz_montlyy->id}}'>
                                    <input type='hidden' name='jahiz_period_id_{{$rownum}}'
                                           id='jahiz_period_id_{{$rownum}}'
                                           value='{{$drivers_jahiz_montlyy->jahiz_period_id}}'>
                                    <b><font color='red'>{{$drivers_jahiz_montlyy->ym}}</font></b>
                                </td>
                                <td>
                                    @if ($drivers_jahiz_montlyy->week1_clearing_id==$jahiz_clearing_id)
                                        <input type='checkbox' name='week1_{{$rownum}}' id='week1_{{$rownum}}'
                                               value="40"
                                               onchange="Monthly_Commission();" class="icheckbox_flat-green" checked>
                                    @elseif($drivers_jahiz_montlyy->week1_clearing_id=="")
                                        <input type='checkbox' name='week1_{{$rownum}}' id='week1_{{$rownum}}'
                                               value="40" onchange="Monthly_Commission();" class="icheckbox_flat-green">
                                    @else {{$drivers_jahiz_montlyy->week1_dt}}
                                    @endif

                                </td>
                                <td>
                                    @if ($drivers_jahiz_montlyy->week2_clearing_id==$jahiz_clearing_id)
                                        <input type='checkbox' name='week2_{{$rownum}}' id='week2_{{$rownum}}'
                                               value="40" onchange="Monthly_Commission();" class="icheckbox_flat-green"
                                               checked>
                                    @elseif($drivers_jahiz_montlyy->week2_clearing_id=="")
                                        <input type='checkbox' name='week2_{{$rownum}}' id='week2_{{$rownum}}'
                                               value="40" onchange="Monthly_Commission();" class="icheckbox_flat-green">
                                    @else {{$drivers_jahiz_montlyy->week2_dt}}
                                    @endif

                                </td>
                                <td>
                                    @if ($drivers_jahiz_montlyy->week3_clearing_id==$jahiz_clearing_id)
                                        <input type='checkbox' name='week3_{{$rownum}}' id='week3_{{$rownum}}'
                                               value="35" onchange="Monthly_Commission();" class="icheckbox_flat-green"
                                               checked>
                                    @elseif($drivers_jahiz_montlyy->week3_clearing_id=="")
                                        <input type='checkbox' name='week3_{{$rownum}}' id='week3_{{$rownum}}'
                                               value="35" onchange="Monthly_Commission();" class="icheckbox_flat-green">
                                    @else {{$drivers_jahiz_montlyy->week3_dt}}
                                    @endif

                                </td>
                                <td>
                                    @if ($drivers_jahiz_montlyy->week4_clearing_id==$jahiz_clearing_id)
                                        <input type='checkbox' name='week4_{{$rownum}}' id='week4_{{$rownum}}'
                                               value="35" onchange="Monthly_Commission();" class="icheckbox_flat-green"
                                               checked>
                                    @elseif($drivers_jahiz_montlyy->week4_clearing_id=="")
                                        <input type='checkbox' name='week4_{{$rownum}}' id='week4_{{$rownum}}'
                                               value="35" onchange="Monthly_Commission();" class="icheckbox_flat-green">
                                    @else {{$drivers_jahiz_montlyy->week4_dt}}
                                    @endif

                                </td>
                                <td>
                                    @if ($drivers_jahiz_montlyy->weekAll_clearing_id==$jahiz_clearing_id)
                                        <input type='checkbox' name='weekAll_{{$rownum}}' id='weekAll_{{$rownum}}'
                                               value="150" onchange="Monthly_Commission();" class="icheckbox_flat-green"
                                               checked>
                                    @elseif($drivers_jahiz_montlyy->weekAll_clearing_id=="")
                                        <input type='checkbox' name='weekAll_{{$rownum}}' id='weekAll_{{$rownum}}'
                                               value="150" onchange="Monthly_Commission();"
                                               class="icheckbox_flat-green">
                                    @else {{$drivers_jahiz_montlyy->weekAll_dt}}
                                    @endif

                                </td>
                                <td>
                                    @if ($drivers_jahiz_montlyy->amount_by_days_clearing_id==$jahiz_clearing_id)
                                        <input type='text' name='amount_by_days_{{$rownum}}'
                                               id='amount_by_days_{{$rownum}}'
                                               value="{{$drivers_jahiz_montlyy->amount_by_days_amount}}"
                                               oninput="Monthly_Commission();" class="form-control"
                                               style="width: 50px;text-align: center;display: inline">
                                    @elseif($drivers_jahiz_montlyy->amount_by_days_clearing_id=="")
                                        <input type='text' name='amount_by_days_{{$rownum}}'
                                               id='amount_by_days_{{$rownum}}'
                                               value="{{$drivers_jahiz_montlyy->amount_by_days_amount}}"
                                               oninput="Monthly_Commission();" class="form-control"
                                               style="width: 50px;text-align: center;display: inline">
                                    @else
                                        <table class='TB_amount_by_days' align='center'>
                                            <tr>
                                                <td><b>{{$drivers_jahiz_montlyy->amount_by_days_amount}}</b></td>
                                            </tr>
                                            <tr>
                                                <td>{{$drivers_jahiz_montlyy->amount_by_days_dt}}</td>
                                            </tr>
                                        </table>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        <script>
                            document.getElementById('rownum').value = "{{$rownum}}";
                        </script>
                    @endif
                </TABLE>
                @endif
            </td>
        </tr>

        <!---------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------->
        <tr>
            <td></td>
            <td style="padding: 1.5rem 0.0rem !important;text-align: center;font-size: 16px !important;font-weight: bold"
                id="Status"></td>
        </tr>
        <tr>
            <TH>المبلغ استلام/تسليم للمندوب</TH>
            <td style="padding: 0.0rem 0.0rem !important;">
                تحويل بنك

                <img src="{{asset("/AdminLTE/img/visa.png")}}"
                     style="width: 45px;height: 35px;margin-bottom: 0px!important;">
                <input type="text" class="form-control" style="width: 70px;display: inline;!important;" name="bank"
                       id="bank"
                       value="@if ($jahiz_clearing_id<>"0"){{$drivers_jahiz_clearing->bank}} @endif">
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label style="font-weight: normal!important;" id="cash_label">كاش</label>

                <img src="{{asset("/AdminLTE/img/cash.jpg")}}"
                     style="width: 45px;height: 30px;margin-bottom: 0px!important;" id="cash_img">
                <input type="text" class="form-control" style="width: 70px;display: inline;!important;" name="cash"
                       id="cash"
                       value="@if ($jahiz_clearing_id<>"0"){{$drivers_jahiz_clearing->cash}} @endif">
                @if (Auth::user()->user_type_id == 1)
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label style="font-weight: normal!important;" id="ATM_label">ATM</label>

                    <img src="{{asset("/AdminLTE/img/ATM.jpg")}}"
                         style="width: 45px;height: 30px;margin-bottom: 0px!important;" id="ATM_img">
                    <input type="text" class="form-control" style="width: 70px;display: inline;!important;" name="ATM"
                           id="ATM"
                           value="@if ($jahiz_clearing_id<>"0"){{$drivers_jahiz_clearing->ATM}} @endif">
                @endif
            </td>

        </tr>


        <tr>
            <td colspan="2"><br><br></td>
        </tr>


        <!---------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------->
    </table>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">
            @if ($jahiz_clearing_id<>"0"){{"تعديل"}} @endif
            @if ($jahiz_clearing_id=="0"){{"اضافة"}} @endif

            التصفية
        </button>
    </div>
    <input type="hidden" name="last_amount" id="last_amount" value="0">

    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button
            onclick="window.close();"
            type="button" class="w3-btn w3-red">Cancel
        </button>
    </div>
</form>
<script>


    $(function () {
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        })
    });

    function validateForm() {
        //alert(Number.isInteger(parseFloat($('#Jahiz_Amount').val())));
        //alert($.isNumeric($('#Jahiz_Amount').val()));
        //var txt=$('input:text[name=DrugDurationLength]').val();
        //alert($('input:radio[name=Jahiz_Amount_Sign]:checked').val());
        if ($('#Jahiz_Amount').val() === '' || !$.isNumeric($('#Jahiz_Amount').val()) || parseFloat($('#Jahiz_Amount').val()) < 0) {
            alert('ادخل : المبلغ المسجل في جاهز');
            return false;
        }

        if (!$('input:radio[name=Jahiz_Amount_Sign]:checked').val()) {
            alert('اختار : موجب/سالب للمبلغ المسجل في جاهز');
            return false;
        }

        @if($Driver->driver_type_id==3)
        if ($('#Bander_Commission').val() === '' || !$.isNumeric($('#Bander_Commission').val())  || parseFloat($('#Bander_Commission').val()) < 0) {
            alert('ادخل : عمولة الشركة (بندر)');
            return false;
        }
        @endif

        @if($Driver->driver_type_id==2)
        //if (!$('input:checkbox[name=week1]:checked').val() && !$('input:checkbox[name=week2]:checked').val() && !$('input:checkbox[name=week3]:checked').val() && !$('input:checkbox[name=week4]:checked').val() && !$('input:checkbox[name=weekAll]:checked').val()) {
        //    alert('اختار : عمولة الشركة (بندر)');
        //    return false;
        //}
            @endif

            @if($Driver->driver_type_id==2)
        for (i = 1; i <= rownum; i++) {
            if (document.getElementById('jahiz_period_id_' + i)) {
                if ((!document.getElementById('weekAll_' + i) || $('input:checkbox[name="weekAll_' + i + '"]:checked').val()) && ((!document.getElementById('week1_' + i) || $('input:checkbox[name="week1_' + i + '"]:checked').val()) || (!document.getElementById('week2_' + i) || $('input:checkbox[name="week2_' + i + '"]:checked').val()) || (!document.getElementById('week3_' + i) || $('input:checkbox[name="week3_' + i + '"]:checked').val()) || (!document.getElementById('week4_' + i) || $('input:checkbox[name="week4_' + i + '"]:checked').val()))) {
                    alert('خطا : لقد اخترت كل العمولة مع الاقساط');
                    return false;
                }

                //if ((!document.getElementById('amount_by_days_' + i) || document.getElementById('amount_by_days_' + i).value != '') && ((!document.getElementById('week1_' + i) || $('input:checkbox[name="week1_' + i + '"]:checked').val()) || (!document.getElementById('week2_' + i) || $('input:checkbox[name="week2_' + i + '"]:checked').val()) || (!document.getElementById('week3_' + i) || $('input:checkbox[name="week3_' + i + '"]:checked').val()) || (!document.getElementById('week4_' + i) || $('input:checkbox[name="week4_' + i + '"]:checked').val()) || (!document.getElementById('weekAll_' + i) || $('input:checkbox[name="weekAll_' + i + '"]:checked').val()))) {
                //    alert('خطا : لقد اخترت الاقساط مع المبلغ بالايام');
               //     return false;
              //  }

                if ((document.getElementById('amount_by_days_' + i) && document.getElementById('amount_by_days_' + i).value != '') && (!$.isNumeric(document.getElementById('amount_by_days_' + i).value) || !Number.isInteger(parseFloat(document.getElementById('amount_by_days_' + i).value)) || parseFloat(document.getElementById('amount_by_days_' + i).value) < 0)) {
                    alert('خطا : ادخل المبلغ بالايام بصورة صحيحة');
                    return false;
                }

                if (document.getElementById('amount_by_days_' + i) && parseFloat(document.getElementById('amount_by_days_' + i).value) > 150) {
                    alert('خطا : المبلغ بالايام اكبر من 150');
                    return false;
                }
            }

        }
            @endif

            @if($Driver->driver_type_id==2)
        //for (r = 1; r <= rownum; r++) {
       //     if (document.getElementById('jahiz_period_id_' + r)) {
        //        if (document.getElementById('weekAll_' + r) && !$('input:checkbox[name="weekAll_' + r + '"]:checked').val()) {
        //            for (i = 4; 0 < i; i--) {
        //                if (document.getElementById('week' + i + '_' + r) && document.getElementById('week' + i + '_' + r).checked) {
         //                   for (k = i - 1; 0 < k; k--) {
          //                      if (document.getElementById('week' + k + '_' + r) && !document.getElementById('week' + k + '_' + r).checked) {
          //                          alert(' : لم تقم باختيار القسط رقم : ' + k);
          //                          return false;
          //                      }
          //                  }
            //            }

         //           }
         //       }
        //    }
      //  }

        @endif

        if ($('#bank').val() != '' && (!$.isNumeric($('#bank').val()) || parseFloat($('#bank').val()) < 0)) {
            alert('ادخل : مبلغ التحويل بصورة صحيحة');
            return false;
        }
        if ($('#cash').val() != '' && (!$.isNumeric($('#cash').val()) || parseFloat($('#cash').val()) < 0)) {
            alert('ادخل : مبلغ الكاش بصورة صحيحة');
            return false;
        }
        @if (Auth::user()->user_type_id == 1)
        if ($('#ATM').val() != '' && (!$.isNumeric($('#ATM').val()) || parseFloat($('#ATM').val()) < 0)) {
            alert('ادخل : مبلغ ATM بصورة صحيحة');
            return false;
        }
        @endif

            bank_cash = 0;
        if (document.getElementById('cash') && document.getElementById('cash').value != '' && $.isNumeric($('#cash').val()))
            bank_cash = Number(parseFloat(document.getElementById('cash').value).toFixed(2));
        if (document.getElementById('bank') && document.getElementById('bank').value != '' && $.isNumeric($('#bank').val()))
            bank_cash += Number(parseFloat(document.getElementById('bank').value).toFixed(2));
        @if (Auth::user()->user_type_id == 1)

        if (document.getElementById('ATM') && document.getElementById('ATM').value != '' && $.isNumeric($('#ATM').val()))
            bank_cash += Number(parseFloat(document.getElementById('ATM').value).toFixed(2));
        @endif
            bank_cash = bank_cash.toFixed(2);
        //alert('bank_cash=' + bank_cash);
        //alert('last_amount=' + document.getElementById('last_amount').value);
//alert(document.getElementById('clearing_type_id').value);
        if (Number(bank_cash) !== Number(parseFloat(document.getElementById('last_amount').value).toFixed(2))) {
            alert('المبلغ المسجل في جاهز + العمولة لايساوي السداد');
            return false;
        }
//return false;

        return true;

    }

    //---------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------
    function calculate() {
//alert('calculate');
        document.getElementById('Status').innerHTML = '';
        document.getElementById('last_amount').value = '0';
        document.getElementById('bank').value = '';
        document.getElementById('cash').value = '';
        @if (Auth::user()->user_type_id == 1)
        document.getElementById('ATM').value = '';
        @endif
        if ($('#Jahiz_Amount').val() !== '' && $.isNumeric($('#Jahiz_Amount').val()) && $('input:radio[name=Jahiz_Amount_Sign]:checked').val()) {

            Sign = 0;
            //alert($('input:radio[name=Jahiz_Amount_Sign]:checked').val());
            if ($('input:radio[name=Jahiz_Amount_Sign]:checked').val() == 1) Sign = 1;
            else if ($('input:radio[name=Jahiz_Amount_Sign]:checked').val() == 2) Sign = -1;

            Bander_Commission = 0;
            if ($('#Bander_Commission').val() != '')
                Bander_Commission = parseFloat($('#Bander_Commission').val());
            //alert(Bander_Commission);

            amount = ((Sign * parseFloat($('#Jahiz_Amount').val())) + Bander_Commission).toFixed(2);
            //alert(amount);
            if (amount > 0) {

                document.getElementById('Status').style.color = "green";
                document.getElementById('Status').innerHTML = 'استلام من المندوب : ' + amount;
                document.getElementById('cash_label').style.display = 'initial';
                document.getElementById('cash_img').style.display = 'initial';
                document.getElementById('cash').value = '';
                document.getElementById('cash').style.display = 'initial';
                @if (Auth::user()->user_type_id == 1)
                document.getElementById('ATM_label').style.display = 'initial';
                document.getElementById('ATM_img').style.display = 'initial';
                document.getElementById('ATM').value = '';
                document.getElementById('ATM').style.display = 'initial';
                @endif
                document.getElementById('bank').value = '';
                document.getElementById('last_amount').value = amount;
                document.getElementById('clearing_type_id').value = '1';
            } else if (amount < 0) {
                document.getElementById('Status').style.color = "red";
                amount = amount * -1;
                document.getElementById('Status').innerHTML = 'تسليم للمندوب : ' + amount;
                @if ($Driver->warehouseId == 201 || $Driver->warehouseId == 220||$Driver->warehouseId == 221)
                document.getElementById('cash_label').style.display = 'none';
                document.getElementById('cash_img').style.display = 'none';
                document.getElementById('cash').value = '';
                document.getElementById('cash').style.display = 'none';
                document.getElementById('bank').value = amount;


                @else
                document.getElementById('cash_label').style.display = 'initial';
                document.getElementById('cash_img').style.display = 'initial';
                document.getElementById('cash').value = '';
                document.getElementById('cash').style.display = 'initial';
                document.getElementById('bank').value = '';

                @endif


                @if (Auth::user()->user_type_id == 1)
                document.getElementById('ATM_label').style.display = 'none';
                document.getElementById('ATM_img').style.display = 'none';
                document.getElementById('ATM').value = '';
                document.getElementById('ATM').style.display = 'none';
                @endif

                document.getElementById('last_amount').value = amount;
                document.getElementById('clearing_type_id').value = '2';

            } else {
                document.getElementById('clearing_type_id').value = '3';
            }
            //document.getElementById('Status').innerHTML=amount;
            //alert('ok');
            //alert(document.getElementById('Status').innerHTML);

        }
    }

    $(document).ready(function () {
        $('input:radio[name="Jahiz_Amount_Sign"]').on('ifChecked ifUnchecked', function (event) {
            calculate();
        });


//$('input:radio').on('ifChecked ifUnchecked', function (event) {
//    alert('Checked');
//});
//$('input:checkbox[name="week1"]').on('ifChecked ifUnchecked', function (event) {
//alert('week1');
//$('input:checkbox[name=week1]').iCheck('check');
//if (document.getElementById('week1').checked)
//alert('checked');
//else
//alert('uncheck');

//$('#week2').prop("disabled", false).iCheck('update');
//$('#weekAll').prop("disabled", true).iCheck('update');

//});


    });


</script>
<SCRIPT language="javascript">
    @if($Driver->driver_type_id==2)
    @if ($jahiz_clearing_id=="0")
    var rownum = 0;
    @else
    var rownum = {{$rownum}};
    @endif
    @endif
    var week1 = "";
    var week2 = "";
    var week3 = "";
    var week4 = "";
    var weekAll = "";

    function addRow(tableID) {
        if (document.getElementById('jahiz_period_id')) {
            if (document.getElementById('jahiz_period_id').value == "") {
                alert('الرجاء اختيار الشهر');
                return;
            }
        }
        //-------------------------------------------------------------------------------------------
        for (i = 1; i <= rownum; i++) {
            if (document.getElementById('jahiz_period_id_' + i) && document.getElementById('jahiz_period_id') && document.getElementById('jahiz_period_id_' + i).value == document.getElementById('jahiz_period_id').value) {
                alert('الشهر موجود');
                return;
            }
        }
        //-------------------------------------------------------------------------------------------
        //alert(document.getElementById('jahiz_period_id').value);

        $.getJSON("{{URL("/getDriversJahizMontly")}}" + "/" + document.getElementById('driverId').value + "/" + document.getElementById('jahiz_period_id').value, function (json) {

            $.each(json, function (i, obj) {
                // $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                week1 = obj.week1_dt;
                week2 = obj.week2_dt;
                week3 = obj.week3_dt;
                week4 = obj.week4_dt;
                weekAll = obj.weekAll_dt;
                amount_by_days_dt = obj.amount_by_days_dt;
                amount_by_days = obj.amount_by_days;
                //alert(obj.week1_dt);
            });
            //-------------------------------------------------------------------------------------------------------------------
            rownum++;
            document.getElementById('rownum').value = rownum;

            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            //Column 1
            var cell1 = row.insertCell(0);
            var element1 = document.createElement("input");
            element1.type = "button";
            var btnName = "button" + (rownum);
            element1.name = btnName;
            element1.className = "btnaction btn menu-icon vd_bd-red vd_red delete";
            element1.setAttribute('value', 'حذف'); // or element1.value = "button";
            element1.onclick = function () {
                removeRow(btnName);
            }
            cell1.appendChild(element1);
            //Column 2  ****************************************************************************************************
            var cell2 = row.insertCell(1);
            cell2.innerHTML = " <input type='hidden' name='jahiz_period_id_" + rownum + "' id='jahiz_period_id_" + rownum + "' value='" + document.getElementById('jahiz_period_id').value + "'>"
                + "<b><font color='red'>" + $("#jahiz_period_id option:selected").text() + "</font></b>";


            //Column 3 ****************************************************************************************************
            var cell3 = row.insertCell(2);
            //alert(week1);
            if (week1 == null) {
                var element3 = document.createElement("input");
                element3.type = "checkbox";
                element3.name = "week1_" + (rownum);
                element3.id = "week1_" + (rownum);
                element3.value = "40";
                element3.className = "icheckbox_flat-green";
                element3.onchange = function () {
                    Monthly_Commission();
                }
                cell3.appendChild(element3);

            } else {
                cell3.innerHTML = week1;
            }
            //Column 4 ****************************************************************************************************
            var cell4 = row.insertCell(3);
            //alert(week2);
            if (week2 == null) {
                var element4 = document.createElement("input");
                element4.type = "checkbox";
                element4.name = "week2_" + (rownum);
                element4.id = "week2_" + (rownum);
                element4.value = "40";
                element4.className = "icheckbox_flat-green";
                element4.onchange = function () {
                    Monthly_Commission();
                }
                cell4.appendChild(element4);
            } else {
                cell4.innerHTML = week2;
            }
            //Column 5 ****************************************************************************************************
            var cell5 = row.insertCell(4);
            //alert(week2);
            if (week3 == null) {
                var element5 = document.createElement("input");
                element5.type = "checkbox";
                element5.name = "week3_" + (rownum);
                element5.id = "week3_" + (rownum);
                element5.value = "35";
                element5.className = "icheckbox_flat-green";
                element5.onchange = function () {
                    Monthly_Commission();
                }
                cell5.appendChild(element5);
            } else {
                cell5.innerHTML = week3;
            }
            //Column 6 ****************************************************************************************************
            var cell6 = row.insertCell(5);
            //alert(week2);
            if (week4 == null) {
                var element6 = document.createElement("input");
                element6.type = "checkbox";
                element6.name = "week4_" + (rownum);
                element6.id = "week4_" + (rownum);
                element6.value = "35";
                element6.className = "icheckbox_flat-green";
                element6.onchange = function () {
                    Monthly_Commission();
                }
                cell6.appendChild(element6);
            } else {
                cell6.innerHTML = week4;
            }
            //Column 7 ****************************************************************************************************
            var cell7 = row.insertCell(6);
            //alert(week2);
            if (weekAll == null) {
                var element7 = document.createElement("input");
                element7.type = "checkbox";
                element7.name = "weekAll_" + (rownum);
                element7.id = "weekAll_" + (rownum);
                element7.value = "150";
                element7.className = "icheckbox_flat-green";
                element7.onchange = function () {
                    Monthly_Commission();
                }
                cell7.appendChild(element7);

            } else {
                cell7.innerHTML = weekAll;
            }
            //Column 8 ****************************************************************************************************
            var cell8 = row.insertCell(7);
            //alert(week2);
            if (amount_by_days == null) {
                var element8 = document.createElement("input");
                element8.type = "text";
                element8.name = "amount_by_days_" + (rownum);
                element8.id = "amount_by_days_" + (rownum);
                element8.value = "";
                element8.className = "form-control";
                element8.style.width = "50px";
                element8.style.textAlign = "center";
                element8.style.display = "inline";
                element8.oninput = function () {
                    Monthly_Commission();
                }
                cell8.appendChild(element8);

            } else if (amount_by_days != null) {
                cell8.innerHTML = "<table class ='TB_amount_by_days' align='center'><tr><td><b>" + amount_by_days + "</b></td></tr><tr><td>" + amount_by_days_dt + "</td></tr></table>";
            }
        });
        //-------------------------------------------------------------------------------------------

        //alert(document.getElementById('jahiz_period_id_'+rownum).value);

    }


    function removeRow(btnName) {

        try {
            var table = document.getElementById('dataTable');
            var rowCount = table.rows.length;
            for (var i = 0; i < rowCount; i++) {
                var row = table.rows[i];
                var rowrowObj = row.cells[0].childNodes[0];
                //alert(rowrowObj.name);
                if (rowrowObj.name == btnName) {
                    table.deleteRow(i);

                    rowCount--;
                    Monthly_Commission()
                }
            }
        } catch (e) {
            alert(e);
        }
    }

    function Monthly_Commission() {
        Commission = 0;

        for (r = 1; r <= rownum; r++) {
            for (k = 4; 0 < k; k--) {
                if (document.getElementById('week' + k + '_' + r) && document.getElementById('week' + k + '_' + r).checked) {
                    Commission += parseInt(document.getElementById('week' + k + '_' + r).value);
                }
            }
            if (document.getElementById('weekAll_' + r) && document.getElementById('weekAll_' + r).checked) {
                Commission += parseInt(document.getElementById('weekAll_' + r).value);
            }
            if (document.getElementById('amount_by_days_' + r) && document.getElementById('amount_by_days_' + r).value != '') {
                Commission += parseInt(document.getElementById('amount_by_days_' + r).value);
            }
        }
        document.getElementById('Bander_Commission').value = Commission;
        document.getElementById('td_Bander_Commission').innerHTML = Commission;
        calculate();
    }


    @if ($jahiz_clearing_id<>"0")
    @if($Driver->driver_type_id==2)
    Monthly_Commission();
    @endif
    calculate();
    document.getElementById('bank').value = "{{$drivers_jahiz_clearing->bank}}";
    document.getElementById('cash').value = "{{$drivers_jahiz_clearing->cash}}";
    @if (Auth::user()->user_type_id == 1)
    document.getElementById('ATM').value = "{{$drivers_jahiz_clearing->ATM}}";
    @endif
    @endif

</SCRIPT>
<!-- ./wrapper -->

<!-- jQuery 3 -->

<script src="{{asset("/AdminLTE/js/jquery.min.js")}}"></script>

<script src="{{asset("/AdminLTE/js/select2.full.min.js")}}"></script>
<!-- Bootstrap 3.3.7 -->

<script src="{{asset("/AdminLTE/js/bootstrap.min.js")}}"></script>
<!-- date-range-picker -->
<script src="{{asset("/AdminLTE/moment/min/moment.min.js")}}"></script>
<script src="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.js")}}"></script>

<script src="{{asset("/AdminLTE/js/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/AdminLTE/js/dataTables.bootstrap.min.js")}}"></script>
<!-- FastClick -->
<script src="{{asset("/AdminLTE/js/fastclick.js")}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset("/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("/AdminLTE/js/adminlte.min.js")}}"></script>


