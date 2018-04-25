<?php

$logInUsr="frog";
$logInPwd='$2a$08$dJ6f/AV9tdbsST79w/1xcuGIw4JlhmENdqhpUdhxMQL5puotlNYzC';

$GLOBALS['colour']="rgb(0,103,169)";


//=======================db=Data=======================//
$GLOBALS['dbIP']='127.0.0.1';
$GLOBALS['dbUsr']='root';
$GLOBALS['dbPwd']='';
$GLOBALS['db']='frog3';

function dbConn(){ //only connect to DB
	if(empty($GLOBALS['conn'])){
		$GLOBALS['conn']=mysqli_connect($GLOBALS['dbIP'],$GLOBALS['dbUsr'],$GLOBALS['dbPwd']);
		mysqli_query($GLOBALS['conn'],"CREATE DATABASE IF NOT EXISTS ".$GLOBALS['db']);
		mysqli_select_db($GLOBALS['conn'], $GLOBALS['db']);
		mysqli_query($GLOBALS['conn'],"CREATE TABLE IF NOT EXISTS users (id int AUTO_INCREMENT, regTime text, username text, firstName text, lastName text, email text, type text, enabled int,PRIMARY KEY (id))");
	}
	return $GLOBALS['conn'];
}

function dbQuery($conn,$sql){ //run a query on the DB
	$result=$conn->query($sql);
	return $result;
}

function dbGet($data){ //return array containing full result set of query
	$out=array();
	while($tmp=mysqli_fetch_assoc($data)) array_push($out,$tmp);
	return $out; 
}

function dbX($sql){ //shorthand for returning DB query result
	return dbGet(dbQuery(dbConn(),$sql));
}






if(!empty($_POST['usr'])){ //login
	session_start(); //re-start session for httprequest
	require 'PasswordHash.php';
	$usr=mysqli_real_escape_string(dbConn(),$_POST['usr']); //collect data
	$pwd=mysqli_real_escape_string(dbConn(),$_POST['pwd']);
	$phpass=new PasswordHash(8,false);

	if($usr==$logInUsr && $phpass->CheckPassword($pwd,$logInPwd)){ 
		echo "correct";
		$_SESSION['loggedIn']=true;
	}else{
		echo "incorrect";
		$_SESSION['loggedIn']=false;
	}
}

if(!empty($_POST['tab'])){ //fill content of list page
	$tab=$_POST['tab'];
	if($tab=="add") include 'add.php'; //page to add new user in separate file
	elseif($tab=="list"){
		if(empty($_POST['val'])) $data=dbX("SELECT * FROM users"); //if no ordering requested, simply fetch all
		else{
			$val=$_POST['val'];
			if($_POST['order']==1) $order="ASC"; //if a value is specified, search also by order
			else $order="DESC";
			$data=dbX("SELECT * FROM users ORDER BY $val $order");
		}
		if($data==false) echo "<div class='message'>There are currently no registered users!</div>";
		else{
			//header row
			echo '
				<div id="userH" class="userDetailsH">
					<div id="nameH" class="fullNameH userDetail">Full Name<br />
					<span style="font-weight:normal;font-size:0.6em;">(click to expand)</span></div>
					<div class="detsH">
						<div id="timeH" class="timeH userDetail" onclick="sortList(\'regTime\');">Timestamp<span id="so0" class="so"></span></div>
						<div id="fnameH" class="fNameH userDetail" onclick="sortList(\'firstName\');">First Name<span id="so1" class="so"></span></div>
						<div id="lnameH" class="lNameH userDetail" onclick="sortList(\'lastName\');">Last Name<span id="so2" class="so"></span></div>
						<div id="usernameH" class="usernameH userDetail" onclick="sortList(\'username\');">Username<span id="so3" class="so"></span></div>
						<div id="emailH" class="emailH userDetail" onclick="sortList(\'email\');">Email<span id="so4" class="so"></span></div>
						<div id="userTypeH" class="userTypeH userDetail" onclick="sortList(\'type\');">User Type<span id="so5" class="so"></span></div>
						<div id="enabledH" class="enabledH userDetail" onclick="sortList(\'enabled\');">Enabled<span id="so6" class="so"></span></div>
					</div>
					<div class="clearFix"></div>
				</div>';

			//list users
			for($i=0;$i<count($data);$i++){
				if($i%2==0)$even=" even";
				else $even="";
				echo '
				<div id="user'.$i.'" class="userDetails'.$even.'">
					<div id="name'.$i.'" class="fullName userDetail" onclick="showUser('.$i.');">'.$data[$i]['firstName']." ".$data[$i]['lastName'].'</div>
					<div class="dets" id="dets'.$i.'">
						<div id="timestamp'.$i.'" class="timestamp userDetail">'.$data[$i]['regTime'].'</div>
						<div id="fname'.$i.'" class="fName userDetail">'.$data[$i]['firstName'].'</div>
						<div id="lname'.$i.'" class="lName userDetail">'.$data[$i]['lastName'].'</div>
						<div id="username'.$i.'" class="username userDetail">'.$data[$i]['username'].'</div>
						<div id="email'.$i.'" class="email userDetail">'.$data[$i]['email'].'</div>
						<div id="userType'.$i.'" class="userType userDetail">'.$data[$i]['type'].'</div>
						<div id="enabled'.$i.'" class="enabled userDetail">'.$data[$i]['enabled'].'</div>
					</div>
					<div class="clearFix"></div>
				</div>';
			}

		}
	}
}

if(!empty($_POST['username'])){ //adding a new user
	$ret=@dbX("SELECT * FROM users WHERE username='".trim($_POST['username'])."'");
	if(count($ret)>0) echo "usernameTaken"; //flag error if username exists
	else{
		$now=date('Y-m-d H:i:s');
		$username=mysqli_real_escape_string(dbConn(),$_POST['username']);
		$firstName=mysqli_real_escape_string(dbConn(),$_POST['firstName']);
		$lastName=mysqli_real_escape_string(dbConn(),$_POST['lastName']);
		$email=mysqli_real_escape_string(dbConn(),$_POST['email']);
		$userType=mysqli_real_escape_string(dbConn(),$_POST['userType']);
		$enabled=mysqli_real_escape_string(dbConn(),$_POST['enabled']);
		//add to DB 

		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			dbQuery(dbConn(),"INSERT INTO users (regTime,username,firstName,lastName,email,type,enabled) VALUES ('$now','$username','$firstName','$lastName','$email','$userType','$enabled')");
			if(mysqli_affected_rows($GLOBALS['conn'])>0) echo 'success';
			else echo 'error';
		}else{
			echo 'invalidEmail';
		}
	}
}
?>