<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file

require_once("./dbconnect.php");

$error = null; $output=0; $token=""; 
if (isset($_GET["token"])) {$token = $_GET["token"];}
if (isset($_GET["table"])) {$table = $_GET["table"];}


$sql = "SELECT id FROM ".$table."_tokens WHERE token='".$token."' AND used=0";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
   $output=1; //token correct and not used
    $sql2 = "UPDATE ".$table."_tokens SET used=1 WHERE token='".$token."'"; //set it as used so it can't be used again
    $conn->query($sql2);
} 
echo $output;

?> 

