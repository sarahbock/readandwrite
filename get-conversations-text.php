<?php
header("Access-Control-Allow-Origin: *"); // allow cross-origin requests

require_once($db_connect_dir . "dbconnect.php");
require_once("settings.php");

$error = null;
$rows = array();
$table = $_GET["table"];
$table_conv = $table . "_conversations";

$sql = "
SELECT
    c.id,
    ch1.translation AS 'entry1',
    ch2.translation AS 'entry2',
    ch3.translation AS 'entry3',
    ch4.translation AS 'entry4',
    ch5.translation AS 'entry5',
    ch6.translation AS 'entry6'
FROM $table_conv c
LEFT JOIN $table ch1 ON ch1.id = c.entry1
LEFT JOIN $table ch2 ON ch2.id = c.entry2
LEFT JOIN $table ch3 ON ch3.id = c.entry3
LEFT JOIN $table ch4 ON ch4.id = c.entry4
LEFT JOIN $table ch5 ON ch5.id = c.entry5
LEFT JOIN $table ch6 ON ch6.id = c.entry6
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$rows[] = $row;
	}
}

echo json_encode($rows);
?>
