 <?php

$language1=$_SESSION['language1']; //lowercase primary language name e.g. german
$language1header=$_SESSION['language1header'];
$language2=$_SESSION['language2']; //lowercase translation language name e.g. english
$language1U = ucfirst($language1); //Change first letter to capital
$language2U = ucfirst($language2);

$table=$language1;
$root_dir="https://elearnaustralia.com.au/opal/";
$web_dir=$root_dir."readandwrite/";
$shellPath=$root_dir."listenandtalk/web.htm?lang=".$language1."&translation=".$language2;
$mediaPath=$root_dir.$language1."/";
$mp3Path=$mediaPath."mp3/";
$imagePath=$mediaPath."img/";
$apiPath=$web_dir;

$db_connect_dir="./"; //change this to where your database connection file will sit
require_once($db_connect_dir."dbconnect.php");//move this file to your root directory if you require more security


//Label in drop down menu => field name in database table (must be exact match) - removed function due to SQL error in name
$filters=array("Topics"=>"topic", "Flagged"=>"flag","Language keywords"=>"keyword", "Translation keywords"=>"keywordtranslation", "Speaker"=>"speaker", "Class"=>"class","Linguistic keyword"=>"keywordling");

//detect Windows-1252
function convertString ($str) {
  $characters = ['¤','¼','©','‰','¶','Ã¡','ˆ','Ì','ÃŸ','â€™'];
  $pos = false;
  foreach ($characters as $value) {
    if (strpos($str, $value)) $pos = true;
  }
  if ($pos === false) {
    $convertedString = $str;
  } else {
    $convertedString = mb_convert_encoding($str, "Windows-1252", "UTF-8");
  }
  return $convertedString;
}

//create array of glossing categories
$sql_glossing = "SELECT * FROM ".$table."_glossing ORDER BY id";
$result_glossing = $conn->query($sql_glossing);
$glossing=array();
if ($result_glossing) {
  if ($result_glossing->num_rows > 0) {
    while($row_glossing = $result_glossing->fetch_assoc()) {
      $glossing_temp = array(
        "id"=>$row_glossing['id'],
        "title"=>$row_glossing['title'],
        "symbol"=>$row_glossing['symbol'],
        "glossGroup"=>$row_glossing['glossGroup'],
        "descr"=>$row_glossing['descr'],
        "colour"=>$row_glossing['colour'],
        "url"=>$row_glossing['url'],
      );
      $glossing[]=$glossing_temp;
    }
  }
}



//create array of speakers
$sql_speakers = "SELECT * FROM ".$table."_speakers ORDER BY name";
$result_speakers = $conn->query($sql_speakers);
$speakers=array();
if ($result_speakers->num_rows > 0) {
  while($row_speakers = $result_speakers->fetch_assoc()) {
    $speakers[]=$row_speakers['name'];
  }
}

//create array of functions
$sql_functions = "SELECT * FROM ".$table."_functions ORDER BY title";
$result_functions = $conn->query($sql_functions);
$functions=array();
if ($result_functions->num_rows > 0) {
  while($row_functions = $result_functions->fetch_assoc()) {
    $functions[]=$row_functions['title'];
  }
}

  //new version
  //create array of topics

  $headings_sql = "SELECT * FROM ".$table."_headings ORDER BY heading";
  $topics_sql = "SELECT * FROM ".$table."_topics ORDER BY topic";

  $headings_result = $conn->query($headings_sql);
  $topics_result = $conn->query($topics_sql);

  $topics = [];

  $alltopics = [];
  if ($topics_result->num_rows > 0) {
    while($topic = $topics_result->fetch_assoc()) {
      $alltopics[] = $topic;
    }
  }

  if ($headings_result->num_rows > 0) {
    while($heading = $headings_result->fetch_assoc()) {
      if ($heading['id']!=="0" && trim($heading['heading']) !=="" ){

        $subtopics = [];

        foreach ($alltopics as $key => $value) {
          if ($value['heading'] === $heading['id'] || $value['heading'] === $heading['heading']){
            if ( trim($value["topic"]) !=="" ) {
              $temp = array("id"=>$value["id"],"topic"=>$value["topic"]);
              $subtopics[]=$temp;
            }
          }
        }

        $temp2 = array("id"=>$heading['id'], "title"=>$heading['heading'], "subtopics"=>$subtopics);
        $topics[]=$temp2;

      }
    }
  }

/*} else {

  //create array of topics
  $sql = "SELECT * FROM ".$table."_topics";
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
        $temp2[]=$value2["topic"];
      }
    }
    //sort topics into alphabetical order under each heading
    sort($temp2);
    //for each heading create array of heading title plus the topics for each heading
    $temp = array("title"=>$value, "subtopics"=>$temp2);
    $topics[]=$temp;
  }
}*/


?>
