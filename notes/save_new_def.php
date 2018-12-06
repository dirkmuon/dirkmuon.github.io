<?php
session_start();
require("./connect.php");

$topic_id=$_REQUEST['topic'];
$title=$_REQUEST['title'];
$body=rtrim($_REQUEST['body']) . "\n";

if (!($stmt= $mysqli->prepare("INSERT into notes (topic_id,title,body) values (?,?,?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}

#bind
if (!$stmt->bind_param("iss", $topic_id, $title, $body)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    exit;
}


#execute
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    exit;
}

$_SESSION['topic_id'] = $topic_id;

#return the id of the new record
echo $mysqli->insert_id;

?>
