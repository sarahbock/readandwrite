<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");

$id = intval($_GET["id"]);
$table = $_GET["table"];

if ($id!==0) {
  $sql = 'UPDATE '.$table.' SET flag="X" WHERE id='.$id;
  //$sql = 'DELETE from '.$table.' WHERE id='.$id;
	$conn->query($sql);
}


?>
