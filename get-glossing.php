<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");
$table = $_GET["table"];
$error = null; $rows = array();
$table_gloss=$table."_glossing";

$sql = "SELECT * FROM ".$table_gloss;

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$rows[] = $row;
   }
}
echo json_encode($rows);

?>
