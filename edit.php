<?php require('access.php'); ?>
<!doctype html>
<html>
<head>
	<title>Edit phrase</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<link rel="stylesheet" href="css/styles.css?v=30">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css" />
    <link href="css/all.min.css" rel="stylesheet">
    <?php require_once("settings.php"); ?>
    <script type="text/javascript">
        <?php
        //write settings to js
        $jsString.='var apiPath="'.$apiPath.'"; ';
        $jsString.='var language1="'.$language1.'"; ';
				$jsString.='var language1header="'.$language1header.'"; ';
        $jsString.='var language2="'.$language2.'"; ';
        echo $jsString;



        ?>
    </script>
		<style>
		/*overwrite categories stylesheet*/
		<?php
		$css="";
		foreach ($glossing as $value) {
			if ($value["glossGroup"]==="2" && $value["title"]!==""){ //only group 2 has colours
				$css.=".colour".$value["id"].", .modeNavigation button.colour".$value["id"]."{background-color: #".$value["colour"].";color: #".$value["colour"].";}";
			}
		}
		echo $css;
		?>
		</style>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/scripts.js?v=31"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="js/rangy-core.js"></script>
    <script type="text/javascript" src="js/rangy-classapplier.js"></script>
</head>
<body id="edit" >
 <?php
    require_once($db_connect_dir."dbconnect.php");
    $id=0; if (isset($_GET["id"])) {$id = $_GET["id"];}
    $error = null; $rows;
    $sql = "SELECT * FROM ".$table." WHERE id='".$id."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $rows[] = $row;
        }
    }
    //$data=json_encode($rows);
?>

<div id="container" data-id="<?php echo($rows[0]['id']);?>">

<div class="containerHead"> <!--fixed header-->
    <div class="modeNavigation">
  <h1><button class="backIcon" title="Go back" onclick="entryBack();"><i class="fas fa-arrow-alt-circle-left"></i></button> Edit phrase: <span class="chunkHeading"><?php echo($rows[0]['language']);?></span></h1>
        <button class="flagIcon<?php if ($rows[0]['flag']==="1"){echo(" on");}?>" title="Toggle flag" onclick="toggleFlag(<?php echo($rows[0]['id']);?>);"><i class="fas fa-flag"></i></button>
    </div>
</div>

