@extends('AdminLTE')
@section('content')      
 <style>
    th{
        border: solid 1px black;
    }
 </style>
 
    @php     @endphp
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-weight: bold;">Vehicle :{{$vehicle->plate}}</h2>
        </div>
        @if(Auth::user()->user_type_id==1||session('Session_DriversCarrefour')=='yes')
            
        @endif
    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>

 <div class="table-responsive" style="width: 100%;">
    <form action="{{url('Vehicles/vehicle-utilities/Validate')}}" method="post"> 
        @csrf
        <input type="hidden" name="checkup_id" value="{{$VehicleCheckup->id}}">
        <input type="hidden" name="vehicle_id" value="{{$VehicleCheckup->vehicle_id}}">
        <table id="customer_data" class="table table-bordered table-striped table-responsive">
            <thead>
                {{-- <TH>#</TH> --}}
                <TH >Utilities</TH>
                <TH >Condition</TH> 
            </thead>
            <tbody>
                @foreach ($response as $k=>$item) 
                    <tr>  
                        <td>{{$item->name_en}}
                            @if($item->isRequired == 'Yes')
                                (<span style="color:red">*</span>)
                            @else
                                <span style="color:rgb(22, 95, 197)">(Optional)</span> 
                            @endif
                        </td>
                        <td>  
                            @foreach(json_decode($item->category) as $category)
                                <input type="radio" name="{{$item->code}}" @if($item->isRequired == 'Yes') {{'required'}}  @endif value="{{$category}}"> {{$category}}   
                            @endforeach
                        </td>  
                    </tr>
                @endforeach
            </tbody>
            <thead class="thead-dark">
                <tr>
                    
                    <TH colspan="2" ><input type="submit" value="Confirm" style="float: right;" class="btn btn-light"></TH> 
                </tr>
            </thead>
        </table>
    </form>
</div> 
 

@endsection