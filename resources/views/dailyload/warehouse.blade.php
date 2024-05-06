<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Modifiy Warehouses prices in order to continue</title>
    <style>
        .table{
            width: 89%;
            margin: 0 auto;
            background-color: #e7e9eb;
        }
        th,td{
            border: 1px solid #8e8fa0;
            text-align: center;

        }
        th{
            background-color: #afafb4;
        }
    </style>
</head>
<body>
    <!-- <h5>Update Bellow Warehose delivery price </h5>
    <p>Cant Continue without makign this change</p> -->
    <table class="table" >
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Company name</th>
                <th scope="col">Warehouse name</th>
                <th scope="col">Note</th> 
                <th scope="col">Delivery Price</th>
                
            </tr>
        </thead>
        <tbody>
            <form action="{{url('Import_DA_Dailyload/storewarehouse')}}" method="post">
                @csrf
                @foreach($final as $k=>$finoo)
                <tr>
                    <th scope="row">{{$k+1}}</th>
                    <td>{{$finoo->company_name}}</td>
                    <td>{{$finoo->warehouseName}}</td> 
                    <td><span style="color:red">Delivery Price Can not be Zero</span></td>
                    <td>
                        <input type="hidden" name="file_id" value="{{$returnedData[1]}}">
                        <input type="hidden" name="file_path" value="{{$returnedData[0]}}"> 
                        <input type="number" min="4" name="warehouseDeliverPrice[]" required value="{{$finoo->deliveryPrice}}">
                    </td>
                </tr> 
                @endforeach
                <tr>
                    <td colspan="5">
                        <button class="btn btn-info" style="float: right;  margin: 10px; width: 137px;  height: 34px;">Continue</button>
                    </td>
                </tr>
            </form>
        </tbody>
    </table>
</body>
</html>