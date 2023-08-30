<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Modifiy Drivers Types</title>
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
        .hidableElement{
            display: none;
        }
    </style>
</head>
<body>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>In order to continue you have to </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    <!-- Modal -->



    <table class="table" >
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Company name</th>
                <th scope="col">Warehouse name</th>
                <th scope="col">Driver AMP</th> 
                <th scope="col">Driver Name</th> 
                <th scope="col">Driver Type</th>
                <th scope="col" colspan="2">Additional Data</th> 
                <!-- <th >Action</th>  -->
                
            </tr>
        </thead>
        <tbody>
            <form action="{{url('Import_DA_Dailyload/bulk-drivers')}}" method="post">
                @csrf
                @foreach($unspacifyDA as $k=>$finoo)
                <tr> 
                    <th scope="row">{{$k+1}}</th>
                    <td>{{$finoo['company_name']}} </td>
                    <td> {{$finoo['hub_name']}}</td>
                    <td><span style="color:red">{{$finoo['amp']}}</span></td>
                    <td> {{$finoo['daName']}}</td>
                    <td>
                        <input type="hidden" name="file_id"  value="{{$returnedData[0]}}">
                        <select name="driverTypes[]" id="driverTypes{{$k}}" required onchange="setAdditionalData({{$k}})">
                            <option disabled selected>Select driver type</option>
                            @foreach($Driver_types as $Driver_type)
                                <option value="{{$Driver_type->id}}" @if($Driver_type->id == 3) selected  @endif>{{$Driver_type->driver_type}}</option>
                            @endforeach
                        </select> 
                    </td>
                    <td id="additinalData{{$k}}" colspan="2">No Additional Data required</td>
                    <td class="hidableElement" id="basic_Salary{{$k}}"><input type="number" min="4" id="basic_SalaryInput{{$k}}" name="basic_Salary[]" placeholder="Basic Salary 0.00 SAR"><input type="hidden" name="driver_id[]" value="{{$finoo['driver_id']}}"></td>
                    <td class="hidableElement" id="fuelPerDay{{$k}}"><input type="number" min="4" name="fuelPerDay[]" placeholder="Fuel Per Day 0.00 SAR"></td>

                    <!-- <td ><input value="Add"></td> -->
                </tr> 
                @endforeach
                <tr>
                    <td colspan="8">
                        <button id="addBtn{{$k}}" type="submit"  class="btn btn-light" style="float: right;  margin: 10px; width: 137px;  ">Continue</button>
                    </td>
                </tr>
            </form>
        </tbody>
    </table>


    <script>
        function setAdditionalData(index){
            // alert(index);
            var fuelPerDay = '#fuelPerDay'+index;
            var basic_Salary = '#basic_Salary'+index;
            if($('#driverTypes'+index).find(":selected").val() == 1 || $('#driverTypes'+index).find(":selected").val() == 3){
                $('#additinalData'+index).show(); 
                $('.hidableElement').hide();  
                $('#basic_SalaryInput'+index).prop('required',false); 
            }else{ 
                $('#additinalData'+index).hide();
                $(basic_Salary).show(); 
                $(fuelPerDay).show(); 
                $('#basic_SalaryInput'+index).prop('required',true); 
            }  
        }
        function vaildateInputs() {
            
        }
    </script>
</body>
</html>