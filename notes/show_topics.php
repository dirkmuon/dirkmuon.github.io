<?php
#writes <select> for topics and buttons into #left
#is $_SESSION['topic_id'] then will add SELECTED to item in <select>

if (session_id() === "") {
  session_start();
}

#establish database connection
require("./connect.php");

echo "<select>\n";
$sql = "SELECT * FROM topics order by ordinal";
$res = $mysqli->query($sql);

while($topic_row = $res->fetch_assoc()) {
  echo "<option value=\"$topic_row[id]\"";
  if (isset($_SESSION['topic_id'])) {
    if ($topic_row['id'] == $_SESSION['topic_id']) {
      echo " SELECTED";
    }
  }
  echo ">$topic_row[topic]</option>\n";
}
?>
</select>
