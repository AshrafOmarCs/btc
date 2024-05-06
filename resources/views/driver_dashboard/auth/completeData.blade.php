@extends('driver_dashboard.driverlayout.index')
@section('content') 

<div class="card">
    <div class="card-body">
        <h5>Welome, Ashraf o Moh'd <img  style="float: right;" src="{{url('images/arabic.png')}}" alt="" srcset=""></h5>
        <p>Please Complete The Following in order to
        Complete your Profile .  </p>
    </div>
</div>
<div class="mb-3">
    <label for="idFormControlInput1" class="form-label">Identity/Iqama version</label>
    <input type="number" min="1" class="form-control" id="idFormControlInput1" placeholder="1,2,3....">
  </div>
  <div class="mb-3">
    <label for="absherFormControlTextarea1" class="form-label">Absher Number</label>
    <span>+966</span><input type="number" min="0" class="form-control" id="absherFormControlTextarea1" placeholder="53 123 1234">
  </div>
  <div class="form-floating">
    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
      <option selected>Open this select menu</option>
      <option value="1">One</option>
      <option value="2">Two</option>
      <option value="3">Three</option>
    </select>
    <label for="floatingSelect">Works with selects</label>
  </div>
@endsection