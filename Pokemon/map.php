<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pokemon Nanaimo Map!</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
    <!-- old version of JQuery! -->
    <!-- <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script> -->
    <script>
        var map;
        var myMarkers = [];

        function initMap() {
            var nanaimo = {
                lat: 49.159700,
                lng: -123.907750
            };
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: nanaimo
            });
        }

        function clearMarkers() {
            for (var i = 0; i < myMarkers.length; i++) {
                myMarkers[i].setMap(null);
            }
            myMarkers = [];
        }

        $(document).ready(function() {

            console.log("Document ready!");

            $('#reset').click(function() {

                // remove any previous markers
                clearMarkers();
                var showData = $('#show-data');
                showData.empty();
                var pokeData = $('#poke-data');
                var url = 'getPokemon.php?reset=true';
                var data = {};
                $.getJSON(url, data, function(data, status) {
                    console.log("Back from the reset");

                    try {
                        $.getJSON(url, data, function(data, status) {
                            console.log("Ajax call completed, status is: " + status);

                            // show the  message from the data
                            $msg = data.message;
                            showData.html($msg);

                            $data = data.pokedata;
                            pokeData.html($data);

                            //console.log("Setting up markers");

                            data.markers.forEach(function(marker) {
                                //console.log("Creating marker on map");
                                var myLatlng = new google.maps.LatLng(marker.lat, marker.long);

                                //var image = marker.image;

                                var myIcon = new google.maps.MarkerImage(("images/" + marker.image), null, null, null, new google.maps.Size(40, 40));

                                var mmarker = new google.maps.Marker({
                                    position: myLatlng,
                                    map: map,
                                    title: marker.name,
                                    icon: myIcon
                                });

                                // add this marker to our array of markers
                                myMarkers.push(mmarker);
                            });
                        })
                    } catch (error) {
                        console.log("Error requesting JSON data: " + error);
                    }
                });
            });

            $('#get-data').click(function() {

                // remove any previous markers
                // DC: note this might be somewhat inefficient.. for performance you might have to keep an index
                // of which marker is for which pokemon, and update the lat and long accordingly
                clearMarkers();

                var showData = $('#show-data');
                showData.empty();

                var pokeData = $('#poke-data');
                pokeData.empty();

                var url = 'getPokemon.php';
                var data = {
                    q: 'search',
                    text: 'not implemented yet!'
                };
                console.log("Sending request for Pokemon marker list...");

                try {
                    $.getJSON(url, data, function(data, status) {
                        console.log("Ajax call completed, status is: " + status);

                        // show the  message from the data
                        $msg = data.message;
                        showData.html($msg);

                        $data = data.pokedata;
                        pokeData.html($data);

                        //console.log("Setting up markers");

                        data.markers.forEach(function(marker) {
                            //console.log("Creating marker on map");
                            var myLatlng = new google.maps.LatLng(marker.lat, marker.long);

                            var myIcon = new google.maps.MarkerImage(("images/" + marker.image), null, null, null, new google.maps.Size(40, 40));

                            var mmarker = new google.maps.Marker({
                                position: myLatlng,
                                map: map,
                                title: marker.name,
                                icon: myIcon
                            });

                            // add this marker to our array of markers
                            myMarkers.push(mmarker);
                        });
                    })
                } catch (error) {
                    console.log("Error requesting JSON data: " + error);
                }

            });
        });
    </script>
</head>

<body>
    <div id="map" style="width: 800px; height: 600px"></div>
    <a href="#map" id="get-data">Attack! (one round)</a>
    <br>
    <a href="#map" id="reset">Reset Map</a>

    <div id="show-data"></div>
    <div id="poke-data"></div>

    <!-- NOTE this google map is using an ITAS Google Map key! Do not use for any of your private applications hosted live anywhere-->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGSxLOCh-pWE4dUZeMw4yvpgAa0fqLBjg&callback=initMap">
    </script>


</body>

</html>