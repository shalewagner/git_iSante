var centerLatitude = 18.9;
var centerLongitude = -73.0;
var startZoom = 8;
var map;

var iconGreen = new GIcon();
iconGreen.image = 'http://labs.google.com/ridefinder/images/mm_20_green.png';
iconGreen.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
iconGreen.iconSize = new GSize(12, 20);
iconGreen.shadowSize = new GSize(22, 20);
iconGreen.iconAnchor = new GPoint(6, 20);
iconGreen.infoWindowAnchor = new GPoint(5, 1);

var iconRed = new GIcon();
iconRed.image = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
iconRed.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
iconRed.iconSize = new GSize(12, 20);
iconRed.shadowSize = new GSize(22, 20);
iconRed.iconAnchor = new GPoint(6, 20);
iconRed.infoWindowAnchor = new GPoint(5, 1);

var iconBlack = new GIcon();
iconBlack.image = 'http://labs.google.com/ridefinder/images/mm_20_black.png';
iconBlack.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
iconBlack.iconSize = new GSize(12, 20);
iconBlack.shadowSize = new GSize(22, 20);
iconBlack.iconAnchor = new GPoint(6, 20);
iconBlack.infoWindowAnchor = new GPoint(5, 1);

var iconBlue = new GIcon();
iconBlue.image = 'http://labs.google.com/ridefinder/images/mm_20_blue.png';
iconBlue.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
iconBlue.iconSize = new GSize(12, 20);
iconBlue.shadowSize = new GSize(22, 20);
iconBlue.iconAnchor = new GPoint(6, 20);
iconBlue.infoWindowAnchor = new GPoint(5, 1);

var iconOrange = new GIcon();
iconOrange.image = 'http://labs.google.com/ridefinder/images/mm_20_orange.png';
iconOrange.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
iconOrange.iconSize = new GSize(12, 20);
iconOrange.shadowSize = new GSize(22, 20);
iconOrange.iconAnchor = new GPoint(6, 20);
iconOrange.infoWindowAnchor = new GPoint(5, 1);

var customIcons = [];
customIcons['green'] = iconGreen;
customIcons['red'] = iconRed;
customIcons['black'] = iconBlack;
customIcons['blue'] = iconBlue;
customIcons['orange'] = iconOrange;

function addMarker(latitude, longitude, name, description, mapColor, lastDate) {
	var myIcon = customIcons[mapColor];
	var options = {
		title: name + '(' + lastDate + ')',
		icon: myIcon
	};
	var marker = new GMarker(new GLatLng(latitude, longitude), options);
	GEvent.addListener(marker, 'click',
		function() {
			marker.openInfoWindowHtml(description);
		}
	);
	GEvent.addListener(marker, 'infowindowclose',
		function() {
			map.setCenter(new GLatLng(centerLatitude, centerLongitude), startZoom);
		}
	);
	map.addOverlay(marker);
}

function init() {
  if (GBrowserIsCompatible()) {
    map = new GMap2(document.getElementById("map"));
	map.addControl(new GSmallMapControl());
    map.setCenter(new GLatLng(centerLatitude, centerLongitude), startZoom);

	for(i=0; i<markers.length; i++) {
		addMarker(markers[i].latitude, markers[i].longitude, markers[i].name, markers[i].description, markers[i].mapColor, markers[i].lastDate);
	}

  }
}

window.onload = init;
window.onunload = GUnload;
