jQuery(document).ready(function($) {
	function updateWeather(){
			var weatherFeedURL = "http://forecast.weather.gov/MapClick.php?lat=39.9524909&lon=-75.163589&FcstType=json";

			$.ajax({
				type: "POST",
				dataType: 'jsonp',
				url: weatherFeedURL,
				crossDomain : true,
				})
				.done(function( data ) {
					var weatherIcon = "";
					var currentWeather = data.currentobservation.Weather.toLowerCase();

					//Looks like string.contains isn't supported in older versions of javascript. This should do the same.
					//It returns a position of -1 if the string isn't found.
					if (currentWeather.indexOf("sunny") != -1)
					{
						weatherIcon = "<i class=\"wi wi-day-sunny\"></i>"
					}
					else if (currentWeather.indexOf("clear") != -1)
					{
						weatherIcon = "<i class=\"wi wi-day-sunny\"></i>"
					}
					else if (currentWeather.indexOf("cloud") != -1)
					{
						weatherIcon = "<i class=\"wi wi-day-cloudy\"></i>"
					}
					else if (currentWeather.indexOf("overcast") != -1)
					{
						weatherIcon = "<i class=\"wi wi-cloudy\"></i>"
					}
					else if (currentWeather.indexOf("freezing") != -1)
					{
						weatherIcon = "<i class=\"wi wi-rain-mix\"></i>"
					}
					else if (currentWeather.indexOf("rain") != -1)
					{
						weatherIcon = "<i class=\"wi wi-rain\"></i>"
					}
					else if (currentWeather.indexOf("drizzle") != -1)
					{
						weatherIcon = "<i class=\"wi wi-sprinkle\"></i>"
					}
					else if (currentWeather.indexOf("blizzard") != -1)
					{
						weatherIcon = "<i class=\"wi wi-snowflake-cold\"></i>"
					}
					else if (currentWeather.indexOf("fog") != -1)
					{
						weatherIcon = "<i class=\"wi wi-fog\"></i>"
					}
					else if (currentWeather.indexOf("haze") != -1)
					{
						weatherIcon = "<i class=\"wi wi-day-fog\"></i>"
					}
					else if (currentWeather.indexOf("snow") != -1)
					{
						weatherIcon = "<i class=\"wi wi-snow\"></i>"
					}
					else if (currentWeather.indexOf("ice") != -1)
					{
						weatherIcon = "<i class=\"wi wi-rain-mix\"></i>"
					}
					else if (currentWeather.indexOf("flurries") != -1)
					{
						weatherIcon = "<i class=\"wi wi-snow\"></i>"
					}
					else if (currentWeather.indexOf("sleet") != -1)
					{
						weatherIcon = "<i class=\"wi wi-rain-mix\"></i>"
					}
					else if (currentWeather.indexOf("wintry") != -1)
					{
						weatherIcon = "<i class=\"wi wi-rain-mix\"></i>"
					}
					else if (currentWeather.indexOf("hail") != -1)
					{
						weatherIcon = "<i class=\"wi wi-hail\"></i>"
					}
					else if (currentWeather.indexOf("shower") != -1)
					{
						weatherIcon = "<i class=\"wi wi-sprinkle\"></i>"
					}
					else if (currentWeather.indexOf("storm") != -1)
					{
						weatherIcon = "<i class=\"wi wi-thunderstorm\"></i>"
					}
					else
					{
					weatherIcon = "<i class=\"wi wi-day-sunny-overcast\"></i>"
					}  		

					$("#alert-text").html(weatherIcon + " " + data.currentobservation.Temp + "&#xb0;");
				})
				.fail( function(xhr, textStatus, errorThrown) {
					alert(xhr.responseText);
					alert(textStatus);
				});
		}
		updateWeather();
});
	
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
			 dateNode.firstChild.nodeValue = currentDateString;
		
	   }
	updateDate();
	setInterval('updateClock()', 1000);