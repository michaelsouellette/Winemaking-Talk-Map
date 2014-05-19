<?php
require("phpsqlajax_dbinfo.php");

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
$types = array(events,homebrew,person,winery,nursery);
$typecount = array(0,0,0,0,0);
$today = date("Y/m/d");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WineMakingTalk.com Forum User Map Info</title>
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="css/info.css"> 

<script type="text/javascript"><!--
function showHide(num) {
		var className=document.getElementById('className');
		var memberbox=document.getElementById('memberbox');
		var countrybox=document.getElementById('countrybox');
		var statebox=document.getElementById('statebox');
		var markerbox=document.getElementById('markerbox');
		var eventsbox=document.getElementById('eventsbox');
	    if (num == 1)
        {
                memberbox.className = "boxVisible";
                countrybox.className = "boxHidden";
				statebox.className = "boxHidden";
				markerbox.className = "boxHidden";
				eventsbox.className = "boxHidden";
        }
        else if (num == 2)
        {
                memberbox.className = "boxHidden";
                countrybox.className = "boxVisible";
				statebox.className = "boxHidden";
				markerbox.className = "boxHidden";
				eventsbox.className = "boxHidden";
        }
		else if (num == 3)
        {
                memberbox.className = "boxHidden";
                countrybox.className = "boxHidden";
				statebox.className = "boxVisible";
				markerbox.className = "boxHidden";
				eventsbox.className = "boxHidden";
        }
		else if (num == 4)
        {
                memberbox.className = "boxHidden";
                countrybox.className = "boxHidden";
				statebox.className = "boxHidden";
				markerbox.className = "boxVisible";
				eventsbox.className = "boxHidden";
        }
		else if (num == 5)
        {
                memberbox.className = "boxHidden";
                countrybox.className = "boxHidden";
				statebox.className = "boxHidden";
				markerbox.className = "boxHidden";
				eventsbox.className = "boxVisible";
        }

}
//-->
</script>
</head>
<body>
<div id="contmenu">
    <div class="menu">
     <h2><img src="images/favicon.png" style="width:18px; height:18px;"/> WineMakingTalk.com Forum User Map Info</h2>
     <ul>
     <li><a onclick="showHide(1);" alt="List of forum members on the map">Members</a></li>
     <li><a onclick="showHide(2);" alt="Countries information numbers">Countries</a> and <a onclick="showHide(3);" alt="States information numbers">States/Province</a></li>
     <li><a onclick="showHide(4);" alt="Marker count stats">Markers</a></li>
     <li><a onclick="showHide(5);" alt="Upcoming events on the map">Upcoming Events</a></li>
     <li><a href="index.php" alt="Go back to the WineMakingTalk.com map">Go Back To Map</a></li>
     </ul>
    </div>
