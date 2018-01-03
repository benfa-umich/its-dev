<?php
//DON'T show the many uninformative errors the oci8 module kicks out
error_reporting(E_ERROR);

include("DB.php");

function ociquery($querytype, $code, $time) {

$equipment_categories = array(
	"ACC" => "Handsets and Cords",
	"ELE" => "Electronic Telephones",
	"IPT" => "IP Telephones",
	"STD" => "Basic Telephones",
	"IMP" => "Equipment for the Hearing Impaired",
	"HED" => "Headsets",
	"CON" => "Conference Telephones (Traditional)",
	"NET" => "Network Cables");


//DEV
//	$username = "RMTITCOMOSC_PINNDEV2";
//	$password = "bnt6acew3";
//	$hostspec = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=pinntst.dsc.umich.edu)(PORT=1521))(CONNECT_DATA=(SID=pinndev)))";
//QA
	$username = "RMTITCOMOSC_PINNQA2";
	$password = "t5redm7b";
	$hostspec = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=pinntst.dsc.umich.edu)(PORT=1521))(CONNECT_DATA=(SID=pinnqa)))";
//PROD
//	$username = "RMTITCOMOSC_PINNPROD2";
//	$password = "dcV5Iszq";
//	$hostspec = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=pinnprd.dsc.umich.edu)(PORT=1521))(CONNECT_DATA=(SID=PINNPROD)))";

$db = DB::connect("oci8://$username:$password@$hostspec");
if (DB::isError($db)) {
	echo "Database connection failed: ";
	echo $db->getMessage();
}

if ($querytype == "doLabor") {
	$query = "select id, standard_rate, overtime_rate, season_rate, holiday_rate from PINN_CUSTOM.UM_ECOMM_LABOR_RATES_V";
	$result = $db->getAssoc($query);
	echo "$".number_format($result[$code][$time], "2");
}

if ($querytype == "doRate" || "doRepair") {
	$sql = "select ITEM_CODE, CHARGE_AMOUNT from PINN_CUSTOM.UM_ECOMM_CURRENT_MRC_OCC_V where CHARGE_AMOUNT > 0 order by ITEM_CODE";
	$res = $db->getAssoc($sql);
	if ($querytype == "doRate") {
		echo "$".number_format($res[$code], "2");}
	else if ($querytype == "doRepair") {
		$repairhour = $res[$code]*$time;
		echo "$".number_format(round($repairhour), "2");
	}
}

if ($querytype == "doEstLaborTest") {
	$query = "select id, standard_rate, overtime_rate, season_rate, holiday_rate from PINN_CUSTOM.UM_ECOMM_LABOR_RATES_V";
	$res = $db->getAssoc($query);
	return $res[$code][$time];
}
if ($querytype == "doEstTest") {
	$sql = "select ITEM_CODE, CHARGE_AMOUNT from PINN_CUSTOM.UM_ECOMM_CURRENT_MRC_OCC_V where CHARGE_AMOUNT > 0 order by ITEM_CODE";
	$res = $db->getAssoc($sql);
	return $res[$code];
}

if ($querytype == "doTaxRate") {
	$tax_sql = "select tax_type, tax_pct from PINN_CUSTOM.UM_ECOMM_TAX_CHARGED_V";
	$tax_res = $db->getAssoc($tax_sql);
	echo $tax_res[$code];
}


if ($querytype == "doAssistRate") {
	$dir_asst_sql = "select CLASS_OF_SERVICE, DIR_ASST_CHARGE_INTRA_LATA from PINN_CUSTOM.UM_ECOMM_DIR_ASST_V";
	$dir_asst_res = $db->getAssoc($dir_asst_sql);
	echo "$".number_format($dir_asst_res[$code], "2");
}

if ($querytype == "doCallingCardRate") {
	$carriers = array("AMERITECH", "ATT", "QWEST", "SPRINT");
	foreach($carriers as $carrier) {
		$sql = "select SETTLEMENT_TRANS, INIT_MIN_DAY from PINN_CUSTOM.UM_ECOMM_CALLING_CARD_RATES_V where CARRIER like '$carrier%'";
		$callingcard_res = $db->getAssoc($sql);
		$carriers[$carrier] = $callingcard_res;
	}	
		echo "$".number_format($carriers[$carrier][$code], "2");	
}
	
