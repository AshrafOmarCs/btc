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
        vertical-align: middle !important;
        text-align: right;
        margin: 0 !important;
        font-size: 24px;
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
<?php
if ($Drivers->iqama == '') {
    echo '<table  border="0" width="100%" align="center">
     <tr><td style="font-family: Arial;font-size: 26px; font-weight: bold;" align="center">
     الرجاء ادخال رقم الاقامة
     </td></tr>
    </table>';
    exit;
}
if ($Drivers->balance < 0) {
    echo '<table  border="0" width="1%" align="center" dir=rtl>
     <tr><td style="font-family: Arial;font-size: 26px; font-weight: bold;" align="center" >
     الرصيد=
</td>
<td style="font-family: Arial;font-size: 26px; font-weight: bold;" align="center" dir=ltr>
' . $Drivers->balance . '
     </td></tr>
    </table>';
    exit;
}
?>

@if($print =='0')
    <form method="GET" action="{{ URL('/ClearancePrint')}}/{{$Drivers->driverId}}/1">

        <table border="0" width="100%" id="table1" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" dir=rtl id="hed" bgColor=#3065A7>
                    <table bgcolor="#FFFFFF" style="border: 2px solid #C4C4C4;">
                        <tr>
                            <td>
                                <button type="submit" style="background-color: #ffffff"><img border="0"
                                                                                             src="{{asset("/AdminLTE/img/Print.bmp")}}"
                                                                                             width="48" height="48">
                                </button>
                                &nbsp;&nbsp;
                            </td>
                            <td style="VERTICAL-ALIGN: middle;">طباعـــــة&nbsp;&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
@else
    <script>
        window.print();
    </script>
@endif
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
                                <td style="font-family: 'Arial';font-size: 26px; font-weight: bold;">
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
                                    3100361683000003
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    الايميــــــــــــل:
                                    Info@mashaueer.com
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    التاريخ:
                                    <?php echo date('d/m/Y');?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table border="0" width="100%">
                <tr>
                    <td style="width:20%;font-family: 'Arial';font-size: 26px; font-weight: bold;"
                        align="center"><u>مخالصة</u></td>
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
            <br><br><br><br><br><br>

            <table border="0" class="show_table" width="100%" align="center" dir="rtl">
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    اقر انا /
                                </td>
                                <td style="font-size: 18px;font-weight:bold">
                                    {{$Drivers->fullName}}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    هوية رقم:
                                </td>
                                <td style="font-size: 18px;font-weight:bold">
                                    {{$Drivers->iqama}}
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>

            </table>
            <br><br><br><br>
            <table border="0" class="show_table" width="100%" align="center" dir="rtl">
                <tr>
                    <td>
                        بأني استلمت كافة حقوقي من شركة مشوار العاصمة وليس لي اي مستحقات مالية للشركة واصبح
                        طرفي خاليا من تاريخه.
                    </td>

                </tr>

            </table>
            <br><br>
            <br><br><br><br><br><br><br><br>
            <table width="100%" align="center" dir="rtl">
                <tr>
                    <td style="width:50%;text-align:center;font-family: 'Arial';font-size: 20px;">المقر بما
                        فيه
                    </td>
                    <td style="width:50%;text-align:center;font-family: 'Arial';font-size: 20px;">المدير
                        التنفيذي
                    </td>
                </tr>
                <tr>
                    <td style="width:50%;text-align:center;font-family: 'Arial';font-size: 20px;">الاسم/
                        .............................................
                    </td>
                    <td style="width:50%;text-align:center;font-family: 'Arial';font-size: 20px;">عبدالله بن
                        سامر
                    <td>
                </tr>
                <tr>
                    <td style="width:50%;text-align:center;font-family: 'Arial';font-size: 20px;">التوقيع/
                        ............................................
                    </td>
                    <td style="width:50%;text-align:center;font-family: 'Arial';font-size: 20px;"></td>
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
