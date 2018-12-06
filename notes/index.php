<?php

session_start();

#establish database connection
require("./connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8"> 
<head>
<link href="https://fonts.googleapis.com/css?family=Fira+Mono|Fira+Sans" rel="stylesheet"> 
<link rel="stylesheet" type="text/css" href="notes.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
<div id="controls">
<ul>
<li>Add new note</li>
<li>Add new topic</li>
<li>Sort topics</li>
<li>Delete topic</li>
</ul>
</div>


<div id="container">
 <div id="left">
  <div id="leftTop"></div>
  <div id="leftBottom"></div>
 </div>
 <div id="right">
<h3>Select a topic</h3>
<ul class="topicul">

<?php
$sql = "SELECT * FROM topics order by ordinal";
$res = $mysqli->query($sql);
while($row = $res->fetch_assoc()) {
  echo "<li topic_id=\"$row[id]\">$row[topic]</li>\n";
}
?>

</ul>
 </div>
</div>
<script>
$(document).ready(function() {

//grab click from splash screen
  $(".topicul>li").on("click",function() {
    setTopic($(this).attr("topic_id"));
    $("#right").html('');
  });



//grab <select> in #leftTop -- delegated for future
  $("#leftTop").on("change","select",function() {
    setTopic($(this).val());
  });



//grab <li> entry in #leftBottom, show definition
  $("#leftBottom").on("click","li",function() {
    showDef($(this).attr("def_id"));
  });


//grab pencil or trash click in #right, show definition
//supply current def id in <img def_id= > attr
  $("#right").on("click","img",function() {
    let defId = $(this).attr("def_id");
    if ( $(this).attr("alt") == "edit") {
      editDef(defId);
    }
    else if ( $(this).attr("alt") == "delete") {
    $.post( "get_def_name.php",{id:defId }, function(data) {
      if (confirm("Delete " + data + " permanently ?")) {
        $("#right").load("delete_def.php",{id:defId}, function() {
          $("#leftBottom").load("show_toc.php");
          });
        }
      });
    }
  });


//grab any buttons in #right
  $("#right").on("click","button", function() {
    let topic =  $("#right select").val();
    let id = $("#def_id").val();
    let v = $(this).attr("value");
    if (v == "save") {
      $("#right").load("save_edited_def.php", {
        id: id,
        topic: topic,
        title: $("#title").val(),
        body: $("#body").val()}, function() {
          showDef(id);
          setTopic(topic);
    });
  } //end if
    else if (v == "cancel") {
      showDef(id);
    } //end else if
    else if (v == "cancel_clear") {
      $("#right").html('');
    } //end else if
    else if (v == "save_new") {
      $("#right").load("save_new_def.php", {
        topic: topic,
        title: $("#title").val(),
        body: $("#body").val()}, function(data) {
          showDef(parseInt(data));  //data is a string, showDef needs int
          setTopic(topic);
    });
  } //end else if
    else if (v == "save_sorted_topics") {
      var obj = {}; //empty object
      for (let i = 0 ; i < $("#sortable li").length ; i++ ) {
        obj[i.toString()] = $("#sortable li").eq(i).attr("topic_id");
      }
      $.post("save_sorted_topics.php",obj,function() {
        $("#right").load("show_topics_order.php");
        $("#leftTop").load("show_topics.php" , showGear);
      });
    } //end else if
}); //end grab button in #right


//grab gear in #leftTop, show controls
  $("#leftTop").on("click","#gear",function() {
    $("#controls").toggle();
  });


//grab <li>in controls
  $("#controls").on("click","li",function(e) {
    let answer = $(this).text();

    switch (answer) {
      case 'Add new note':
        $("#controls").hide();
        $("#right").load("new_def.php");
      break;

      case 'Add new topic':
        $.when($("#controls").hide()).then(function() {
          var newTopic = prompt("Enter new topic.");
          if (newTopic != null) {
            $.post("add_new_topic.php",{topic:newTopic},function(data) {
              let str = "<option value=\"" + data + "\">" + newTopic + "</option>";
              $("#leftTop select").append(str);
              alert( newTopic + "added");
            });
          }
        });
      break;

      case 'Sort topics':
      $.when($("#controls").hide()).then(function() {
        $("#right").load("sort_topics.php");
      });
      break;

      default:
    }  //end switch
  });



  function setTopic(id) {
    $.post( "set_topic_id.php",{ topic_id: id }, function() {
      $("#leftTop").load("show_topics.php" , showGear);
      $("#leftBottom").load("show_toc.php",function() {
        $("#controls").hide();
      });
   });
  }



  function showDef(id) {
    $("#right").load("show_def.php",{ id: id},function() {
      $("#controls").hide();
    });
  }


  function editDef(id) {
    $("#controls").hide();
    $("#right").load("edit_def.php",{ id: id});
  }


// keep gear button separate from writing topic <select> since 
// <select> is needed in different places
  function showGear() {
    $("#leftTop").append('<img src="gear.png" id="gear" alt="controls">\n');
  }










});  //end $(document).ready(

</script>