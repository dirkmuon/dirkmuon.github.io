<?php

session_start();
require("./connect.php");

$topic=$_REQUEST['topic'];

$sql = "SELECT MAX(ordinal) largest FROM topics";
$res = $mysqli->query($sql);
$row = $res->fetch_assoc();
$largest = $row['largest'] + 10;

if (!($stmt= $mysqli->prepare("INSERT into topics (topic,ordinal) values (?,?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}

#bind
if (!$stmt->bind_param("si", $topic,$largest)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    exit;
}


#execute
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    exit;
}

echo $mysqli->insert_id;