<div class="containerScroll"> <!--scrollable content-->

    <div class="modeNavigation shading2">

        <div class="glossContainer">
				<?php
				for ($i = 0; $i < count($glossing); $i++) {
					if ($glossing[$i]['title']!==""){
						echo '<button class="glossGroup'.$glossing[$i]['glossGroup'].' glossCircle colour'.$glossing[$i]['id'].'" data-glossgroup="'.$glossing[$i]['glossGroup'].'" data-glossid="'.$glossing[$i]['id'].'" title="'.$glossing[$i]['title'].'">'.$glossing[$i]['symbol'].'</button> ';
					}
				}
				?>
        <button class="glossGroup3 glossCircle colour20 on" data-glossgroup="3" data-glossid="20" title="None">X</button>
				<!--<button class="glossCircle glossManage" title="Manage"><i class="fas fa-cog"></i></button>-->
        <button class="glossCircle glossUndo" title="Undo"><i class="fas fa-undo"></i></button>
        <button class="glossCircle glossRedo" title="Redo"><i class="fas fa-redo"></i></button>
        </div>
     </div>

    <!-- LANGUAGE 1 -->
    <div class="shading2">
        <div class="editLeft"><div><span class="language1"></span></div></div>
        <div class="editRight"><div><div contenteditable="true" class="ta glossing" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);"  data-id="<?php echo($rows[0]['id']);?>" data-field="language" id="<?php echo($language1.$rows[0]['id']);?>" placeholder="Type phrase"><?php echo($rows[0]['language']);?></div></div></div>
        <div class="clearBoth"></div>
    </div>

    <!--EXPLANATION-->
    <div class="shading2">
        <div class="editLeft"><div>Explanation</div></div>
        <div class="editRight"><div><div contenteditable="true" class="ta glossing" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" maxlength="500" data-id="<?php echo($rows[0]['id']);?>" data-field="explanation" id="explanation<?php echo($rows[0]['id']);?>" placeholder="Type explanation"><?php echo($rows[0]['explanation']);?></div></div></div>
        <div class="clearBoth"></div>
    </div>



    <!--SOUND FILE-->
    <div class="shading2">
        <div class="editLeft"><div>Sound file</div></div>
        <div class="editRight">
            <!--show file input if there is no sound file-->
            <div id="soundfilenameUpload" class="<?php if($rows[0]['soundfilename']!==""){ echo("invisible");} ?>">
                <input type="file" value="Select new" name="soundfilename" id="soundfilename" data-id="<?php echo($rows[0]['id']);?>" accept=".mp3">
								<input type="button" id="soundfilenameupload"  value="Upload" class="uploadButton"  onclick="uploadFile('soundfilename','<?php echo($rows[0]['id']);?>');" >
            </div>
            <!--show audio player and info if there is a sound file-->
            <div id="soundfilenameShow" class="<?php if($rows[0]['soundfilename']===""){ echo("invisible");} ?>">
                <audio controls="" id="">
                    <source src="<?php if($rows[0]['soundfilename']!==""){ echo($mp3Path.$rows[0]['soundfilename']);}?>" type="audio/mpeg"></audio>
                		<span id=""><?php echo($rows[0]['soundfilename']);?></span> &nbsp;
                     <select id="speakerSelect" name="" class="inline" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo(trim($rows[0]['speaker']));?>">
                    <?php
                     $speakerStr='<option value="0">Select a speaker</option>';//populate dropdown with data from array in settings.php
										 $speakerStr.='<option value="M">Manage speakers</option>';
										 $speakerStr.='<option value="0">---------------</option>';
                    foreach($speakers as $x => $x_value) {
											if ($x_value){$speakerStr.='<option value="'.$x_value.'">'.$x_value.'</option>';}
										}
										echo $speakerStr;
                    ?>
            </select>
                <input type="button" id="soundfilenamedelete"  value="Remove" class="uploadButton"  onclick="deleteFile('soundfilename','<?php echo($rows[0]['id']);?>','<?php echo str_replace("'", "\'", $rows[0]['soundfilename']); ?>');" >
                </div>
        </div>
        <div class="clearBoth"></div>
    </div>

      <!-- FILE SOURCE -->
    <div class="shading2">
        <div class="editLeft"><div>File source</div></div>
        <div class="editRight"><div><div contenteditable="true" class="ta" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" maxlength="500" data-id="<?php echo($rows[0]['id']);?>" data-field="source" placeholder=""><?php echo($rows[0]['source']);?></div></div></div>
        <div class="clearBoth"></div>
    </div>

    <!-- IMAGE -->
    <div class="shading2">
        <div class="editLeft"><div>Image</div></div>
         <div class="editRight">
             <!--show file input if there is no image-->
            <div id="imageUpload" class="<?php if($rows[0]['image']!==""){ echo("invisible");} ?>">
                <input type="file" value="Upload new" name="image" id="image" data-id="<?php echo($rows[0]['id']);?>" accept=".jpg,.png,.gif">
				<input type="button" id="imageupload"  value="Upload" class="uploadButton"  onclick="uploadFile('image','<?php echo($rows[0]['id']);?>');" >
            </div>
             <!--show image if there is one-->
            <div id="imageShow" class="<?php if($rows[0]['image']===""){ echo("invisible");} ?>">
                <img class="thumbnail" src="<?php if($rows[0]['image']!==""){ echo($imagePath.$rows[0]['image']);} ?>">
				<input type="button" id="imagedelete" value="Remove" class="uploadButton"  onclick="deleteFile('image','<?php echo($rows[0]['id']);?>','<?php echo($rows[0]['image']);?>');" >
             </div>
        </div>
        <div class="clearBoth"></div>
    </div>


    <hr>
    <h2>Translation</h2>

    <!-- TRANSLATION TEXT -->
    <div class="shading2">
        <div class="editLeft"><div>Text</div></div>
        <div class="editRight"><div><div contenteditable="true" class="ta" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" maxlength="500" data-id="<?php echo($rows[0]['id']);?>" data-field="translation" placeholder="Type translation here"><?php echo($rows[0]['translation']);?></div></div></div>
        <div class="clearBoth"></div>
    </div>

    <!--TRANSLATION SOUND FILE -->
    <div class="shading2">
        <div class="editLeft"><div>Audio</div></div>
         <div class="editRight">
            <!--show file input if there is no sound file-->
            <div id="translationUpload" class="<?php if($rows[0]['translationsoundfilename']!==""){ echo("invisible");} ?>">
                <input type="file" value="Upload new" name="translationsoundfilename" id="translationsoundfilename" data-id="<?php echo($rows[0]['id']);?>" accept=".mp3">
				<input type="button" id="translationsoundfilenameupload"  value="Upload" class="uploadButton"  onclick="uploadFile('translationsoundfilename','<?php echo($rows[0]['id']);?>');" >
            </div>
            <!--show audio player and info if there is a sound file-->
            <div id="translationsoundfilenameShow" class="<?php if($rows[0]['translationsoundfilename']===""){ echo("invisible");} ?>">
                <audio controls="" id="">
                    <source src="<?php if($rows[0]['translationsoundfilename']!==""){echo($mp3Path.$rows[0]['translationsoundfilename']);}?>" type="audio/mpeg"></audio>
                <span id=""><?php echo($rows[0]['translationsoundfilename']);?></span> &nbsp;
                <input type="button" id="translationsoundfilenamedelete"  value="Remove" class="uploadButton"  onclick="deleteFile('translationsoundfilename','<?php echo($rows[0]['id']);?>','<?php echo($rows[0]['translationsoundfilename']);?>');" >
                </div>
        </div>
        <div class="clearBoth"></div>
    </div>



    <!-- NOTES -->
    <div class="shading2">
        <div class="editLeft"><div>Notes</div></div>
        <div class="editRight"><div><div contenteditable="true" class="ta" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" maxlength="500" data-id="<?php echo($rows[0]['id']);?>" data-field="notes" placeholder="Type notes here"><?php echo($rows[0]['notes']);?></div></div></div>
        <div class="clearBoth"></div>
    </div>


    <hr>
    <h2>Topics and tags</h2>

		<?php
			$topicStr=''; //populate dropdown with data from topic array in settings.php
			$topicStr.='<option value="">Select a topic</option>';
			$topicStr.='<option value="N">No topic</option>';
			$topicStr.='<option value="M">Add your own topic</option>';
			foreach($topics as $x => $x_value) {
				$topicStr.='<option value="0">---------------</option>';
				$topicStr.='<option value="0">'.strtoupper($x_value["title"]).'</option>';
				for ($i = 0; $i < count($x_value["subtopics"]); $i++){
					$topicStr.='<option value="'.$x_value["subtopics"][$i].'">'.$x_value["subtopics"][$i].'</option>';
				}
			 }
			 $topicStr.='<option value="0">---------------</option>';
			 $topicStr.='<option value="M">Add your own topic</option>';
		?>

    <!-- TOPICS -->
    <div class="shading2">
        <div class="editLeft"><div>Topics</div></div>
        <div class="editRight"><div>
            <?php  $addtionaltopics=explode(",", trim($rows[0]['related']));   ?>
						<select id="topicSelect" name="" class="inline" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo(trim($rows[0]['topic']));?>"><?php echo $topicStr; ?></select>
            <select id="additionaltopic1Select" name="" class="inline" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo($addtionaltopics[0]);?>"><?php echo $topicStr; ?></select>
            <select id="additionaltopic2Select" name="" class="inline" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo($addtionaltopics[1]);?>"><?php echo $topicStr; ?></select>
            </div></div>
        <div class="clearBoth"></div>
    </div>

		<!-- CLASS -->
		<div class="shading2">
				<div class="editLeft"><div>Phrase or word?</div></div>
				<div class="editRight"><div>
						<select id="classSelect" name="" class="" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo(ucfirst(trim($rows[0]['class'])));?>"> <!--trim and capitalise first letter-->
						</select>
						</div></div>
				<div class="clearBoth"></div>
		</div>

		<!-- TAGS -->
		<div class="shading2">
				<div class="editLeft"><div><a data-fancybox data-src="#popupTags" href="javascript:void(0);"  title="More information"><i class="infoIcon fas fa-info-circle"></i></a>Searchable tags</div></div>
				<div class="editRight"><div>
						<div contenteditable="true" class="ta" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" maxlength="500" data-id="<?php echo($rows[0]['id']);?>" data-field="tags" placeholder="Add any search terms that aren’t shown above"><?php echo($rows[0]['tags']);?></div>
						</div></div>
				<div class="clearBoth"></div>
		</div>

		<div class="textLeft">
				<button id="advancedTopicsArrow" onclick="toggleAdvancedTopics();"><span class="showHideText">Show</span> advanced options <i class="fas fa-chevron-down"></i></button>
		</div>

		<div class="advanced">

    <!-- LANGUAGE FUNCTION -->
    <div class="shading2">
        <div class="editLeft"><div><a data-fancybox data-src="#popup" href="javascript:void(0);"  title="More information"><i class="infoIcon fas fa-info-circle"></i></a>Language function</div></div>
        <div class="editRight"><div>
				<select id="functionSelect" name="" class="" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo(trim($rows[0]['function']));?>">
				<?php
				$functionStr='<option value="0">Select a function</option>';
				$functionStr.='<option value="M">Manage functions</option>';
				$functionStr.='<option value="0">---------------</option>';
				foreach($functions as $x => $x_value) {
				if ($x_value){$functionStr.='<option value="'.$x_value.'">'.$x_value.'</option>';}
				}
				echo $functionStr;
				?>
				</select>
        </div></div>
        <div class="clearBoth"></div>
    </div>





    <!-- LANG 1 KEYWORDS -->
    <div class="shading2">
        <div class="editLeft"><div><a data-fancybox data-src="#popup" href="javascript:void(0);"  title="More information"><i class="infoIcon fas fa-info-circle"></i></a><span class="language1"></span> keywords</div></div>
        <div class="editRight"><div>
            <div contenteditable="true" id="keywordlanguage" class="ta" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" maxlength="500" data-id="<?php echo($rows[0]['id']);?>" data-field="keyword" placeholder="Separate keywords with commas"><?php if ($rows[0]['keyword']===""){echo preg_replace('/\s+/', ',', $rows[0]['language']);}else {echo($rows[0]['keyword']);} ?></div>
        </div></div>
        <div class="clearBoth"></div>
    </div>

    <!-- LANG 2 KEYWORDS -->
    <div class="shading2">
        <div class="editLeft"><div><a data-fancybox data-src="#popup" href="javascript:void(0);"  title="More information"><i class="infoIcon fas fa-info-circle"></i></a><span class="language2"></span> keywords</div></div>
        <div class="editRight"><div>
            <div contenteditable="true" id="keywordtranslation" class="ta" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" maxlength="500" data-id="<?php echo($rows[0]['id']);?>" data-field="keywordtranslation" placeholder="Separate keywords with commas"><?php if ($rows[0]["keywordtranslation"]===""){echo preg_replace('/\s+/', ',', $rows[0]['translation']);}else {echo($rows[0]["keywordtranslation"]);} ?></div>
        </div></div>
        <div class="clearBoth"></div>
    </div>

    <!--  LINGUISTIC KEYWORDS -->
    <div class="shading2">
        <div class="editLeft"><div><a data-fancybox data-src="#popup" href="javascript:void(0);"  title="More information"><i class="infoIcon fas fa-info-circle"></i></a>Linguistic keywords</div></div>
        <div class="editRight"><div>
            <?php   $lingkeywords=explode(",", $rows[0]['keywordling']);       ?>
            <select id="ling1Select" name="" class="inline" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo(ucfirst(trim($lingkeywords[0])));?>"></select>
            <select id="ling2Select" name="" class="inline" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo(ucfirst(trim($lingkeywords[1])));?>"></select>
            <select id="ling3Select" name="" class="inline" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo(ucfirst(trim($lingkeywords[2])));?>"></select>
            <select id="ling4Select" name="" class="inline" data-id="<?php echo($rows[0]['id']);?>" data-selected="<?php echo(ucfirst(trim($lingkeywords[3])));?>"></select>
            </div></div>
        <div class="clearBoth"></div>
    </div>

	</div><!--end advanced-->

    <hr>

    <!-- FINISH -->
    <div class="finishDiv">
        <div><input type="checkbox" id="checkFlag" name="checkFlag" <?php if ($rows[0]['flag']==="1"){echo(" checked");}?> onclick="toggleFlag(<?php echo($rows[0]['id']);?>);"> <label for="checkFlag">I need someone to check this</label></div>
        <button id="finishButton" onclick=" entryBack(<?php echo($rows[0]['id']);?>);">Finish</button>
    </div>
    <div class="clearBoth"></div>

