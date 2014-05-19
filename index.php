<?
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

include ('includes/process.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" >
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="google-site-verification" content="AHM0HHPCxZ92gwTB_ijswMNSVfjuS96SF8qtZ1sqBuU" />
<title>WineMakingTalk.com Forum User Map</title>

<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="css/map.css" />
<link rel="stylesheet" type="text/css" href="css/anytime.css" /> 
<link rel="stylesheet" type="text/css" href="css/niceforms-default.css" media="all" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="js/anytime.js"></script>
<script type="text/javascript" src="/js/niceforms.js" language="javascript"></script>
<script type="text/javascript" src="/js/FormManager.js"></script>       
<script type="text/javascript">
	window.onload = function() {
	setupDependencies('weboptions');
  };
</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">
// JavaScript Document
$(document).ready(function(){
	loadPage();
});

var errors=new Array();
var geocoder;
var map;
var infoWindow;
var customIcons = {
  events: {
	  icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
	  shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
  },
  person: {
	  icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
	  shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
  },
  winery: {
	  icon: 'http://labs.google.com/ridefinder/images/mm_20_purple.png',
	  shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'	  
  },
  homebrew: {
	  icon: 'http://labs.google.com/ridefinder/images/mm_20_yellow.png',
	  shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
  },
  nursery: {
	  icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png',
	  shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
  }
};	

function onLoad() {
	open_popup('progress');
	initialize();
	close_popup("progress");
}

function initialize() {
 
var issetvalue = "<?= $issetvalue ?>";
if (issetvalue=="Y"){
	var maplat = "<?= $startlat ?>";
	var maplng = "<?= $startlng ?>";
	var mapzoom = 14;
} else {
	var maplat = 37.6922222;
	var maplng = -97.337222;
	var mapzoom = 4;		
}
 
geocoder = new google.maps.Geocoder(); 
var latlng = new google.maps.LatLng(maplat, maplng);
var myOptions = {
  zoom: mapzoom,
  center: latlng,
  mapTypeId: google.maps.MapTypeId.ROADMAP
};
infoWindow = new google.maps.InfoWindow;
map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
// Try W3C Geolocation method (Preferred)
if (issetvalue == "N") {
  if(navigator.geolocation) {
	browserSupportFlag = true;
	navigator.geolocation.getCurrentPosition(function(position) {
	  initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	  contentString = "Location found using W3C standard";
	  map.setCenter(initialLocation);
	  map.setZoom(8);
	  infoWindow.setContent(contentString);
	  infoWindow.setPosition(initialLocation);		  
	  // infoWindow.open(map);
	}, function() {
	  handleNoGeolocation(browserSupportFlag);
	});
  } else if (google.gears) {
	// Try Google Gears Geolocation
	browserSupportFlag = true;
	var geo = google.gears.factory.create('beta.geolocation');
	geo.getCurrentPosition(function(position) {
	  initialLocation = new google.maps.LatLng(position.latitude,position.longitude);
	  contentString = "Location found using Google Gears";
	  map.setCenter(initialLocation);
	  map.setZoom(8);
	  infoWindow.setContent(contentString);
	  infoWindow.setPosition(initialLocation);
	  // infoWindow.open(map);
	}, function() {
	  handleNoGeolocation(browserSupportFlag);
	});
  } else {
	// Browser doesn't support Geolocation
	browserSupportFlag = false;
	handleNoGeolocation(browserSupportFlag);
  }
}
  
  downloadUrl("phpsqlajax_genxml.php", function(data) {
  var xml = data.responseXML;
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
	var point = new google.maps.LatLng(
		parseFloat(markers[i].getAttribute("lat")),
		parseFloat(markers[i].getAttribute("lng")));

	html = windowhtml (id, name, username, address, city, state, zip, country, begindate, enddate, phone, website, email, type, produce);
	var icon = customIcons[type] || {};
	var marker = new google.maps.Marker({
	  map: map,
	  position: point,
	  icon: icon.icon,
	  shadow: icon.shadow
	});
	bindInfoWindow(marker, map, infoWindow, html);
  }
});
}
  
