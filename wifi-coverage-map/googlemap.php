<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/><title>U-M WiFi Locations</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=yes"/>
<style type="text/css">
html {
	height:100%;
}
body {
	height:100%;
	margin:0;
	padding:0;
	font-size:1em;
	font-family:sans-serif;
}
#map_canvas {
	height:100%;
	font-size:.8em;
	font-family:Arial,Helvetica,sans-serif;
	line-height:150%;
}
#map_canvas a:link {
	color:#0000ff;
	text-decoration:none;
}
#map_canvas a:visited {
	color:#9933cc;
	text-decoration:none;
}
#map_canvas a:hover {
	color:#cc3300;
	text-decoration:none;
}
#map_canvas a:active {
	color:#cc9933;
	text-decoration:none;
}
.gm-style-iw div {
	width:auto !important;
	overflow:hidden !important;
}
</style>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="//code.google.com/apis/gears/gears_init.js"></script>
<script type="text/javascript">
//<![CDATA[

function initialize() {

var myLocation;
var browserSupportFlag = new Boolean();
var centralCampus = new google.maps.LatLng(42.277039,-83.738091);
var myOptions = {
	zoom: 16,
	mapTypeId: google.maps.MapTypeId.ROADMAP
};
var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
map.setCenter(centralCampus);
setMarker(centralCampus);

var infoWindow = new google.maps.InfoWindow({
	maxWidth: 480
	});

function setMarker(centralCampus) {
	var Mimage = new google.maps.MarkerImage(
		"m-icon.png",
		new google.maps.Size(26,31),
		new google.maps.Point(0,0),
		new google.maps.Point(13,31)
		);
	var UMcentralCampus = new google.maps.Marker({
		map: map,
		position: centralCampus,
		icon: Mimage,
		clickable: false,
		title: "University of Michigan"
	});
	UMcentralCampus.setMap(map);
}

function downloadUrl(url,callback) {
	var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest; 
	request.onreadystatechange = function() { 
		if (request.readyState == 4) { 
			//request.onreadystatechange = doNothing; 
			//request.onreadystatechange = alert('ready'); 
			callback(request, request.status); 
			} 
		};
	request.open('GET', url, true); 
	request.send(null); 
}

downloadUrl("markers.xml", function(data) { 
	var xml = data.responseXML; 
	var markers = xml.documentElement.getElementsByTagName("marker"); 
	for (var i = 0; i < markers.length; i++) { 
		var name = markers[i].getAttribute("name");
		var nickname = markers[i].getAttribute("nickname");
		var address = markers[i].getAttribute("address"); 
		var coverage = markers[i].getAttribute("coverage"); 
		var type = markers[i].getAttribute("type"); 
		var point = new google.maps.LatLng( 
			parseFloat(markers[i].getAttribute("lat")), 
			parseFloat(markers[i].getAttribute("lng"))); 
		if(nickname!="") {
			var html = "<div style=\"min-width:340px;min-height:3em;overflow:auto;\"><p style=\"margin:.5em;\"><strong>"+name+"</strong><br/>"+coverage+"<br/><a href='javascript:link()' onclick='popup(\"maps.php?loc="+nickname+"\")'>View WiFi Coverage &raquo;</a></p></div>";
		} else {
			var html = "<div style=\"min-width:340px;min-height:3em;overflow:auto;\"><p style=\"margin:.5em;\"><strong>"+name+"</strong><br/>"+coverage+"<br/>"+name+" has pervasive WiFi coverage</p></div>";
			}
		var icon = customIcons[type] || {}; 
		var marker = new google.maps.Marker({ 
			map: map, 
			position: point, 
			icon: icon.icon,
			title: name
		}); 
	bindInfoWindow(marker, map, infoWindow, html); 
	} 
});

var customIcons = {
	Wireless: {
		icon: 'wifi-its.png'
	},
	MWireless: {
		icon: 'wifi-icon.png'
	},
	UMHHC: {
		icon: 'wifi-umhhc.png'
	}
};

function bindInfoWindow(marker, map, infoWindow, html) {
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.open(map, marker);
		infoWindow.setContent(html);
		});
	}

}

//]]>
</script>

<script type="application/x-javascript">
addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar() {
	window.scrollTo(0,1);
}
</script>

<?// include "../../includes/ismobile.php"; ?>
<script language="JavaScript" type="text/javascript">
function popup(url) {
	window.open(url, 'maps', 'top=100,left=100,location=0,resizable=1,status=0,titlebar=1,directories=0,toolbar=0,menubar=1,scrollbars=1,width="80%",height="80%"');
}
function link() {}
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-16685041-1', 'umich.edu');
  ga('send', 'pageview');

  function recordOutboundLink(link, category, action, label) {
    ga('send', 'event', category, action, label);
    setTimeout('document.location = "' + link.href + '"', 500);
  }
</script>

</head>
<body onload="initialize()">

<div id="map_canvas" style="width:100%; height:100%"></div>

</body>
</html>