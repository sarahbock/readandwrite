<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file

require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");

$table = $_GET["table"];

$error = null; $rows = array();
$sql = "SELECT * FROM ".$table." WHERE `flag`!='X'";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
	 //email exists
	while($row = $result->fetch_assoc()) {
	 	$row['language'] = convertString($row['language']);
	 	$row['soundfilename'] = convertString($row['soundfilename']);
	 	$row['speaker'] = convertString($row['speaker']);
	 	$row['explanation'] = convertString($row['explanation']);
		$rows[] = $row;
   }

}
echo json_encode($rows);

?>
