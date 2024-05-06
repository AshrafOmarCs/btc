@extends('AdminLTE')
@section('content')
    <style>

        .label {

            color: #000;

            background-color: white;

            border: 1px solid #000;

            font-family: "Lucida Grande", "Arial", sans-serif;

            font-size: 12px;

            text-align: center;

            white-space: nowrap;

            padding: 2px;
            margin: 0px 0px !important;

        }

        .label.green {

            background-color: #58D400;

        }

        .label.red {

            background-color: #D80027;

            color: #fff;

        }

        .label.yellow {

            background-color: #FCCA00;

        }

        .label.turquoise {

            background-color: #00D9D2;

        }

        .label.brown {

            background-color: #BF5300;

            color: #fff;

        }

    </style>
    <!-- Content Header (Page header) -->

    <form method="GET" action="{{ route('GoogleMapTrack.index')}}"    >
        @csrf
        <table class="table m-0 search_table" style="width:10px!important;">
            <tr>
                <TH>Google Map</TH>
                <TH>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TH>
                <TH>Company:</TH>
                <td>
                    <select name="filter_companyId" id="filter_companyId" onchange="filterMarkers(this.value);"
                            class="form-control" style="width:200px;" >
                        <option value="">All</option>
                        @foreach($lkp_company as $lkpcompany)
                            <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                        @endforeach
                    </select>
                </td>
                <TH>Tracking Date</TH>
                <td>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" style="width:200px" class="form-control pull-right" name="tracking_date"
                               id="tracking_date" placeholder="dd/mm/yyyy" value="{{$tracking_date}}" required>
                    </div>
                </td>
                <TH>Supervisor:</TH>
                <td>
                    <select name="filter_userId" id="filter_userId"
                            class="form-control" style="width:200px;" >
                        <option value="">All</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}" <?php if( $filter_userId==$user->id) echo " selected ";?>> {{$user->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <button type="submit" name="filter" class="btn btn-sm btn-info" id="filter">Track</button>
                </td>
            </tr>
        </table>
    </form>




    <div id="map" style="height: 650px; width: 1300px;">
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvvDMJeEDbV5IVHAACwO8tBZsS7UXNF9s"></script>

    <script src="{{asset("/AdminLTE/js/maplabel.js")}}"></script>
    <script src="https://cdn.sobekrepository.org/includes/gmaps-markerwithlabel/1.9.1/gmaps-markerwithlabel-1.9.1.js"
            type="text/javascript"></script>

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


        //********************************************************************************************************
        //********************************************************************************************************
        //********************************************************************************************************
        var gmarkers1 = [];
        var markers1 = [];

        // Our markers

        var markers1 = [
                <?php $i = 0;?>
                @if(!empty($warehouses))
                @foreach($warehouses as $warehouse)

            [{{$i}}, '{{$warehouse->warehouseName}}', {{$warehouse->latitude}}, {{$warehouse->longitude}},{{$warehouse->companyId}}],
            <?php $i++?>
            @endforeach
            @endif

        ];

        var coordinates = {

            <?php
            $name='';
            $i = 0;$loc = '';$userId = '';
            foreach ($polygons as $polygon) {
                $i++;
                if ($userId <> $polygon->userId && $i <> 1) {
                    echo "\"" . $name . "\":[\n";
                    echo $loc . "],\n";
                    $loc="";
                }
                $name = $polygon->name;
                $loc .= "[" . $polygon->latitude . "," . $polygon->longitude . ",'" . $polygon->HM . "'," . $polygon->distance_in_km . "],\n";
                $userId = $polygon->userId;
            }
            echo "\"" . $name . "\":[\n";
            echo $loc . "],\n";
            ?>

        }

        //********************************************************************************************************
        //********************************************************************************************************
        //********************************************************************************************************

        //var map, infoWindow;

        function initialize() {

            var center = new google.maps.LatLng(24.774265, 46.738586);
            var mapOptions = {
                zoom: 5,
                center: center,
                // mapTypeId: google.maps.MapTypeId.TERRAIN
                gestureHandling: 'greedy'
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // var bounds = new google.maps.LatLngBounds();
            var polygons = [];
            var arr = new Array();
            for (i = 0; i < markers1.length; i++) {
                addMarker(markers1[i]);
            }
            //var infowindow = new google.maps.InfoWindow({content: ''});
            //var infowindow = new google.maps.InfoWindow();
            // Define the LatLng coordinates for the polygon's path.

            var col='';
            for (var i in coordinates) {
                arr = [];

                for (var j = 0; j < coordinates[i].length; j++) {
                    arr.push(new google.maps.LatLng(
                        parseFloat(coordinates[i][j][0]),
                        parseFloat(coordinates[i][j][1])
                    ));

                    /* var mapLabel = new MapLabel({
                         text: 'Test',
                         position: new google.maps.LatLng(
                             parseFloat(coordinates[i][j][0]),
                             parseFloat(coordinates[i][j][1])
                         ),
                         map: map,
                         align: 'right',
                         fontSize: 20,
                         strokeWeight: 1.0,
                         strokeColor: '#01579B',
                         backgroundColor: '#000000',
                         borderRadius: 10,
                         padding: 10,

                         backgroundStrokeWeight: 3
                     });
                     mapLabel.set('position', new google.maps.LatLng(
                         parseFloat(coordinates[i][j][0]),
                         parseFloat(coordinates[i][j][1])
                     ));
                    */
                    if (parseFloat(coordinates[i][j][3])<1) col='green'; else col='red';

                    var marker = new MarkerWithLabel({

                        position: {lat: parseFloat(coordinates[i][j][0]), lng: parseFloat(coordinates[i][j][1])},

                        map: map,

                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            fillColor: '#00F',
                            fillOpacity: 0.6,
                            strokeColor: '#00A',
                            strokeOpacity: 0.9,
                            strokeWeight: 1,
                            scale: 7
                        },

                        labelContent: coordinates[i][j][2],



                        labelAnchor: new google.maps.Point(parseFloat(coordinates[i][j][0]), parseFloat(coordinates[i][j][1])),

                        // the CSS class for the label

                        labelClass: "label " + col,

                        labelInBackground: true,


                    });


                }

                // Construct the polygon.
                polygons.push(new google.maps.Polyline({
                    //map: map,
                    path: arr,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 4,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,


                }));

                polygons[polygons.length - 1].setMap(map);
                polygons[polygons.length - 1].set('info', i);


                var infowindow = new google.maps.InfoWindow();

                google.maps.event.addListener(polygons[polygons.length - 1], 'click', function (event) {
                    //alert(this.get('info'));
                    infowindow.setContent(this.get('info'));
                    infowindow.open(map);
                    infowindow.setPosition(event.latLng);
                });

                // alert(polygon.get("Info"));


            }

            // google.maps.event.addDomListener(window, 'load', initMap);
            //map.fitBounds(bounds);


            //google.maps.event.addListener(polygon, 'click', showArrays);
            //infoWindow = new google.maps.InfoWindow();
            //initialize();


        }


        google.maps.event.addDomListener(window, 'load', initialize);
        /*function showArrays(event) {
            alert("rrr");
          var contentString = '<b>Bermuda Triangle polygon</b><br>';

          // Replace the info window's content and position.
          infoWindow.setContent(contentString);
         infoWindow.setPosition(event.latLng);

          infoWindow.open(map);
        }*/

        // google.maps.event.addDomListener(window, 'load', initMap);


        //*******************************************************************************************************
        //*******************************************************************************************************
        //********************************************************************************************************
        //************************************************************************************************8 */
        var iconBase =
            'https://maps.google.com/mapfiles/ms/icons/';

        var icons = [iconBase + 'red-dot.png', iconBase + 'blue-dot.png', iconBase + 'green-dot.png'];

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
                icon: icons[marker[4] - 1],
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


        $(function () {
            $('#tracking_date').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                autoHide: true,
                zIndex: 9999,
            });
        });


    </script>


@endsection




