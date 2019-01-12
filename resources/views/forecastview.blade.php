<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weather</title>
<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1542186754" />


<link rel="stylesheet" href="{{asset('assets/css/weather.css')}} ">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}} "/>


<style>
  body{
    overflow-x:hidden;
    overflow-y:hidden;
  }
  .front-page-description
  {
    color:#202A34;
  }
</style>
</head>
<body id="weather-background" class="lightning-canvas">


<canvas id="rain-canvas"> </canvas>
<canvas id="cloud-canvas"> </canvas>
<canvas id="weather-canvas"> </canvas>
<canvas id="time-canvas"> </canvas>
<canvas id="lightning-canvas"> </canvas>
<div class="container" id='weatherSelect'>

<div id="front-page-description" class="front-page-description">
  <div class="row">
  <div class="col-md-12">
  <h1> {{ $forecast['hourly_forecast']->city }} - {{ $forecast['hourly_forecast']->state }} - {{ $forecast['hourly_forecast']->country }}</h1>
      <h3>Hourly Forecast</h3>
  <h5 style=''> Latitude : {{ $forecast['hourly_forecast']->latitude }} - Longitude : {{ $forecast['hourly_forecast']->longitude }}</h5>

  </div>
  </div>
 
  <div class="links row" style='margin-left: 112px;'>
  <br>
  <div class="">
  @if (count($forecast['hourly_forecast']->forecast))
    <table class="table table-sm">
      <thead>
      <tr>
        
        <th scope="col">Day Light</th>
        <th scope="col">Week Day</th>
        <th scope="col">Weather</th>
        <th scope="col">Humidity</th>
        <th scope="col">Wind Speed</th>
        <th scope="col">Date Time</th>
        <th scope="col">Temperature</th>
        
      </tr>
      </thead>
      <tbody>
      @foreach (array_slice($forecast['hourly_forecast']->forecast,0,8) as $f)
        <tr>
          <th scope="row">
            <img width=24 src="{{ $f->iconLink }}">
          </th>
          <td>{{$f->weekday}}</td>
          <td>{{ $f->description }}</td>
          <td>{{$f->humidity}}</td>
          <td>{{$f->windSpeed}}</td>
          
          <td>{{ Carbon\Carbon::createFromFormat("HmdY", $f->localTime) }}</td>
          <td> {{ $f->temperature }}&deg;</td>

        </tr>
      @endforeach
      </tbody>
    </table>

  @else
    <li>Sorry my dear friend, no forecast here.</li>
  @endif
  </div>

</div>
<div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10">
      @foreach($forecast['astronomy_forecast'] as $f)
        <?php $day = date_parse($f->utcTime);
        $day1 =  date_parse(gmdate("Y-m-d H:i:s"));
       $var =$day1['day'];
         $foo = $day['day'] ;
        if($var== $foo)
        {
          echo '<span> Sunrise - '.$f->sunrise."</span> Date -"."<span>".gmdate("Y-m-d")."</span>";
          echo ' |<span> Sunset - '.$f->sunset."</span>  Date -"."<span>".gmdate("Y-m-d")."</span>";
        }
        
        ?>
       
       
      @endforeach
      
      <?php // echo $forecast['astronomy_forecast'][0]->utcTime;?>

      </div>
      <div class="col-md-1"></div>
  </div>
<!-- Footer -->
<footer class="page-footer font-small blue">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">Develop By:
    <a href="#" style='text-decoration:none;'>Alam Riku</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
</div>

<div id="weather" class="weather middle hide">
  <div class="location" id="location"></div>
  <div class="weather-container">
    <div id="temperature-info" class="temperature-info">
      <div class="temperature" id="temperature"></div>
      <div class="weather-description" id="weather-description"></div>
    </div>
    <div class="weather-box">
      <ul class="weather-info" id="weather-info">
        <li class="weather-item humidity">Humidity: <span id="humidity"></span>%</li>
        <!--
                     -->
        <li class="weather-item wind">Wind: <span id="wind-direction"></span> <span id="wind"></span> <span id="speed-unit"></span></li>
      </ul>
    </div>
    <div class="temp-change">
      <button id="celsius" class="temp-change-button celsius">&deg;C</button>
      <button id="fahrenheit" class="temp-change-button fahrenheit">&deg;F</button>
    </div>
  </div>
</div>

</div>

<div style="width: 640px; height: 480px" id="mapContainer"></div>





<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>

<script type='text/javascript' src="{{asset('assets/js/jquery-3.2.1.js')}}"></script>
<script type='text/javascript' src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script type='text/javascript' src="{{asset('assets/js/weather.js')}}"></script>
<script >
 
  
    
  /*  var platform = new H.service.Platform({
        app_id: 'devportal-demo-20180625',
        app_code: '9v2BkviRwi9Ot26kp2IysQ',
    });

   
    var maptypes = platform.createDefaultLayers();

    
    var map = new H.Map(
    document.getElementById('mapContainer'),
    maptypes.normal.map,
    {
      zoom: 10,
      center: { lng: 91.8342, lat:22.3455 }
    });
 */
</script>

</body>
</html>