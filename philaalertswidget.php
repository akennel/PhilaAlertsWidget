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

<head>
<!-- Latest compiled and minified CSS -->
<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
	function ShowDate() {
		var currentDate = new Date()
		var day = currentDate.getDate()
		var month = currentDate.getMonth() + 1
		var year = currentDate.getFullYear()
		document.getElementById('PhilaAlertsDateBlock').innerHTML = "<b>" + day + "/" + month + "/" + year + "</b>";
	}
</script>

<script type="text/javascript">
    $(document).ready(function () {	
		ShowDate();
    });
</script>

</head>

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
$calculatedContent .= "	<span id=\"PhilaAlertsMainWindow\">";
$calculatedContent .= "<div id =\"PhilaAlertsDateBlock\">DateTime</div>";
$calculatedContent .= "<div id=\"PhilaAlertsIconsBlock\">";

if (CheckForActiveAlerts("weatheralerts")) {
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Weather-Alerts\"><span class=\"glyphicon glyphicon-cloud PhilaAlertIconActiveColor\"></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Weather-Alerts\"><span class=\"glyphicon glyphicon-cloud PhilaAlertIconInactiveColor\"></span></a>";
}

if (CheckForActiveAlerts("transitalerts")) {
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Transit-Alerts\"><span class=\"glyphicon glyphicon-plane PhilaAlertIconActiveColor\"></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Transit-Alerts\"><span class=\"glyphicon glyphicon-plane PhilaAlertIconInactiveColor\"></span></a>";
}

if (CheckForActiveAlerts("trashalerts")) {
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Collection-Alerts\"><span class=\"glyphicon glyphicon-trash PhilaAlertIconActiveColor\"></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Collection-Alerts\"><span class=\"glyphicon glyphicon-trash PhilaAlertIconInactiveColor\"></span></a>";
}

if (CheckForActiveAlerts("streetalerts")) {
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Closure-Alerts\"><span class=\"glyphicon glyphicon-road PhilaAlertIconActiveColor\"></span></a>";
}
else{
$calculatedContent .= "<a href=\"http://alpha.phila.gov/Closure-Alerts\"><span class=\"glyphicon glyphicon-road PhilaAlertIconInactiveColor\"></span></a>";
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
	
	echo $activeAlert;
	$args=array(
      'tag' => $tagName,
	  'category' => 'Display on Front Page',
      'showposts'=>5,
      'caller_get_posts'=>1
    );
    $my_query = new WP_Query($args);
	
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