</div>
<div id="cont">
    <table>
        <tr>
            <td id="memberbox" class="boxHidden"><h2>Members Info</h2>
            <?php
            $query = "SELECT count(id) FROM markers WHERE type='person'";
			$result = mysql_query($query);
			if (!$result) {
			  die('Invalid query: ' . mysql_error());
			}
			while ($row = mysql_fetch_array($result)){
				echo'There are ',$row['count(id)'],' members with a location on the map!';
			}
			?>
            <iframe src ="includes/info/members.php" style="width:100%; height:85%;">
			  <p>Your browser does not support iframes.</p>
			</iframe>
            </td>
            <td id="statebox" class="boxHidden"><h2>States/Province Info</h2>
            (United States, Canada, and Australia)<br />
            <?php
			$query = "SELECT state,count(state) FROM markers WHERE (country='United States' OR country='Canada' OR country='Australia') AND (type<>'events' OR enddate>='$today') GROUP BY state ORDER BY count(state) DESC LIMIT 10";
			$result = mysql_query($query);
			if (!$result) {
			  die('Invalid query: ' . mysql_error());
			}
			echo'
			<table border="1" width="100%">
			<tr>
			<td>Rank</td><td>State</td><td># Markers</td><td>Events</td><td>Homebrew</td><td>Person</td><td>Winery</td><td>Nursery</td>
			</tr>
			<tr>';
			$count = 1;
			while ($row = mysql_fetch_array($result)){
				$state = $row['state'];
				$counttype = 0;
				while ($counttype <= 4){					
					$typetosearch = $types[$counttype];					
					$query2 = "SELECT count(id) FROM markers WHERE (state='$state' AND type='$typetosearch') AND (type<>'events' OR enddate>='$today')";
					$result2 = mysql_query($query2);
					if (!$result2) {
					  die('Invalid query: ' . mysql_error());
					}
					while ($row2 = mysql_fetch_array($result2)){
						$typecount[$counttype] = $row2['count(id)'];
					}
				$counttype = $counttype + 1;
				}
			echo'<td>',$count,'</td><td>',$row['state'],'</td><td>',$row['count(state)'],' markers</td><td>',$typecount[0],'</td><td>',$typecount[1],'</td><td>',$typecount[2],'</td><td>',$typecount[3],'</td><td>',$typecount[4],'</td></tr>';
			$count = $count + 1;
			}
			echo'
			</table>
			';
			?>
			</td>
			<td id="countrybox" class="boxHidden"><h2>Countries Info</h2>			
            <?php
			$query = "SELECT country,count(country) FROM markers WHERE (type<>'events' OR enddate>='$today') GROUP BY country ORDER BY count(country) DESC LIMIT 10";
			$result = mysql_query($query);
			if (!$result) {
			  die('Invalid query: ' . mysql_error());
			}
			echo'
			<table border="1" width="100%">
			<tr>
			<td>Rank</td><td>Country</td><td># Markers</td><td>Events</td><td>Homebrew</td><td>Person</td><td>Winery</td><td>Nursery</td>
			</tr>
			<tr>';
			$count = 1;
			while ($row = mysql_fetch_array($result)){
				$country = $row['country'];
				$counttype = 0;
				while ($counttype <= 4){					
					$typetosearch = $types[$counttype];					
					$query2 = "SELECT count(id) FROM markers WHERE (country='$country' AND type='$typetosearch') AND (type<>'events' OR enddate>='$today')";
					$result2 = mysql_query($query2);
					if (!$result2) {
					  die('Invalid query: ' . mysql_error());
					}
					while ($row2 = mysql_fetch_array($result2)){
						$typecount[$counttype] = $row2['count(id)'];
					}
				$counttype = $counttype + 1;
				}
				echo'<td>',$count,'</td><td>',$row['country'],'</td><td>',$row['count(country)'],'</td><td>',$typecount[0],'</td><td>',$typecount[1],'</td><td>',$typecount[2],'</td><td>',$typecount[3],'</td><td>',$typecount[4],'</td></tr>';
				$count = $count + 1;
			}
			echo'
			</table>
			';
			?>
            </td> 
            <td id="markerbox" class="boxHidden"><h2>Marker Count Info</h2>
            <?php
			$query = "SELECT type,count(id) FROM markers WHERE (type<>'events' OR enddate>='$today') GROUP BY type";
			$result = mysql_query($query);
			if (!$result) {
			  die('Invalid query: ' . mysql_error());
			}
			echo'
			<table border="1" width="50%">
			<tr>
			<td>Marker Type</td><td>Count</td>
			</tr>
			<tr>';
			while ($row = mysql_fetch_array($result)){
				echo'<td>',ucfirst($row['type']),'</td><td>',$row['count(id)'],' markers</td></tr>';
			}
			echo'
			</table><br />';
			$query2 = "SELECT count(id) FROM markers WHERE (type<>'events' OR enddate>='$today')";
			$result2 = mysql_query($query2);
			if (!$result2) {
			  die('Invalid query: ' . mysql_error());
			}
			while ($row2 = mysql_fetch_array($result2)){
				echo'
				Total marker count: ',$row2['count(id)'],'';
			}
			?>
            </td>
            <td id="eventsbox" class="boxHidden">
            <h2>Upcoming Events</h2>
            <?php
			$query = "SELECT * FROM markers WHERE type='events' AND enddate>='$today' ORDER BY begindate ASC LIMIT 5";
			$result = mysql_query($query);
			if (!$result) {
			  die('Invalid query: ' . mysql_error());
			}
			echo'<ul>';
			while ($row = mysql_fetch_array($result)){
				$country = $row['country'];
				if ($country == "United States" || $country == "Canada" || $country == "Australia"){
					echo'<li>';
					if ($row['website'] == ""){
						echo '<i>',$row['name'],'</i>';
					} else {
						echo'<a href="',$row['website'],'" target="_blank"><i>',$row['name'],'</i></a></li>';
					}
					echo '',$row['city'],', ',$row['state'],' ',$row['country'],'<br /> 
					',$row['begindate'],' - ',$row['enddate'],''; 

				} else {
					echo'<li>';
					if ($row['website'] == ""){
						echo '<i>',$row['name'],'</i>';
					} else {
						echo'<a href="',$row['website'],'" target="_blank"><i>',$row['name'],'</i></a></li>';
					}
					echo '',$row['city'],' ',$row['country'],' <br />
					',$row['begindate'],' - ',$row['enddate'],''; 	
				}			
			}
			echo'</ul>';
			?>
			</td>
        </tr>
    </table>
</div>
<div id="contcopy">
    <div class="copy">
          <h3>| Design by <a href="http://www.michaelsouellette.com" target="_blank">Michael S. Ouellette</a> |</h3>
    </div>
</div>
<div id="bg">
    <div>
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <img src="images/vineyard.jpg" alt=""/>
                </td>
            </tr>
        </table>
    </div>
</div>
  
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11156935-6']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>