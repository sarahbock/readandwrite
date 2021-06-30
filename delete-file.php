<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
$response = 0;
$dir="mp3/";
$type="sound"; $type=$_GET["type"];
$file=""; $file=$_GET["file"];
if ($type==="image"){$dir="img/";}
$filepath=$dir.$file;
if ($file!==""){if(file_exists($filepath)) { unlink($filepath); $response = 1;}}
echo $response;
?>