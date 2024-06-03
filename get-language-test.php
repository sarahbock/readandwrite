<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file

require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");

function cleanString ($str) {
    $spans = array(NULL,'<font color="0b0b14">','</font','<span class="colour1">','<span class="colour2">','<span class="colour3">','<span class="colour4">','<span class="colour5">','<span class="colour6">','<span class="colour7">','<span class="colour8">','<span class="colour9">','<span class="colour10">','<span class="colour11">','<span class="colour12">','</span>');
    $convertedString = str_replace($spans, "", $str);
    return $convertedString;
}

function prepareTopics ($topic, $related) {
    $topicStr=$topic;
    if ($related != NULL && $related != '') {
        $topicStr.=','.$related;
    }
    //$relatedArray = explode( ',', $related ) 
    return $topicStr;
}

  
class Entry {
    // Properties
    public $Id;
    public $Language;
    public $Explanation;
    public $Meaning;
    public $Sound;
    public $Image;
    public $Notes;

    public $Topics;
    public $Class;
    public $Tags;
    public $LanguageFunction;
    public $LanguageKeywords;
    public $EnglishKeywords;
    public $LinguisticKeywords;

    // Methods
    function set_id($val) { $this->Id = (int)$val; }
    function set_language($val) { $this->Language = $val; }
    function set_explanation($val) { $this->Explanation = $val; }
    function set_meaning($val) { $this->Meaning = $val; }
    function set_sound($val) { if ($val) { $this->Sound = true; } else { $this->Sound = false; } }
    function set_image($val) { if ($val) { $this->Image = true; } else { $this->Image = false; } }
    function set_notes($val) { $this->Notes = $val; }
    
    function set_topics($val) { $this->Topics = $val; }
    function set_class($val) { $this->Class = $val; }
    function set_tags($val) { $this->Tags = $val; }
    function set_langfunction($val) { $this->LanguageFunction = $val; }
    function set_langkeywords($val) { $this->LanguageKeywords = $val; }
    function set_englishkeywords($val) { $this->EnglishKeywords = $val; }
    function set_lingkeywords($val) { $this->LinguisticKeywords = $val; }
}

$table = $_GET["table"];

$error = null; 

$topics_sql = "SELECT * FROM ".$table."_topics";
$topics_result = $conn->query($topics_sql);

$alltopic = [];
if ($topics_result->num_rows > 0) {
    while($topic = $topics_result->fetch_assoc()) {
      $alltopic[] = $topic;
    }
}

$rows = array();
$sql = "SELECT * FROM ".$table." WHERE `flag`!='X'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
        $entry = new Entry();
        $entry->set_id(int($row['id']));
        $entry->set_language(cleanString($row['language']));
        $entry->set_explanation(cleanString($row['explanation']));
        $entry->set_meaning(cleanString($row['translation']));
        $entry->set_sound($row['soundfilename']);
        $entry->set_image($row['image']);
        $entry->set_notes(cleanString($row['notes']));

        //FOR DENISE
        $entry->set_topics(prepareTopics($row['topic'],$row['related']));
        $entry->set_class(cleanString($row['class']));
        $entry->set_tags(cleanString($row['tags']));
        $entry->set_langfunction(cleanString($row['function']));
        $entry->set_langkeywords(cleanString($row['keyword']));
        $entry->set_englishkeywords(cleanString($row['keywordtranslation']));
        $entry->set_lingkeywords(cleanString($row['keywordling']));

		$rows[] = $entry;
   }
}

echo json_encode($rows);
//echo json_encode($alltopic);

?>
