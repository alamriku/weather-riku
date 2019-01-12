<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Cache;
use \Log;
use Carbon\Carbon;
class WeatherController extends Controller
{
    public function weather()
    {
       // $forecast = [];
      //  return view('forecastview',['forecast'=>$forecast]);
      $minutes = 60;
      $forecast = Cache::remember('forecast', $minutes, function () {
        Log::info("Not from cache");
        $app_id = config("here.app_id");
        $app_code = config("here.app_code");
        $lat = config("here.lat_default");
        $lng = config("here.lng_default");
        $url_hourly = "https://weather.api.here.com/weather/1.0/report.json?product=forecast_hourly&latitude=${lat}&longitude=${lng}&oneobservation=true&language=en&app_id=${app_id}&app_code=${app_code}";
        $url_astronomy = "https://weather.api.here.com/weather/1.0/report.json?product=forecast_astronomy&latitude=${lat}&longitude=${lng}&oneobservation=true&language=en&app_id=${app_id}&app_code=${app_code}";
        $url = array($url_hourly,$url_astronomy);
        Log::info($url_hourly);
        $client = new \GuzzleHttp\Client();
        $hourly_response = $client->get($url_hourly);
        $astronomy_response = $client->get($url_astronomy);
        
        
     if ($hourly_response->getStatusCode() == 200 && $astronomy_response->getStatusCode() ==200) {
          $hourly = $hourly_response->getBody();
          $hourly_obj = json_decode($hourly);
          $astronomy = $astronomy_response->getBody();
          $astronomy_obj = json_decode($astronomy);
          $hourly_forecast = $hourly_obj->hourlyForecasts->forecastLocation;
          $astronomy_forecast = $astronomy_obj->astronomy->astronomy;
          
        }
        //echo "<pre>";
       // var_dump($hourly_forecast);
        
        
        $forecast = array('hourly_forecast'=>$hourly_forecast,'astronomy_forecast'=>$astronomy_forecast);
        //var_dump($forecast[1]);
        //exit();
        return $forecast;
      });
        return view('forecastview',['forecast'=>$forecast]);
    }
}
