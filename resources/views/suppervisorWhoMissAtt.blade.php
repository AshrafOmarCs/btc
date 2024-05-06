<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>01-09-2023 to 31-09-2023</title>
</head>
<body>
    <table>
        <tr> 
            <th>Name</th> 
            <th>Warehouse</th>
            <th>Date</th>
        </tr>
        @foreach ($res as $item)
            <tr> 
                <td>{{$item->name}}</td>
                <td>{{$item->warehouses_names}}</td>
                <td>{{$item->date}}</td>
            </tr>
        @endforeach
        
    </table>
</body>
</html>