function handleNoGeolocation(errorFlag) {
  if (errorFlag == true) {
	var top_error=document.getElementById('top_error');	
	top_error.innerHTML = "<div class=\"popup_close\"><a href=\"#\" onclick=\"close_popup('top_error')\"><img src=\"/images/close.png\"></a></div>Error: The Geolocation service failed.";
	open_popup('top_error');
  } else {
	var top_error=document.getElementById('top_error');	
	top_error.innerHTML = "<div class=\"popup_close\"><a href=\"#\" onclick=\"close_popup('top_error')\"><img src=\"/images/close.png\"></a></div>Error: Your browser doesn't support geolocation.";
	open_popup('top_error');
  }
}  

function downloadUrl(url,callback) {
 var request = window.ActiveXObject ?
     new ActiveXObject('Microsoft.XMLHTTP') :
     new XMLHttpRequest;

 request.onreadystatechange = function() {
   if (request.readyState == 4) {
     request.onreadystatechange = doNothing;
     callback(request, request.status);
   }
 };

 request.open('GET', url, true);
 request.send(null);
}

function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(html);
    infoWindow.open(map, marker);
  });
}

function windowhtml (id, name, username, address, city, state, zip, country, begindate, enddate, phone, website, email, type, produce) {
	if (type=='person'){
		if (name == ''){
		   if (email == '') {
			var html = "Username: <b>" + username + "</b> <br/>" + city + ", " + state + " " + zip + " " + country;
		   } else {
			var html = "Username: <b>" + username + "</b> <br/>" + city + ", " + state + " " + zip + " " + country + "<br />";   
		   }
	   } else {
		   if (email == '') {
			var html = "Username: <b>" + username + "</b> <br/>" + name + "</b> <br/>" + city + ", " + state + " " + zip + " " + country;
		   } else {
			 var html = "Username: <b>" + username + "</b> <br/>" + name + "</b> <br/>" + city + ", " + state + " " + zip + " " + country + "<br />";  
		   }
			}
			var htmls = [html];
			}
  else if (type=='events'){
	  if (website=="") {
		  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + begindate + " to " + enddate + "<br /><h6><i>Submitted By:" + username + "</h6>";}
   else {
  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + begindate + " to " + enddate + "<br/>" + "<a href='" + website + "'>Visit Event Website</a><h6><i>Submitted By:" + username + "</h6>";}
  var htmls = [html];
  }
  
  else if (type=='winery' || type=='homebrew'){
	  if (website=="") {
		  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + phone + "<br />";}
   else {
  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + phone + "<br/><a href='" + website + "' target='_blank'>Visit " + name + "</a>";}
  	var htmls = [html];
	}

  return html;
}

