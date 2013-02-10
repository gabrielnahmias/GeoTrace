<?php

//error_reporting(E_ALL);

require "common.php";

?><!doctype html> 
<html lang="en">
<head>
<title><?=NAME . ( (!$bI) ? (SEP.DESC) : "" )?></title>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="content-language" content="en" />
<meta name="author" content="Gabriel Nahmias" />
<meta name="keywords" content="Google maps, Geolocation, Geo positioning, find devices, find iphone, find my iphone" />
<meta name="description" content="Shows your devices' geolocation using Google maps." />

<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="<?=DIR_CSS?>/normalize/min/normalize.css" />
<link type="text/css" rel="stylesheet" href="<?=DIR_CSS?>/styles.css" />
<?=$oBr->getStylesheet()?>

</head>

<body>

<div id="map_canvas" class="map"></div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?=DIR_JS?>/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=DIR_JS?>/jquery.standalone.min.js"></script>
<script type="text/javascript" src="<?=DIR_JS?>/map/jquery.ui.map.js"></script>
<script type="text/javascript" src="<?=DIR_JS?>/map/jquery.ui.map.overlays.js"></script>
<script type="text/javascript" src="<?=DIR_JS?>/map/jquery.ui.map.extensions.js"></script>
<script src="http://j.maxmind.com/app/geoip.js" charset="UTF-8" type="text/javascript" ></script>
<script type="text/javascript">

$( function() {
	
	var $Map = $("#map_canvas"),
		refresher;
	
	// If it's not a standalone (native) web application, scroll the window down
	// past the address bar (to focus on the map).
	
	if (!$.browser.standalone)
		window.scrollTo(0, 1);
	
	$Map.gmap( {
		
		disableDefaultUI: false,
		
		mapTypeControl: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
		
		mapTypeId: google.maps.MapTypeId.HYBRID,
		
		callback: function() {
			
			var self = this;
			
			$.getJSON("assets/inc/locate.php", function(coords) {
			
			//self.getCurrentPosition( function(position, status) {
				
				console.debug( "Latitude: " , coords.latitude );
				console.debug( "Longitude: " , coords.longitude );
				
				// Remove extraneous map data info.
				
				$("img[src*=google_white]").remove();
				
				$(".gmnoprint:first").remove();
				$(".gmnoprint:first").remove();		// Instead of just removing this "Report error" link, change its HREF and title.
				
				//if (status === 'OK') {
				
				self.set('clientPosition', new google.maps.LatLng(/*position.coords.latitude*/ coords.latitude , /*position.coords.longitude*/ coords.longitude ) );
				
				self.addMarker( { 'position' : self.get('clientPosition'), 'bounds': true } ).click( function() {
					
					self.openInfoWindow( {'content': "This is your device's current location."}, this );
					
				} );
				
				self.addShape('Circle',
					
					{
						center: self.get('clientPosition'),
						clickable: false,
						strokeWeight: 0,
						fillColor: "#008595",
						fillOpacity: 0.25,
						radius: 15
					}
					
				);
				
				// Start refreshing the map.
				
				( function() {
					
					refresher = window.setInterval( function() {
						
						$("#map_canvas").gmap("refresh");
						
						//console.debug("Refreshing map.");
						
						//window.clearInterval(intervalId);
						
					}, 1000);
				
				} )();
				
				//}
				
			} );
		   
		}
	
	} );
	
} );

</script>

</body>

</html>