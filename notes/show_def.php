<?php
session_start();
require("./connect.php");

$id=$_REQUEST['id'];

$sql = "SELECT 
n.id id,
n.title title,
n.body body,
t.topic topic
FROM notes n JOIN topics t 
ON (n.topic_id = t.id) 
WHERE n.id = $id";
$res = $mysqli->query($sql);
$row = $res->fetch_assoc();

#replace a tab with em space

#comment out next line since we are using CKEditor which adds html tags
#$row['body'] = preg_replace('/\t/','&emsp;',htmlspecialchars($row['body']));
$row['body'] = preg_replace('/\t/','&emsp;',$row['body']);

#<b>
$row['body'] = preg_replace('/&lt;b&gt;/','<strong>',$row['body']);
$row['body'] = preg_replace('/&lt;\/b&gt;/','</strong>',$row['body']);

#$row['body'] = preg_replace('•','&bull;',$row['body']);

#<i>
$row['body'] = preg_replace('/&lt;i&gt;/','<em>',$row['body']);
$row['body'] = preg_replace('/&lt;\/i&gt;/','</em>',$row['body']);


?>
<div class="definition">
<h3>
<?php 
echo "$row[title] 
<span style=\"font-size:67%;color:#777;\">in $row[topic]</span>

</h3>" . nl2br($row['body']); 
?>

<br />
<img src="pencil5.png" alt="edit" def_id="<?php echo $id; ?>">
<img src="trash6.png" alt="delete" def_id="<?php echo $id; ?>">
</div>
