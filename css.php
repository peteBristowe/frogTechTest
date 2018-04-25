<?php
header("Content-type: text/css; charset: UTF-8");
include 'api.php';
?>


body{
	margin:0px;
	background-color:rgb(35,31,32);
	font-family:Helvetica;
	font-size:14px;
	color:#fff;
}

a,a:hover,a:visited{
	color:#fff;
	text-decoration:none;
}

.clearFix{
	clear:both;
}



#logIn{
	width:100vw;
	height:100vh;
	display:table-cell;
	vertical-align:middle;
	text-align:center;
}
input,button,select,option{
	text-align:center;
	outline:none;
	font-size:24px;
	padding:10px;
	margin:10px;
	font-weight:bold;
}
input,select,option{
	background-color:#ccc;
	color:<?=$GLOBALS['colour']?>;
	border:3px solid <?=$GLOBALS['colour']?>;
	border-radius:10px;
}
select{
	width:336px;
}
button{
	background-color:<?=$GLOBALS['colour']?>;
	color:#fff;
	border:3px solid <?=$GLOBALS['colour']?>;
	border-radius:10px;
	padding:10px 20px;
}
input[type=checkbox]{
	-ms-transform: scale(2.5);
	-moz-transform: scale(2.5);
	-webkit-transform: scale(2.5);
	-o-transform: scale(2.5);
	outline:none;
}
.checkboxLabel{
	font-size:24px;
	color:<?=$GLOBALS['colour']?>;
	font-weight:bold;
	padding-top:10px;
}
#frogLogo{
	max-width:80%;
}





#header{
	position:fixed;
	top:0px;
	left:0px;
	z-index:2;
	width:100%;
}
#selected{
	width:33.3%;
	height:100%;
	position:absolute;
	top:0px;
	left:0px;
	background-color:<?=$GLOBALS['colour']?>;
	z-index:-1;
	transition:all 0.7s;
}
.menuItem{
	float:left;
	text-align:center;
	width:33.3%;
	padding:10px 0 5px 0;
	font-weight:bold;
	font-size:28px;
	z-index:1;
}
#content{
	margin-top:47px;
	height:80vh;
	overflow-y:scroll;
	padding:20px;
	background-color:#fff;
	color:#333;
	border-top:15px solid <?=$GLOBALS['colour']?>;
	border-left:10px solid <?=$GLOBALS['colour']?>;
	border-right:10px solid <?=$GLOBALS['colour']?>;
}

.message{
	text-align:center;
	color:<?=$GLOBALS['colour']?>;
	font-size:24px;
	padding-top:40px;
	font-weight:bold;
}


#addUser{
	text-align:center;
}


.userDetailsH{
	width:100%;
	color:#333;
	font-weight:bold;
	padding-bottom:10px;
}
.userDetails{
	width:100%;
	color:#333;
}
.userDetail{
	float:left;
	color:#333;
	font-size:18px;
	text-align:center;
	width:13.6%;
	overflow-wrap:break-word;
}
.fullName,.fullNameH,.dets,.detsH{
width:100%;
}
.even{
	background-color:rgba(128,128,128,0.2);
}
.so{
	font-size:0.75em;
}



@media screen and (min-width:1024px){

.fullName,.fullNameH{
	display:none;
}
.dets,.detsH{
	background-color:rgba(128,128,128,0)!important;
	margin-bottom:0px;
}

}







@media screen and (max-width:1023px){

.dets,.detsH{
	background-color:rgba(128,128,128,0);
	transition:all 0.7s;
	-webkit-transition:all 0.7s;
	-moz-transition:all 0.7s;
	-ms-transition:all 0.7s;
	max-height:0px;
	margin-bottom:0px;
	overflow:hidden;
}
.userDetail{
	width:33.33%;
}
.fullName,.fullNameH{
	width:100%;
}

.even{
	background-color:rgba(128,128,128,0);
}

}