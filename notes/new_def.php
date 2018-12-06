<?php

session_start();
require("./connect.php");

$topic_id=$_SESSION['topic_id'];
?>

<div class="definition">
<div id="adding_new_note">
<h3>Add new note</h3>

Name: <input id="title" size="25">
&emsp;&emsp;
Topic: 
<?php
require_once("show_topics.php");
?>

<br /><br />

Body:
<br />
<textarea id="body" cols="70" rows="7"></textarea>
<br />
<button value="save_new">Save</button>
&emsp;
<button value="cancel_clear">Cancel</button>

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
