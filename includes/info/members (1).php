<?php
require("../../phpsqlajax_dbinfo.php");

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<title>WineMakingTalk.com Forum User Map Info</title>
<style>
html, body, #bg, #bg table, #bg td {
	color:#fff;
	background:#000;
}

a {
	color: #fff;
	text-decoration:none;
}

a:hover {
	color: #6f0303;
	text-decoration:none;
}
</style>
</head>
<body>
<?php
$today = date("Y-m-d H:i:s");
$weekago = date("Y-m-d H:i:s", strtotime("-1 week"));

$query = "SELECT * FROM markers WHERE type='person' ORDER BY username ASC";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
echo'<strong style="color:#fff">Wine Members On The Map:</strong><br />
<ul style="color:#fff">';
while ($row =  @mysql_fetch_assoc($result)){
	echo'<li><a href="../../index.php?lat=',$row['lat'],'&lng=',$row['lng'],'" target="_parent" alt="See users location on the map">',$row['username'],'</a>'; 
	if($row['dateadded'] <= $today && $row['dateadded'] >= $weekago){
		echo ' - <strong><text style="color:#6f0303;">NEW</text></strong>'; 
	} echo'</li>';
}
echo'</ul>';
?>
</body>
</html>