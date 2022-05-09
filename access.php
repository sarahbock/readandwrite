<?php
session_start();
//session_unset();

require_once("languages.php");

$selectedlanguage='';
$languagepassword='';

//specified language
$sl = ""; if (isset($_GET["sl"])){$sl=$_GET["sl"];}


if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

if (isset($_POST['language'])) {
  $selectedlanguage=$languages[$_POST['language']];
  $languagepassword=$selectedlanguage->password;
}

if (isset($_POST['password'])) {
    if (sha1($_POST['password']) == $languagepassword) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['language1'] = $selectedlanguage->language1;
        $_SESSION['language1header'] = $selectedlanguage->language1header;
        $_SESSION['language2'] = $selectedlanguage->language2;
    } else {
        die ('Incorrect password');
    }
}

if (!$_SESSION['loggedIn']): ?>
<!doctype html>
<html>
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<link rel="stylesheet" href="css/styles.css?v=1">
</head>
<body id="login">
<div class="loginContainer">
<h1>Login</h1>
<p>You need to login</p>
    <form method="post">
      <select name="language" id="language">
        <option value="">Select language or group</option>
        <?php
        foreach ($languages as $x=>$value) {
          //echo ($value->language1);
          if ($sl==="" || $sl===$value->language1){
            if ($value->language1 === 'umpila') { $displayLanguage = 'Ngampula Kuuku Pitaanchimana'; } else { $displayLanguage = $value->language1;}
            echo '<option value="'.$x.'">'.ucfirst($displayLanguage).'</option>';
          }
        }
        ?>

      </select>
		<p>Password: <input type="password" name="password"> </p>
		<p> <input type="submit" name="submit" value="Login"></p>
    </form>
</div>
</body>
</html>

<?php
exit();
endif;
?>
