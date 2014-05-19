<?php
require('phpsqlajax_dbinfo.php');

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

if (isset($_GET['lat']) && isset($_GET['lng'])){
$issetvalue	= "Y";
$startlat = $_GET['lat'];
$startlng = $_GET['lng'];
} else {
$issetvalue ="N";	
}

include ('includes/states/aus_states.php');
include ('includes/states/can_states.php');
include ('includes/states/usa_states.php');
include ('includes/postlocations.php');
include ('includes/postevents.php');
include ('includes/postwinery.php');
include ('includes/posthomebrew.php');
include ('includes/postnursery.php');
include ('includes/process.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" >
  <head>
  <style type="text/css">v\:* {behavior:url(#default#VML);}</style>
  <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>WineMakingTalk.com Forum User Map</title>
     <!-- Make the document body take up the full screen -->
  <style type="text/css">
    v\:* {behavior:url(#default#VML);}
    html, body {width: 100%; height: 100%;}
    body {margin-top: 0px; margin-right: 0px; margin-left: 0px; margin-bottom: 0px;}
	#bottom {
		width: 100%;
		height: 6.5%;
		padding-top: 1%;
		position: fixed;
		bottom: 0px;
		color: #ffffff;
		background:url(images/topbar.jpg) top repeat-x #6f0303;
	}
	#navbar {
		margin: 0;
		padding: 0;
		height: 1em; }
	#navbar li {
		list-style: none;
		float: right; }
	#navbar li a {
		display: block;
		padding-right: 5px;
		background-color: #6f0303;
		color: #fff;
		text-decoration: none; }
	#navbar li ul {
		display: none;
		text-align:left;
		bottom: 2.8em;
		width: 10em; /* Width to help Opera out */
		background-color: #6f0303;}
	#navbar li:hover ul {
		display: block;
		position: absolute;
		margin: 0;
		padding: 0; }
	#navbar li:hover li {
		float: none; }
	#navbar li:hover li a {
		background-color: #6f0303;
		border-bottom: 1px solid #fff;
		color: #fff; }
	#navbar li li a:hover {
		background-color: #6f0303; }		
  </style>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="css/anytime.css" />  
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="css/slide2.css" type="text/css" media="screen" />
    <!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->
    <!-- jQuery - the core -->         
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="js/anytime.js"></script>
    <script type="text/javascript" src="clearbox.js"></script>    
	<!-- Sliding effect -->
	<script type="text/javascript" src="js/slide.js"></script>    
    
    <script>  
	$(document).ready(function(){  
	    $(".button").hover(function() {  
	        $(this).attr("src","images/btnclose-hover.png");  
	            }, function() {  
	        $(this).attr("src","images/btnclose.png");  
	    });  
	});  
	</script>
    
    <!-- Google map files -->
    <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAA_nrwW79N4h-is3XLNFdGVBTfXZ6cItYrmMejQSgN9U8kC4peEBSRXwm9pJHq38KRvXHdniSfTuukfw" 
       type="text/javascript"></script>
	<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAA_nrwW79N4h-is3XLNFdGVBTfXZ6cItYrmMejQSgN9U8kC4peEBSRXwm9pJHq38KRvXHdniSfTuukfw"></script>
	<script src="js/dragzoom.js" type="text/javascript"></script> 
 
   </head>

  <body onunload="setCookie()">
  <div id="map" style="width: 100%; height: 92%"></div>
         
   <script type="text/javascript">
    //<![CDATA[
	
    var iconBlue = new GIcon(); 
    iconBlue.image = 'http://labs.google.com/ridefinder/images/mm_20_blue.png';
    iconBlue.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
    iconBlue.iconSize = new GSize(12, 20);
    iconBlue.shadowSize = new GSize(22, 20);
    iconBlue.iconAnchor = new GPoint(6, 20);
    iconBlue.infoWindowAnchor = new GPoint(5, 1);

    var iconRed = new GIcon(); 
    iconRed.image = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
    iconRed.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
    iconRed.iconSize = new GSize(12, 20);
    iconRed.shadowSize = new GSize(22, 20);
    iconRed.iconAnchor = new GPoint(6, 20);
    iconRed.infoWindowAnchor = new GPoint(5, 1);

    var iconPurple = new GIcon(); 
    iconPurple.image = 'http://labs.google.com/ridefinder/images/mm_20_purple.png';
    iconPurple.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
    iconPurple.iconSize = new GSize(12, 20);
    iconPurple.shadowSize = new GSize(22, 20);
    iconPurple.iconAnchor = new GPoint(6, 20);
    iconPurple.infoWindowAnchor = new GPoint(5, 1);
	
	var iconYellow = new GIcon(); 
    iconYellow.image = 'http://labs.google.com/ridefinder/images/mm_20_yellow.png';
    iconYellow.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
    iconYellow.iconSize = new GSize(12, 20);
    iconYellow.shadowSize = new GSize(22, 20);
    iconYellow.iconAnchor = new GPoint(6, 20);
    iconYellow.infoWindowAnchor = new GPoint(5, 1);
	
	var iconGreen = new GIcon(); 
    iconGreen.image = 'http://labs.google.com/ridefinder/images/mm_20_green.png';
    iconGreen.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
    iconGreen.iconSize = new GSize(12, 20);
    iconGreen.shadowSize = new GSize(22, 20);
    iconGreen.iconAnchor = new GPoint(6, 20);
    iconGreen.infoWindowAnchor = new GPoint(5, 1);

    var customIcons = [];
    customIcons["event"] = iconBlue;
    customIcons["person"] = iconRed;
	customIcons["winery"] = iconPurple;
	customIcons["homebrew"] = iconYellow;
	customIcons["nursery"] = iconGreen;
	var markerGroups = { "event": [], "person": [], "winery": [], "homebrew": [], "nursery": []};
	
	function wordwrap( str, width, brk, cut ) {
 
    brk = brk || '\n';
    width = width || 75;
    cut = cut || false;
 
    if (!str) { return str; }
 
    var regex = '.{1,' +width+ '}(\\s|$)' + (cut ? '|.{' +width+ '}|.+$' : '|\\S+?(\\s|$)');
 
    return str.match( RegExp(regex, 'g') ).join( brk );
 
	}
	
	function Markers(type){
	 
	// map.closeInfoWindow();
	map.getInfoWindow().hide() 
	   if (document.getElementById(type).checked==false) { // hide the marker
		  for (var i=0;i<gmarkers.length;i++) {
			 if (gmarkers[i].type==type)  {
				map.removeOverlay(gmarkers[i]);
			 }
		  }
	   } else { // show the marker again
		  for (var i=0;i<gmarkers.length;i++) {
			 if (gmarkers[i].type==type)  {
				map.addOverlay(gmarkers[i]);
			 }
		  }
	   }
	}	
	
  
      if (GBrowserIsCompatible()) {
		        // === Some cookie parameters ===
      var cookiename = "mapinfo";  // name for this cookie
      var expiredays = 7;          // number of days before cookie expiry
	  var lat = 37.6922222;
	  var lng = -97.3372222;
	  var zoom = 2;
	  var maptype = 0;
			   
	if (document.cookie.length>0) {
        cookieStart = document.cookie.indexOf(cookiename + "=");
        if (cookieStart!=-1) {
          cookieStart += cookiename.length+1; 
          cookieEnd=document.cookie.indexOf(";",cookieStart);
          if (cookieEnd==-1) {
            cookieEnd=document.cookie.length;
          }
          cookietext = document.cookie.substring(cookieStart,cookieEnd);
          // == split the cookie text and create the variables ==
          bits = cookietext.split("|");
          lat = parseFloat(bits[0]);
          lng = parseFloat(bits[1]);
          zoom = parseInt(bits[2]);
          maptype = parseInt(bits[3]);
		}
     }
	 
	var issetvalue = "<?= $issetvalue ?>";
	if (issetvalue=="Y"){
		var lat = "<?= $startlat ?>";
		var lng = "<?= $startlng ?>";
		var zoom = 14;
		var maptype = 0;
	}
	 
		var mapOptions = {
    		googleBarOptions : {
	      style : "new",
	    }  }
		
        var map = new GMap2(document.getElementById("map"), mapOptions);	
        map.addControl(new GMapTypeControl());
		map.enableScrollWheelZoom();
		map.addControl(new GLargeMapControl3D());
		map.addControl(new DragZoomControl());
        map.setCenter(new GLatLng(lat, lng), zoom, map.getMapTypes()[maptype]);
				
	// Monitor the window resize event and let the map know when it occurs
      if (window.attachEvent) { 
        window.attachEvent("onresize", function() {this.map.onResize()} );
      } else {
        window.addEventListener("resize", function() {this.map.onResize()} , false);
      }

        // Change this depending on the name of your PHP file
        GDownloadUrl("phpsqlajax_genxml.php", function(data) {
          var xml = GXml.parse(data);
          var markers = xml.documentElement.getElementsByTagName("marker");
          for (var i = 0; i < markers.length; i++) {
			var id = markers[i].getAttribute("id");
            var name = markers[i].getAttribute("name");
			var username = markers[i].getAttribute("username");
            var address = markers[i].getAttribute("address");
			var city = markers[i].getAttribute("city");
			var state = markers[i].getAttribute("state");
			var zip = markers[i].getAttribute("zip");
			var country = markers[i].getAttribute("country");
			var begindate = markers[i].getAttribute("begindate");
			var enddate = markers[i].getAttribute("enddate");
			var phone = markers[i].getAttribute("phone");
			var website = markers[i].getAttribute("website");
			var email = markers[i].getAttribute("email");			
			var type = markers[i].getAttribute("type");
			if (type == "nursery"){
				var produce = markers[i].getAttribute("produce");
				produce = wordwrap(produce,45,"<br />");
			}
            var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
                                    parseFloat(markers[i].getAttribute("lng")));
			
			if (type == "nursery"){
				var marker = createMarker(point, id, name, username, address, city, state, zip, country, begindate, enddate, phone, website, email, type, ["Info","Produce"],produce);
			} else {
            	var marker = createMarker(point, id, name, username, address, city, state, zip, country, begindate, enddate, phone, website, email, type, ["Nothing"]);
			}
            map.addOverlay(marker);
          }
        });
      }

	function createMarker(point, id, name, username, address, city, state, zip, country, begindate, enddate, phone, website, email, type, labels, produce) 
	{

	var marker = new GMarker(point, customIcons[type]);
	  markerGroups[type].push(marker);
	  if (type=='person'){
			   if (name == ''){
			   if (email == '') {
				var html = "Username: <b>" + username + "</b> <br/>" + city + ", " + state + " " + zip + " " + country;
			   } else {
				var html = "Username: <b>" + username + "</b> <br/>" + city + ", " + state + " " + zip + " " + country + "<br /><a href=\"includes/editdetails.php?id=" + id + "\" onclick='CB_Open(\"href=includes/editdetails.php?id=" + id + ",,tnhrf=nopreview,,width=600,,height=500\");return false' rel=\"clearbox\">Edit Entry</a>";   
			   }
		   } else {
			   if (email == '') {
				var html = "Username: <b>" + username + "</b> <br/>" + name + "</b> <br/>" + city + ", " + state + " " + zip + " " + country;
			   } else {
				 var html = "Username: <b>" + username + "</b> <br/>" + name + "</b> <br/>" + city + ", " + state + " " + zip + " " + country + "<br /><a href=\"includes/editdetails.php?id=" + id + "\" onclick='CB_Open(\"href=includes/editdetails.php?id=" + id + ",,tnhrf=nopreview,,width=600,,height=500\");return false' rel=\"clearbox\">Edit Entry</a>";  
			   }
				}
				var htmls = [html];
				}
	  else if (type=='event'){
		  if (website=="") {
			  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + begindate + " to " + enddate + "<br /><a href=\"includes/editdetails.php?id=" + id + "\" onclick='CB_Open(\"href=includes/editdetails.php?id=" + id + ",,tnhrf=nopreview,,width=600,,height=500\");return false' rel=\"clearbox\">Edit Entry</a><h6><i>Submitted By:" + username + "</h6>";}
	   else {
	  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + begindate + " to " + enddate + "<br/>" + "<a href='" + website + "'>Visit Event Website</a> | <a href=\"includes/editdetails.php?id=" + id + "\" onclick='CB_Open(\"href=includes/editdetails.php?id=" + id + ",,tnhrf=nopreview,,width=600,,height=500\");return false' rel=\"clearbox\">Edit Entry</a><h6><i>Submitted By:" + username + "</h6>";}
	  var htmls = [html];
	  }
	  else if (type=='nursery'){
		  if (website=="") {
			  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + phone + "<br /><a href=\"includes/editdetails.php?id=" + id + "\" onclick='CB_Open(\"href=includes/editdetails.php?id=" + id + ",,tnhrf=nopreview,,width=600,,height=500\");return false' rel=\"clearbox\">Edit Entry</a>";}
	   else {
	  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + phone + "<br /><a href='" + website + "' target='_blank'>Visit " + name + "</a> | <a href=\"includes/editdetails.php?id=" + id + "\" onclick='CB_Open(\"href=includes/editdetails.php?id=" + id + ",,tnhrf=nopreview,,width=600,,height=500\");return false' rel=\"clearbox\">Edit Entry</a>";}
	  var htmls = [html,produce];
	  }  
	  else if (type=='winery' || type=='homebrew'){
		  if (website=="") {
			  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + phone + "<br /><a href=\"includes/editdetails.php?id=" + id + "\" onclick='CB_Open(\"href=includes/editdetails.php?id=" + id + ",,tnhrf=nopreview,,width=600,,height=500\");return false' rel=\"clearbox\">Edit Entry</a>";}
	   else {
	  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + phone + "<br/><a href='" + website + "' target='_blank'>Visit " + name + "</a> | <a href=\"includes/editdetails.php?id=" + id + "\" onclick='CB_Open(\"href=includes/editdetails.php?id=" + id + ",,tnhrf=nopreview,,width=600,,height=500\");return false' rel=\"clearbox\">Edit Entry</a>";}
	  var htmls = [html];
	  }
		GEvent.addListener(marker, "click", function() {
		  // adjust the width so that the info window is large enough for this many tabs
          if (htmls.length > 2) {
            htmls[0] = '<div style="width:'+htmls.length*88+'px">' + htmls[0] + '<\/div>';
          }
          var tabs = [];
          for (var i=0; i<htmls.length; i++) {
            tabs.push(new GInfoWindowTab(labels[i],htmls[i]));
          }
          marker.openInfoWindowTabsHtml(tabs);
		});  
      return marker;
    }
	
	function toggleGroup(type) {
      for (var i = 0; i < markerGroups[type].length; i++) {
        var marker = markerGroups[type][i];
        if (marker.isHidden()) {
          marker.show();
        } else {
          marker.hide();
        }
      } 
    }
	
 	  function setCookie() {
        maptype = 0;
        for (var i=0;i<map.getMapTypes().length;i++) {
          if (map.getCurrentMapType() == map.getMapTypes()[i]) {
            maptype = i;
          }
        }
        var cookietext = cookiename+"="+map.getCenter().lat()+"|"+map.getCenter().lng()+"|"+map.getZoom()+"|"+maptype;
        if (expiredays) {
          var exdate=new Date();
          exdate.setDate(exdate.getDate()+expiredays);
          cookietext += ";expires="+exdate.toGMTString();
        }
        // == write the cookie ==
        document.cookie=cookietext;
        // == Call GUnload() on exit ==
        GUnload();
      }
    //]]>
  </script>
  <script type="text/javascript" 
   src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>

  <style>
   /* 
    CSS rules to use for styling the overlay:
      .chromeFrameOverlayContent
      .chromeFrameOverlayContent iframe
      .chromeFrameOverlayCloseBar
      .chromeFrameOverlayUnderlay
   */
  </style> 

  <script>
   CFInstall.check({
     mode: "overlay",
     destination: "http://wineapp.michaelsouellette.com/"
   });
  </script>
<?php 
 include ('includes/person.php');
 include ('includes/events.php');
 include ('includes/winery.php');
 include ('includes/homebrew.php');
 include ('includes/nursery.php');
 include ('includes/ibutton.php');
 include ('includes/onoff2.php');
 include ('includes/search.php');
 include ('includes/footer2.php');
 ?>