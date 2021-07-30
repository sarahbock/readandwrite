<?php require('access.php'); ?>

<!doctype html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<link rel="stylesheet" href="css/styles.css?v=35">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css" />
    <link href="css/all.min.css" rel="stylesheet">
    <?php require_once("settings.php");   ?>
    <script type="text/javascript">
        <?php
        //write settings to js
        $jsString.='var apiPath="'.$apiPath.'"; ';
        $jsString.='var shellPath="'.$shellPath.'"; ';
        $jsString.='var language1="'.$language1.'"; ';
        $jsString.='var language1header="'.$language1header.'"; ';
        $jsString.='var language2="'.$language2.'"; ';
				$jsString.='var functions='.json_encode($functions).'; ';
				$jsString.='var topics='.json_encode($topics).'; ';
				$jsString.='var speakers='.json_encode($speakers).'; ';
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
    <script type="text/javascript" src="js/scripts.js?v=38"></script>
    <script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="js/rangy-core.js"></script> <!-- range and selection library - https://github.com/timdown/rangy-->
    <script type="text/javascript" src="js/rangy-classapplier.js"></script>
</head>
<body id="entries">

 <?php
    require_once($db_connect_dir."dbconnect.php");

    $filter = "0"; if (isset($_GET["filter"])) {$filter = $_GET["filter"];}
    $keyword = "0"; if (isset($_GET["keyword"])) {$keyword = $_GET["keyword"];}

    $sql = "SELECT * FROM ".$table;
    switch($filter){
        case "0": $sql.=" ORDER by id"; break;
        case "flag": $sql.=" WHERE flag='1' OR id=(SELECT max(id) FROM ".$table.")"; break; //always show last (empty row)
        case "sort1": $sql.=" WHERE language!='null' AND language!='' ORDER by language"; break; //sort by language 1
        case "sort2": $sql.=" WHERE translation!='null' AND translation!='' ORDER by translation"; break; //sort by language 2
        case "sort3": $sql.=" ORDER by timestamp DESC"; break; //sort by timestamp
        case "topic": $sql.=" WHERE topic LIKE \"%".$keyword."%\" OR related LIKE \"%".$keyword."%\""; break; //search topics and related topics
        default: $sql.=" WHERE ".$filter." LIKE \"%".$keyword."%\"  OR id=(SELECT max(id) FROM ".$table.")"; //always show last (empty row)
    }
    $error = null;
    $result = $conn->query($sql);
?>

