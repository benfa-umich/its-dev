<?

include("DB.php");

// If the OCI libraries are not loaded, load them now.
if($_SERVER["HTTP_HOST"] != "localhost" && !extension_loaded("oci8"))
	{
	if(!dl("oci8.so"))
		{
		die("Unable to load Oracle extension, oci8.so.");
		}
	}

if ($_SERVER["HTTP_HOST"] == "develop.www.umich.edu" || $_SERVER["HTTP_HOST"] == "staging.www.umich.edu")
	{
	$config = array(
		"siteServer" => $_SERVER["HTTP_HOST"],
		"siteBaseUrlHtml" => "/showcase/");
//	$db = oci_connect("showcase", "Sh0wcas3", "babel.world");
//	$db = oci_pconnect("showcase", "Sh0wcas3", "babel.world");
	$showcase_db = OCILogon("showcase", "C0mput3rSh0wcas3", "its_oradev.world");
	}
elseif($_SERVER["HTTP_HOST"] == "localhost")
	{
	}
else	{
	$config = array(
//		"siteServer" => "showcase.itcs.umich.edu",
		"siteServer" => "computershowcase.umich.edu",
		"siteBaseUrlHtml" => "/");
//	$db = oci_connect("showcase", "C0mput3rSh0wcas3", "kannada.world");
	$showcase_db = oci_pconnect("showcase", "C0mput3rSh0wcas3", "kannada.world");
	}

//if($showcase_db) { echo "HEADER DB YEP"; } else { echo "HEADER DB NOPE"; }
	
if($_SERVER["HTTP_HOST"] != "localhost")
	{
	$alter_date = OCIParse($showcase_db, "ALTER SESSION SET NLS_DATE_FORMAT = 'MM/DD/YYYY HH24:MI'");
	OCIExecute($alter_date);
	}

$giftcards = array(000365,445691,714689,715193,771155,771150,713333,711092,770015,770025,770050,771115,772213,772259,772262,772218,772225,772262,772276,772281,772220,772248,772269,888020,888050,888000);

?>
