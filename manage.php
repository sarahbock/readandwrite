<?php require('access.php'); ?>

<!doctype html>
<html>
<head>
	<title>Manage</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<link rel="stylesheet" href="css/styles.css?v=30">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css" />
  <link href="css/all.min.css" rel="stylesheet">
     <?php  require_once("settings.php");   ?>
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
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/scripts.js?v=30"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="js/rangy-core.js"></script> <!-- range and selection library - https://github.com/timdown/rangy-->
    <script type="text/javascript" src="js/rangy-classapplier.js"></script>
</head>
<body id="manage">

 <?php
    require_once($db_connect_dir."dbconnect.php");

    $item = ""; if (isset($_GET["item"])) {$item = $_GET["item"];}
    if ($item){
			if($item==="additionaltopic1" || $item==="additionaltopic2"){ $item="topic"; }//set to manage topics if coming from additional topics dropdown
			if ($item==="heading"||$item==="topic"||$item==="speaker"||$item==="function"){$item.="s";} //backwards compatibility to match table names in DB
			if ($item==="headings"){
				$sql = "SELECT * FROM ".$table."_topics"; //headings are in the topics table
			} else {
				$sql = "SELECT * FROM ".$table."_".$item; //alphabetical order
			}
			switch ($item) {
				case 'functions':
					$sql .= " ORDER BY title"; //alphabetical order
					break;

				case 'speakers':
					$sql .= " ORDER BY name"; //alphabetical order
					break;

				case 'glossing':
					$sql .= " ORDER BY id"; //numbered order
					break;
			}
			$error = null;
	    $result = $conn->query($sql);
		}
?>

