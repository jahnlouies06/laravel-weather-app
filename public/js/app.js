google.maps.event.addDomListener(window, 'load', initialize);
        
function initialize() {
    var input = document.getElementById('autocomplete');
    var autocomplete = new google.maps.places.Autocomplete(input);
    
    // Configure the Search Location change
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();

        let latitude = place.geometry['location'].lat();
        let longitude = place.geometry['location'].lng();
        let pinTitle = place.formatted_address;

        document.getElementById("weatherDetailsCard").style.height = "auto";
        document.getElementById("weatherIcon").style.visibility = "visible";
        document.getElementById("otherWeatherDetails").style.visibility = "visible";
        document.getElementById("unitRadioButton").style.visibility = "visible";
        document.getElementById('celsius').setAttribute('checked', 'true');

        // Get Location's Weather Details
        fetch(appUrl + '/api/weatherDetails?' + new URLSearchParams({
            latitude: latitude,
            longitude: longitude
        }), {
            method: 'GET', 
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            let weatherDetails = data.data;
            let weatherDate = weatherDetails.weatherDate;
            let weatherCelsius = weatherDetails.celsius;
            let weatherMinCelsius = weatherDetails.minCelsius;
            let weatherMaxCelsius = weatherDetails.maxCelsius;
            let weatherFahrenheit = weatherDetails.fahrenheit;
            let weatherMinFahrenheit = weatherDetails.minFahrenheit;
            let weatherMaxFahrenheit = weatherDetails.maxFahrenheit;
            let weatherDesription = weatherDetails.desription;
            let weatherPressure = weatherDetails.pressure;
            let weatherHumidity = weatherDetails.humidity;
            let weatherSunrise = weatherDetails.sunrise;
            let weatherSunset = weatherDetails.sunset;
            let weatherIcon = weatherDetails.weatherIcon;

            // Check Radio Button Value Upon Changing Location
            if(document.getElementById('celsius').checked === true){
                $('#weatherTemperature').text(weatherCelsius + '°C');
                $('#weatherMinMaxTemp').text('H:' + weatherMinCelsius + '°C L:' + weatherMaxCelsius + '°C');
            }
            else if(document.getElementById('fahrenheit').checked === false){
                $('#weatherTemperature').text(weatherFahrenheit + '°F');
                $('#weatherMinMaxTemp').text('H:' + weatherMinFahrenheit + '°F L:' + weatherMaxFahrenheit + '°F');
            }
            
            $('#weatherDate').text(weatherDate);
            $('#weatherLocation').text(pinTitle);
            $('#weatherDesription').text(weatherDesription);
            $('#weatherPressure').text(weatherPressure + ' hPa');
            $('#weatherHumidity').text(weatherHumidity + '%');
            $('#weatherSunrise').text(weatherSunrise);
            $('#weatherSunset').text(weatherSunset);

            document.getElementById('weatherIcon').src = iconUrl + weatherIcon + '@2x.png';

            // Check Unit Radio Button Upon Clicking
            $('input[type=radio]').click(function(e) {
                var unit = $(this).val();

                if(unit === 'celsius'){
                    $('#weatherTemperature').text(weatherCelsius + '°C');
                    $('#weatherMinMaxTemp').text('H:' + weatherMinCelsius + '°C L:' + weatherMaxCelsius + '°C');
                }
                else if(unit === 'fahrenheit'){
                    $('#weatherTemperature').text(weatherFahrenheit + '°F');
                    $('#weatherMinMaxTemp').text('H:' + weatherMinFahrenheit + '°F L:' + weatherMaxFahrenheit + '°F');
                }
            });

            // Place Marker in Map
            const myLatLng = { lat: latitude, lng: longitude };
            placeMarkerAndPanTo(myLatLng, map, pinTitle);
        })
    });

    // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {
        let latitude = mapsMouseEvent.latLng.lat();
        let longitude = mapsMouseEvent.latLng.lng();

        document.getElementById("weatherDetailsCard").style.height = "auto";
        document.getElementById("weatherIcon").style.visibility = "visible";
        document.getElementById("otherWeatherDetails").style.visibility = "visible";
        document.getElementById("unitRadioButton").style.visibility = "visible";
        document.getElementById('celsius').setAttribute('checked', 'true');

        // Get Location's Weather Details
        fetch(appUrl + '/api/weatherDetails?' + new URLSearchParams({
            latitude: latitude,
            longitude: longitude
        }), {
            method: 'GET', 
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            let weatherDetails = data.data;
            let location = weatherDetails.location;
            let weatherDate = weatherDetails.weatherDate;
            let weatherCelsius = weatherDetails.celsius;
            let weatherMinCelsius = weatherDetails.minCelsius;
            let weatherMaxCelsius = weatherDetails.maxCelsius;
            let weatherFahrenheit = weatherDetails.fahrenheit;
            let weatherMinFahrenheit = weatherDetails.minFahrenheit;
            let weatherMaxFahrenheit = weatherDetails.maxFahrenheit;
            let weatherDesription = weatherDetails.desription;
            let weatherPressure = weatherDetails.pressure;
            let weatherHumidity = weatherDetails.humidity;
            let weatherSunrise = weatherDetails.sunrise;
            let weatherSunset = weatherDetails.sunset;
            let weatherIcon = weatherDetails.weatherIcon;

            // Check Radio Button Value Upon Changing Location
            if(document.getElementById('celsius').checked === true){
                $('#weatherTemperature').text(weatherCelsius + '°C');
                $('#weatherMinMaxTemp').text('H:' + weatherMinCelsius + '°C L:' + weatherMaxCelsius + '°C');
            }
            else if(document.getElementById('fahrenheit').checked === false){
                $('#weatherTemperature').text(weatherFahrenheit + '°F');
                $('#weatherMinMaxTemp').text('H:' + weatherMinFahrenheit + '°F L:' + weatherMaxFahrenheit + '°F');
            }
            
            $('#weatherDate').text(weatherDate);
            $('#weatherLocation').text(location);
            $('#weatherDesription').text(weatherDesription);
            $('#weatherPressure').text(weatherPressure + ' hPa');
            $('#weatherHumidity').text(weatherHumidity + '%');
            $('#weatherSunrise').text(weatherSunrise);
            $('#weatherSunset').text(weatherSunset);

            document.getElementById("autocomplete").value = location;
            document.getElementById('weatherIcon').src = iconUrl + weatherIcon + '@2x.png';

            // Check Unit Radio Button Upon Clicking
            $('input[type=radio]').click(function(e) {
                var unit = $(this).val();

                if(unit === 'celsius'){
                    $('#weatherTemperature').text(weatherCelsius + '°C');
                    $('#weatherMinMaxTemp').text('H:' + weatherMinCelsius + '°C L:' + weatherMaxCelsius + '°C');
                }
                else if(unit === 'fahrenheit'){
                    $('#weatherTemperature').text(weatherFahrenheit + '°F');
                    $('#weatherMinMaxTemp').text('H:' + weatherMinFahrenheit + '°F L:' + weatherMaxFahrenheit + '°F');
                }
            });

            // Place Marker in Map
            placeMarkerAndPanTo(mapsMouseEvent.latLng, map, location);
        })
    });
}

function placeMarkerAndPanTo(latLng, map, pinTitle){
    new google.maps.Marker({
        map: map,
        position: latLng,
        title: pinTitle,
        animation: google.maps.Animation.DROP,
    });

    map.setZoom(15);
    map.panTo(latLng);
}

window.initialize = initialize;