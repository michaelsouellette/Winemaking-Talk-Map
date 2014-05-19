<?php 
if($_POST['winerysubmit']){	
$search = Array("/\(/", "/\)/", "/\-/", "/\./", "/\' '/", "/\,/");
$search_two = Array("/\(/", "/\)/", "/\-/", "/\./", "/\,/");
$search_three = Array("/\Ž/", "/\€/", "/\â/");

$website = preg_replace($search_three,"",$_POST['website']);

	// Check for a winery name:
	if (empty($_POST['full_name'])) {
		$errors[] = "You forgot to enter the winery's name.";
	} else {
		$name = mysql_real_escape_string(trim($_POST['full_name']));
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
		//$city = mysql_real_escape_string(trim($_POST['city']));
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

	// Check for a phone number:
	if (empty($_POST['phone'])) {
		$errors[] = 'You forgot to enter the phone number.';
	} else {
		$phone = preg_replace($search,"",$_POST['phone']);
		$phone = str_replace( ' ', '', $phone);
	}
	
if (empty($errors)) { // If everything's OK.
	
	$where = $streetadd." ".$city." ".$state." ".$zip." ".$country;
	$whereurl = urlencode($where);
	// Note - Google key is domain specific!
	$location = file("http://maps.google.com/maps/geo?q=$whereurl
	&output=csv&key=ABQIAAAA_nrwW79N4h-is3XLNFdGVBTfXZ6cItYrmMejQSgN9U8kC4peEBSRXwm9pJHq38KRvXHdniSfTuukfw");
	// Sample - $location[0]="200,8,51.369318,-2.133457";
			//list ($stat,$acc,$north,$east) = explode(",",$location[0]);
			//foreach ($str as $phrase1){
			//   if (strstr($phrase1, 'north')) $key1 = $phrase1;
			//   if(isset($key2)) break;
			//}
			//foreach ($str as $phrase2){
			//   if (strstr($phrase2, 'east')) $key2 = $phrase1;
			//   if(isset($key2)) break;
			//}
			$key1 = array_search('north',$location);
			$key2 = array_search('east',$location);
			$north = explode(':',$location[$key1]);
			$east = explode(':',$location[$key2]);
			$north = explode(',',$north[1]);
			$east = explode(',',$east[1]);
			$lat = $north[0];
			$long = $east[0];
		
	//Check if latitude and longitude have a value
	if ($lat == "00.000000" & $long == "00.000000") {
		echo '
		<div id="statusdisplay">
		<a href="index.php"><img src="images/btnclose.png" alt="Close Error Panel" class="button" align="right" /></a>
		<p>Please check and reenter the address for the winery you just tried to submit.<br />
		</div>';		
	} else {	//If there is a value for latitude and longitude
		// Make sure the winery is not already in the database:
		$q = "SELECT id FROM markers WHERE (lat='$lat' and lng='$long' and type='winery')";
		$r = mysql_query ($q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
				
		if (mysql_num_rows($r) == 0) { // Available.
		
		if ($country == "United States"){
			$state = convert_usastate($state);
		} else if ($country == "Canada"){
			$state = convert_canstate($state);
		} else if ($country == "Australia"){
			$state = convert_ausstate($state);
		}
		
		//print_r($location);
		//echo "<br />".$lat." - ".$long;
		//echo "<br />".$phrase1." | ".$phrase2;
		
		// Add the winery to the database:
		$query = "INSERT INTO markers (name, address, city, state, zip, country, website, phone, lat, lng, type, dateadded) VALUES ('$name', '$streetadd', '$city', '$state', '$zip', '$country', '$website', '$phone', '$lat', '$long', 'winery', NOW())";
		$result = mysql_query ($query) or trigger_error("Query: $q\n<br />MySQL Error: " . mysql_error($dbc));
		
		header("Location: index.php");
		} else { // If winery is already in the database.
				echo '
		<div id="statusdisplay">
		<a href="index.php"><img src="images/btnclose.png" alt="Close Error Panel" class="button" align="right" /></a>
		<p>The winery you just tried to submit is already in the database.<br />
		</div>';
		}}
} else { // Report the errors.
	
	echo '
	<div id="statusdisplay">
	<a href="index.php"><img src="images/btnclose.png" alt="Close Error Panel" class="button" align="right" /></a>
	<p class="error">The following error(s) occurred while adding your winery:<br />';
	foreach ($errors as $msg) { // Print each error.
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p><br />
	</div>';	
}
}?>