<div id="container" data-id="<?php if (isset($_GET["id"])) {echo $_GET["id"];}?>">


	<div class="containerHead"> <!--fixed header-->
	    <div class="modeNavigation">
	  <h1><button class="backIcon" title="Go back" onclick="manageBack();"><i class="fas fa-arrow-alt-circle-left"></i></button> Manage <?php echo $item;?></h1>
	    </div>
	</div>

	<div class="containerScroll"> <!--scrollable content-->

    <table id="manageTable" data-field="<?php echo $item;?>">
  <tbody id="manageTableBody">

    <?php
    $str=""; $count=1;

		//header rows
		$str.='<tr id="tableRow0" data-id="0" class="'.$item.'Row formrowheader fixedformheader">';
		$str.='<th class="col1"><div class="paddedText">&nbsp; </div></th>';
		if ($item==="glossing"){

			$str.='<th class="col4"><div contenteditable="false" class="ta">Category title</div></th>';
			$str.='<th class="col3"><div contenteditable="false" class="ta">Colour (Hex)</div></th>';
			$str.='<th class="col4"><div contenteditable="false" class="ta">Short description</div></th>';
			$str.='<th class="col4"><div contenteditable="false" class="ta">Link for more info</div></th>';
		} else if ($item==="topics"){
			$str.='<th class="col4"><div contenteditable="false" class="ta">Heading</div></th>';
			$str.='<th class="col2"><div contenteditable="false" class="ta">Topic</div></th>';
			$str.='<td class="col3">&nbsp;</td>';
		} else if ($item==="headings"){
			$str.='<th class="col2"><div contenteditable="false" class="ta">Heading</div></th>';
			$str.='<td class="col3">&nbsp;</td>';
		} else if ($item==="speakers"){
			$str.='<th class="col2"><div contenteditable="false" class="ta">Name of speaker</div></th>';
			$str.='<td class="col3">&nbsp;</td>';
		} else if ($item==="functions"){
			$str.='<th class="col2"><div contenteditable="false" class="ta">Function</div></th>';
			$str.='<td class="col3">&nbsp;</td>';
		}
		$str.='</tr>';

		//content rows
		$deleteClass=""; if ($result->num_rows<=2){$deleteClass=" disabled";}//disable delete button if less than 2 entries
    if ($result->num_rows > 0 && $item!=="headings") {
        while($row = $result->fetch_assoc()) {
            if ($row['id']!=="0"){
								$rowCSS=""; if($item==="glossing"){$rowCSS='style="background-color:#'.$row['colour'].';"';}

                $str.='<tr id="tableRow'.$row['id'].'" data-id="'.$row['id'].'" class="'.$item.'Row"'.$rowCSS.'>';
                $str.='<td class="col1"><div class="paddedText">';
                $str.='<span class="rowcount"></span></div></td>';

								if ($item==="topics"){ //managing topics

										$headingStr=''; //set up dropdown menu for topic headings (when managing topics)
										$headingStr.='<option value="">Select a heading</option>';
										$headingStr.='<option value="0">---------------</option>';
										$heading=trim($row['heading']); //trim whitespace from heading
										foreach($topics as $x => $x_value) {
											$headingSelected=""; if ($heading===$x_value["title"]){$headingSelected=" selected";}
											$headingStr.='<option value="'.$x_value["title"].'"'.$headingSelected.'>'.$x_value["title"].'</option>';
										}
										$headingStr.='<option value="0">---------------</option>';
										$headingStr.='<option value="M">Manage headings</option>';

										//write dropdown menu
										$str.='<td class="col4"><select id="headingSelect'.$row['id'].'" name="" class="" data-id="'.$row['id'].'" data-field="heading" data-selected="'.$heading.'">'.$headingStr.'</select></td>';
										//write textareas for topics
										$str.='<td class="col2"><div contenteditable="true" class="ta" id="'.$item.''.$row['id'].'"  data-field="topic" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">'.$row['topic'].'</div></td>';


								} else if ($item==="speakers"){

									$str.='<td class="col2"><div contenteditable="true" class="ta" id="'.$item.''.$row['id'].'"  data-field="name" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">'.$row['name'].'</div></td>';

								} else if ($item==="functions"){

									$str.='<td class="col2"><div contenteditable="true" class="ta" id="'.$item.''.$row['id'].'"  data-field="title" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">'.$row['title'].'</div></td>';

								} else if ($item==="glossing"){

									$str.='<td class="col4"><div contenteditable="true" class="ta" id="title'.$row['id'].'" data-field="title" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">'.$row['title'].'</div></td>';
									switch($row['id']){
										case "1":
											$str.='<td class="col3 formcontent"><strong>Bold</strong></td>';
											break;
										case "2":
											$str.='<td class="col3 formcontent"><em>Italic</em></td>';
											break;
										default:
											$str.='<td class="col3"><div contenteditable="true" class="ta hex" id="colour'.$row['id'].'" data-field="colour" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">'.$row['colour'].'</div></td>';

									}

									$str.='<td class="col4"><div contenteditable="true" class="ta glossing" id="descr'.$row['id'].'" data-field="descr" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">'.$row['descr'].'</div></td>';
									$str.='<td class="col4"><div contenteditable="true" class="ta" id="url'.$row['id'].'" data-field="url" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">'.$row['url'].'</div></td>';

								}

								if ($item!=="glossing"){
	                $str.='<td class="col3"><div class="paddedText">';
	                $str.='<button class="nostyle saveButton" id="save'.$row['id'].'" onclick="confirmSave('.$row['id'].');"><i class="fas fa-save" data-id="'.$row['id'].'"></i></button>';
									$str.='<button class="nostyle'.$deleteClass.'" id="delete'.$row['id'].'" onclick="deleteItem(\''.$row['id'].'\',\''.$item.'\');"><i class="fas fa-trash-alt" data-id="'.$row['id'].'"></i></button>';
	                $str.='</div></td>';
								}
                $str.='</tr>';

                $count++;
            }
        }
    } else { //no items yet

		}

		if ($item==="headings") {
			foreach($topics as $x => $x_value) {
				$x=$x+1;
				$str.='<tr id="tableRow'.$x.'" data-id="'.$x.'" class="headingsRow">';
				$str.='<td class="col1"><div class="paddedText">';
				$str.='<span class="rowcount"></span></div></td>';
				//write textareas for headings
				$str.='<td class="col2"><div contenteditable="true" class="ta" id="'.$item.''.$x.'" data-field="heading" data-id="'.$x.'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);">'.$x_value["title"].'</div></td>';
				$str.='<td class="col3"><div class="paddedText">';
				$str.='<button class="nostyle saveButton" id="save'.$x.'" onclick="confirmSave('.$x.');"><i class="fas fa-save" data-id="'.$x.'"></i></button>';
				$str.='<button class="nostyle" onclick="deleteItem(\''.$x.'\',\''.$item.'\',\''.$x_value["title"].'\');"><i class="fas fa-trash-alt" data-id="'.$x.'"></i></button>';
				$str.='</div></td>';
				$str.='</tr>';
			}
		}



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
