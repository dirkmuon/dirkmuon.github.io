<?php
session_start();
require("./connect.php");

$topic_id=$_REQUEST['topic'];
$title=$_REQUEST['title'];
$id=$_REQUEST['id'];
$body=rtrim($_REQUEST['body']) . "\n";

if (!($stmt= $mysqli->prepare("UPDATE notes SET topic_id=?, title=?, body=? WHERE id=?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}

#bind
if (!$stmt->bind_param("issi", $topic_id,$title,$body,$id)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    exit;
}


#execute
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    exit;
}

$_SESSION['topic_id'] = $topic_id;

?>
