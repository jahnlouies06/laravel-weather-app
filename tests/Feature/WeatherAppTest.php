<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherAppTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testWebViewPage(){
        $view = $this->view('welcome');
        $view->assertSee('Laravel Weather App');
    }

    public function testSuccessfullRequest(){
        $this->json('GET', 'http://127.0.0.1:8000/api/weatherDetails?latitude=14.702044&longitude=121.065915')
            ->assertStatus(200)
            ->assertJsonStructure([
                "status_code",
                "status_message",
                "data" => [
                    "location",
                    "desription",
                    "fahrenheit",
                    "minFahrenheit",
                    "maxFahrenheit",
                    "celsius",
                    "minCelsius",
                    "maxCelsius",
                    "pressure",
                    "humidity",
                    "sunrise",
                    "sunset",
                    "weatherDate",
                    "weatherIcon"
                ]
        ]);
    }

    public function testMissingLatitude(){
        $this->json('GET', 'http://127.0.0.1:8000/api/weatherDetails?longitude=121.065915')
            ->assertStatus(400)
            ->assertJsonStructure([
                "status_code",
                "message"
        ]);
    }

    public function testMissingLongitude(){
        $this->json('GET', 'http://127.0.0.1:8000/api/weatherDetails?latitude=14.702044')
            ->assertStatus(400)
            ->assertJsonStructure([
                "status_code",
                "message"
        ]);
    }
}
