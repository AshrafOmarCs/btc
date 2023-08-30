@extends('AdminLTE')
@section('content')

<!-- Content Header (Page header) -->

      <table class="table m-0 search_table" style="width:10px!important;" >
            <tr>
                            <TH>Google Map</TH>
                            <TH>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TH>
                            <TH>Company:</TH>
                            <td>
                                <select name="filter_companyId" id="filter_companyId" onchange="filterMarkers(this.value);"
                                        class="form-control" style="width:200px;" required>
                                        <option value="">All</option>
                                    @foreach($lkp_company as $lkpcompany)
                                        <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                    @endforeach
                                </select>
                            </td>
                            </tr></table>





    <div id="map" style="height: 650px; width: 1300px;">
</div>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBav-SFRvB1fLJ9tkrEKMpJsCbHGEdqEQ8&callback=initMap">
    </script>



<script type="text/javascript">

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


var gmarkers1 = [];
var markers1 = [];

// Our markers

var markers1 = [
        <?php $i=0;?>
        @foreach($warehouses as $warehouse)

        [{{$i}},'{{$warehouse->warehouseName}}', {{$warehouse->latitude}}, {{$warehouse->longitude}},{{$warehouse->companyId}}],
        <?php $i++?>
        @endforeach

    ];


/**
 * Function to init map
 */

function initMap() {
    var center = new google.maps.LatLng(24.774265, 46.738586);
    var mapOptions = {
        zoom: 5.5,
        center: center,
       // mapTypeId: google.maps.MapTypeId.TERRAIN
       gestureHandling: 'greedy'
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    for (i = 0; i < markers1.length; i++) {
        addMarker(markers1[i]);
    }
    //var infowindow = new google.maps.InfoWindow({content: ''});
    //var infowindow = new google.maps.InfoWindow();
}

/**
 * Function to add marker to map
 */
//************************************************************************************************8 */
var iconBase =
            'https://maps.google.com/mapfiles/ms/icons/';

        var icons = [iconBase + 'red-dot.png',iconBase + 'blue-dot.png',iconBase + 'green-dot.png'];

//************************************************************************************************* */
function addMarker(marker) {
    var category = marker[4];
    var title = marker[1];
    var pos = new google.maps.LatLng(marker[2], marker[3]);
    var content = marker[1];

    marker1 = new google.maps.Marker({
        title: title,
        position: pos,
        category: category,
        //icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
        icon:  icons[marker[4]-1],
        map: map


    });

    gmarkers1.push(marker1);
    var infowindow = new google.maps.InfoWindow({content: ''});

    // Marker click listener
    google.maps.event.addListener(marker1, 'click', (function (marker1, content) {
        return function () {
            console.log('Gmarker 1 gets pushed');
            infowindow.setContent(content);
            infowindow.open(map, marker1);
            //map.panTo(this.getPosition());
            //map.setZoom(15);

        }
    })(marker1, content));
}

/**
 * Function to filter markers by category
 */

filterMarkers = function (category) {
    for (i = 0; i < gmarkers1.length; i++) {
        marker = gmarkers1[i];
        // If is same category or category not picked
        if (marker.category == category || category.length === 0) {
            marker.setVisible(true);
        }
        // Categories don't match
        else {
            marker.setVisible(false);
        }
    }
}

// Init map


</script>


@endsection




