<?php

session_start;
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

#get number of lines in body to set height of textarea
$foo = explode("\n",$row['body']);
$lines = count($foo) + 2;

echo "
<div>
<h3>Edit <span style=\"background-color:#d0d8ff\">&nbsp;$row[title]&nbsp;</span><span style=\"font-size:67%;color:#777;\"> in $row[topic]</span></h3>
<input type=\"hidden\" id=\"def_id\" value=\"$id\">
Name: <input id=\"title\" value='$row[title]'>
&emsp;&emsp;
Topic: 
";

require_once("show_topics.php");

echo "
<br /><br />

Body:
<br />
<textarea id=\"body\" cols=\"70\" rows=\"$lines\">
$row[body]
";
?>
</textarea>
<br />
<button value="save">Save</button>
&emsp;
<button value="cancel">Cancel</button>

<script>
$("textarea").keydown(function(e) {
    if(e.keyCode === 9) { // tab was pressed
        // get caret position/selection
        var start = this.selectionStart;
        var end = this.selectionEnd;

        var $this = $(this);
        var value = $this.val();

        // set textarea value to: text before caret + tab + text after caret
        $this.val(value.substring(0, start)
                    + "\t"
                    + value.substring(end));

        // put caret at right position again (add one for the tab)
        this.selectionStart = this.selectionEnd = start + 1;

        // prevent the form from being submitted???
        e.preventDefault();
    }
});
</script>
