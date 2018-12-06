<?php

session_start();
require("./connect.php");

foreach ($_REQUEST as $key => $value) {
  if ($key !== 'PHPSESSID') {
#echo "new ordinal is " . ($key * 10 + 10). ", value is $value <br>";
    $ordinal = $key * 10 + 10;

#prepare
    if (!($stmt= $mysqli->prepare("UPDATE topics SET ordinal=? WHERE id=?"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
      exit;
    }

#bind
    if (!$stmt->bind_param("ii", $ordinal,$value)) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      exit;
    }

#execute
    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      exit;
    }
  }
}

echo "done???";