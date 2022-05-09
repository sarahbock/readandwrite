<?php
//Connect to database
//$conn = new mysqli("localhost","my_user","my_password","my_db"); //change to your database details
$conn = new mysqli('localhost', 'lovelear_opal', '.27.pIFe^fI#', 'lovelear_opal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 ?>
