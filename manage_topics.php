<?php require('access.php'); ?>

<!doctype html>
<html>
<head>
	<title>Manage</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<link rel="stylesheet" href="css/styles.css?v=33">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css" />
  <link href="css/all.min.css" rel="stylesheet">
     <?php  require_once("settings.php");   ?>
    <script type="text/javascript">
        <?php
        //write settings to js
        $jsString='var apiPath="'.$apiPath.'"; ';
        $jsString.='var language1="'.$language1.'"; ';
				$jsString.='var language1header="'.$language1header.'"; ';
        $jsString.='var language2="'.$language2.'"; ';
        echo $jsString;
        ?>
    </script>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/scripts.js?v=34"></script>
	<script type="text/javascript" src="js/buttons.js?v=1"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="js/rangy-core.js"></script> <!-- range and selection library - https://github.com/timdown/rangy-->
    <script type="text/javascript" src="js/rangy-classapplier.js"></script>
	</head>

	<body id="managetopics">

		 <?php
		    require_once($db_connect_dir."dbconnect.php");

		    $headings_sql = "SELECT * FROM ".$table."_headings ORDER BY displayorder";
			$topics_sql = "SELECT * FROM ".$table."_topics ORDER BY displayorder";

			$headings_result = $conn->query($headings_sql);
			$topics_result = $conn->query($topics_sql);

		?>

		<div id="container" data-id="<?php if (isset($_GET["id"])) {echo $_GET["id"];}?>">

			<div class="containerHead"> <!--fixed header-->
				<div class="modeNavigation">
					<h1>
						 <button class="backIcon" title="Go back" onclick="manageBack();">
							<i class="fas fa-arrow-alt-circle-left"></i>
						</button> Manage categories and topics
					</h1>
				</div>
			</div>

			<div class="containerScroll">
				<p>
					<?php
					//content rows
					$alltopics = [];
					while($row = $topics_result->fetch_assoc()) {
						$alltopics[] = $row;
					}
					 ?>
				</p>

		    <table id="manageTable" data-field="topics">

				<tbody id="manageTableBody" class="manageTopics">

		    <?php
		    $str="";

				//header rows
				/*$str.='<tr id="tableRow0" data-id="0" class="'.$item.'Row formrowheader fixedformheader">';
				$str.='<th class="col1"><div class="paddedText">&nbsp; </div></th>';
				$str.='<th class="col2"><div contenteditable="false" class="ta">'.$item.'</div></th>';
				if ($item==="topics"){
					$str.='<th class="col4"><div contenteditable="false" class="ta">Heading</div></th>';
				}
				$str.='</tr>';*/


				//disable delete button if less than 2 entries
				$deleteClass=""; if ($headings_result->num_rows<2){$deleteClass=" disabled";}

				$newHeadingCounter=1;
                if ($headings_result->num_rows > 0) {
		        while($heading = $headings_result->fetch_assoc()) {
		        if ($heading['id']!=="0"){
                                $newHeadingCounter=$heading['displayorder']+1;

								$str.='<tr class="heading">';

								$str.='<th class="itemName">';

                                $str.='<div contenteditable="true" class="ta" id="headingDisplayOrder'.$heading['id'].'"  data-field="headingDisplayOrder" data-id="'.$heading['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">';
                                $str.=$heading['displayorder'];
                                $str.='</div>';

								$str.='<div contenteditable="true" class="ta" id="heading'.$heading['id'].'"  data-field="heading" data-id="'.$heading['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">';
								$str.=$heading['heading'];
								$str.='</div>';
								$str.='</th>';

								$headingUploadVisibility = $heading['image'] ? ' invisible' : '';
								$headingShowVisibility = $heading['image'] ? '' : ' invisible';
								$headingImage = ($heading['image']) ? $imagePath.$heading['image'] : null;
								$str.='<th class="itemImage">';

								$str.='<div class="image imageUpload'.$headingUploadVisibility.'" id="imageHeadingSet'.$heading['id'].'">';
								$str.='<input type="button" id="imageHeading'.$heading['id'].'set" value="Set icon" class="uploadButton" onclick="$(\'#imageHeadingUpload'.$heading['id'].'\').css(\'display\',\'flex\'); $(\'#imageHeadingSet'.$heading['id'].'\').css(\'display\',\'none\');">';
								$str.='</div>';

								$str.='<div class="image imageUpload invisible" id="imageHeadingUpload'.$heading['id'].'">';
								$str.='<input type="file" value="Upload new" name="image" id="imageHeading'.$heading['id'].'" data-id="'.$heading['id'].'" accept=".jpg,.png,.gif">';
								$str.='<input type="button" id="imageHeading'.$heading['id'].'upload" value="Upload icon" class="uploadButton" onclick="uploadFile(\'imageHeading'.$heading['id'].'\',\''.$heading['id'].'\');">';
								$str.='</div>';

								$str.='<div class="image imageShow'.$headingShowVisibility.'" id="imageHeadingShow'.$heading['id'].'">';
								$str.='<img class="thumbnail" src="'.$headingImage.'">';
								$str.='<input type="button" id="headingimagedelete'.$heading['id'].'" value="Remove icon" class="uploadButton" onclick="deleteFile(\'imageHeading\',\''.$heading['id'].'\',\''.$heading['image'].'\');">';
								$str.='</div>';

								$str.='</th>';
								
								$str.='<th class="itemDelete">';
								$str.='<button onclick="deleteItem(\''.$heading['id'].'\',\'headings\',\''.$heading['image'].'\');" class="deleteIcon nostyle'.$deleteClass.'" id="deleteHeading'.$heading['id'].'"><i class="fas fa-trash-alt" data-id="'.$heading['id'].'"></i></button>';
								$str.='</th>';

		                        $str.='</tr>';

								//disable delete button if less than 2 entries
								$deleteTopicsClass=""; if (count($alltopics)<2){$deleteTopicsClass=" disabled";}

								$newTopicCounter = 1;
                                foreach ($alltopics as $key => $value) {
									if ($value['heading'] === $heading['id'] || $value['heading'] === $heading['heading']){
                                        $newTopicCounter = $value['displayorder']+1;
										$str.='<tr>';

										$str.='<td class="itemName">';
                                        $str.='<div contenteditable="true" class="ta" id="topicDisplayOrder'.$value['id'].'"  data-field="topicDisplayOrder" data-id="'.$value['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">';
                                        $str.=$value['displayorder'];
                                        $str.='</div>';
										$str.='<div contenteditable="true" class="ta" id="topic'.$value['id'].'"  data-field="topic" data-id="'.$value['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">';
										$str.=$value['topic'];
										$str.='</div>';
										$str.='</td>';

										$topicUploadVisibility = $value['image'] ? ' invisible' : '';
										$topicShowVisibility = $value['image'] ? '' : ' invisible';
										$topicImage = ($value['image']) ? $imagePath.$value['image'] : null;
										$str.='<td class="itemImage">';

										$str.='<div class="image imageUpload'.$topicUploadVisibility.'" id="imageTopicSet'.$value['id'].'">';
										$str.='<input type="button" id="imageTopic'.$heading['id'].'set" value="Set icon" class="uploadButton" onclick="$(\'#imageTopicUpload'.$value['id'].'\').css(\'display\',\'flex\'); $(\'#imageTopicSet'.$value['id'].'\').css(\'display\',\'none\');">';
										$str.='</div>';

										$str.='<div class="image imageUpload invisible" id="imageTopicUpload'.$value['id'].'">';
										$str.='<input type="file" value="Upload new" name="image" id="imageTopic'.$value['id'].'" data-id="'.$value['id'].'" accept=".jpg,.png,.gif">';
										$str.='<input type="button" id="imageTopic'.$value['id'].'upload" value="Upload icon" class="uploadButton" onclick="uploadFile(\'imageTopic'.$value['id'].'\',\''.$value['id'].'\');">';
										$str.='</div>';

										$str.='<div class="image imageShow'.$topicShowVisibility.'" id="imageTopicShow'.$value['id'].'">';
										$str.='<img class="thumbnail" src="'.$topicImage.'">';
										$str.='<input type="button" id="topicimagedelete'.$value['id'].'" value="Remove icon" class="uploadButton" onclick="deleteFile(\'imageTopic\',\''.$value['id'].'\',\''.$value['image'].'\');">';
										$str.='</div>';

										$str.='</td>';

										$str.='<td class="itemMove">';

										$str.='<select id="changeHeadingSelect'.$value['id'].'" data-id="'.$value['id'].'" name="">';
										$str.='<option value="0">Change category</option>';
										/*This is actually the headings coming from settlings php*/
										foreach ($topics as $key => $value2) {
											$str.='<option value='.$value2['id'].'>'.$value2['title'].'</option>';
						        }
										$str.='</select>';

										$str.='</td>';

										$str.='<td  class="itemDelete">';

										$str.='<button onclick="deleteItem(\''.$value['id'].'\',\'topics\',\''.$value['image'].'\');" class="deleteIcon nostyle'.$deleteTopicsClass.'" id="deleteTopic'.$value['id'].'"><i class="fas fa-trash-alt" data-id="'.$value['id'].'"></i></button>';
										$str.='</td>';

										$str.='</tr>';

							 	}
								}


								$deleteTopicsClass=" disabled";

								$str.='<tr>';

								$str.='<td class="itemName addIcon">';
								$str.='<div class="ta_buttons">';
								$str.='<button class="nostyle" onclick="addTopic(\''.$heading['id'].'\', '.$newTopicCounter.');"><i class="fas fa-plus-circle"></i></button>';
								$str.='Add a topic to <strong> &nbsp;'.$heading['heading'].'</strong>';
								$str.='</div>';
								$str.='<div class="ta invisible">';
								$str.='New topic';
								$str.='</div>';
								$str.='<div class="ta_buttons invisible">';
								$str.='<button class="nostyle ta_add invisible">Add</button>';
								$str.='<button class="nostyle ta_cancel invisible">Cancel</button>';
								$str.='</div>';
								$str.='</td>';

								$str.='<td class="itemImage">';

								$str.='</td>';



								$str.='<td  class="itemDelete">';

								$str.='<button class="deleteIcon nostyle'.$deleteTopicsClass.'"><i class="fas fa-trash-alt" ></i></button>';
								$str.='</td>';


								$str.='</tr>';


		        }
		      }
		    }

				$deleteTopicsClass=" disabled";


				$str.='<tr class="heading">';

				$str.='<th class="itemName addIcon">';
				$str.='<div class="ta_buttons">';
				$str.='<button class="nostyle" onclick="addHeading('.$newHeadingCounter.');"><i class="fas fa-plus-circle"></i></button>';
				$str.='Add a new category';
				$str.='</div>';
				$str.='<div class="ta invisible">';
				$str.='New heading';
				$str.='</div>';
				$str.='<div class="ta_buttons invisible">';
				$str.='<button class="nostyle ta_add invisible">Add</button>';
				$str.='<button class="nostyle ta_cancel invisible">Cancel</button>';
				$str.='</div>';
				$str.='</th>';

				$str.='<th class="itemImage invisible">';

				$str.='<div class="image imageUpload invisible">';
				$str.='<input type="file" value="Upload new" placeholder="Thumbnail" name="image" accept=".jpg,.png,.gif">';
				$str.='<input type="button" id="imageupload"  value="Upload icon" class="uploadButton">';
				$str.='</div>';

				$str.='<div class="image imageShow invisible">';
				$str.='<img class="thumbnail" src="">';
				$str.='<input type="button" id="imagedelete" value="Remove" class="uploadButton">';
				$str.='</div>';

				$str.='</th>';

				$str.='<th  class="itemDelete">';

				$str.='<button class="deleteIcon nostyle'.$deleteTopicsClass.'"><i class="fas fa-trash-alt" ></i></button>';
				$str.='</th>';


				$str.='</tr>';


		    echo $str;
				?>
		  </tbody>
		</table>


		</div>
		</div>


     <div id="error"><p><i class="fas fa-times-circle"></i> <span id="errorMessage"></span></p></div>
     <div id="saving"><p><i class="fas fa-check-square"></i> Saving ... </p></div>
</body>
</html>
