<?php 
if($_POST['eventsubmit']){	
$search = Array("/\(/", "/\)/", "/\-/", "/\./", "/\' '/", "/\,/");
$search_two = Array("/\(/", "/\)/", "/\-/", "/\./", "/\,/");
$search_three = Array("/\Ž/", "/\€/", "/\â/");

$website = preg_replace($search_three,"",$_POST['website']);

	// Check for an event name:
	if (empty($_POST['full_name'])) {
		$errors[] = 'You forgot to enter the event name.';
	} else {
		$name = mysql_real_escape_string(trim($_POST['full_name']));
	}

	// Check for a forum username:
	if (empty($_POST['forum_un'])) {
		$errors[] = 'You forgot to enter your forum username.';
	} else {
		$forumun = mysql_real_escape_string(trim($_POST['forum_un']));
	}

	// Check for a street address:
	if (empty($_POST['street_add'])) {
		$errors[] = 'You forgot to enter the street address.';
	} else {
		$streetadd = mysql_real_escape_string(trim($_POST['street_add']));
	}
	
	// Check for a city name:
	if (empty($_POST['city'])) {
		$errors[] = 'You forgot to enter the city name.';
	} else {
		$city = preg_replace($search_two,"",$_POST['city']);
	}
	
	// Check for a zip code:
	if (empty($_POST['zip'])) {
		$errors[] = 'You forgot to enter the zip code.';
	} else {
		$zip = mysql_real_escape_string(trim($_POST['zip']));
	}
	
	// Check for a country:
	if (empty($_POST['country'])) {
		$errors[] = 'You forgot to enter the country.';
	} else {
		$country = mysql_real_escape_string(trim($_POST['country']));
	}
	
	// Check for a state/territory:
	if ($country == "United States" || $country == "Canada") {
		if (empty($_POST['state'])) {
			$errors[] = 'You forgot to enter the state/territory.';
		} else {
			$state = preg_replace($search,"",$_POST['state']);
			$state = str_replace( ' ', '', $state);
		}
	} else {
			$state = preg_replace($search,"",$_POST['state']);
			$state = str_replace( ' ', '', $state);
	}
	
	// Check for a event start date:
	if (empty($_POST['startevent'])) {
		$errors[] = 'You forgot to enter the start date.';
	} else {
		$startdate = mysql_real_escape_string(trim($_POST['startevent']));
	}
	
	// Check for a event end date:
	if (empty($_POST['endevent'])) {
		$errors[] = 'You forgot to enter the end date.';
	} else {
		$enddate = mysql_real_escape_string(trim($_POST['endevent']));
	}
	
if (empty($errors)) { // If everything's OK.

	$where = $streetadd." ".$city." ".$state." ".$zip." ".$country;
	$whereurl = urlencode($where);
	// Note - Google key is domain specific!
	$location = file("http://maps.google.com/maps/geo?q=$whereurl
	&output=csv&key=ABQIAAAA_nrwW79N4h-is3XLNFdGVBTfXZ6cItYrmMejQSgN9U8kC4peEBSRXwm9pJHq38KRvXHdniSfTuukfw");
	// Sample - $location[0]="200,8,51.369318,-2.133457";
			list ($stat,$acc,$north,$east) = explode(",",$location[0]);
			$lat = "$north";
			$long = "$east";

	//Check if latitude and longitude have a value
	if ($lat == "00.000000" & $long == "00.000000") {
		echo '
		<div id="statusdisplay">
		<a href="index.php"><img src="images/btnclose.png" alt="Close Error Panel" class="button" align="right" /></a>
		<p>Please check and reenter the address for the event you just tried to submit.<br />
		</div>';		
	} else {	//If there is a value for latitude and longitude
		// Make sure the event is not already in the database:
		$q = "SELECT id FROM markers WHERE (lat='$lat' and lng='$long' and type='event') or (name='$name' and city='$city' and state='$state' and zip='$zip' and country='$country' and type='event')";
		$r = mysql_query ($q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			
		if (mysql_num_rows($r) == 0) { // Available.
	
		if ($country == "United States"){
			$state = convert_usastate($state);
		} else if ($country == "Canada"){
			$state = convert_canstate($state);
		} else if ($country == "Australia"){
			$state = convert_ausstate($state);
		}	
	
		// Add the event to the database:			
		$query = "INSERT INTO markers (name, username, address, city, state, zip, country, begindate, enddate, website, lat, lng, type, dateadded) VALUES ('$name', '$forumun', '$streetadd', '$city', '$state', '$zip', '$country', '$startdate', '$enddate', '$website', '$lat', '$long', 'event', NOW())";
		$result = mysql_query ($query) or trigger_error("Query: $q\n<br />MySQL Error: " . mysql_error($dbc));
		
		header("Location: index.php");
		} else { // If event is already scheduled.
				echo '
		<div id="statusdisplay">
		<a href="index.php"><img src="images/btnclose.png" alt="Close Error Panel" class="button" align="right" /></a>
		<p>Your event is already in the database.<br />
		</div>';
		}}
} else { // Report the errors.
	
	echo '
	<div id="statusdisplay">
	<a href="index.php"><img src="images/btnclose.png" alt="Close Error Panel" class="button" align="right" /></a>
	<p class="error">The following error(s) occurred while adding your event:<br />';
	foreach ($errors as $msg) { // Print each error.
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p><br />
	</div>';	
}
}?>