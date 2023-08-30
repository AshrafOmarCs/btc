<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body style="width:600px,height:600px;">
<table class="table">
  <thead>
    <tr style="font-size: 11px; text-align: center;">
      <th scope="col"><img style="width: 108px;" src="{{asset('images/jahez-new-logo.png')}}" alt=""></th>
      <th scope="col"></th>
      <th scope="col" style="font-size: 15px;">استيراد من ساند الى نظام بندر</th>
    </tr>
  </thead>
  <tbody>
     
    <form action="{{url('/DriversJahiz/store')}}" method="post"  enctype="multipart/form-data">
        @csrf
        <tr style="font-size: 11px; text-align: center;">
            <td scope="col"></td>
            <td scope="col">
                <input type="file"  name="csv" id="" accept=".csv ">
            </td>
            <td scope="col"></td>
        </tr>
        <tr style="font-size: 11px; text-align: center;">
            <td scope="col" colspan="2"><small>*Allowded File Extenstion is : CSV</small></td>
            <td scope="col"><input type="submit" value="Import"></td>
        </tr>
    </form>
  </tbody>
</table>
</body>
</html>