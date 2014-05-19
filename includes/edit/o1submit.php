<?
	$search = Array("/\(/", "/\)/", "/\-/", "/\./", "/\' '/", "/\,/");
	$search_two = Array("/\(/", "/\)/", "/\-/", "/\./", "/\,/");
	$search_three = Array("/\Ž/", "/\€/", "/\â/");
	
	$website_2 = preg_replace($search_three,"",$_POST['website']);
	
		// Check for a name:
		if ($type == "winery" || $type == "homebrew" || $type=="nursery" || $type == "event"){
			if (empty($_POST['full_name'])) {
				$errors[] = "The name field can not be left blank.";
			} else {
				$name_2 = mysql_real_escape_string(trim($_POST['full_name']));
			}
		}else{
			$name_2 = mysql_real_escape_string(trim($_POST['full_name']));
		}
		
		// Check for a forum username:
		if ($type == "person"){
			if (empty($_POST['forum_un'])) {
				$errors[] = 'You forgot to enter your forum username.';
			} else {
				$forumun_2 = mysql_real_escape_string(trim($_POST['forum_un']));
		}}
	
		// Check for a street address:
		if ($type == "winery" || $type == "homebrew" || $type == "nursery" || $type == "event"){
			if (empty($_POST['street_add'])) {
				$errors[] = 'You forgot to enter the street address.';
			} else {
				$streetadd_2 = mysql_real_escape_string(trim($_POST['street_add']));
			}
		} else {
			$streetadd_2 = mysql_real_escape_string(trim($_POST['street_add']));
		}
		
		// Check for a city name:
		if (empty($_POST['city'])) {
			$errors[] = 'You forgot to enter the city name.';
		} else {
			$city_2 = preg_replace($search_two,"",$_POST['city']);
		}
		
		// Check for a country:
		if (empty($_POST['country'])) {
			$errors[] = 'You forgot to enter the country.';
		} else {
			$country_2 = mysql_real_escape_string(trim($_POST['country']));
		}
		
		// Check for a state/territory:
		if ($country_2 == "United States" || $country_2 == "Canada") {
			if (empty($_POST['state'])) {
				$errors[] = 'You forgot to enter the state/territory.';
			} else {
				$state_2 = preg_replace($search,"",$_POST['state']);
				$state_2 = str_replace( ' ', '', $state_2);
			}
		} else {
				$state_2 = preg_replace($search,"",$_POST['state']);
				$state_2 = str_replace( ' ', '', $state_2);
		}
		
		// Check for a zip code:
		if (empty($_POST['zip'])) {
			$errors[] = 'You forgot to enter the zip code.';
		} else {
			$zip_2 = mysql_real_escape_string(trim($_POST['zip']));
		}
		
		// Check for a phone number:
		if ($type == "winery" || $type == "homebrew" || $type == "nursery"){
			if (empty($_POST['phone'])) {
				$errors[] = 'You forgot to enter the phone number.';
			} else {
				$phone_2 = preg_replace($search,"",$_POST['phone']);
				$phone_2 = str_replace( ' ', '', $phone_2);
		}}
		
		if ($type == "event"){
			if (empty($_POST['startevent'])) {
				$errors[] = 'You forgot to enter the start date and time.';
			} else {
				$startdate_2 = mysql_real_escape_string(trim($_POST['startevent']));
			}
			
			if (empty($_POST['endevent'])) {
				$errors[] = 'You forgot to enter the end date and time.';
			} else {
				$enddate_2 = mysql_real_escape_string(trim($_POST['endevent']));
			}
		}
		
		if ($type == "nursery"){
			$produce = mysql_real_escape_string(trim($_POST['produce']));
		}
		
	if (empty($errors)) { // If everything's OK.
		$where = $streetadd_2." ".$city_2." ".$state_2." ".$zip_2." ".$country_2;
		$whereurl = urlencode($where);
		// Note - Google key is domain specific!
		$location = file("http://maps.google.com/maps/geo?q=$whereurl
		&output=csv&key=ABQIAAAA_nrwW79N4h-is3XLNFdGVBSAUii1_C7QCLr1lUFUH0c1LdCpvhRfweE7Gdl2y9IZMWc-L2KqTVAMFw");
		// Sample - $location[0]="200,8,51.369318,-2.133457";
				list ($stat,$acc,$north,$east) = explode(",",$location[0]);
				$lat_2 = "$north";
				$lng_2 = "$east";
				
		//Check if latitude and longitude have a value
			if ($lat_2 == "00.000000" && $lng_2 == "00.000000") {
				echo 'Please check and reenter the address you just tried to submit.';
				
			} else if ($lat_2 == $lat && $lng_2 == $lng) { //If there is are values for lat and long but they are the same in the db			
				if ($country_2 == "United States"){
					$state_2 = convert_usastate($state_2);
				} else if ($country_2 == "Canada"){
					$state_2 = convert_canstate($state_2);
				} else if ($country_2 == "Australia"){
					$state_2 = convert_ausstate($state_2);
				}
				
				// Update the entry in the database:
				if ($type == "event"){
				$query = "UPDATE markers SET name='$name_2', address='$streetadd_2', city='$city_2', state='$state_2', zip='$zip_2', country='$country_2', begindate='$startdate_2', enddate='$enddate_2', website='$website_2', phone='$phone_2' WHERE id='$userid'";	
				} else {					
				$query = "UPDATE markers SET name='$name_2', address='$streetadd_2', city='$city_2', state='$state_2', zip='$zip_2', country='$country_2', website='$website_2', phone='$phone_2' WHERE id='$userid'";
				}
				$result = mysql_query ($query) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error($dbc));
					if (mysql_affected_rows($connection) == 1) { // If it ran OK.						
					// Print a message:
					echo '<p>The entry has been updated.</p>';
					} else { // If it did not run OK.
					echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
					echo '<p>' . mysql_error($connection) . '<br />Query: ' . $query . '</p>'; // Debugging message.
					}
					
			} else { //If there is a value for latitude and longitude and they aren't the same
				if ($country_2 == "United States"){
					$state_2 = convert_usastate($state_2);
				} else if ($country_2 == "Canada"){
					$state_2 = convert_canstate($state_2);
				} else if ($country_2 == "Australia"){
					$state_2 = convert_ausstate($state_2);
				}
				
				// Update the entry in the database:
				if ($type == "event"){
				$query = "UPDATE markers SET name='$name_2', address='$streetadd_2', city='$city_2', state='$state_2', zip='$zip_2', country='$country_2', begindate='$startdate_2', enddate='$enddate_2', website='$website_2', phone='$phone_2', lat='$lat', lng='$lng_2' WHERE id='$userid'";					
				} else {					
				$query = "UPDATE markers SET name='$name_2', address='$streetadd_2', city='$city_2', state='$state_2', zip='$zip_2', country='$country_2', website='$website_2', phone='$phone_2', lat='$lat', lng='$lng_2' WHERE id='$userid'";
				}
				$result = mysql_query ($query) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error($dbc));
					if (mysql_affected_rows($connection) == 1) { // If it ran OK.
				
					// Print a message:
					echo '<p>The entry has been updated.</p>';
					} else { // If it did not run OK.
					echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
					echo '<p>' . mysql_error($connection) . '<br />Query: ' . $query . '</p>'; // Debugging message.
					}
			}
	} else { // Report the errors.
		
		echo 'The following error(s) occurred while editing the marker:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		} echo '</p><p>Please try again.</p><br />
		</div>';	
	}
?>