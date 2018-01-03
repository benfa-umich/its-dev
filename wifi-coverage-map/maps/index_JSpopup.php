<html>

<head>
<title>ITCom: UM Wireless Network Locations</title>

<link rel="StyleSheet" type="text/css" href="/includes/itcom.css">
<style>
body {
	margin:20px;
	font-size:12px;
	font-family:Arial,Helvetica,sans-serif;
	color:#003366;
}
ul {
	margin-top:0px;
	list-style-type:square;
}
</style>

<script language="JavaScript">

function popUp(url) {
window.open(url, 'maps', 'location=0,resizable=1,status=0,titlebar=1,directories=0,toolbar=0,menubar=0,scrollbars=1,width=800,height=600');
}

function link() {
}

</script>

</head>

<body>
         
<h1>UM Wireless Network Locations</h1>

<ul>
<?

include "../campus_map/maps-array.php";

foreach($floorplans as $key => $value)
	{
?>
<li><a href="javascript:link()" onClick="popUp('../campus_map/maps.php?loc=<? echo $key; ?>',800,600)"><? echo $value[name]; ?></a></li>
<? 	}
?>
</ul><p>

<a href="/wireless/campus_map/">&#171; Wireless Network Locations Campus Map</a><p>

</body>
</html>