<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");

$id = intval($_GET["id"]);
$field= $_GET["field"]; //topic or name
$value = $_GET["value"];
$item = $_GET["item"];//topics, speakers, heading or functions
$replace = $_GET["replace"];//replace these old headings in the topics table
$table = $_GET["table"];


if ($id!==0) {
  //already exists
	$sql = 'UPDATE '.$table.'_'.$item.' SET '.$field.'="'.$value.'" WHERE id='.$id;

	if ($item==="headings"){
		$sql = 'UPDATE '.$table.'_topics SET '.$field.'="'.$value.'" WHERE '.$field.'="'.$replace.'"';
	}
} else {
	//insert new row
	if ($item==="headings"){$item="topics";}//insert new heading into topics table

	$sql = 'INSERT INTO '.$table.'_'.$item.' VALUES ()';
}

if ($conn->query($sql) === TRUE) {
    if ($id===0) {
        $last_id = $conn->insert_id;
        echo $last_id;
    }
}

//$conn->close();


?>
