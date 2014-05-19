<div class="popup_close"><a href="#" onclick="close_popup('markerContainer')"><img src="/images/close.png"></a></div>
<div id="markerContent">
<?php
require("../phpsqlajax_dbinfo.php");

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
	$q = "SELECT * FROM markers WHERE (id='$userid')";
	$r = mysql_query($q);
	if (!$r) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $query;
		die($message);
	}
	//$row = mysql_fetch_array($r);
	while ($row = mysql_fetch_assoc($r)) {
    $name = stripslashes($row['name']);
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
	$country = $row['country'];
	$zip = $row['zip'];
	$username = $row['username'];
	$begindate = $row['begindate'];
	$enddate = $row['enddate'];
	$phone = $row['phone'];
	$email = $row['email'];
	$website = $row['website'];
	$type = $row['type'];
	$lat = $row['lat'];
	$lng = $row['lng'];
	
		if ($type == "nursery"){
			$query2 = "SELECT * FROM nursery WHERE dbid=$userid";
			$result2 = mysql_query($query2);
			
			while ($row2 = @mysql_fetch_assoc($result2)){
				$produce = $row2['produce'];
			}
		}
	}
	
	if($_POST['editsubmit']){
		include ('../includes/states/aus_states.php');
		include ('../includes/states/can_states.php');
		include ('../includes/states/usa_states.php');
		$option = $_POST['option']; 
			if ($option == "o1"){
				include ('../includes/edit/o1submit.php');
			} else if (($type == "winery" || $type == "homebrew" || $type == "event" || $type == "nursery") && $option == "o2"){
				include ('../includes/edit/o2submit.php');
			} else if ($type == "person" && $option == "o2"){
				include ('../includes/edit/o2submit_person.php');
			//} else if ($option = "o3") {
			}
	} else if ($_POST['emailsubmit']) {
		$emaillogin = $_POST['email_login'];
		if ($emaillogin == $email) {
			include ('../includes/edit/person2.php');
		} else {
		echo '
		<div id="container">
			<form action="#" method="post" class="niceform" name="weboptions" id="weboptions">
			<fieldset>
			<legend><h1>', $name ,'</h1></legend>
			</fieldset>
			<fieldset> 
			<legend>Access Denied</legend> 
			<dl>
				Email address entered was incorrect. You do not have permission to edit this user!
			</dl>
			</fieldset>
			';
		}
	} else {
		//			<option value="o3">Change Type
		echo '
		<div id="container">
			<form action="#" method="post" class="niceform" name="weboptions" id="weboptions">';
			if ($type == "winery" || $type == "homebrew" || $type == "event" || $type == "nursery"){
			echo'
			<fieldset>
			<legend><h1>', $name ,'</h1></legend>
			<label for="option">What would you like to do?</label>
			<select name="option">
			<option value="o1">Edit Details
			<option value="o2">Flag for Deletion
			</select>
			</fieldset>
			<fieldset> 
    		<legend>Edit Entry</legend>';
			include ('../includes/edit/delete.php');
			include ('../includes/edit/changetype.php');}			
			if ($type == "winery" || $type == "homebrew") {
				include ('../includes/edit/winehome.php');
			} else if ($type == "nursery"){
				include ('../includes/edit/nursery.php');
			} else if ($type == "event"){
				include ('../includes/edit/event.php');
			} else if ($type == "person") {
				echo '
				<fieldset>
				<legend><h1>', $name ,'</h1></legend>
				</fieldset>
				<fieldset> 
    			<legend>Security</legend>';
				include ('../includes/edit/person.php');
			}
			
			echo'
		</form> 
		</div>'; 
	}} else { 
    echo 'Variable not set.'; 
}
?> 
	<script type="text/javascript">
    $('#startevent').focus( function() {
    $('#startevent').unbind('focus').AnyTime_picker( 
          { format: "%m/%d/%z %h:%i %p" } ); } );
    $('#endevent').focus( function() {
    $('#endevent').unbind('focus').AnyTime_picker( 
          { format: "%m/%d/%z %h:%i %p" } ); } );
    </script>
	<script type="text/javascript">
    
    $(document).ready( function() { $.NiceJForms.build(); } );
    
    </script>
</div>