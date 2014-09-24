<?php
/* Plugin Name: Phila Alerts Widget
Plugin URI: localhost/wordpress
Description: Front Page Widget, active alerts with links to related pages.
Version: 1.0
Author: Andrew Kennel
Author URI: localhost/wordpress
*/
defined('ABSPATH') or die("safety first");

add_shortcode('PhilaAlertsWidget', 'philaAlertsWidget_handler');

function philaAlertsWidget_handler(){
$topOfMessage = <<<EOM

<link rel="stylesheet" type="text/css" href="wp-content/plugins/PhilaAlertsWidget/weather-icons/css/weather-icons.css">
<script type="text/javascript">

EOM;

$weatherInfo = philaAlertWidgetGetStartingWeather();

$calculatedContent = "<div id=\"PhilaAlertsWidget\">";
$calculatedContent .= "<span id=\"PhilaAlertsMainWindow\">";
$calculatedContent .= "<div class=\"row\">";
$calculatedContent .= "<div id=\"PhilaAlertsDateTimeBlock\" class=\"col-md-8 hidden-xs hidden-sm\">";
$calculatedContent .= "<span id=\"clock\">Time</span> - ";
$calculatedContent .= "<span id=\"date\">Date</span>";
$calculatedContent .= "</div>";
$calculatedContent .= "<div class=\"col-md-16  col-xs-24\">";
$calculatedContent .= "<div id=\"PhilaAlertsIconsBlock\">";
$calculatedContent .= "<h1 class=\"alerts hidden-xs\">Alerts:</h1>";

if (CheckForActiveAlerts("Weather Alert")) {
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Weather-Alerts\"><span class=\"weather-alert active-alert\"><span id=\"alert-text\">" . $weatherInfo . "</span></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Weather-Alerts\"><span class=\"weather-alert\"><span id=\"alert-text\">" . $weatherInfo . "</span></span></a>";
}

if (CheckForActiveAlerts("Transit Alert")) {
$calculatedContent .= "<a href=\"http://www.septa.org/realtime/status/system-status.shtml\"><span class=\"transit-alert active-alert\"><span class=\"alert-text\">Transit</span></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://www.septa.org/realtime/status/system-status.shtml\"><span class=\"transit-alert\"><span class=\"alert-text\">Transit</span></span></a>";
}

if (CheckForActiveAlerts("Trash Collection Alert")) {
$calculatedContent .= "<a href=\"http://www.philadelphiastreets.com/sanitation/residential/collection-schedules\"><span class=\"trash-alert active-alert\"><span class=\"alert-text\">Collection</span></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://www.philadelphiastreets.com/sanitation/residential/collection-schedules\"><span class=\"trash-alert\"><span class=\"alert-text\">Collection</span></span></a>";
}

if (CheckForActiveAlerts("Street Closure Alert")) {
$calculatedContent .= "<a href=\"http://www.phila.gov/MDO/SpecialEvents/Pages/StreetClosures.aspx\"><span class=\"street-alert active-alert\"><span class=\"alert-text\">Closures</span></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://www.phila.gov/MDO/SpecialEvents/Pages/StreetClosures.aspx\"><span class=\"street-alert\"><span class=\"alert-text\">Closures</span></span></a>";
}

$calculatedContent .= "</div>";
$calculatedContent .= "</div>";
$calculatedContent .= "</div>";
$calculatedContent .= "	</span>";
$calculatedContent .= "</div>";
$calculatedContent .= "</body>";

$code = $topOfMessage;
$code .= $calculatedContent;
return $code;
}

function CheckForActiveAlerts($tagName) {
	$activeAlert = False;
	
	$frontPageCategory_id = get_cat_ID('Display on Front Page');
	$tagCategory_id = get_cat_ID($tagName);
	
	$my_query = new WP_Query( array( 'category__and' => array( $frontPageCategory_id, $tagCategory_id ) ) );
    if( $my_query->have_posts() ) {
		
		$activeAlert = True;
	}
	
	return $activeAlert;
}