function formValidator(type){
	// Make quick references to our fields
	var id = "";
	var fullname = document.getElementById('full_name');
	var username = document.getElementById('forum_un');
	var addr = document.getElementById('street_add');
	var city = document.getElementById('city');
	var state = document.getElementById('state');
	var zip = document.getElementById('zip');
	var country = document.getElementById('country');
	var begindate = document.getElementById('startevent');
	var enddate = document.getElementById('endevent');
	var phone = document.getElementById('phone');
	var website = document.getElementById('website');
	var email = document.getElementById('email');
	var produce = document.getElementById('produce');
	var type2 = capitalizeMe(type);
	
	if (type == "winery" || type == "homebrew"){
		notEmpty(fullname, type2+" Name");
		isAlphanumeric(addr, "Street Address");
		isAlphabet(city, "City");
		isAlphabet(state, "State");
		isAlphanumeric(zip, "Zip");
		madeSelection(country, "Country");
		notEmpty(phone, "Phone Number");
		notEmpty(website, "Website");
		username = "";
		begindate = "";
		enddate = "";
		email = "";
		produce = "";
		name = fullname;
	} else if (type == "person") {
		if (fullname.length == 0){
			fullname = "";
		} else {
			notEmpty(fullname, type2+" Name");
		}
		isAlphabet(city, "City");
		isAlphabet(state, "State");
		isAlphanumeric(zip, "Zip");
		madeSelection(country, "Country");
		isAlphanumeric(username, "Username");
		if (email.length == 0){
			email = "";
		} else {
			emailValidator(email, 'Email Address');
		}
		if (addr.length == 0){
			addr = "";
		}
		phone = "";
		website = "";
		begindate = "";
		enddate = "";
		produce = "";
		name = fullname;
	} else if (type == "events") {
		notEmpty(fullname, type2+" Name");
		isAlphanumeric(username, "Username");
		isAlphanumeric(addr, "Street Address");
		isAlphabet(city, "City");
		isAlphabet(state, "State");
		isAlphanumeric(zip, "Zip");
		madeSelection(country, "Country");
		notEmpty(begindate, "Event Start Date & Time");
		notEmpty(enddate, "Event End Date & Time");
		notEmpty(website, "Website");
		phone = "";
		email = "";
		produce = "";
		name = fullname;
	} else if (type == "nursery") {
	}
	
	if (errors.length > 0) {
		var errordiv=document.getElementById('errors');
		var buffer = "<div class=\"popup_close\"><a href=\"#\" onclick=\"close_popup('errors')\"><img src=\"/images/close.png\"></a></div>Problem(s) were found in the following boxes. Please correct before continuing:<br /><ul>";
		var num = 0;
		while (num <= errors.length){
			if (errors[num] != undefined){
		   		buffer = buffer + "<li>" + errors[num] + "</li>";
			}
		   num = num + 1;	
		}
		buffer = buffer + "</ul>";
		errordiv.innerHTML = buffer;
		open_popup('errors');
		errors = new Array();
	} else {
		codeAddress(id, fullname, username, addr, city, state, zip, country, begindate, enddate, phone, website, email, type, produce);
	}
	
}

function codeAddress(id, name, username, addr, city, state, zip, country, begindate, enddate, phone, website, email, type, produce) {
id = id.value;
name = name.value;
username = username.value;
addr = addr.value;
city = city.value;
state = state.value;
zip = zip.value;
country = country.value;
begindate = begindate.value;
enddate = enddate.value;
if (type == "winery" || type == "homebrew" || type == "nursery"){
	phone = phone.value;
	phone = phone.replace(/[\(\)-]/gi, "");
	phone = phone.replace(/ /gi, "");
}
if (type != "person"){
	website = encodeURIComponent(website.value);
	website = website.replace('%E2','');
	website = website.replace('%80','');
	website = website.replace('%8E','');
}
email = email.value;
produce = produce.value;

var address = addr + "," + city + "," + state + " " + zip + "," + country;
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK) {
	latlng = results[0].geometry.location;
	posttodb(name, username, addr, city, state, zip, country, begindate, enddate, phone, website, email, type, produce, latlng);
	close_popup('markerContainer');
	close_popup('addmarker');
	map.setCenter(latlng);
	var icon = customIcons[type] || {};
	website = decodeURIComponent(website);
	if (website == "http://www."){
		$website = "";
	}
	var html = windowhtml(id, name, username, addr, city, state, zip, country, begindate, enddate, phone, website, email, type, produce);
	var marker = new google.maps.Marker({
	  map: map,
	  position: latlng,
	  icon: icon.icon,
	  shadow: icon.shadow
	});	
	bindInfoWindow(marker, map, infoWindow, html);
	var top_error=document.getElementById('top_error');
	top_error.innerHTML = "<div class=\"popup_close\"><a href=\"#\" onclick=\"close_popup('top_error')\"><img src=\"/images/close.png\"></a></div>Marker added for: " + name;
	open_popup('top_error');
  } else {
	var top_error=document.getElementById('top_error');
	top_error.innerHTML = "<div class=\"popup_close\"><a href=\"#\" onclick=\"close_popup('top_error')\"><img src=\"/images/close.png\"></a></div>Geocode was not successful for the following reason: <br />" + status;
	open_popup('top_error');	
  }
});
}

