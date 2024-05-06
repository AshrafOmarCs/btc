<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Almashwar</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>
<style>
    body {
        font-family: Arial;
        font-weight: 400;
        overflow-x: hidden;
        overflow-y: auto;
        font-size: 16px !important;
        padding: 0.3rem 2.0rem !important;
    }

    .show_table {
        border-collapse: collapse;
        font-size: 14px !important;
        line-height: 25px;
    }

    .show_table th {
        background-color: #BCBCBC;
        padding: 0.0rem 0.2rem !important;
        white-space: nowrap;
        border: solid 1px #000000 !important;
        margin: 0 !important;
    }

    .show_table td {
        padding: 0.0rem 0.2rem !important;
        border: solid 1px #000000 !important;
        vertical-align: middle !important;
        text-align: center;
        margin: 0 !important;
    }

    .show_footer td {
        font-family: Arial;
        padding: 0.0rem 0.0rem !important;
        vertical-align: middle !important;
        text-align: center;
        margin: 0 !important;
        font-size: 14px !important;
    }
</style>
<table border="0" width="100%" style="height:1010px">
    <tr>
        <td style="vertical-align: top;height: 100px">
            <table border="0" width="100%">
                <tr>
                    <td style="width:40%">
                        <img src="{{asset("/AdminLTE/img/logo3.jpg")}}"
                             style="width:150px;height:154px"></a>
                    </td>
                    <td style="width:60%" align="right" valign="middle">
                        <table dir="rtl">
                            <tr>
                                <td style="font-family: 'Arial';font-size: 24px; font-weight: bold;">
                                    شركة مشوار العاصمة للخدمات اللوجستية
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    سجل تجاري رقم :
                                    1010469177
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    الرقم الضريبي :
                                    310036168300003
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    الايميــــــــــــل :
                                    Info@mashaueer.com
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    الرقم الموحد :
                                    920012252
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table border="0" width="100%">
                <tr>
                    <td style="width:20%;font-family: 'arial';font-size: 20px; font-weight: bold;"
                        align="center"><u>فاتورة ضريبية</u></td>
                </tr>
            </table>
        </td>
    </tr>
    <!------------------------------------------------------------------------------------------------------->
    <!------------------------------------------------------------------------------------------------------->
    <tr>
        <td style="text-align:center;vertical-align: top;background-image: url('{{asset("/AdminLTE/img/report_background2.JPG")}}');
            background-repeat: no-repeat;
            background-position: center center;
            ">
            <br>
            <table border="0" width="100%" dir="rtl">
                <tr>
                    <td style="width:50%" valign="top">
                        <table class="show_table" width="250px">
                            <tr>
                                <th>تاريخ الفاتورة</th>
                                <th>تاريخ الاستحقاق</th>
                            </tr>
                            <tr>
                                <td align="center">
                                    <?php
                                    $d = explode(" - ", $data->period);
                                    $dd = explode("-", $d[0]);
                                    echo $dd[2] . "/" . $dd[1] . "/" . $dd[0];
                                    ?>
                                </td>
                                <td align="center">
                                    <?php
                                    $dd = explode("-", $d[1]);
                                    echo $dd[2] . "/" . $dd[1] . "/" . $dd[0];
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:50%" align="left" valign="top">
                        <table class="show_table" width="250px">
                            <tr>
                                <th>رقم الفاتورة</th>
                            </tr>
                            <tr>
                                <td align="center">
                                    {{$data->invoice_number}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br><br>
            <table class="show_table" width="500px" align="center">
                <tr>
                    <th>فاتورة إلي</th>
                </tr>
                <tr>
                    <td align="center">
                        Noon E-Commerce solutions single person company (LLC)
                        <br>
                        شركة حلول نون للتسويق الالكتروني
                        <br>
                        الرقم الضريبي : 302004655210003
                    </td>
                </tr>
            </table>
            <br><br>
            <table class="show_table" width="100%" align="center" dir="rtl">
                <tr>
                    <th>النوع</th>
                    <th>الوصف</th>
                    <th>الكمية</th>
                    <th>سعر الوحدة</th>
                    <th>نسبة ضريبة القيمة المضافة</th>
                    <th>الاجمالي</th>
                </tr>
                <tr>
                    <td>
                        توصيل طرود بضائع
                    </td>
                    <td>
                        <?php
                        $month = array("يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو",
                            "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر");
                        ?>
                        مبيعات
                        {{$month[$dd[1]-1]}}
                        {{$dd[0]}}
                    </td>
                    <td>
                        {{$data->No_of_TouchPoint}}
                    </td>
                    <td>
                        {{$data->unit_cost}}
                    </td>
                    <td>
                        {{$data->vat}}
                    </td>
                    <td>
                        {{$data->amount}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                    </td>
                    <td>ضريبة القيمة المضافة</td>
                    <td>
                        {{$data->vat_amount}}

                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        فقط
                        {{$number_to_text}}
                        لاغير
                    </td>
                    <td>مجموع المبلغ المستحق</td>
                    <td>
                        {{$data->total_amount}}

                    </td>
                </tr>
            </table>
            <br><br>
            <table class="show_table" width="100%" align="center">
                <tr>
                    <th>ارقام الحسابات البنكية</th>
                </tr>
                <tr>
                    <td dir="rtl">
                       البنك الاهلي :
                        SA 10000026765588000101
                    </td>
                </tr>
                <tr>
                    <td dir="rtl">
                        بنك الراجحي :
                        SA 1180000219608013331332
                    </td>
                </tr>
            </table>

            <br><br>
            <table border="0" width="100%" align="center" dir="rtl">
                <tr>
                    <td style="width:50%;text-align:center;">توقيع العميل</td>
                    <td style="width:50%;text-align:center;">توقيع شركة مشوار العاصمة</td>
                </tr>
                <tr>
                    <td style="width:50%;text-align:center;"></td>
                    <td style="width:50%;text-align:center;padding-left: 0px" valign="middle">
                        <table border="0" align="center">
                            <tr>
                                <td>
                                    <img src="{{asset("/AdminLTE/img/circle_stamp2.jpg")}}"
                                         style="width:141px;height:144px"></a>
                                </td>
                            </tr><tr>
                                <td>
                                    <img src="{{asset("/AdminLTE/img/signature.jpg")}}"
                                         style="width:139px;height:56px"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td dir="rtl" style="height: 10px;border-bottom: solid 1px #000000">
            <table border=0 cellspacing="0" cellpadding="0" class="show_footer" width="100%">
                <tr>
                    <td style="text-align: right;width:25%">
                        الرياض . حي السلمانية . مكتب رقم 1
                    </td>
                    <td style="text-align: center;width:25%">
                        الرمز البريدي:
                        12231
                    </td>
                    <td style="text-align: center;width:25%">
                        جوال:
                        0552771495
                    </td>
                    <td style="text-align: left;width:25%">
                        info@mashaueer.com
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
