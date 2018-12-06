<ul>

<?php
session_start();

#establish database connection
require("./connect.php");

$sql = "SELECT * FROM notes where topic_id=$_SESSION[topic_id] order by title";
$res = $mysqli->query($sql);

while($row = $res->fetch_assoc()) {
 echo "<li def_id=\"$row[id]\">$row[title]</li>\n";
}

?>
</ul>