function posttodb (name, username, addr, city, state, zip, country, begindate, enddate, phone, website, email, type, produce, latlng){
	str = "name=" + name + "&username=" + username + "&address=" + addr + "&city=" + city + "&state=" + state + "&zip=" + zip + "&country=" + country + "&begindate=" + begindate + "&enddate=" + enddate + "&phone=" + phone + "&website=" + website + "&email=" + email + "&type=" + type + "&produce=" + produce + "&latlng=" + latlng;

	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }

	xmlhttp.open("POST","/includes/addmarker.php?"+str,true);
	xmlhttp.send();	
}

function notEmpty(elem, formitem){
	if(elem.value.length == 0){
		errors.push(formitem);
		return false;
	}
	return true;
}

function isNumeric(elem, formitem){
	var numericExpression = /^[0-9]+$/;
	if (notEmpty(elem)){
		if (formitem == "Phone Number"){
			elem = elem.value;
			elem = elem.replace(/^\D+/, '');
			
			if(elem.match(numericExpression)){
				return true;
			}else{
				errors.push(formitem);
				return false;
			}
		} else {
			if(elem.value.match(numericExpression)){
				return true;
			}else{
				errors.push(formitem);
				return false;
			}
		}
	} else {
		errors.push(formitem);
		return false;
	}
}

