<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");

$id = intval($_GET["id"]);
$field=''; if (isset($_GET["field"])) { $field= $_GET["field"]; }
$value=''; if (isset($_GET["value"])) { $value= $_GET["value"]; }
$table = $_GET["table"];

//https://elearnaustralia.com.au/opal/readandwrite/set-data.php?id=0&table=guugu_yimithirr

if ($id!==0) {
   //already exists
	$sql = 'UPDATE '.$table.' SET '.$field.'="'.$value.'", timestamp=NOW() WHERE id='.$id;

} else if ( $id===0 && strpos($table, 'topics') ){
	//topics table with prefilled headings id and topic
	//$sql = 'INSERT INTO '.$table.' (`id`, `heading`, `topic`, `image`, `timestamp`) VALUES (NULL, '.$value.', NULL, NULL, '')';
	$sql = 'INSERT INTO '.$table.' (`id`, `heading`, `topic`, `image`, `timestamp`) VALUES (NULL, \''.$value.'\', \'~New topic~\', NULL, \'\')';

} else if ( $id===0 && strpos($table, 'headings') ){
	//headings table with prefilled headings
	$sql = 'INSERT INTO '.$table.' (`id`, `heading`, `image`, `timestamp`) VALUES (NULL, \'~New category~\', NULL, \'\')';

} else {
	//insert new row
	//$sql = 'INSERT INTO '.$table.' VALUES ()';
	$sql = 'INSERT INTO '.$table.' (`translationsoundfilename`,`keyword`,`soundfilename`,`speaker`,`timestamp`) VALUES (\'\',\'\',\'\',\'\',NOW())';

	//$sql = 'INSERT INTO `'.$table.'`(`translationsoundfilename`,`soundfilename`,`speaker`,`timestamp`) VALUES ('','','',NOW());';
}
if ($conn->query($sql) === TRUE) {
    if ($id===0) {
        $last_id = $conn->insert_id;
        echo $last_id;
    }
}

//$conn->close();


?>
