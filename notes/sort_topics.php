<?php

session_start();
require("./connect.php");
?>
<h3>Sort topics</h3>
<p>
Drag boxes to arrange topics in the order in which they should appear.
<p>
<ul id="sortable">
<?php
$sql = "SELECT * FROM topics order by ordinal";
$res = $mysqli->query($sql);
while($topic_row = $res->fetch_assoc()) {
  echo "  <li topic_id=\"$topic_row[id]\">$topic_row[topic]</li>\n";
}
?>
</ul>
<p>
&emsp;&emsp;&emsp;
<button value="save_sorted_topics">Save</button>
&emsp;
<button value="cancel_clear">Cancel</button>
</p>

<script>
$( function() {
  $( "#sortable" ).sortable();
  $( "#sortable" ).disableSelection();
});
</script>

<script>
$("button").on("click",function() {
  var obj = {}; //empty object
  for (let i = 0 ; i < $("#sortable li").length ; i++ ) {
    obj[i.toString()] = $("#sortable li").eq(i).attr("topic_id");
  }

$.post("sort_topics_save.php",obj);





});




</script>


</main> 
</body>
</html>