if ($querytype == "doLongDistanceRates") {
	$ldrate_sql = "select * from PINN_CUSTOM.UM_ECOMM_INTERNATIONAL_RATES_V order by COUNTRY_NAME";
	$ldrate_res = $db->getAssoc($ldrate_sql);
	echo "<table class=\"alt-row-table\">";
	echo "<thead><tr><th scope=\"col\">Country Code</th><th scope=\"col\">Country</th><th scope=\"col\">Rate/Minute</th></tr></thead><tbody>";
	foreach($ldrate_res as $ldrate_res => $ldrate_val) { echo "<tr><td>".$ldrate_res."</td><td>".$ldrate_val[0]."</td><td>$".number_format($ldrate_val[1], "2")."</td></tr>"; }
	echo "</tbody></table>";
}

if ($querytype == "doCanadaCallRates") {
	$can_prov = array(
		"AB" => "Alberta",
		"BC" => "British Columbia",
		"MB" => "Manitoba",
		"NB" => "New Brunswick",
		"NF" => "Newfoundland",
		"NS" => "Nova Scotia/Prince Edward Island",
		"NT" => "Northwest Territory",
		"NU" => "Nunavut",
		"ON" => "Ontario",
		"PE" => "Price Edward Island/Nova Scotia",
		"QU" => "Quebec",
		"SA" => "Saskatchewan",
		"YU" => "Yukon Territory/Northwest Territories"
	);
	$canrate_sql = "select * from PINN_CUSTOM.UM_ECOMM_CANADIAN_RATES_V order by STATE_NAME";
	$canrate_res = $db->getAssoc($canrate_sql);
	echo "<table class=\"alt-row-table\">";
	echo "<thead><tr><th scope=\"col\">Area Code</th><th scope=\"col\">Province</th><th scope=\"col\">Rate/Minute</th></tr></thead><tbody>";
	foreach($canrate_res as $canrate_res => $canrate_val) { echo "<tr><td>".$canrate_res."</td><td>".$can_prov[$canrate_val[1]]."</td><td>$".number_format($canrate_val[2], "2")."</td></tr>"; }
	echo "</tbody></table>";
}

if ($querytype == "doIslandCallRates") {
	$island_name = array(
		"ANGUILLA" => "Anguilla",
		"ANTIGUA" => "Antigua and Barbuda",
		"BAHAMAS" => "Bahamas",
		"BARBADOS" => "Barbados",
		"BERMUDA" => "Bermuda",
		"BRITISH VI" => "British Virgin Islands",
		"CAYMAN ISL" => "Cayman Island",
		"CNMI" => "Commonwealth of the Northern Mariana Islands",
		"DOMINICA" => "Dominica",
		"DOMINREPUB" => "Dominican Republic",
		"E TIMOR" => "East Timor",
		"GRENADA" => "Grenada",
		"GUAM" => "Guam",
		"JAMAICA" => "Jamaica",
		"MONTSERRAT" => "Montserrat",
		"N MARIANA" => "Northern Mariana Islands",
		"ST KITTS" => "St. Kitts and Nevis",
		"ST LUCIA" => "St. Lucia",
		"SAIPAN" => "Saipan",
		"ST VINCENT" => "St. Vincent and the Grenadines",
		"TRINIDAD" => "Trinidad and Tobago",
		"TURK/CAICO" => "Turks and Caicos",
		"TURKSCAICO" => "Turks and Caicos"
	);
	$islrate_sql = "select * from PINN_CUSTOM.UM_ECOMM_ISLAND_RATES_V order by COUNTRY_NAME";
	$islrate_res = $db->getAssoc($islrate_sql);
	echo "<table class=\"alt-row-table\">";
	echo "<thead><tr><th scope=\"col\">Area Code</th><th scope=\"col\">Island Name</th><th scope=\"col\">Rate/Minute</th></tr></thead><tbody>";
	foreach($islrate_res as $islrate_res => $islrate_val) { echo "<tr><td>".$islrate_res."</td><td>".$island_name[$islrate_val[0]]."</td><td>$".number_format($islrate_val[1], "2")."</td></tr>"; }
	echo "</tbody></table>";
}

if ($querytype == "doMexicoCallRates") {
	$mexrate_sql = "select PLACE_NAME, REGION_CODE, STD_RATE_PER_MIN from PINN_CUSTOM.UM_ECOMM_MEXICAN_CITY_RATES_V order by PLACE_NAME";
	$mexrate_res = $db->getAssoc($mexrate_sql);
//	echo "<pre>"; print_r($mexrate_res); echo "</pre>";
	echo "<table class=\"alt-row-table\">";
	echo "<thead><tr><th scope=\"col\">Place Name</th><th scope=\"col\">Rate/Minute</th></tr></thead><tbody>";
	foreach($mexrate_res as $mexrate_res => $mexrate_val) { echo "<tr><td>".$mexrate_res."</td><td>$".number_format($mexrate_val[1], "2")."</td></tr>"; }
	echo "</tbody></table>";
}

}

?>