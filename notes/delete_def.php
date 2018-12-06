<?php
require("./connect.php");

session_start();

$id=$_REQUEST['id'];

$sql = "DELETE FROM notes WHERE id=$id";
$res = $mysqli->query($sql);

echo "";