function isAlphabet(elem, formitem){
	var alphaExp = /^[a-zA-Z \-'_]+$/;
	if (notEmpty(elem)){
		if(elem.value.match(alphaExp)){
			return true;
		}else{
			errors.push(formitem);
			return false;
		}
	} else {
		errors.push(formitem);
		return false;
	}
}

function isAlphanumeric(elem, formitem){
	var alphaExp = /^[0-9a-zA-Z \-'_]+$/;
	if (notEmpty(elem)){
		if(elem.value.match(alphaExp)){
			return true;
		}else{
			errors.push(formitem);
			return false;
		}
	} else {
		errors.push(formitem);
		return false;
	}
}

function lengthRestriction(elem, min, max){
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		alert("Please enter between " +min+ " and " +max+ " characters");
		errors.push(formitem);
		return false;
	}
}

function madeSelection(elem, formitem){
	if(elem.value == ""){
		errors.push(formitem);
		return false;
	}else{
		return true;
	}
}

function emailValidator(elem, formitem){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if (notEmpty(elem)){
		if(elem.value.match(emailExp)){
			return true;
		}else{
			errors.push(formitem);
			return false;
		}
	} else {
		errors.push(formitem);
		return false;
	}		
}

function capitalizeMe(obj) {
        val = obj;
        newVal = '';
        val = val.split(' ');
        for(var c=0; c < val.length; c++) {
                newVal += val[c].substring(0,1).toUpperCase() +
val[c].substring(1,val[c].length) + ' ';
        }
        return newVal;
}

function geoCode() {
	myAddress[i] = myJSONResult.results[i].formatted_address;
}

function loadPage(url) {
	open_popup('progress');
	if (url == undefined) {
		$('#markerContainer').load('index.php #header ul', hijackLinks);
	} else {
		$('#markerContainer').load(url, hijackLinks);
		open_popup('markerContainer');
	}
}

function hijackLinks() {
	$('#markerContainer a').click(function(e){
		e.preventDefault();
		loadPage(e.target.href);
	});
	close_popup('progress');
}

function open_popup(divname) {
	var opendiv=document.getElementById(divname);
	opendiv.style.visibility= "visible";
	if (divname == "addmarker" || divname == "onoffmarker"){
		var overlay=document.getElementById('overlay');
		overlay.style.visibility= "visible";
	}
}

function close_popup(divname) {
	var closediv=document.getElementById(divname);
	closediv.style.visibility= "hidden";
	if (divname == "addmarker" ||  divname == "onoffmarker"){
		var overlay=document.getElementById('overlay');
		overlay.style.visibility= "hidden";
	}
}

function doNothing() {}
</script>
</head>
<body onLoad="onLoad()">
<div id="overlay"></div>

<div id="map_canvas" style="width:100%; height:100%" ></div>

<div id="progress">
Loading...
</div> 

<div id="errors">
<center>
<div class="popup_close"><a href="#" onClick="close_popup('errors')"><img src="/images/close.png"></a></div>
</center>
</div>

<div id="top_error"></div>

<div id="markerContainer"></div>

<div id="addmarker">
<div class="popup_close"><a href="#" onClick="close_popup('addmarker')"><img src="/images/close.png"></a></div>
    <ul>
    <li><a href="#" onClick="loadPage('/includes/winery.php')"><img src="http://labs.google.com/ridefinder/images/mm_20_purple.png" width="12" height="20" title="Winery Markers" alt="Winery Marker" /> Winery</a></li>
    <li><a href="#" onClick="loadPage('/includes/homebrew.php')"><img src="http://labs.google.com/ridefinder/images/mm_20_yellow.png" width="12" height="20" title="Homebrew Store Markers" alt="Homebrew Store Marker" /> Homebrew Store</a></li>
    <li><a href="#" onClick="loadPage('/includes/person.php')"><img src="http://labs.google.com/ridefinder/images/mm_20_red.png" width="12" height="20" title="Forum Members Markers" alt="Forum Mmebers Marker" /> Forum Member</a></li>
    <li><a href="#" onClick="loadPage('/includes/events.php')"><img src="http://labs.google.com/ridefinder/images/mm_20_blue.png" width="12" height="20" title="Events Markers" alt="Events Marker" /> Event</a></li>
    <!-- <li><a href="#" onClick="loadPage('/includes/nursery.php')"><img src="http://labs.google.com/ridefinder/images/mm_20_green.png" width="12" height="20" title="Nurseries" alt="Nurseries" /> Nursery</a></li> -->
    </ul>
</div>

<div id="onoffmarker">
<div class="popup_close"><a href="#" onClick="close_popup('onoffmarker')"><img src="/images/close.png"></a></div>
<form name="form1" action="" align="left"><strong>Legend / Toggles</strong></p>
<ul>
<li><img src="http://labs.google.com/ridefinder/images/mm_20_red.png" title="Forum Members Markers" alt="Forum Mmebers Marker" /> 
<input type="checkbox" id="personCheckbox" onClick="toggleGroup('person')" CHECKED /> Forum Members</li>
<li><img src="http://labs.google.com/ridefinder/images/mm_20_blue.png" title="Events Markers" alt="Events Marker" />
<input type="checkbox" id="eventCheckbox" onClick="toggleGroup('event')" CHECKED /> Events</li>
<li><img src="http://labs.google.com/ridefinder/images/mm_20_yellow.png" title="Homebrew Store Markers" alt="Homebrew Store Marker" /> <input type="checkbox" id="homebrewCheckbox" onClick="toggleGroup('homebrew')" CHECKED /> Homebrew Stores</li> 
<li><img src="http://labs.google.com/ridefinder/images/mm_20_purple.png" title="Winery Markers" alt="Winery Marker" /> <input type="checkbox" id="wineryCheckbox" onClick="toggleGroup('winery')" CHECKED /> Wineries</li>
<!-- <li><img src="http://labs.google.com/ridefinder/images/mm_20_green.png" title="Nurseries" alt="Nurseries" /> <input type="checkbox" id="nurseryCheckbox" onclick="toggleGroup('nursery')" CHECKED /> Nurseries</li>  -->
</ul>
</form>
</div>
<?
include ('includes/footer.php');
?>