</div>


    <!-- GLOSSING TABLE -->
  <button id="glossHelperArrow" onclick="toggleGlossHelper();"><i class="fas fa-chevron-down"></i></button>
    <div id="glossHelper">
    <div class="glossHelperTableDiv">
   <table class="glossHelperTable">
  <tbody>
		<?php
		for ($i = 0; $i < count($glossing); $i++) {
			echo'
			<tr>
	      <td class="glossHelperCol1 colour'.$glossing[$i]['id'].'">'.$glossing[$i]['id'].'</td>
	      <td class="glossHelperCol2 colour'.$glossing[$i]['id'].'">'.$glossing[$i]['title'].'</td>
	      <td class="glossHelperCol3">'.$glossing[$i]['descr'].'</td>
				<td class="glossHelperCol4">';if ($glossing[$i]['url']){echo '<a href="'.$glossing[$i]['url'].'" target="_blank" title="More information"><i class="fas fa-info-circle"></i></a>';}
			echo'</td>
	    </tr>
			';
		}
		?>
  </tbody>
</table>
        </div>
        </div>

    </div>

		<div class="invisible popup" id="popup">
		<h2>Heading</h2>
		<p>More information about this</p>
		</div>

		<div class="invisible popup" id="popupTags">
		<h2>Searchable tags</h2>
		<p>Enter tags (i.e. words that aren't in the phrase) to help the learner find the phrase. </p>
		<p>Separate multiple tags with commas.</p>
		</div>


    <div id="error"><p><i class="fas fa-times-circle"></i> <span id="errorMessage"></span></p></div>
    <div id="saving"><p><i class="fas fa-check-square"></i> Saving ... </p></div>
</body>
</html>
