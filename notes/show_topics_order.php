<?php

session_start();
require("./connect.php");
?>
<p>
The order of topics is now
</p>
<ol>
<?php
$sql = "SELECT * FROM topics order by ordinal";
$res = $mysqli->query($sql);
while($topic_row = $res->fetch_assoc()) {
  echo "  <li>$topic_row[topic]</li>\n";
}
?>
</ol>
