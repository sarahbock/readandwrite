<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");
$table = $_GET["table"];
$error = null;


//create array of topics
//$sql = "SELECT * FROM ".$table."_topics";
$sql= "SELECT ".$table."_topics.heading, ".$table."_topics.topic FROM ".$table."_topics JOIN ".$table." ON ".$table."_topics.topic = ".$table.".topic OR ".$table."_topics.topic = ".$table.".related";

$result = $conn->query($sql);
$topics_full=array();
$topics=array();
$topic_headings=array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    //create array of headings
    $topic_heading=$row['heading']; if ($topic_heading===null||$topic_heading===""){$topic_heading="Other";}
    if (!in_array($topic_heading, $topic_headings)) {$topic_headings[]=$topic_heading;}

    //create keyed array for topics and push into topics full array
    if (trim($row['topic'])!==""){
      $temp = array("heading"=>$topic_heading,"topic"=>$row['topic']);
      $topics_full[]=$temp;
    }
  }
}

//format the topics array correctly
//sort headings into alphabetical order
sort($topic_headings);
//move the 'Other' heading to the end of the list
$other_index=array_search('Other', $topic_headings);
if($other_index){unset($topic_headings[$other_index]); $topic_headings[]="Other";}
//go through headings array and get topics under each heading
foreach ($topic_headings as $value) {
  $temp2=array();
  foreach ($topics_full as $value2) {
    if ($value2["heading"]===$value){
      if (!in_array($value2["topic"],array_column($temp2, 'title'))) {
        $temp2[]=array("title"=>$value2["topic"]);
      }
    }
  }
  //sort topics into alphabetical order under each heading
  sort($temp2);
  //for each heading create array of heading title plus the topics for each heading
  $temp = array("title"=>$value, "subtopics"=>$temp2);
  $topics[]=$temp;
}

echo json_encode($topics);

?>
