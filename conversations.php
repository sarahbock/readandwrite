<?php require('access.php'); ?>
<!doctype html>
<html>
<head>
	<title>Conversations</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<link rel="stylesheet" href="css/styles.css?v=10">
	<link rel="stylesheet" href="css/jquery.fancybox.min.css" />
	<link href="css/all.min.css" rel="stylesheet">
	<?php require_once("settings.php"); ?>
	<script type="text/javascript">
			<?php
			//write settings to js
			$jsString.='var apiPath="'.$apiPath.'"; ';

			$jsString.='var shellPath="'.$shellPath.'"; ';
			$jsString.='var language1="'.$language1.'"; ';
			$jsString.='var language1header="'.$language1header.'"; ';
			$jsString.='var language2="'.$language2.'"; ';
			echo $jsString;
			?>


	</script>
</head>
<body id="conversations">
<?php
	require_once($db_connect_dir."dbconnect.php");
	$id = 0; if (isset($_GET["id"])) {$id = $_GET["id"];}
	$selectstr="<option value='0'>Select one</option>";


	$filter = "0"; if (isset($_GET["filter"])) {$filter = $_GET["filter"];}
	$keyword = "0"; if (isset($_GET["keyword"])) {$keyword = $_GET["keyword"];}


	$sql = "SELECT id,translation FROM ".$table."";
	switch($filter){
			case "topic": $sql.=" WHERE topic LIKE \"%".$keyword."%\" OR related LIKE \"%".$keyword."%\""; break; //search topics and related topics
			default: $sql.=" WHERE ".$filter." LIKE \"%".$keyword."%\"  OR id=(SELECT max(id) FROM ".$table.")"; //always show last (empty row)
	}
	$sql.=" ORDER BY translation";
	$error = null;
echo $sql;

	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if(trim($row['translation'])!==""){
        $selectstr.="<option value='".$row['id']."'>".$row['translation']."</option>";
			}
	   }
    }
	?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/scripts.js?v=20"></script>

<div id="container" data-id="<?php echo($id);?>">













	<div class="containerHead"> <!--fixed header-->



			<div class="modeNavigation">
				<h1><button class="backIcon" title="Go back" onclick="conversationsBack();"><i class="fas fa-arrow-alt-circle-left"></i></button> Conversations</h1>

					<!--Filter button-->
					<div class="modeButtonBlock">
				<div class="modeButton" id="modeButtonFilter" onclick="showMode('Filter');">
							<i class="fas fa-filter"></i> <button onclick="showMode('Filter');">Filter / Sort</button>
							<div class="modeButtonFull inline">
									<!--First filter selection drop down (e.g. type of keyword)-->
									<select class="modeButtonItem invisible" id="filter1" onchange="setFilter(1);">
											<?php
											$fStr=''; //populate dropdown with data from filter array in settings.php
											$fStr.='<option value="0"'; if ($filter=="0"){$fStr.= ' selected';}  $fStr.='>Select an option</option>';
											$fStr.='<option value="0">============</option>';
											$fStr.='<option value="0">FILTER BY</option>';
											 //$fStr.='<option value="search"'; if ($filter=="search"){$fStr.= ' selected';}  $fStr.='>Search term</option>';
											 foreach($filters as $x => $x_value) {
													 $fStr.='<option value="'.$x_value.'"'; if ($filter==$x_value){ $fStr.=' selected';} $fStr.='>'.$x.'</option>';
											 }
											$fStr.='<option value="0">============</option>';
											$fStr.='<option value="0">SORT BY</option>';
											$fStr.='<option value="sort1"'; if ($filter=="sort1"){$fStr.= ' selected';}  $fStr.='>'.$language1U.'</option>';
											$fStr.='<option value="sort2"'; if ($filter=="sort2"){$fStr.= ' selected';}  $fStr.='>'.$language2U.'</option>';
											$fStr.='<option value="sort3"'; if ($filter=="sort3"){$fStr.= ' selected';}  $fStr.='>Timestamp</option>';
											$fStr.='<option value="0">============</option>';
											$fStr.='<option value="clear">Clear filter</option>';
											echo $fStr;
											?>
									</select>
									<!--Second level filter (e.g. list of keywords)-->
									<select class="modeButtonItem invisible<?php if ($keyword!=="0"){echo' inline';}?>" id="filter2" onchange="setFilter(2);"></select>
									<!--Close button-->
									<div class="modeButtonItem"><button onclick="reloadPage();"><i class="fas fa-times-circle"></i></button></div>
							</div>
					</div>
							 </div>

			</div>
	</div>


<div class="containerScroll"> <!--scrollable content-->
	<div class="formrow formrowheader">
	  <div class="formcol5">&nbsp;</div>
		<div class="formcol15">Part 1</div>
		<div class="formcol15">Part 2</div>
		<div class="formcol15">Part 3</div>
		<div class="formcol15">Part 4</div>
		<div class="formcol15">Part 5</div>
		<div class="formcol15">Part 6</div>
		<div class="formcol5">&nbsp;</div>
	</div>

  <div id="conversationsList"></div>

		<div class="formrow formadd">
			<div class="formcol5">+</div>
			<div class="formcol15 formcontent"><select id="entry1"><?php echo $selectstr;?></select></div>
			<div class="formcol15 formcontent"><select id="entry2"><?php echo $selectstr;?></select></div>
			<div class="formcol15 formcontent"><select id="entry3"><?php echo $selectstr;?></select></div>
			<div class="formcol15 formcontent"><select id="entry4"><?php echo $selectstr;?></select></div>
			<div class="formcol15 formcontent"><select id="entry5"><?php echo $selectstr;?></select></div>
			<div class="formcol15 formcontent"><select id="entry6"><?php echo $selectstr;?></select></div>
			<div class="formcol5 formcontent"><div class="button addbutton" id="addConversation">Add</div></div>
		</div>


	</div>

</div>

</body>
</html>
