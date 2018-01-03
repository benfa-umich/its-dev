<html>

<head>
<title>ITCom: University of Michigan wireless network locations</title>

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

</head>

<body>
         
<h1>UM Wireless Network locations</h1>

<?

include "../campus_map/maps-array.php";

foreach($floorplans as $key => $value)
	{
?>
<h3><? echo $value[name]; ?></h3>
<?
	if($value[floors] != "")
		{
?>
<ul>
<?
		foreach($value[floors] as $key => $value)
			{
?>
<li><a href="<? echo $key; ?>"><? echo $value; ?></a></li>
<?
			}
?>
</ul><p>

<?
		}
if($value[floors] == "")
		{
?>
<? echo $value[alttext]; ?><p>

<?
		}
	}

?>

<a href="/wireless/campus_map/">&#171; Wireless Network Locations Campus Map</a><p>

</body>
</html>