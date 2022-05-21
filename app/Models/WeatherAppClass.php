<?php

namespace App\Models;

use Validator;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class WeatherAppClass extends Model
{
    public function getCurrentWeather($latitude, $longitude){

        $openWeatherAppUrl = env('OPEN_WEATHER_API_URL', '');

        $data = [
            'weatherUrl' => $openWeatherAppUrl,
            'latitude'   => $latitude,
            'longitude'  => $longitude,
        ];

        $validator = Validator::make($data, [
            'weatherUrl'  => 'required',
            'latitude'    => 'required',
            'longitude'   => 'required',
        ]);

        if($validator->fails()){
            $errors = $validator->errors();

            foreach ($errors->all() as $message){
                throw new Exception($message);
            }
        }

        $fullUrl = sprintf($openWeatherAppUrl, $latitude, $longitude);

        $client = new Client();
        $result = $client->get($fullUrl);
        $result = json_decode($result->getBody()->getContents(), true);

        return !empty($result) ? $this->formatWeatherData($result) : []; 
    }

    public function formatWeatherData($item){
        if(empty($item)){
            return [];
        }

        $sunrise     = Carbon::parse($item['sys']['sunrise'])->setTimezone('Asia/Manila')->format('h:iA');
        $sunset      = Carbon::parse($item['sys']['sunset'])->setTimezone('Asia/Manila')->format('h:iA');
        $weatherDate = Carbon::parse($item['dt'])->setTimezone('Asia/Manila')->format('l, d M Y');

        $data = [
            'location'      => $item['name'].', '.$item['sys']['country'],
            'desription'    => strtoupper($item['weather'][0]['description']),
            'fahrenheit'    => $this->kelvinToFahrenheit($item['main']['temp']),
            'minFahrenheit' => $this->kelvinToFahrenheit($item['main']['temp_min']),
            'maxFahrenheit' => $this->kelvinToFahrenheit($item['main']['temp_max']),
            'celsius'       => $this->kelvinToCelsius($item['main']['temp']),
            'minCelsius'    => $this->kelvinToCelsius($item['main']['temp_min']),
            'maxCelsius'    => $this->kelvinToCelsius($item['main']['temp_max']),
            'pressure'      => number_format($item['main']['pressure'], 0, '.', ','),
            'humidity'      => $item['main']['humidity'],
            'sunrise'       => $sunrise,
            'sunset'        => $sunset,
            'weatherDate'   => $weatherDate,
            'weatherIcon'   => $item['weather'][0]['icon']
        ];

        return $data;
    }

    private function kelvinToFahrenheit($kelvin){
        $fahrenheit = 9/5*($kelvin-273.15)+32;

        return round($fahrenheit, 0);
    }

    private function kelvinToCelsius($kelvin){
        $celsius = $kelvin-273.15;
	    
        return round($celsius, 0);
    }
}
