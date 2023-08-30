@include('pages.messages')
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="{{asset("/AdminLTE/css/bootstrap.min.css")}}">
<style type="text/css">

        #map {

            width: 100%;

            height: 500px;

        }

    </style>

</head>
<body>

<center>
<table   style="width:10px!important;margin:0!important;" align=center >
            <tr>
                            <TH style="white-space: nowrap;">Google Map</TH>
                            <TH>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TH>
                            <TH>Company:</TH>
                            <td style="white-space: nowrap;">{{$Warehouse->companyName}}</td>
                            <TH>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TH>
                            <TH>Warehouse:</TH>
                            <td style="white-space: nowrap;">{{$Warehouse->warehouseName}}</td>
                            </tr></table>
 </center>                           
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBav-SFRvB1fLJ9tkrEKMpJsCbHGEdqEQ8&callback=initMap">
    </script>  

<table   style="width:100%; margin:0!important;" align=center>
<tr>
<td id="map"></td>
</tr>
</table>
<form method="POST" action="{{ action('WarehousesController@MapWindowSave') }}">
                       @csrf
<input name="id" id="id" type="hidden" value="{{$Warehouse->id}}">
<input name="lat-text" id="lat-text" type="hidden" value="{{$Warehouse->latitude}}">
<input name="lon-text" id="lon-text" type="hidden" value="{{$Warehouse->longitude}}">
<ul id="geoData">

    <li>Latitude: <span id="lat-span">{{$Warehouse->latitude}}</span></li>
    <li>Longitude: <span id="lon-span">{{$Warehouse->longitude}}</span></li>

</ul>
<center>
<button type="submit" name="submit"  class="btn btn-sm btn-info" id="filter">update</button>
</center>
</form>
<script>
// Store old reference
const appendChild = Element.prototype.appendChild;

// All services to catch
const urlCatchers = [
  "/AuthenticationService.Authenticate?",
  "/QuotaService.RecordEvent?"
];

// Google Map is using JSONP.
// So we only need to detect the services removing access and disabling them by not
// inserting them inside the DOM
Element.prototype.appendChild = function (element) {
  const isGMapScript = element.tagName === 'SCRIPT' && /maps\.googleapis\.com/i.test(element.src);
  const isGMapAccessScript = isGMapScript && urlCatchers.some(url => element.src.includes(url));

  if (!isGMapAccessScript) {
    return appendChild.call(this, element);
  }

  // Extract the callback to call it with success data
  // Only needed if you actually want to use Autocomplete/SearchBox API
  //const callback = element.src.split(/.*callback=([^\&]+)/, 2).pop();
  //const [a, b] = callback.split('.');
  //window[a][b]([1, null, 0, null, null, [1]]);

  // Returns the element to be compliant with the appendChild API
  return element;
};


function initMap() {

    var myLatLng = {lat: {{$Warehouse->latitude}}, lng: {{$Warehouse->longitude}}};

  

    var map = new google.maps.Map(document.getElementById('map'), {

      center: myLatLng,

      zoom: 18

    });

  

    var marker = new google.maps.Marker({

          position: myLatLng,

          map: map,

          //title: 'Hello World!',

          draggable: true

        });

  

     google.maps.event.addListener(marker, 'dragend', function(marker) {

        var latLng = marker.latLng;

        document.getElementById('lat-span').innerHTML = latLng.lat();
        document.getElementById('lat-text').value = latLng.lat();

        document.getElementById('lon-span').innerHTML = latLng.lng();
        document.getElementById('lon-text').value = latLng.lng();

     });
	 google.maps.event.addListener(marker, 'drag', function(marker) {

        var latLng = marker.latLng;

        document.getElementById('lat-span').innerHTML = latLng.lat();
        document.getElementById('lat-text').value = latLng.lat();

        document.getElementById('lon-span').innerHTML = latLng.lng();
        document.getElementById('lon-text').value = latLng.lng();

     });
	 

}

  

</script>


  

</body>

</html>