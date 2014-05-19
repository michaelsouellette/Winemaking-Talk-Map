<?php
require("phpsqlajax_dbinfo.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WineMakingTalk.com Forum User Map - Confirm Delete</title>
        <link rel="stylesheet" href="css/editform.css" type="text/css" media="screen" />  
		<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />     
		<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
</head>
<?php
if (isset($_GET['id'])) { 
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
	
	// Select all the row in the markers table that we need
	$userid = $_GET['id'];
	$timestamp = $_GET['d'];
	$q = "SELECT id FROM delete_flag WHERE timestamp='$timestamp' AND mapid='$userid'";
	$r = mysql_query($q);
	if (!$r) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $q;
		die($message);
	}
	
	if (mysql_num_rows($r) > 0) { // Delete flag exsists
	
		// Select all the row in the markers table that we need
		$q2 = "SELECT * FROM markers WHERE (id='$userid')";
		$r2 = mysql_query($q2);
		if (!$r2) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $q2;
			die($message);
		}
		//$row = mysql_fetch_array($r);
		while ($row = mysql_fetch_assoc($r2)) {
		$name = stripslashes($row['name']);
		$address = $row['address'];
		$city = $row['city'];
		$state = $row['state'];
		$country = $row['country'];
		$zip = $row['zip'];
		$type = $row['type'];
		}
		
		if ($_POST['confirmdelete']){
			$sql = "DELETE FROM markers WHERE id='$userid'";
		    $result = mysql_query($sql);
		    echo '
				<div id="container">
				<fieldset> 
				<legend>Marker Deleted</legend> 
				<dl>
					The marker has been deleted from the map!<br />
					<a href="http://wineapp.michaelsouellette.com">Return to the map</a><br />
				</dl>
				</fieldset></div>';
			$sql2 = "UPDATE delete_flag SET deleted='y' WHERE timestamp='$timestamp' AND mapid='$userid'";
			$result2 = mysql_query ($sql2) or trigger_error("Query: $q\n<br />MySQL Error: " . mysql_error($dbc));
			
		} else if ($_POST['unconfirmdelete']){
			$sql = "DELETE FROM delete_flag WHERE timestamp='$timestamp' AND mapid='$userid'";
		    $result = mysql_query($sql);
			echo '
			<div id="container">
			<fieldset> 
			<legend>Marker Unflagged</legend> 
			<dl>
				The marker has been unflagged for deletion from the map!<br />
				<a href="http://wineapp.michaelsouellette.com">Return to the map</a><br />
			</dl>
			</fieldset></div>';
			
		} else {
			echo '
			<div id="container">
				<form action="#" method="post" class="niceform" name="confirmdelete">
				<fieldset>
				<legend><h1>', $name ,'</h1></legend>
				<dl>
				',$address,'<br />
				',$city,', ',$state,' ',$zip,'<br />
				',$country,'<p />
				Marker Type: ',$type,'<br />
				</dl>
				</fieldset>
				<fieldset> 
				<legend>Confirm Deletion</legend> 
				<dl>
					Are you sure you want to permanently delete this marker from the map?<br />
				</dl>
					<input type="submit" name="confirmdelete" id="submit" value=" Yes " /> 
					<input type="submit" name="unconfirmdelete" id="submit" value=" No " /> 
				</fieldset>
			';
		}
		} else {
			echo '
			<div id="container">
			<fieldset> 
			<legend>Access Denied</legend> 
			<dl>
				Variable not set!<br />
				<a href="http://wineapp.michaelsouellette.com">Return to the map</a><br />
			</dl>
			</fieldset></div>';	
		}
	
} else {
	echo '
	<div id="container">
	<fieldset> 
	<legend>Access Denied</legend> 
	<dl>
		Variable not set!<br />
		<a href="http://wineapp.michaelsouellette.com">Return to the map</a><br />
	</dl>
	</fieldset></div>';
}
?>
<body>
</body>
</html>