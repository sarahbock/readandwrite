<?php
header("Access-Control-Allow-Origin: *");

require_once("./dbconnect.php");

$entry = isset($_GET["entry"]) ? intval($_GET["entry"]) : 0;
$interaction = isset($_GET["interaction"]) ? intval($_GET["interaction"]) : 0;
$token = isset($_GET["token"]) ? $_GET["token"] : "";
$table = isset($_GET["table"]) ? $_GET["table"] : "";

// Validate table name to prevent SQL injection
$allowed_tables = [
    'umpila', 
    'mangarrayi', 
    'dharug'
]; 


if (!in_array($table, $allowed_tables)) {
    die("Invalid table name.");
}

if ($entry && $token !== "sarah@bock.com.au") {
    if ($token === '') {
        $insertSQL2 = "INSERT INTO `{$table}_log` (`userid`, `entryid`, `interactionid`, `date`) VALUES ('0', {$entry}, {$interaction}, CURRENT_TIMESTAMP);";
    } else {
        $token = $conn->real_escape_string($token);
        $insertSQL2 = "INSERT INTO `{$table}_log` (userid, entryid, interactionid, date) SELECT id, {$entry}, {$interaction}, CURRENT_TIMESTAMP FROM {$table}_tokens WHERE token='{$token}'";
    }

    if (!$conn->query($insertSQL2)) {
        echo "SQL Error: " . $conn->error;
    } else {
        echo "Success.";
    }
}
?>

