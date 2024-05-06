<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAND-MARK IDS</title>
    <style>
        td,th{
            border: 1px solid #ffcc08;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>#</th>
            <th>Old ID</th>
            <th>NEW ID</th>
        </tr>
        @foreach($Payload as $count=>$items)
        <tr>
            <td>{{$count+1}}</td>
            <td>{{$items[0]}}</td>
            <td>{{$items[1]}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>