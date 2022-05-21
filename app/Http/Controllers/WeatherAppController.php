<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

use App\Models\WeatherAppClass as WeatherApp;

class WeatherAppController extends Controller
{
    private $weatherApp;

    public function __construct(){
        $this->weatherApp = new WeatherApp();
    }

    public function getCurrentWeather(Request $request){
        try{
            $latitude  = $request->get('latitude', '');
            $longitude = $request->get('longitude', '');

            $result = $this->weatherApp->getCurrentWeather($latitude, $longitude);

            return response()->json([
                'status_code'    => 200,
                'status_message' => 'WEATHER_DETAILS',
                'data'           => $result
            ], 200);
        }
        catch(Exception $e) {
            return response([
                'status_code' => 400,
                'message'     => $e->getMessage(),
            ], 400);
        }
    }
}
