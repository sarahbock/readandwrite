<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");

$table = $_GET["table"];

$id=0;
$var1 = intval($_GET["var1"]); 
$var2 = intval($_GET["var2"]);
$var3 = intval($_GET["var3"]);
$var4 = intval($_GET["var4"]);
$var5 = intval($_GET["var5"]);
$var6 = intval($_GET["var6"]);


if ($id!==0) {
   //already exists
	//$insertSQL = "UPDATE journal SET descr='".$descr."', redflag='".$redflag."',flare='".$flare."', date='".$date."', hour=".$hour.", minute=".$minute.", photo='".$photo."', author='".$moonname."', tracking_s='".$tracking_s."', tracking_a='".$tracking_a."', scale='".$scale."', measure1='".$measure1."', measure2='".$measure2."', notes='".$notes."' WHERE id=".$id;

} else {
	//insert new
	$insertSQL = "INSERT INTO ".$table."_conversations (entry1,entry2,entry3,entry4,entry5,entry6) VALUES (".$var1.",".$var2.",".$var3.",".$var4.",".$var5.",".$var6.")";

}

$conn->query($insertSQL);



?>
