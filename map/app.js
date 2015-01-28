var centerLatitude = 18.9;
var centerLongitude = -73.0;
var startZoom = 9;
var map;

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

    var customIcons = [];
    customIcons['local'] = iconBlue;
    customIcons['asp'] = iconRed;

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

    var customIcons = [];
    customIcons['local'] = iconBlue;
    customIcons['asp'] = iconRed;

function addMarker(latitude, longitude, name, description, dbSite, lastDate) {
	if (dbSite == 0) var myIcon = customIcons['asp'];
	else var myIcon = customIcons['local'];
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
		addMarker(markers[i].latitude, markers[i].longitude, markers[i].name, markers[i].description, markers[i].dbSite, markers[i].lastDate);
	}

  }
}

window.onload = init;
window.onunload = GUnload;