<div id="container">
  <div class="containerHead"> <!--fixed header-->
        <div class="modeNavigation">
            <!--<h1>Dashboard</h1>-->

            <div class="modeNavigationButtons">


							<!--RESET-->
		 <div class="modeButton" id="modeButtonReset">
				 <i class="fas fa-redo-alt"></i>
						 <div class="modeButtonItem"><button onclick="playOnboarding();">Replay onboarding</button></div>
		 </div>

		            <!--SEARCH-->
            <div class="modeButton" id="modeButtonSearch">
                <i class="fas fa-search"></i>
                    <input type="text" placeholder="Type search term" id="filterSearch" class="modeButtonItem searchInput">
                    <div class="modeButtonItem"><button onclick="clearSearch();"><i class="fas fa-times-circle"></i></button></div>
            </div>


                   <!--Import button-->
     <!--  <a href="" onlick="resetMode();"><div class="modeButtonClose" id="modeButtonImportClose"><i class="fas fa-times"></i></div></a>
            <!--<div class="modeButton" id="modeButtonImport" onclick="showMode('Import');">-->
       <!--   <div class="modeButton disabled" id="modeButtonImport">
                <i class="fas fa-file-upload"></i><button>Import / Export</button>
                 <div class="modeButtonFull">
                    <input type="file" value="Browse" class="modeButtonItem">
                     <div class="modeButtonItem"><a href="link" target="_blank">CSV template</a></div>
                     <div class="modeButtonItem"><button><i class="fas fa-times-circle"></i></button></div>
                </div>
            </div>

            -->


            <!--Filter button-->
            <div class="modeButtonBlock">
            <div class="modeButtonClose<?php if ($filter!=="0"){echo' inline';}?>" id="modeButtonFilterClose"  onclick="resetMode();"><i class="fas fa-angle-right"></i></div>
            <div class="modeButton" id="modeButtonFilter" onclick="showMode('Filter');">
                <i class="fas fa-filter"></i> <button onclick="showMode('Filter');">Filter / Sort</button>
                <div class="modeButtonFull<?php if ($filter!=="0"){echo' inline';}?>">
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



          <!--Quick edit button-->
          <div class="modeButtonBlock">
          <div class="modeButtonClose" id="modeButtonQuickClose" onclick="resetMode();"><i class="fas fa-angle-right"></i></div>
            <div class="modeButton modeButtonLast" id="modeButtonQuick" onclick="showMode('Quick');" title="Add colour">
                <i class="fas fa-paint-brush noMargin"></i>
                <div class="modeButtonFull">
									<div class="glossContainer">
									<?php
									for ($i = 0; $i < count($glossing); $i++) {
										if ($glossing[$i]['title']!==""){
											echo '<button class="glossGroup'.$glossing[$i]['glossGroup'].' glossCircle colour'.$glossing[$i]['id'].'" data-glossgroup="'.$glossing[$i]['glossGroup'].'" data-glossid="'.$glossing[$i]['id'].'" title="'.$glossing[$i]['title'].'">'.$glossing[$i]['symbol'].'</button> ';
										}
									}
									?>
									<button class="glossGroup3 glossCircle colour20 on" data-glossgroup="3" data-glossid="20" title="None">X</button>
									<button class="glossCircle glossManage" title="Manage"><i class="fas fa-cog"></i></button>
                    <button class="glossCircle glossUndo" title="Undo"><i class="fas fa-undo"></i></button>
                    <button class="glossCircle glossRedo" title="Redo"><i class="fas fa-redo"></i></button>
                    </div>
                </div>

        		</div>
          </div>
				</div>

        </div>
        <div class="tableHeader">
            <div class="col1">&nbsp;</div>
            <div class="col2"><span class="language1"></span></div>
            <div class="col3">Break it down</div>
            <div class="col4"><span class="language2"></span> meaning</div>
            <div class="col5">Action</div>
            <div class="clearBoth"></div>
        </div>
    </div>
    <div class="containerScroll"> <!--scrollable content-->



    <table id="entriesTable">
  <tbody id="entriesTableBody">

    <?php
    $str=""; $count=1;
		$deleteClass=""; if ($result->num_rows<=2){$deleteClass=" disabled";}//disable delete button if less than 2 entries
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
						//only show rows that are not deleted. Only show first row if it contains data
            if ($row['id']!=="0" && $row['flag']!=="X" && ($row['id']!=="1" || ($row['language']!==""||$row['explanation']!==""||$row['translation']!==""))){
                $temp[]=$row['keywordling'];
               // $rows[] = $row;
                $str.='<tr id="tableRow'.$row['id'].'" data-id="'.$row['id'].'">';
                $str.='<td class="col1"><div class="paddedText">';
                $str.='<button class="nostyle addButton" id="add'.$row['id'].'" onclick="addRow('.$row['id'].');"><i class="fas fa-plus" data-id="'.$row['id'].'"></i></button>';
                $str.='<span class="rowcount"></span></div></td>';
                $str.='<td class="col2"><div contenteditable="false" class="ta glossing disabled" id="language'.$row['id'].'" data-field="language" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" onclick="showQuick()">'.$row['language'].'</div></td>';
                $str.='<td class="col3"><div contenteditable="false" class="ta glossing disabled" id="explanation'.$row['id'].'" data-field="explanation" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" onclick="showQuick()">'.$row['explanation'].'</div></td>';
                $str.='<td class="col4"><div contenteditable="false" class="ta disabled" id="translation'.$row['id'].'" data-field="translation" data-id="'.$row['id'].'" onfocus="textAreaFocus(this);" onblur="textAreaBlur(this);" onclick="showQuick()">'.$row['translation'].'</div></td>';

                $str.='<td class="col5"><div class="paddedText">';
                //$str.='<button class="nostyle disabled saveButton" id="save'.$row['id'].'" onclick="confirmSave('.$row['id'].');"><i class="fas fa-save" data-id="'.$row['id'].'"></i></button>';

                $str.='<button class="nostyle" onclick="editEntry(\''.$row['id'].'\');" title="Edit"><i class="fas fa-edit" data-id="'.$row['id'].'"></i></button>';
                $str.='<button class="nostyle" onclick="editConversations(\''.$row['id'].'\');" title="Conversations"><i class="fas fa-comments" data-id="'.$row['id'].'"></i></button>';
								$str.='<button class="nostyle viewButton" id="view'.$row['id'].'" onclick="viewShell('.$row['id'].',false);"><i class="fas fa-eye" data-id="'.$row['id'].'" title="Preview in app"></i></button>';
                $flagClass=" disabled"; if($row['flag']==="1"){$flagClass="";}
                $str.='<button class="nostyle'.$flagClass.'" id="flagIcon'.$row['id'].'" onclick="toggleIndexFlag('.$row['id'].')"><i class="fas fa-flag" data-id="'.$row['id'].'" title="Toggle flag"></i></button>';
								$str.='<button class="nostyle'.$deleteClass.'" id="delete'.$row['id'].'" onclick="deleteEntry(\''.$row['id'].'\');"><i class="fas fa-trash-alt" data-id="'.$row['id'].'" title="Delete"></i></button>';
                $str.='</div></td>';
                $str.='</tr>';
                $count++;
            }
            //echo $str;
        }
    }
		if ($str===""){
			//$str= '<a data-fancybox data-src="#popup" href="javascript:void(0);"  title="More information">no rows</a>';
		}
    echo $str;
	?>
  </tbody>
