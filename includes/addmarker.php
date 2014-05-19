<?php
require('../phpsqlajax_dbinfo.php');

// Opens a connection to a mySQL server
$connection=mysql_connect ($host, $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

include ('../includes/states/aus_states.php');
include ('../includes/states/can_states.php');
include ('../includes/states/usa_states.php');

$search = Array("/\(/", "/\)/", "/\-/", "/\./", "/\' '/", "/\,/");
$search_two = Array("/\(/", "/\)/", "/\-/", "/\./", "/\,/");
$search_three = Array("/\Ž/", "/\€/", "/\â/");

if (isset($_GET['latlng']) && isset($_GET['latlng'])){
	$name = mysql_real_escape_string(trim($_GET['name']));
	$username = mysql_real_escape_string(trim($_GET['username']));
	$address = mysql_real_escape_string(trim($_GET['address']));
	$city = $_GET['city'];
	$state = $_GET['state'];
	$zip = mysql_real_escape_string(trim($_GET['zip']));
	$country = mysql_real_escape_string(trim($_GET['country']));
	$begindate = mysql_real_escape_string(trim($_GET['begindate']));
	$enddate = mysql_real_escape_string(trim($_GET['enddate']));
	$phone = $_GET['phone'];
	$website =  rawurldecode($_GET['website']);	
	$email = mysql_real_escape_string(trim($_GET['email']));
	$type = $_GET['type'];
	$produce = mysql_real_escape_string(trim($_GET['produce']));
	$latlng = $_GET['latlng'];
	
	$latlng = str_replace('(','',$latlng);
	$latlng = str_replace(')','',$latlng);
	$latlngarray = explode(",",$latlng);
	$lat = $latlngarray[0];
	$lng = $latlngarray[1];
	
	$phone = preg_replace($search,"",$phone);
	$phone = str_replace( ' ', '', $phone);
	
	$city = preg_replace($search_two,"",$city);
	
	$state = preg_replace($search,"",$state);
	$state = str_replace( ' ', '', $state);
	
	$q = "SELECT id FROM markers WHERE (lat='$lat' and lng='$lng' and type='$type')";
	$r = mysql_query ($q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			
	if (mysql_num_rows($r) == 0) { // Available.
	
		if ($country == "United States"){
			$state = convert_usastate($state);
		} else if ($country == "Canada"){
			$state = convert_canstate($state);
		} else if ($country == "Australia"){
			$state = convert_ausstate($state);
		}
		
		if ($type == "winery" || $type == "homebrew") {
			$username = "";
			$begindate = "";
			$enddate = "";
			$email = "";
		} else if ($type == "events") {
			$email = "";
			$phone = "";
		} else if ($type == "person") {
			$begindate = "";
			$enddate = "";
			$website = "";
			$phone = "";			
		}
		
		// Add the winery to the database:
		$query = "INSERT INTO markers (name, username, address, city, state, zip, country, begindate, enddate, phone, website, email, lat, lng, type, dateadded) VALUES ('$name', '$username', '$address', '$city', '$state', '$zip', '$country', '$begindate', '$enddate', '$phone', '$website', '$email', '$lat', '$lng', '$type', NOW())";
		$result = mysql_query ($query) or trigger_error("Query: $q\n<br />MySQL Error: " . mysql_error($dbc));
	}
}
?>