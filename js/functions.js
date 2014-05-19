// JavaScript Document
$(document).ready(function(){
	loadPage();
});

$(document.getElementsByTagName('map_canvas')[0]).ready(function() {
// do stuff when div is ready
	close_popup("progress");
});

var geocoder;
var map;

function initialize() {
open_popup('progress');
  
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
var infoWindow = new google.maps.InfoWindow;
var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
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
	if (type=='person'){
		   if (name == ''){
		   if (email == '') {
			var html = "Username: <b>" + username + "</b> <br/>" + city + ", " + state + " " + zip + " " + country;
		   } else {
			var html = "Username: <b>" + username + "</b> <br/>" + city + ", " + state + " " + zip + " " + country + "<br /><a href=\"#\" onclick='loadPage(\"/includes/editdetails.php?id=" + id + "\")'>Edit Entry</a>";   
		   }
	   } else {
		   if (email == '') {
			var html = "Username: <b>" + username + "</b> <br/>" + name + "</b> <br/>" + city + ", " + state + " " + zip + " " + country;
		   } else {
			 var html = "Username: <b>" + username + "</b> <br/>" + name + "</b> <br/>" + city + ", " + state + " " + zip + " " + country + "<br /><a href=\"#\" onclick='loadPage(\"/includes/editdetails.php?id=" + id + "\")'>Edit Entry</a>";  
		   }
			}
			var htmls = [html];
			}
  else if (type=='event'){
	  if (website=="") {
		  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + begindate + " to " + enddate + "<br /><a href=\"#\" onclick='loadPage(\"/includes/editdetails.php?id=" + id + "\")'>Edit Entry</a><h6><i>Submitted By:" + username + "</h6>";}
   else {
  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + begindate + " to " + enddate + "<br/>" + "<a href='" + website + "'>Visit Event Website</a> | <a href=\"#\" onclick='loadPage(\"/includes/editdetails.php?id=" + id + "\")'>Edit Entry</a><h6><i>Submitted By:" + username + "</h6>";}
  var htmls = [html];
  }
  
  else if (type=='winery' || type=='homebrew'){
	  if (website=="") {
		  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + phone + "<br /><a href=\"#\" onclick='loadPage(\"/includes/editdetails.php?id=" + id + "\")'>Edit Entry</a>";}
   else {
  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + city + ", " + state + " " + zip + " " + country + "<br/>" + phone + "<br/><a href='" + website + "' target='_blank'>Visit " + name + "</a> | <a href=\"#\" onclick='loadPage(\"/includes/editdetails.php?id=" + id + "\")'>Edit Entry</a>";}
  var htmls = [html];
  }
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
	top_error.innerHTML = "<div class=\"popup_close\"><a href=\"#\" onclick=\"close_popup('top_error')\"><img src=\"/images/close.png\"></a></div>Error: Your browser doesn't support geolocation. Are you in Siberia?";
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

var errors=new Array();
function formValidator(type){
	// Make quick references to our fields
	var fullname = document.getElementById('full_name');
	var addr = document.getElementById('street_add');
	var city = document.getElementById('city');
	var state = document.getElementById('state');
	var zip = document.getElementById('zip');
	var country = document.getElementById('country');
	var phone = document.getElementById('phone');
	var website = document.getElementById('website');
	var type2 = capitalizeMe(type);
	
	if (type == "winery" || type == "homebrew"){
		// Check each input in the order that it appears in the form!
		notEmpty(fullname, errors, type2+' Name');
		isAlphanumeric(addr, errors, 'Street Address');
		isAlphabet(city, errors, "City");
		madeSelection(state, errors, "State");
		isNumeric(zip, errors, "Zip");
		madeSelection(country, errors, "Country");
		isNumeric(phone, errors, "Phone Number");
	} else if (type == "person") {
		if(lengthRestriction(username, 6, 8)){
			if(emailValidator(email, "Please enter a valid email address")){
				return true;
			}
		}
	} else if (type == "events") {
	} else if (type == "nursery") {
	}
	
	alert(errors.length);
	if (errors.length > 0) {
		var overlay=document.getElementById('overlay');	
		overlay.innerHTML = "<div class=\"popup_close\"><a href=\"#\" onclick=\"close_popup('overlay')\"><img src=\"/images/close.png\"></a></div>Problem(s) were found in the following boxes. Please correct before continuing:<br />" + errors;
		open_popup('overlay');
		errors = new Array();
	} else {
		codeAddress(addr, city, state, zip, country);
	}
	
}

function codeAddress(addr, city, state, zip, country) {
addr = addr.value;
city = city.value;
state = state.value;
zip = zip.value;
country = country.value;

var address = addr + "," + city + "," + state + " " + zip + "," + country;
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK) {
	alert('Address entered: ' + address);
	latlng = results[0].geometry.location;
	alert('latlng: ' + latlng);
	close_popup('markerContainer');
	map.setCenter(results[0].geometry.location);
	var marker = new google.maps.Marker({
		map: map, 
		position: results[0].geometry.location
	});
  } else {
	alert('Address entered: ' + address);
	var top_error=document.getElementById('top_error');
	top_error.innerHTML = "<div class=\"popup_close\"><a href=\"#\" onclick=\"close_popup('top_error')\"><img src=\"/images/close.png\"></a></div>Geocode was not successful for the following reason: <br />" + status;
	open_popup('top_error');	
  }
});
}

function posttodb (){
	if (str.length==0)
	  { 
	  document.getElementById("txtHint").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","gethint.php?q="+str,true);
	xmlhttp.send();	
}

function notEmpty(elem, errorMsg, formitem){
	if(elem.value.length == 0){
		errors.push(formitem);
		return false;
	}
	return true;
}

function isNumeric(elem, errorMsg, formitem){
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

function isAlphabet(elem, errorMsg, formitem){
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

function isAlphanumeric(elem, errorMsg, formitem){
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

function madeSelection(elem, errorMsg, formitem){
	if(elem.value == ""){
		errors.push(formitem);
		return false;
	}else{
		return true;
	}
}

function emailValidator(elem, errorMsg, formitem){
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
	http://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&sensor=true_or_false
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
}

function close_popup(divname) {
	var closediv=document.getElementById(divname);
	closediv.style.visibility= "hidden";
}

function doNothing() {}