<?php require('access.php'); ?>
<!doctype html>
<html>
<head>
    <?php require_once("settings.php");   ?>
    <script type="text/javascript">
        <?php
        //write settings to js
        $jsString.='var language1="'.$language1.'"; ';
        echo $jsString;
        ?>
    </script>
    <title><?php if ($language1==='umpila') { echo 'Kuuku ngaachiku app tokens'; } else { echo $language1U.' app tokens'; }  ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<style>
		
		body{font-family: sans-serif; text-align: center; background-color: #4e86c1;  background-image: linear-gradient(#4e86c1, #85bfed, #85bfed); height: 90vh; padding: 5vh 0; margin: 0;}
		.block{width: 600px; margin: 0 auto;  text-align: left; max-width: 90%;}
		h1{ text-align: center;     margin-top: 0;}
		p{text-align: center; font-size: 20px; line-height: 30px;}
		input{font-family: sans-serif;font-weight:400;font-size: 1em; letter-spacing: 0;      padding: 1em 5%;width: 100%; margin-bottom: 1em;     width: 90%;}
		.button{background-color: #FF4C02; color: #FFF;   width: 200px; border-radius: 10px; padding: 1em 0; text-align: center; float: right; margin-top: 1em; cursor:pointer;}
		.success{background-color: #6bce75; padding: 1em; margin-bottom: 1em; display: none;}
	</style>
    
    <script>
        function addToken(){
            "use strict";
            $(".success").css("display","none");
            if ($("#token1").val()===""){alert("Make sure the token is not blank."); return false;}
            var token=cleanUp($("#token1").val());
            //console.log("./token-added.php?table="+language1+"&token="+token);
            $.get("./token-added.php?table="+language1+"&token="+token, function(data) {})
            .done(function() {$(".success").slideDown();})
            .fail(function() { alert("Oh no! Something went wrong with adding the token. Contact Sarah Bock at Elearn Australia for help."); return false;});
        } 
        function cleanUp(str){
            "use strict";
            var value = str.replace(/[^ +-/(/)<>_*{}=:;@$%^&*.,|?!"'a-zA-Z0-9[u00E0-u00FF]]/g, '');
            value = str.replace(/[+]/g, '%2B'); //The plus is reserved in PHP so must be submitted to PHP as the encoded value: %2B
            return value;
        }
    </script>
</head>
<body>
<script type="text/javascript" src="js/jquery.js"></script>
<div>
		<div class="block">
		<h1><?php if ($language1==='umpila') { echo 'Kuuku ngaachiku app tokens'; } else { echo $language1U.' app tokens'; }  ?></h1> 
        <p>Ask the app user what they want their token to be. It could be their email address, phone number, full name or anything that is unique.</p>
		<div class="success">The token has been added!</div>

		<input type="text" id="token1" maxlength="50" placeholder="Enter the token here">

		<div class="button" onclick="addToken();">Add token</div>

		</div>
	</div>
    </body>
</html>


