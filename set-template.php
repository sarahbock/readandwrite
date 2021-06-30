<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");



$template = intval($_GET["template"]);

switch($template){

	case 0:
	//template 0 = blank
	$insertSQL = "INSERT INTO `".$table."` (`topic`, `function`, `related`, `class`, `keyword`, `tags`, `keywordtranslation`, `keywordling`, `language`, `response`, `explanation`, `translation`, `translationsoundfilename`, `image`, `chunks`, `flag`, `soundfilename`,`source`, `speaker`, `notes`, `timestamp`) VALUES ('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');";
	$insertTopicsSQL="INSERT INTO `".$table."_topics` (`heading`, `topic`) VALUES('Topics', 'Topic 1'),('Topics', 'Topic 2'),('Topics', 'Topic 3'),('Topics', 'Topic 4'),('Topics', 'Topic 5'),('', 'Other');";
	$insertConvSQL="";
	break;

	case 1:
	//template 1 TRAVEL

	$insertSQL = "INSERT INTO `".$table."` (`topic`, `function`, `related`, `class`, `keyword`, `tags`, `keywordtranslation`, `keywordling`, `language`, `response`, `explanation`, `translation`, `translationsoundfilename`, `image`, `chunks`, `flag`, `soundfilename`, `source`, `speaker`, `notes`, `timestamp`) VALUES ('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),('At home', '', '', 'phrase', '', '', 'Would,you,like,a,coffee', '', '', '', '', 'Would you like a coffee?', '', '', '', '', '', '', '', '', ''),('At home', '', '', 'phrase', '', '', 'Yes,please', '', '', '', '', 'Yes please', '', '', '', '', '', '', '', '', ''),('At home', '', '', 'phrase', '', '', 'Do,you,take,milk', '', '', '', '', 'Do you take milk?', '', '', '', '', '', '', '', '', ''),('At home', '', '', 'phrase', '', '', 'No,thanks', '', '', '', '', 'No thanks', '', '', '', '', '', '', '', '', ''),('At home', '', '', 'phrase', '', '', 'How,many,sugars', '', '', '', '', 'How many sugars?', '', '', '', '', '', '', '', '', ''),('At home', '', '', 'phrase', '', '', 'Two,sugars,please', '', '', '', '', 'Two sugars please', '', '', '', '', '', '', '', '', '');";

	$insertTopicsSQL="INSERT INTO `".$table."_topics` (`heading`, `topic`) VALUES('General conversation', 'Common expressions'),('General conversation', 'Getting to know someone'),('General conversation', 'Shopping'),('General conversation', 'Family and relations'),('General conversation', 'Likes and dislikes'),('General conversation', 'Work or school'),('General conversation', 'Meeting up'),('General conversation', 'Time and numbers'),('General conversation', 'Weather'),('General conversation', 'Language and communication'),('Travel', 'Directions'),('Travel', 'Emergencies'),('Travel', 'Making a booking'),('Travel', 'Buying a ticket'),('Travel', 'Accommodation'),('Food and drink', 'At home'),('Food and drink', 'At a restaurant'),('Food and drink', 'In a pub or bar'),('Food and drink', 'Buying things'),('Food and drink', 'At the supermarket'),('Food and drink', 'Ordering take-away'),('Lessons', 'Lesson 1'),('Lessons', 'Lesson 2'),('Lessons', 'Lesson 3'),('Lessons', 'Lesson 4'),('Lessons', 'Lesson 5'),('', 'Other');";
	$insertConvSQL = "INSERT INTO `".$table."_conversations` (`entry1`,`entry2`,`entry3`,`entry4`,`entry5`,`entry6`) VALUES (2,3,4,5,6,7);";

	break;


	//https://elearnaustralia.com.au/opal/chinese/set-conversation.php?var1=2&var2=3&var3=6&var4=20&var5=4&var6=5

}

echo 	$insertConvSQL;
echo 	$insertSQL;

if($conn->query("TRUNCATE TABLE `".$table."`")){
	$conn->query($insertSQL);
}

if($conn->query("TRUNCATE TABLE `".$table."_topics`")){
	$conn->query($insertTopicsSQL);
}

if($conn->query("TRUNCATE TABLE `".$table."_conversations`")){
	$conn->query($insertConvSQL);
}






?>
