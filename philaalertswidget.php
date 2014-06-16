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
    $message = <<<EOM

<head>
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
	function GetRecent() {
		var recentAPI = "http://www.publicstuff.com/api/open311/services.json?jurisdiction_id=philadelphia-pa";
		
		$.ajax({
                url:        recentAPI,
                dataType:   "json", // <== JSON-P request
                success:    function(data){
					$("#Phila311RecentList").empty();
					var i = 0;
					while(i < 3)
					{
						var newEntry = "<p><strong>" + data[i].group + ": " + data[i].service_name + "</p></strong><p>" + data[i].description + "</p>";
						$("#Phila311RecentList").append(newEntry);
						i++;
					}
                }
        });
	}
</script>

<script type="text/javascript">
    $(document).ready(function () {	
		GetRecent();
    });
</script>

</head>

<style>

#Phila311LinkBlock{
float:left;
}

#Phila311MapBlock{
float:left;
}

#Phila311RecentBlock{
float:left;
}

</style>

<div id="Phila311Widget">
	<span id="Phila311MainWindow">
		<h1>Philly 311</h1>
		<div id="Phila311LinkBlock">
		<p><a href="http://www.publicstuff.com/pa/philadelphia-pa/report-issues">Submit New Request</a></p>
		<p><a href="http://www.publicstuff.com/pa/philadelphia-pa/issues">Track Request</a></p>
		<p><a href="http://www.publicstuff.com/pa/philadelphia-pa/newsfeed">News</a></p>
		</div>
		<div id="Phila311RecentBlock">
			<h4>Recent Requests</h4>
			<ul id="Phila311RecentList">
			</ul>
		</div>
	</span>
</div>


EOM;

return $message;
}

function philaAlertsWidget($args, $instance) { // widget sidebar output
  extract($args, EXTR_SKIP);
  echo $before_widget; // pre-widget code from theme
  echo philaAlertsWidget_handler();
  echo $after_widget; // post-widget code from theme
}
?>
