<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Filter layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .list-group-item+.list-group-item.active {
            border-top: 1px solid white;
        }
        #table{
            width: 90%; margin: 0 auto; margin-top: 44px;
        }
    </style>
</head>
<body>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
      </button>
      
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>

    



    <table id="table">
        {{-- End Header --}} 
        <tr>
            <td>
               <input type="checkbox" name="" id=""> Select all
            </td>
            <td>
                
            </td>
            <td>
                <input type="checkbox" name="" id=""> Unselect all
            </td>
        </tr>
        {{-- End Header --}} 


        {{-- Body --}} 
        @php 

        $array = [
            0=>'Company name',
            1=>'Hub',
            2=>'Driver name',
            3=>'Driver ID',
            4=>'Balance',
            5=>'Suppervisor', 
        ]; 
        @endphp
        <tr>
            <td>
                <ul class="list-group"> 
                    @foreach($array as $k=>$option)
                        <li class="list-group-item"  id="option{{$k}}" onclick="selectOption('{{$k}}')" style="    cursor: pointer;">{{$option}}</li>
                    @endforeach  
                </ul>
            </td>
            <td style="text-align: center;">
                <img style="width: 37px;    margin-top: 4px;" src="https://cdn-icons-png.flaticon.com/512/2735/2735071.png" alt="">
                <br>
                <img style="width: 37px; margin-top: 53px;" src="https://cdn-icons-png.flaticon.com/512/2985/2985161.png" alt="">
            </td>
            <td>
                <ul class="list-group"> 
                    @foreach($array as $k=>$option)
                        <li class="list-group-item"  id="unselect_option{{$k}}" onclick="unselectOption('{{$k}}')" style="    cursor: pointer;"> &nbsp </li>
                    @endforeach
                </ul>
            </td>
        </tr>  
        {{-- End Body --}}


        {{-- Footer --}}
        <tr>
            <td>
                
            </td>
            <td>
                
            </td>
            <td style="text-align: right;">
                Total Select (<span style="color: red">3</span>)
            </td>
        </tr>  
        {{-- End-Footer --}}
    </table>
<script>
    function selectOption(args){
        var option_id = 'option'+args;
         
        var option_id = document.getElementById(option_id);
        
        // console.log(element.classList);
        var classList = option_id.classList
        classList.forEach(element => {
            if(element == 'active'){
                classList.remove("active");
            }else{
                classList.add("active");
            }
        });
        // console.log(index);
    }
</script>
</body>
</html>