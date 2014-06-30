<?php
/* Plugin Name: Phila Alerts Widget
Plugin URI: localhost/wordpress
Description: Front Page Widget, active alerts with links to related pages.
Version: 1.0
Author: Andrew Kennel
Author URI: localhost/wordpress
*/
add_shortcode('PhilaAlertsWidget', 'philaAlertsWidget_handler');

function philaAlertsWidget_handler(){
$topOfMessage = <<<EOM
<script type="text/javascript">
   function updateClock(){
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var weekDay = 

        //add 0 to beginning of minutes/seconds
        // ? - returns value before before : if true or after : if false (if statement shorthand)
        minutes = ( minutes < 10 ? "0" : "" ) + minutes;

        var timeOfDay = ( hours < 12 ) ? "AM" : "PM";
        //make 12 hour day
        hours = ( hours > 12 ) ? hours - 12 : hours;
        //show "12" instead of "0" at midnight
        hours = ( hours == 0 ) ? 12 : hours;

        //stick it all together
        var currentTimeString = hours + ":" + minutes + " " + timeOfDay;

        //add the clock to the ID this needs the &nbsp; to work - not sure why
        document.getElementById("clock").firstChild.nodeValue = currentTimeString;
	}
</script>
<script type="text/javascript">
   function updateDate(){
		var currentTime = new Date();
        
        var weekday = new Array(7);
            weekday[0]=  "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";
        
        var month_name=new Array(12);
         month_name[0]="January"
         month_name[1]="February"
         month_name[2]="March"
         month_name[3]="April"
         month_name[4]="May"
         month_name[5]="June"
         month_name[6]="July"
         month_name[7]="August"
         month_name[8]="September"
         month_name[9]="October"
         month_name[10]="November"
         month_name[11]="December";
		 var currentDateString =  weekday[currentTime.getDay()] + ", " + month_name[currentTime.getMonth()]+" "+currentTime.getDate()+", "+currentTime.getFullYear();
		 var dateNode = document.getElementById("date");
		 document.getElementById("date").firstChild.nodeValue = currentDateString;
   }
</script>   
<script type="text/javascript">
jQuery(document).ready(function($) {	
		updateDate();
		setInterval('updateClock()', 1000);
    });
</script>
<style>

.PhilaAlertIconActiveColor{
color: red;
font-size: 200%;
}

.PhilaAlertIconInactiveColor{
color: green;
font-size: 200%;
}

#PhilaAlertsDateBlock{
float:left;
}

#PhilaAlertsIconBlock{
float:right;
}

</style>

<body>

EOM;

$calculatedContent = "<div id=\"PhilaAlertsWidget\">";
$calculatedContent .= "<span id=\"PhilaAlertsMainWindow\">";
$calculatedContent .= "<div id=\"PhilaAlertsDateTimeBlock\">";
$calculatedContent .= "<span id=\"date\">Date</span><br>";
$calculatedContent .= "<span id=\"clock\">Time</span>";
$calculatedContent .= "</div>";
$calculatedContent .= "<div id=\"PhilaAlertsIconsBlock\">";

if (CheckForActiveAlerts("Weather Alert")) {
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Weather-Alerts\"><span class=\"glyphicon glyphicon-cloud PhilaAlertIconActiveColor\"></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Weather-Alerts\"><span class=\"glyphicon glyphicon-cloud PhilaAlertIconInactiveColor\"></span></a>";
}

if (CheckForActiveAlerts("Transit Alert")) {
$calculatedContent .= "<a href=\"http://www.septa.org/realtime/status/system-status.shtml\"><span class=\"glyphicon glyphicon-plane PhilaAlertIconActiveColor\"></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://www.septa.org/realtime/status/system-status.shtml\"><span class=\"glyphicon glyphicon-plane PhilaAlertIconInactiveColor\"></span></a>";
}

if (CheckForActiveAlerts("Trash Collection Alert")) {
$calculatedContent .= "<a href=\"http://www.philadelphiastreets.com/sanitation/residential/collection-schedules\"><span class=\"glyphicon glyphicon-trash PhilaAlertIconActiveColor\"></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://www.philadelphiastreets.com/sanitation/residential/collection-schedules\"><span class=\"glyphicon glyphicon-trash PhilaAlertIconInactiveColor\"></span></a>";
}

if (CheckForActiveAlerts("Street Closure Alert")) {
$calculatedContent .= "<a href=\"http://www.phila.gov/MDO/SpecialEvents/Pages/StreetClosures.aspx\"><span class=\"glyphicon glyphicon-road PhilaAlertIconActiveColor\"></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://www.phila.gov/MDO/SpecialEvents/Pages/StreetClosures.aspx\"><span class=\"glyphicon glyphicon-road PhilaAlertIconInactiveColor\"></span></a>";
}

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

function philaAlertsWidget($args, $instance) { // widget sidebar output
  extract($args, EXTR_SKIP);
  echo $before_widget; // pre-widget code from theme
  echo philaAlertsWidget_handler();
  echo $after_widget; // post-widget code from theme
}
?>
