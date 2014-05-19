<?php
require("phpsqlajax_dbinfo.php");

function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&apos;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 

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

// Select all the rows in the markers table
$query = "SELECT * FROM markers WHERE 1";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
$today = date("Y/m/d");

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
	if (($row['type'] == "events" && $row['enddate'] < $today) || $row['type'] == "nursery"){
	} else {
	  // ADD TO XML DOCUMENT NODE
	  echo '<marker ';
	  echo 'id="' . parseToXML($row['id']) . '" '; 
	  echo stripslashes('name="' . parseToXML($row['name']) . '" ');
	  echo stripslashes('username="' . parseToXML($row['username']) . '" ');
	  echo stripslashes('address="' . parseToXML($row['address']) . '" ');
	  echo stripslashes('city="' . parseToXML($row['city']) . '" ');
	  echo 'state="' . parseToXML($row['state']) . '" ';
	  echo 'zip="' . parseToXML($row['zip']) . '" ';
	  echo 'country="' . parseToXML($row['country']) . '" ';
	  echo 'begindate="' . parseToXML($row['begindate']) . '" ';
	  echo 'enddate="' . parseToXML($row['enddate']) . '" ';
	 if ($row['country'] == "United Kingdom"){
	  $phone = stripslashes($row['phone']); 
	  $sArea = substr($phone,0,5); 
	  $sPrefix = substr($phone,5,3); 
	  $sNumber = substr($phone,7,3); 
	  $phone = $sArea." ".$sPrefix." ".$sNumber; 
	 }else if($row['country'] == "France") {
	  $phone = stripslashes($row['phone']); 
	  $sArea = substr($phone,0,2); 
	  $sPrefix = substr($phone,2,2); 
	  $sNumber = substr($phone,4,2);
	  $fNumber = substr($phone,6,2);
	  $frNumber = substr($phone,8,2);
	  $phone = $sArea." ".$sPrefix." ".$sNumber." ".$fNumber." ".$frNumber;
	  }else if($row['country'] == "Italy") {
	  $phone = stripslashes($row['phone']); 
	  $sArea = substr($phone,0,4); 
	  $sPrefix = substr($phone,4,3); 
	  $sNumber = substr($phone,7,3);
	  $phone = $sArea." ".$sPrefix." ".$sNumber;
	 }else if($row['country'] == "Spain") {
	  $phone = stripslashes($row['phone']); 
	  $sArea = substr($phone,0,3); 
	  $sPrefix = substr($phone,3,2); 
	  $sNumber = substr($phone,5,2);
	  $fNumber = substr($phone,7,2);
	  $phone = $sArea." ".$sPrefix." ".$sNumber." ".$fNumber;	 
	 }else if($row['country'] == "New Zealand") {
	  $phone = stripslashes($row['phone']); 
	  $sArea = substr($phone,0,2); 
	  $sPrefix = substr($phone,2,3); 
	  $sNumber = substr($phone,5,4); 
	  $phone = "(".$sArea.") ".$sPrefix." ".$sNumber;	 
	 }else if($row['country'] == "Australia") {
	  $phone = stripslashes($row['phone']); 
	  $sArea = substr($phone,0,2); 
	  $sPrefix = substr($phone,2,4); 
	  $sNumber = substr($phone,6,4); 
	  $phone = "(".$sArea.") ".$sPrefix." ".$sNumber;	 
	 }else {
	  $phone = stripslashes($row['phone']); 
	  $sArea = substr($phone,0,3); 
	  $sPrefix = substr($phone,3,3); 
	  $sNumber = substr($phone,6,4); 
	  $phone = "(".$sArea.")".$sPrefix."-".$sNumber; 
	 }
	  echo 'phone="' . parseToXML($phone) . '" ';
	  
	  if ($row['website']== "http://www.") {
		  $website = "";
	  } else {
		  $website = $row['website'];
	  }
	  echo 'website="' . parseToXML($website) . '" ';
	  echo 'email="' . $row['email'] . '" ';  
	  echo 'lat="' . $row['lat'] . '" ';
	  echo 'lng="' . $row['lng'] . '" ';
	  echo 'type="' . parseToXML($row['type']) . '" ';
	  if ($row['type'] == "nursery"){
		$dbid = $row['id'];
		$query2 = "SELECT * FROM nursery WHERE dbid=$dbid";
		$result2 = mysql_query($query2);
		
		while ($row2 = @mysql_fetch_assoc($result2)){
			echo 'produce="' . $row2['produce'] . '" ';
		}
	  }
	  echo '/>';
	}
}

// End XML file
echo '</markers>';

?>