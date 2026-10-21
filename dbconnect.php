<?php
//Connect to database
//$conn = new mysqli("localhost","my_user","my_password","my_db"); //change to your database details
mysqli_report(MYSQLI_REPORT_OFF); //PHP 8.1+ throws on failed queries by default; keep PHP 7 behaviour (return false)
$conn = new mysqli('localhost', 'lovelear_opal', '.27.pIFe^fI#', 'lovelear_opal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 ?>