</table>
</div>


</div>

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

				<!--Onboarding screen one - set language-->
				<div class="invisible popup" id="popup_onboarding1">
					<h2>Onboarding Pane 1</h2>
					<p>Image and text about how to use this tool.</p>
					<div class="buttonHolderRight">
						<button class="buttonSkip" onclick="onboardFinish();">Skip</button>
						<button class="buttonNext" onclick="onboard(2);">Next &gt;</button>
					</div>
				<!--<h2>Welcome</h2>
				<p>Looks like this is your first time here.</p>
				<p>Which languages will you be working with?</p>
				<p class="inputHolder"><label for="targetLanguage">Target language: </label><input type="text" id="targetLanguage" name="targetLanguage" value="Ktunaxa"></p>
				<p class="inputHolder"><label for="translationLanguage">Translation language: </label><input type="text" id="translationLanguage" name="translationLanguage" value="English"></p>
				<div class="buttonHolderRight">
				<button class="buttonNext" onclick="onboard(2);">Next &gt;</button>
			</div>-->
				</div>

				<!--Onboarding screen two - pane 1-->
				<div class="invisible popup" id="popup_onboarding2">
				<h2>Onboarding Pane 2</h2>
				<p>Image and text about how to use this tool.</p>
				<!--<p>What is the primary purpose of your project?</p>
				<div class="buttonHolder templateButtons">
					<button id="template2" onclick="chooseTemplate(2);">Travel</button>
					<button id="template1" onclick="chooseTemplate(1);">Language revitalisation</button>
					<button id="template3" onclick="chooseTemplate(0);">Blank</button>
				</div>-->
				<div class="buttonHolderRight">
					<button class="buttonSkip" onclick="onboardFinish();">Skip</button>
					<button class="buttonNext" onclick="onboard(3);">Next &gt;</button>
				</div>
				</div>

				<!--Onboarding screen two - pane 2-->
				<div class="invisible popup" id="popup_onboarding3">
				<h2>Onboarding Pane 3</h2>
				<p>Image and text about how to use this tool.</p>
				<div class="buttonHolderRight">
					<button class="buttonSkip" onclick="onboardFinish();">Skip</button>
					<button class="buttonNext" onclick="onboard(4);">Next &gt;</button>
				</div>
				</div>

				<!--Onboarding screen two - pane 3-->
				<div class="invisible popup" id="popup_onboarding4">
				<h2>Onboarding Pane 4</h2>
				<p>Image and text about how to use this tool.</p>
				<div class="buttonHolderRight">
					<button class="buttonNext" id="onboardFinish" onclick="onboardFinish();">Finish &gt;</button>
				</div>
				</div>

				<div class="tooltiptext tooltiptext1 invisible" id="popup_onboarding3">Click 'Add colours' to add colouring to your phrases.<button onclick="closeToolTip(1);">OK, I got it!</button></div>


				<!--<div class="invisible popup" id="popup_entries">
				<h2>Welcome</h2>
				<p>Set up entries.</p>
			</div>-->
			<button id="logout">Logout</button>
     <div id="error"><p><i class="fas fa-times-circle"></i> <span id="errorMessage"></span></p></div>
     <div id="saving"><p><i class="fas fa-check-square"></i> Saving ... </p></div>
</body>
</html>
