<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إخلاء طرف</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: right;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .note {
            margin-top: 20px;
            font-size: 14px;
        }
        .print-button {
            margin-bottom: 20px;
            text-align: center;
        }
        .print-button button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    @if($type == 1)
        <div class="print-button">
            <button onclick="window.print()">طباعة</button>
        </div>
    @endif
    <div class="header">إخلاء طرف</div>

    <table>
        <tr>
            <th colspan="4">البيانات العامة</th>
        </tr>
        <tr>
            <td>التاريخ</td>
            <td>{{$liability->date}}</td>
            <td>الموافق</td>
            <td></td>
        </tr>
        <tr>
            <td>الاسم</td>
            <td>{{$liability->driverName}}</td>
            <td>رقم الهوية/الإقامة</td>
            <td>{{$liability->iqama}}</td>
        </tr>
        <tr>
            <td>الجنسية</td>
            <td>{{$liability->nationality}}</td>
            <td>الوظيفة</td>
            <td>{{$liability->job_title}}</td>
        </tr>
        <tr>
            <td>رقم الهاتف</td>
            <td colspan="3">{{$liability->mobileNumber}}</td>
        </tr>

        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <th colspan="4">سبب إخلاء الطرف</th>
        </tr>
        <tr>
            <td colspan="4">{{$liability->note}}</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
            <th colspan="4">إخلاء الطرف</th>
        </tr>
        <tr>
            <td colspan="4">يقر جميع الموقعين كل فيما يخصه أن الموظف المذكور خالي الطرف من أي عهدة مالية أو عينية أو أي حق من حقوق الشركة</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
            <th>الإدارة</th>
            <th>اسم المسؤول</th>
            <th>التاريخ</th>
            <th>الملاحظات</th>
        </tr>
        <tr>
            <td>Vehicle</td>
            <td>{{$liability->vehicle_done_by}}</td>
            <td>{{$liability->vehicle_done_at}}</td>
            <td>{{$liability->vehicle_note}}</td>
        </tr>
        <tr>
            <td>Finance</td>
            <td>{{$liability->finance_done_by}}</td>
            <td>{{$liability->finance_done_at}}</td>
            <td>{{$liability->finance_note}}</td>
        </tr>
        <tr>
            <td>Manager</td>
            <td>{{$liability->manager_done_by}}</td>
            <td>{{$liability->manager_done_at}}</td>
            <td>{{$liability->manager_note}}</td>
        </tr>
    </table>
        <div class="note">
            @if ($liability->manager_done_by === null OR $liability->finance_done_by === null OR $liability->vehicle_done_by === null)
                بعد إخلاء هذا الطرف غير ساري حتى اليوم وننتظر اكتمال اعتماد الأقسام أعلاه لذلك لا يمكن استخدامه
            @else
               هذه الشهادة صالحة من {{max($liability->vehicle_done_at, $liability->finance_done_at, $liability->manager_done_at)}}
            @endif
        </div>

</body>
</html>
