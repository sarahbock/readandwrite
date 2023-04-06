<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file

require_once("./dbconnect.php");

//$.get("log.php?table="+language+"&token="+token+"&entry="+selectedAudio+"&interaction=1", function() { });

$entry="";  if (isset($_GET["entry"])) {$entry= $_GET["entry"];}
$interaction=""; if (isset($_GET["interaction"])) {$interaction= $_GET["interaction"];}
$token="";  if (isset($_GET["token"])) {$token= $_GET["token"]; }
$table="";  if (isset($_GET["table"])) {$table= $_GET["table"]; }

if($entry!=="" && $token!=="sarah@bock.com.au"){
    //$day=date("d"); $month=date("m"); $year=date("Y");
	$entry = intval($entry); $interaction = intval($interaction);

    $insertSQL2 ="INSERT INTO ".$table."_log (userid, entryid, interactionid, date) SELECT id , ".$entry." AS entryid, ".$interaction." AS interactionid, ".CURRENT_TIMESTAMP." AS date FROM ".$table."_tokens WHERE token='".$token."'";
    echo $insertSQL2;
    //$insertSQL2 = "INSERT INTO log (entryid, day, month, year) VALUES (".$entry.", ".$day.", ".$month.", ".$year.")";
    //$insertSQL2 = "INSERT INTO log (entryid, date) VALUES (".$entry.", ".CURRENT_TIMESTAMP.")";
    $conn->query($insertSQL2);
}


?>
