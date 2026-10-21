<?php

//API calls have no session so these default to empty strings
$language1=isset($_SESSION['language1']) ? $_SESSION['language1'] : ''; //lowercase primary language name e.g. german
$language1header=isset($_SESSION['language1header']) ? $_SESSION['language1header'] : '';
$language2=isset($_SESSION['language2']) ? $_SESSION['language2'] : ''; //lowercase translation language name e.g. english
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
  if ($str === null || $str === '') { return $str; } //NULL db columns stay null in JSON
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

$glossing=array();
$speakers=array();
$functions=array();
$topics = [];

//only look up language tables when logged in (API calls have no session so $table is empty)
if ($table !== '') {

  //create array of glossing categories
  $sql_glossing = "SELECT * FROM ".$table."_glossing ORDER BY id";
  $result_glossing = $conn->query($sql_glossing);
  if ($result_glossing && $result_glossing->num_rows > 0) {
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

  //create array of speakers
  $sql_speakers = "SELECT * FROM ".$table."_speakers ORDER BY name";
  $result_speakers = $conn->query($sql_speakers);
  if ($result_speakers && $result_speakers->num_rows > 0) {
    while($row_speakers = $result_speakers->fetch_assoc()) {
      $speakers[]=$row_speakers['name'];
    }
  }

  //create array of functions
  $sql_functions = "SELECT * FROM ".$table."_functions ORDER BY title";
  $result_functions = $conn->query($sql_functions);
  if ($result_functions && $result_functions->num_rows > 0) {
    while($row_functions = $result_functions->fetch_assoc()) {
      $functions[]=$row_functions['title'];
    }
  }

  //create array of topics
  $headings_sql = "SELECT * FROM ".$table."_headings ORDER BY heading";
  $topics_sql = "SELECT * FROM ".$table."_topics ORDER BY topic";

  $headings_result = $conn->query($headings_sql);
  $topics_result = $conn->query($topics_sql);

  $alltopics = [];
  if ($topics_result && $topics_result->num_rows > 0) {
    while($topic = $topics_result->fetch_assoc()) {
      $alltopics[] = $topic;
    }
  }

  if ($headings_result && $headings_result->num_rows > 0) {
    while($heading = $headings_result->fetch_assoc()) {
      if ($heading['id']!=="0" && trim((string)$heading['heading']) !=="" ){

        $subtopics = [];

        foreach ($alltopics as $key => $value) {
          if ($value['heading'] === $heading['id'] || $value['heading'] === $heading['heading']){
            if ( trim((string)$value["topic"]) !=="" ) {
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

}

?>
