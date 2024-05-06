@extends('AdminLTE')
@section('content')
<link rel="stylesheet" href="{{asset('dropAndDrag/src/style.css')}}">
    <form action="HandleLandmarkFile" method="post" enctype="multipart/form-data">


        
        <div style="width: 88%; margin: 0 auto;">
            <h5 class="certrilize" style="margin-top: 14px; ">- Upload the dailyload Excel sheet</h5>
            <p class="certrilize">  Drop file Bellow or click on the squire to choose file and continue </p>
            
            <form action="{{url('Import_DA_Dailyload/validate')}}" method="post"  enctype="multipart/form-data">

               
                

                @csrf
                <div class="drop-zone">
                    <span class="drop-zone__prompt">Drop file here or click to upload</span>
                    <input type="file" name="myFile" required class="drop-zone__input" style="display:none">
                </div>  
                <table style="width: 100%; margin: 0 auto;">
                    <tr>
                        <td>
                            <div class="form-group">
                                <label for="PDInput">PD Amount Per Day</label>
                                <input style="width: 48%;" type="number" name="pd" class="form-control" required min="0"  step="0.01" id="PDInput" placeholder="PD Price per day ">
                            </div>
                        </td>
                        <td>
                        <div class="form-group">
                            <label for="permanentInput">Permanent</label>
                            <input type="number" style="width: 48%;" name="permanent" class="form-control" required min="0"   id="permanentInput" placeholder="permanent Price per day">
                        </div>  
                        </td>
                    </tr>
                </table>

                <!-- <a href="{{url('Import_DA_Dailyload/step/Check-warehouse')}}">Next</a> -->
                <input type="submit" value="Confirm" class="btn btn-info" style="float: right; margin-top: 32px; margin-right: 53px;">
            </form>
        </div>

        
    </form>

    <script src="{{asset('dropAndDrag/src/script.js')}}"></script> 
@endsection