<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
<title>U-M WiFi Network Locations</title>

<meta name="viewport" content="initial-scale=1.0, user-scalable=yes"/>

<link rel="StyleSheet" type="text/css" href="/wireless/global.css"/>
<style type="text/css">
ul {
/*	margin:0 0 0 10px;
	padding:0 0 0 10px;*/
	list-style-type:square;
}
.indent {
	margin-left:40px;
}
</style>

</head>

<body>

<? include "../page-banner.php"; ?>

<? include "../left-nav.php"; ?>

<div id="pageContent">

<div id="backLinks">
<p>&laquo; <a href="<? echo $http_URL; ?>">WiFi</a> &laquo; <a href="/wireless/campus_map/">Network Locations</a></p>
</div>

<h1>U-M WiFi Network Locations</h1>

<ul>
<?

include "../campus_map/maps-array.php";

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

foreach($floorplans as $key => $value)
	{
?>
<li><a href="../campus_map/maps.php?loc=<? echo $key; ?>"><? echo $value["name"]; ?></a></li>
<? 	}
?>
</ul>

<? include "../service-center.php"; ?>

<p><a href="/wireless/campus_map/">&laquo; U-M WiFi Network Locations Map</a></p>

</div>

<? include "/afs/umich.edu/group/itd/itcomweb/Public/html/includes/service-footer.php"; ?>

</body>
</html>
