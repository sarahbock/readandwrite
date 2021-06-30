<?php
header("Access-Control-Allow-Origin: *"); //allow app to access cross domain file
require_once($db_connect_dir."dbconnect.php");
require_once("settings.php");



$template = intval($_GET["template"]);

switch($template){

	case 0:
	//template 0 = blank
	$insertSQL = "INSERT INTO `".$table."` (`topic`, `function`, `related`, `class`, `keyword`, `tags`, `keywordtranslation`, `keywordling`, `language`, `response`, `explanation`, `translation`, `translationsoundfilename`, `image`, `chunks`, `flag`, `soundfilename`, `source`, `speaker`, `notes`, `timestamp`) VALUES ('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');";

	$insertTopicsSQL="INSERT INTO `".$table."_topics` (`heading`, `topic`) VALUES('Topics', 'Topic 1'),('Topics', 'Topic 2'),('Topics', 'Topic 3'),('Topics', 'Topic 4'),('Topics', 'Topic 5'),('', 'Other');";

	$insertConvSQL="";

	break;

	case 1:
	//template 1 = language revitalisation
	$insertSQL = "INSERT INTO `".$table."` (`topic`, `function`, `related`, `class`, `keyword`, `tags`, `keywordtranslation`, `keywordling`, `language`, `response`, `explanation`, `translation`, `translationsoundfilename`, `image`, `chunks`, `flag`, `soundfilename`, `source`, `speaker`, `notes`, `timestamp`) VALUES ('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Ask a question', '', 'phrase', '', 'what\'s wrong, what\'s the matter, crook, sick, no good', 'What, you, sick', 'interrogative, focus, present tense, 2SG', '', '', '', 'What\'s wrong? / What\'s the matter?', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Say what\'s wrong', '', 'phrase', '', 'sick, no good, sore, pain, hurt', 'stomach, my, I, sore', 'present tense, 1SG possessive pronoun', '', '', '', 'I\'ve got a sore stomach. / I have a pain in the stomach', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Give explanation for sickness', '', 'phrase', '', 'eat, eat tucker', 'maybe, bad, I, ate', 'past tense, 1SG, transitive', '', '', '', 'Maybe I ate ate something bad. ', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Say what you should do', '', 'phrase', '', '', 'doctor, to, I, go', 'allative, present tense', '', '', '', 'I am going to the doctor.', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Give explanation for sickness', '', 'phrase', '', '', 'not, I, sleep', 'negative, 1SG, past tense', '', '', '', 'I didn\'t sleep. / I couldn\'t sleep.', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Say what\'s wrong', '', 'phrase', '', 'tired', 'I, sleepy, today', 'present tense, 1SG', '', '', '', 'I\'m sleepy today.', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Say what you are going to do', '', 'phrase', '', '', 'go back, I, first, sleep', 'present tense, 1SG', '', '', '', 'I\'m going to go back but first I\'m going to have a sleep.', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Explain why  ', '', 'phrase', '', 'cut', 'he, she, cut, meat', 'imperfect tense, 3SG', '', '', '', 'He/she was cutting the meat.', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Say what\'s wrong', '', 'phrase', '', 'cut, self', 'he, cut, himself, herself properly', 'past tense, 3SG, reflexive', '', '', '', 'He cut himself properly / She cut herself properly.', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Give explanation for sickness', '', 'phrase', '', 'slip', 'slipped, I', 'past tense, 3SG', '', '', '', 'He slipped and cut himself. / She slipped and cut herself.', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Say what action you are going to take', '', 'phrase', '', 'going to, will, might', 'little, food, I, eat', 'Irrealis, 1SG', '', '', '', 'I might eat a little food.', '', '', '', '', '', '', '', '', ''),('Staying healthy', 'Say what action you are going to take', '', 'phrase', '', 'emphasis, important', 'a little bit, you give me, food', 'focus, irrealis, 2SG / 1SG', '', '', '', 'Can you give me a little food?', '', '', '', '', '', '', '', '', ''),('About you', 'Describe someone', '', 'phrase', '', '', 'What, is, your, name', 'present tense, 1SG, copula, pronoun, focus, interrogative', '', '', '', 'What is your name?', '', '', '', '', '', '', '', '', ''),('About you', 'Describe someone', '', 'phrase', '', '', 'Me, I\'m, Sheila', 'present tense, 1SG, copula, pronoun, focus', '', '', '', 'Me, I\'m Sheila.', '', '', '', '', '', '', '', '', ''),('Other people', 'Say hello', '', 'phrase', '', 'greeting, hi, g\'day, you', 'hello', 'pronoun, greeting', '', '', '', 'Hello.', '', '', '', '', '', '', '', '', ''),('Other people', 'Ask a question', '', 'phrase', '', '', 'where, do, you, live', 'interrogative, present tense, 2SG', '', '', '', 'Where do you live?', '', '', '', '', '', '', '', '', ''),('Other people', 'Say goodbye', '', 'phrase', '', '', 'goodbye, see, you, tomorrow', 'irrealis, 1SG', '', '', '', 'Goodbye, see you tomorrow.', '', '', '', '', '', '', '', '', ''),('Food and Drink', 'Describing a physical state', '', 'phrase', '', '', 'now, I\'m, a, little, hungry, ', 'present tense, 1SG, ', '', '', '', 'Now I\'m a little hungry.', '', '', '', '', '', '', '', '', ''),('Food and Drink, Get ready', 'Describe an action,Tell someone to do something', '', 'phrase', '', '', 'I\'ll, get, up, now, and, get, it,', 'irrealis, 1SG, present tense, future', '', '', '', 'I\'ll get up now and get it.', '', '', '', '', '', '', '', '', ''),('Food and Drink', 'Ask for something', '', 'phrase', '', 'can you', 'yes, you, give, me, ', 'imperative, 2SG/1SG', '', '', '', 'Yes, give it to me. Can you give it to me?', '', '', '', '', '', '', '', '', '');";

	$insertTopicsSQL="INSERT INTO `".$table."_topics` (`heading`, `topic`) VALUES('Who are you?', 'About you'),('Who are you?', 'How do you feel?'),('Who are you?', 'What things do you like?'),('Family, friends and other people', 'Family'),('Family, friends and other people', 'Marriage'),('Family, friends and other people', 'Other people'),('Around camp', 'Get ready'),('Around camp', 'Food and drink'),('Around camp', 'Getting around'),('Around camp', 'Work'),('Around camp', 'School'),('Around camp', 'Sport and free time'),('Body and health', 'Staying healthy'),('Body and health', 'Health messages'),('Body and health', 'Bush medicine'),('Body and health', 'Body'),('Body and health', 'Actions'),('Body and health', 'Daily body care'),('Culture', 'Country'),('Culture', 'Places'),('Culture', 'Plants'),('Culture', 'Animals'),('Culture', 'Ceremony'),('Culture', 'Dreaming'),('Culture', 'Seasons and time'),('Talking together', 'Tell someone to do something'),('Talking together', 'Say what you think'),('Talking together', 'Show respect'),('Talking together', 'Ask a question'),('Talking together', 'Suggest something'),('Talking together', 'Warn someone'),('Talking together', 'Offer or ask for help'),('Talking together', 'Encourage someone'),('Talking together', 'Explain something'),('Lessons', 'Lesson 1'),('Lessons', 'Lesson 2'),('Lessons', 'Lesson 3'),('Lessons', 'Lesson 4'),('Lessons', 'Lesson 5'),('', 'Other');";

	$insertConvSQL = "INSERT INTO `".$table."_conversations` (`entry1`,`entry2`,`entry3`,`entry4`,`entry5`,`entry6`) VALUES (2,3,4,5,1,1);";

	break;

	case 2:
	//template 2 TRAVEL

	$insertSQL = "INSERT INTO `".$table."` (`topic`, `function`, `related`, `class`, `keyword`, `tags`, `keywordtranslation`, `keywordling`, `language`, `response`, `explanation`, `translation`, `translationsoundfilename`, `image`, `chunks`, `flag`, `soundfilename`, `source`, `speaker`, `notes`, `timestamp`) VALUES ('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),('Getting to know someone', '', '', 'phrase', '', '', 'What,is,your,name?', '', '', '', '', 'What is your name?', '', '', '', '', '', '', '', '', ''),('Getting to know someone', '', '', 'phrase', '', '', 'My,name,is,Tom.', '', '', '', '', 'My name is Tom.', '', '', '', '', '', '', '', '', ''),('Getting to know someone', '', '', 'phrase', '', '', 'Where,are,you,from?', '', '', '', '', 'Where are you from?', '', '', '', '', '', '', '', '', ''),('Getting to know someone', '', '', 'phrase', '', '', '', '', '', '', '', 'I live in Sydney.', '', '', '', '', '', '', '', '', ''),('Work or school', '', '', 'phrase', '', '', '', '', '', '', '', 'What do you do with yourself?', '', '', '', '', '', '', '', '', ''),('Language and communication', '', '', 'phrase', '', '', '', '', '', '', '', 'I am a little out of practice.', '', '', '', '', '', '', '', '', ''),('Language and communication', '', '', 'phrase', '', '', '', '', '', '', '', 'Sorry, I did not understand.', '', '', '', '', '', '', '', '', ''),('Language and communication', '', '', 'phrase', '', '', '', '', '', '', '', 'I speak French and a little Italian.', '', '', '', '', '', '', '', '', ''),('Language and communication', '', '', 'phrase', '', '', '', '', '', '', '', 'Do you understand (it)?', '', '', '', '', '', '', '', '', ''),('Language and communication', '', '', 'phrase', '', '', '', '', '', '', '', 'Did you understand (it)?', '', '', '', '', '', '', '', '', ''),('Language and communication', '', '', 'phrase', '', '', '', '', '', '', '', 'How do you spell it?', '', '', '', '', '', '', '', '', ''),('Language and communication', '', '', 'phrase', '', '', '', '', '', '', '', 'How do you pronounce this word?', '', '', '', '', '', '', '', '', ''),('Language and communication', '', '', 'phrase', '', '', '', '', '', '', '', 'Yes, I understood (it).', '', '', '', '', '', '', '', '', ''),('Language and communication', '', '', 'phrase', '', '', '', '', '', '', '', 'Yes, I understand (it).', '', '', '', '', '', '', '', '', ''),('Getting to know someone', '', '', 'phrase', '', '', 'How,long,do,you,plan,to,stay,here?', '', '', '', '', 'How long do you plan to stay here?', '', '', '', '', '', '', '', '', ''),('Getting to know someone', '', '', 'phrase', '', '', '', '', '', '', '', 'For one more year.', '', '', '', '', '', '', '', '', ''),('Getting to know someone', '', '', 'phrase', '', '', '', '', '', '', '', 'I am studying here.', '', '', '', '', '', '', '', '', ''),('Work or school', '', '', 'phrase', '', '', '', '', '', '', '', 'I work at the council.', '', '', '', '', '', '', '', '', ''),('Work or school', '', '', 'phrase', '', '', '', '', '', '', '', 'I work in a shop.', '', '', '', '', '', '', '', '', ''),('Work or school', '', '', 'phrase', '', '', '', '', '', '', '', 'I am a teacher.', '', '', '', '', '', '', '', '', '');";

	$insertTopicsSQL="INSERT INTO `".$table."_topics` (`heading`, `topic`) VALUES('General conversation', 'Common expressions'),('General conversation', 'Getting to know someone'),('General conversation', 'Shopping'),('General conversation', 'Family and relations'),('General conversation', 'Likes and dislikes'),('General conversation', 'Work or school'),('General conversation', 'Meeting up'),('General conversation', 'Time and numbers'),('General conversation', 'Weather'),('General conversation', 'Language and communication'),('Travel', 'Directions'),('Travel', 'Emergencies'),('Travel', 'Making a booking'),('Travel', 'Buying a ticket'),('Travel', 'Accommodation'),('Food and drink', 'At home'),('Food and drink', 'At a restaurant'),('Food and drink', 'In a pub or bar'),('Food and drink', 'Buying things'),('Food and drink', 'At the supermarket'),('Food and drink', 'Ordering take-away'),('Lessons', 'Lesson 1'),('Lessons', 'Lesson 2'),('Lessons', 'Lesson 3'),('Lessons', 'Lesson 4'),('Lessons', 'Lesson 5'),('', 'Other');";
	$insertConvSQL = "INSERT INTO `".$table."_conversations` (`entry1`,`entry2`,`entry3`,`entry4`,`entry5`,`entry6`) VALUES (2,3,6,20,4,5);";

	break;


	//https://elearnaustralia.com.au/opal/chinese/set-conversation.php?var1=2&var2=3&var3=6&var4=20&var5=4&var6=5

}

//echo 	$insertConvSQL;
//echo 	$insertSQL;

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
