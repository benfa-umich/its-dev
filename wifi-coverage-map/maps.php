<?
include "maps-array.php";
$loc = $_REQUEST["loc"];
$plans = $_REQUEST["plans"];
$dorms = array("bursley", "southquad");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/><meta name="viewport" content="initial-scale=1.0, user-scalable=yes"/>

<title><? echo $floorplans[$loc]["name"]; ?></title>

<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic:latin"/>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Slab:400,700:latin"/>
<style type="text/css">
body {
	margin:20px;
	background:#ffffff;
	font-size:1em;
	font-family:Roboto;
	color:#333333;
}
h1 {
	margin-top:0;
	font-family:'Roboto Slab';
	color:#00274c;
}
h2 {
	margin-top:0;
	font-family:'Roboto Slab';
	color:#40658f;
}
form {
	display:inline;
	margin:0;
}
select {
	font-size:1em;
	font-family:inherit;
}
img {
	max-width:100%;
	height:auto;
}
a {
	color:#0000ff;
/*	text-decoration:none;*/
}
a:hover {
	color:#cc3300;
	text-decoration:underline;
}
.floatR {
	float:right;
	margin:0 0 0 20px;
	white-space:nowrap;
}
.indent {
	margin-left:40px;
}
.nobr {
	white-space:nowrap;
}
</style>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-12471005-1', 'umich.edu');
  ga('send', 'pageview');

  function recordOutboundLink(link, category, action, label) {
    ga('send', 'event', category, action, label);
    setTimeout('document.location = "' + link.href + '"', 500);
  }
</script>

</head>

<body onload="window.focus();">

<h1><? echo $floorplans[$loc]["name"]; ?></h1>

<? if(count($floorplans[$loc]["floors"]) > 1)
	{
	if($floorplans[$loc]["floors"] != "")
		{
?>
<form name="plans" method="post" action="<? echo $_SERVER["PHP_SELF"]; ?>">
<input type="hidden" name="loc" value="<? echo $loc; ?>"/>
<p><select name="plans" onchange="document.plans.submit()">
<option value="">Select a Floor to View:</option>
<?
	foreach($floorplans[$loc]["floors"] as $plan => $floor)
		{
?>
<option value="<? echo $plan; ?>"><? echo $floor; ?></option>
<?
		}
?>
</select></p>
</form>

<?		}
	}
?>

<? if(count($floorplans[$loc]["floors"]) < 1)
	{
	echo "<p>".$floorplans[$loc]["alttext"]."</p><p>&nbsp;</p>";
	}
else	{
?>
<?	if(isset($plans))
		{
		$image = $plans;
		}
	else	{
		$noplan = array_keys($floorplans[$loc]["floors"]);
		$image = $noplan[0];
		}
	$image_size = getimagesize("maps/".$image);
	echo "<h2>".$floorplans[$loc]["floors"][$image]."</h2>";
	if($floorplans[$loc]["alttext"] != "")
		{
		echo $floorplans[$loc]["alttext"]."<br/>";
		}
?>

<p><img src="maps/<? echo $image; ?>" <? echo $image_size[3]; ?> alt="<? echo $floorplans[$loc]["name"]." ".$floorplans[$loc]["floors"][$image]; ?>"/></p>

<p><strong>WiFi (MWireless, MGuest, eduroam) available in shaded areas</strong><br/>
<img src="umwireless-icon.gif" width="10" height="10" alt="802.11 a/b/g"/> 802.11 a/<!--b/-->g<br/>
<img src="mwireless-icon.gif" width="10" height="10" alt="802.11 a/b/g/n"/> 802.11 a/<!--b/-->g/n<? if($loc=="dent") { ?> (MWireless Only)<? } if(in_array($loc,$dorms)) { ?><br/>
<img src="bursley-icon.gif" width="10" height="10" alt="802.11 a/b/g/n - not guaranteed"/> If WiFi signal is weak, report location information to <a href="mailto:resnet@umich.edu">resnet@umich.edu</a> or <span class="nobr">734-647-1133.</span><? } ?></p>

<?
	}
?>

<h2>For Assistance or Questions</h2>

<p>Contact the ITS Service Center:</p>

<p>Monday–Thursday, 7 a.m.–7 p.m.; Friday, 7 a.m.–6 p.m.; Sunday, 2–7 p.m.</p>

<div class="indent">
<p><a href="http://its.umich.edu/help/request/" target="_blank">Submit a Service Request Online</a><br/>
734-764-HELP (764-4357)<br/>
<a href="mailto:4HELP@umich.edu">4HELP@umich.edu</a><br/>
<a href="http://its.umich.edu/help/" target="_blank">http://its.umich.edu/help/</a></p>
</div>

</body>
</html>