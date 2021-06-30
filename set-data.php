<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");

$id = intval($_GET["id"]);
$field= $_GET["field"];
$value = $_GET["value"];
$table = $_GET["table"];

if ($id!==0) {
   //already exists
	$sql = 'UPDATE '.$table.' SET '.$field.'="'.$value.'", timestamp=NOW() WHERE id='.$id;
} else {
	//insert new row
	$sql = 'INSERT INTO '.$table.' VALUES ()';
}
//echo $sql;
if ($conn->query($sql) === TRUE) {
    if ($id===0) {
        $last_id = $conn->insert_id;
        echo $last_id;
    }
}

//$conn->close();


?>