function philaAlertWidgetGetStartingWeather(){
	$weatherIcon = "";
	$weatherFeedURL = "http://forecast.weather.gov/MapClick.php?lat=39.9524909&lon=-75.163589&FcstType=json";
	
	$data = PhilaWeatherGetFeed($weatherFeedURL);
	//$data = PhilaWeatherGetFeedFromProxy($weatherFeedURL);
	//foreach ($data->currentobservation->Weather as $item)
	//{
	//	$array_item = (array) $item;
	//	
	//	$title = (array) $item->title;		
	//	$start = $array_item['gd$when'][0]->startTime;			
	//	
	//	$eventArray[] = array('title' => $title['$t'], 'startDate' => $start);
	//}
	
	$currentWeatherDesc = $data->currentobservation->Weather;
	$currentWeatherTemp = $data->currentobservation->Temp;
	
	$currentWeather = strtolower($currentWeatherDesc);
	
	if (strpos($currentWeather, 'sunny') !== FALSE)	
	{
		$weatherIcon = "<i class=\"wi wi-day-sunny\"></i>";
	}
	elseif (strpos($currentWeather, 'clear') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-day-sunny\"></i>";
	}
	else if (strpos($currentWeather, 'cloud') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-day-cloudy\"></i>";
	}
	else if (strpos($currentWeather, 'overcast') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-cloudy\"></i>";
	}
	else if (strpos($currentWeather, 'freezing') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-rain-mix\"></i>";
	}
	else if (strpos($currentWeather, 'rain') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-rain\"></i>";
	}
	else if (strpos($currentWeather, 'drizzle') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-sprinkle\"></i>";
	}
	else if (strpos($currentWeather, 'blizzard') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-snowflake-cold\"></i>";
	}
	else if (strpos($currentWeather, 'fog') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-fog\"></i>";
	}
	else if (strpos($currentWeather, 'haze') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-day-fog\"></i>";
	}
	else if (strpos($currentWeather, 'snow') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-snow\"></i>";
	}
	else if (strpos($currentWeather, 'ice') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-rain-mix\"></i>";
	}
	else if (strpos($currentWeather, 'flurries') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-snow\"></i>";
	}
	else if (strpos($currentWeather, 'sleet') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-rain-mix\"></i>";
	}
	else if (strpos($currentWeather, 'wintry') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-rain-mix\"></i>";
	}
	else if (strpos($currentWeather, 'hail') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-hail\"></i>";
	}
	else if (strpos($currentWeather, 'shower') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-sprinkle\"></i>";
	}
	else if (strpos($currentWeather, 'storm') !== FALSE)
	{
		$weatherIcon = "<i class=\"wi wi-thunderstorm\"></i>";
	}
    else
    {
	$weatherIcon = "<i class=\"wi wi-day-sunny-overcast\"></i>";
	} 
	
	$weatherIcon .= " " . $currentWeatherTemp . "&#xb0;";
	
	return $weatherIcon;
}

function PhilaWeatherGetFeedFromProxy($url){
//Use local proxy server when runnign on dev machine
$aContext = array(
    'http' => array(
        'proxy' => 'tcp://127.0.0.1:3128',
        'request_fulluri' => true,
    ),
);
$cxContext = stream_context_create($aContext);
$data = json_decode(file_get_contents($url, True, $cxContext));

return $data;
}

function PhilaWeatherGetFeed($url){
//When running on server, no proxy is required
$data = json_decode(file_get_contents($url, True));

return $data;
}

function philaAlertsWidget($args, $instance) { // widget sidebar output
  extract($args, EXTR_SKIP);
  echo $before_widget; // pre-widget code from theme
  echo philaAlertsWidget_handler();
  echo $after_widget; // post-widget code from theme
}

function alerts_bar() {
	wp_enqueue_script(
		'alerts',
		plugins_url( '/js/alerts.js' , __FILE__ ),
		array( 'jquery' )
	);
}

add_action( 'wp_enqueue_scripts', 'alerts_bar' );