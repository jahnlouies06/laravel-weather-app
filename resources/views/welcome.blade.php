<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Laravel Weather App</title>
    
    <link rel="icon" name="app_icon" href="{{ asset('images/default_icon.png') }}" type="image/png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body id="weatherAppBody">
    <div id="weatherAppContainer" class="container mt-5">
        <div class="row" style="display: table;">
            <img id="appIcon" src="{{ asset('images/default_icon.png') }}"><h2 style="display: table-cell; vertical-align: middle;">Laravel Weather App</h2>
        </div>
        <div class="form-group">
            <label>This application allows you to search a specific location or click on the map to get the current weather forecast.</label>
            <input type="text" id="autocomplete" name="autocomplete" class="form-control" placeholder="Search location...">
        </div>
        <div class="row">
            <div id="weatherDetailsCard">
                <h3 id="weatherDate"></h3>
                <h1 id="weatherTemperature"></h1>
                <h6 id="weatherLocation"></h6>
                <img id="weatherIcon">
                <h2 id="weatherDesription"></h2>
                <h4 id="weatherMinMaxTemp"></h4>

                <div id="otherWeatherDetails">
                    <div id="cardDetails">
                        <span id="cardTitle">PRESSURE</span>
                        <br>
                        <br>
                        <h6 id="weatherPressure"></h6>
                    </div>
                    <div id="cardDetails">
                        <span id="cardTitle">HUMIDITY</span>
                        <br>
                        <br>
                        <h6 id="weatherHumidity"></h6>
                    </div>
                    <div id="cardDetails">
                        <span id="cardTitle">SUNRISE</span>
                        <br>
                        <br>
                        <h6 id="weatherSunrise"></h6>
                    </div>
                    <div id="cardDetails">
                        <span id="cardTitle">SUNSET</span>
                        <br>
                        <br>
                        <h6 id="weatherSunset"></h6>
                    </div>
                </div>

                <div id="unitRadioButton">
                    <label>
                        <input type="radio" id="celsius" name="weatherUnit" value="celsius"> Celsius
                    </label>
                    <label>
                        <input type="radio" id="fahrenheit" name="weatherUnit" value="fahrenheit"> Fahrenheit
                    </label>
                </div>
            </div>
            <div id="map"></div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript"
        src="{{ env('GOOGLE_MAP_URL') }}">
    </script>
    <script>
        // Default Google Map View
        const appUrl = '{{ env('APP_URL') }}';
        const iconUrl = '{{ env('OPEN_WEATHER_ICON_URL') }}';
        const defaultMapLatitude  = '{{ env('DEFAULT_MAP_LATITUDE') }}';
        const defaultMapLongitude = '{{ env('DEFAULT_MAP_LONGITUDE') }}';

        const myLatLng = { lat: parseFloat(defaultMapLatitude), lng: parseFloat(defaultMapLongitude) };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: myLatLng,
            gestureHandling: 'greedy'
        });

        $(document).ready(function () {
            $("#weatherLocation").text("Please select location...");
            document.getElementById("weatherDetailsCard").style.height = "70px";
            document.getElementById("weatherIcon").style.visibility = "hidden";
            document.getElementById("otherWeatherDetails").style.visibility = "hidden";
            document.getElementById("unitRadioButton").style.visibility = "hidden";
        });
        
        $("input").on("keydown", function search(e) {
            if(e.keyCode == 13 && document.getElementById('autocomplete').value === '') {
                alert('Please select location.');
            }
        });
    </script>
    <script src="{{ asset('js/app.js' )}}"></script>
</body>
</html>