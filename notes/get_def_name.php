<?php
session_start();
require("./connect.php");

$id=$_REQUEST['id'];

$sql = "SELECT title from notes where id = $id";
$res = $mysqli->query($sql);
$row = $res->fetch_assoc();

echo $row['title'];



