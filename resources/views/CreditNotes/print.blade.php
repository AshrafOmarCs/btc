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
        font-size: 16px !important;
        line-height: 30px;
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
                                    الرقم الضريبي:
                                    310036168300003
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    الايميــــــــــــل:
                                    Info@mashaueer.com
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table border="0" width="100%">
                <tr>
                    <td style="width:20%;font-family: 'Segoe UI';font-size: 20px; font-weight: bold;"
                        align="center"><u>Credit
                            Note</u></td>
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
            <br><br><br>
            <table border="0" width="100%" dir="rtl">
                <tr>
                    <td style="width:50%">
                        <table class="show_table" width="250px">
                            <tr>
                                <th>التاريخ</th>
                            </tr>
                            <tr>
                                <td align="center">
                                    <?php echo date('d/m/Y');?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:50%" align="left">
                        <table class="show_table" width="250px">
                            <tr>
                                <th>رقم الفاتورة</th>
                            </tr>
                            <tr>
                                <td align="center">
                                    {{$CreditNotes->invoice_number}}
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
                        <?php
                        if ($CreditNotes->companyFullName_en <> '')
                            echo $CreditNotes->companyFullName_en . '<br>';
                        if ($CreditNotes->companyFullName_ar <> '')
                            echo $CreditNotes->companyFullName_ar . '<br>';
                        if ($CreditNotes->TaxNumber <> '')
                            echo 'الرقم الضريبي :' . ' ' . $CreditNotes->TaxNumber;
                        ?>
                    </td>
                </tr>
            </table>
            <br><br>
            <table class="show_table" width="100%" align="center" dir="rtl">
                <tr>
                    <th>النوع</th>
                    <th>الوصف</th>
                    <th>&nbsp;</th>
                    <th>الاجمالي</th>
                </tr>
                <tr>
                    <td>
                        مفقودات
                    </td>
                    <td>
                        {{$CreditNotes->job_id}}
                        <br>
                        {{$CreditNotes->fullName}}
                    </td>
                    <td></td>
                    <td>
                        {{$CreditNotes->amount}}
                        ريال
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        فقط
                        {{$number_to_text}}
                        لاغير
                    </td>
                    <td>مجموع المبلغ المستحق</td>
                    <td>
                        {{$CreditNotes->amount}}
                        ريال
                    </td>
                </tr>
            </table>
            <br><br><br><br><br>
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
