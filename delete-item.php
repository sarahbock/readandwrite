<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");

$id = intval($_GET["id"]);
$item = $_GET["item"];
$value = $_GET["value"];
$table = $_GET["table"];

if ($id!==0 && $item) {
  $sql = 'DELETE from '.$table.'_'.$item.' WHERE id='.$id;

  if ($item==="headings"){
     $sql2 = 'DELETE from '.$table.'_topics WHERE heading="'.$id.'"';
     $conn->query($sql2);
  }


    //if ($item==="headings" && $value ){
		//   $sql = 'UPDATE '.$table.'_topics SET heading="" WHERE heading="'.$value.'"';
	  //}


  $conn->query($sql);

  //$item=substr($item, 0, -1);
  //$sql2= 'UPDATE '.$table.' SET '.$item.'="" WHERE '.$item.'='.$id;
}


?>
