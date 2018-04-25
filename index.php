<?php
session_start();
if(empty($_SESSION['loggedIn'])) $_SESSION['loggedIn']=false;
include('api.php'); 
?>

<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="css.php">
	<script src="js.js" type="text/javascript"></script>
	<script>setColour("<?=$GLOBALS['colour']?>");</script>
	<link rel="icon" type="image/png" href="icon.png">
	<link rel="apple-touch-icon" href="icon.png">
	<link rel="apple-touch-startup-image" href="icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-title" content="Frog Users">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<title id="t">Frog Users</title>
</head>

<body>
	<?php if($_SESSION['loggedIn']==false){ ?>

	<div id="logIn">
		<img src="frog.png" id="frogLogo" /><br />
		<input type="text" placeholder="Username" id="usr" onkeyup="changed(this.id);" /><br />
		<input type="password" placeholder="Password" id="pwd" onkeyup="changed(this.id);" /><br />
		<button type="button" onclick="logIn();" id="logInButton">Log In</button>
	</div>

	<?php }else{ ?>
	
	<div id="header">
		<div id="selected"></div>
		<div onclick="section('list');" id="list" class="menuItem">List</div>
		<div onclick="section('add');" id="add" class="menuItem">Add</div>
		<div class="menuItem"><a href="logOut.php" id="out">Log Out</a></div>
		<div class="clearFix"></div>
	</div>

	<div id="content">
	</div>

	<?php } ?>

</body>
</html>