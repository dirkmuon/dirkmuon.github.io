<?php
require("./connect.php");

$id=$_REQUEST['id'];

$sql = "DELETE FROM notes WHERE id=$id";
$res = $mysqli->query($sql);
$_SESSION['id'] = '';

print TRUE;
