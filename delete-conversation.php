<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file

require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");

$id = intval($_GET["m"]);
$table = $_GET["table"];

$insertSQL  = 'DELETE from '.$table.'_conversations WHERE id='.$id;
//echo $insertSQL;
$conn->query($insertSQL);







?>
