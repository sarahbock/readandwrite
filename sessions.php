<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file

require_once("/home/lovelear/mangarray-dbconnect.php");

$error = null;
$token="";
if (isset($_GET["token"])) {
    $token= $_GET["token"];
    if($token==="sarah@bock.com.au"){return;}
   // $day=date("d"); $month=date("m"); $year=date("Y");
    //inserts entry into sessions table if the user's token matches the token in the tokens table
    //$insertSQL2 ="INSERT INTO sessions (userid, day, month, year) SELECT id , ".$day." AS day, ".$month." AS month, ".$year." AS year FROM tokens WHERE token='".$token."'";
    $insertSQL2 ="INSERT INTO sessions (userid, date) SELECT id , ".CURRENT_TIMESTAMP." AS date FROM tokens WHERE token='".$token."'";
    $conn->query($insertSQL2);
}

?>
