<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file

require_once("./dbconnect.php");

$token =""; if (isset($_GET["token"])) {$token = $_GET["token"];}
$table =""; if (isset($_GET["table"])) {$table = $_GET["table"];}

if ($token!==""){
    $sql = "SELECT * FROM ".$table."_tokens WHERE token='".$token."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //if token exists reset token
        $sql2 = "UPDATE ".$table."_tokens SET used=0 WHERE token='".$token."'";
    } else {
        //if token doesn't already exist then insert token
        $sql2 = "INSERT INTO ".$table."_tokens (token) VALUES ('".$token."')";
        
    }
    $conn->query($sql2);
}

?> 

