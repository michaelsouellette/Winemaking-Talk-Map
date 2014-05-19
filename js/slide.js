$(document).ready(function() {
	
	// Expand Add User Panel
	$("#openlocation").click(function(){
		$("div#panel").slideToggle("slow");
	
	});		
	
	// Expand Add Event Panel
	$("#openevent").click(function(){
		$("div#eventpanel").slideToggle("slow");
	
	});	
	
	// Expand Add Winery Panel
	$("#openwinery").click(function(){
		$("div#winerypanel").slideToggle("slow");
	
	});	
	
	// Expand Add Homebrew Store Panel
	$("#openhomebrew").click(function(){
		$("div#homebrewpanel").slideToggle("slow");
	
	});	
	
	// Expand Add Nursery Panel
	$("#opennursery").click(function(){
		$("div#nurserypanel").slideToggle("slow");
	
	});	
	
	// Expand iPanel
	$("#openinfo").click(function(){
		$("div#ipanel").slideToggle("slow");
	
	});	
	
	// Expand On/Off Panel
	$("#openonoff").click(function(){
		$("div#onoffpanel").slideToggle("slow");
	
	});	
	
	// Expand Search Panel
	$("a#opensearch").click(function(){
		$("div#searchpanel").toggle("slow");
		$(this).toggleClass("active");
		return false;
	});	
		
});