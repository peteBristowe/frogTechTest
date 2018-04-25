var colour="";
var sortVal="regTime";
var sortOrder=1;

//----------------------------------------------
//--------------login functions-----------------
//----------------------------------------------

//on login page, attempt login on Enter, regardless of selection state
if(g('logInButton')!=false) document.addEventListener("keydown", function(e){ if(e.keyCode==13){ logIn(); } }); 

function changed(id){ //reset login input borders if value!=""
	var element=g(id);
	if(element.value!="") element.style.border="3px solid "+colour;
}

function logIn(){ //attempt login
	var usr=g('usr');
	var pwd=g('pwd');
	
	if(usr!=false && usr.value=="") usr.style.border="3px solid red"; //flag missing field
	if(pwd!=false && pwd.value=="") pwd.style.border="3px solid red";

	if(usr.value!="" && pwd.value!=""){ //if both fields filled, attempt login
		if(window.XMLHttpRequest){ x2 = new XMLHttpRequest();
		}else{ x2 = new ActiveXObject("Microsoft.XMLHTTP"); }
		x2.onreadystatechange = function(){
			if(x2.readyState == 4 && x2.status == 200){
				if(x2.responseText=='incorrect'){
					var button=g('logInButton');
					button.innerHTML="Username or password incorrect.";
					button.style.border="3px solid "+colour;
					button.style.backgroundColor="#ccc";
					button.style.color=colour;
					setTimeout(function(){
						button.innerHTML="Log In";
						button.style.color="#fff";
						button.style.backgroundColor=colour;
					},2500);
				}else{ window.location.replace("index.php"); /*logged in*/ }
			}
		}
		x2.open("POST","api.php", true);
		x2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		x2.send("usr="+usr.value+"&pwd="+pwd.value);
	}
}


//---------------------------------------------
//--------------list functions-----------------
//---------------------------------------------

//on main page, trigger DB call immediately after loading to populate list
if(g('list')!=false) setTimeout(function(){ section('list',sortVal,sortOrder);},1);

function section(tab,val,order){
	if(window.XMLHttpRequest) x=new XMLHttpRequest();
	else x=new ActiveXObject("Microsoft.XMLHTTP");
	x.onreadystatechange = function(){
		if(x.readyState == 4 && x.status == 200){
			g('selected').style.left=g(tab).offsetLeft+"px";
			g('content').innerHTML=x.responseText;

			for(i=0;i<7;i++) g('so'+i).innerHTML="";
			switch(val){
				case "regTime": 
					if(sortOrder>0) g('so0').innerHTML=" (0-9)";
					else g('so0').innerHTML=" (9-0)";
					break;
				case "firstName":
					if(sortOrder>0) g('so1').innerHTML=" (A-Z)";
					else g('so1').innerHTML=" (Z-A)";
					break;
				case "lastName": 
					if(sortOrder>0) g('so2').innerHTML=" (A-Z)";
					else g('so2').innerHTML=" (Z-A)";
					break;
				case "username":
					if(sortOrder>0) g('so3').innerHTML=" (A-Z)";
					else g('so3').innerHTML=" (Z-A)";
					break;
				case "email":
					if(sortOrder>0) g('so4').innerHTML=" (A-Z)";
					else g('so4').innerHTML=" (Z-A)";
					break;
				case "type":
					if(sortOrder>0) g('so5').innerHTML=" (A-Z)";
					else g('so5').innerHTML=" (Z-A)";
					break;
				case "enabled":
					if(sortOrder>0) g('so6').innerHTML=" (0-9)";
					else g('so6').innerHTML=" (9-0)";
					break;
			}
		}
	}
	x.open("POST","api.php", true);
	x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	if(val==undefined) x.send("tab="+tab);
	else x.send("tab="+tab+"&val="+val+"&order="+order);
}


function showUser(id){
	var ele=g('dets'+id);
	if(ele.style.maxHeight!="80px"){
		ele.style.maxHeight="80px";
		ele.style.marginBottom="10px";
		g('user'+id).style.backgroundColor="rgba(128,128,128,0.2)";
		g('name'+id).style.fontWeight="bold";
	}
	else{
		ele.style.maxHeight="0px";
		ele.style.marginBottom="0px";
		g('user'+id).style.backgroundColor="rgba(128,128,128,0)";
		g('name'+id).style.fontWeight="normal";
	}
}


function sortList(val){
	if(val==sortVal) sortOrder*=-1;
	else sortOrder=1;
	sortVal=val;

	section('list',val,sortOrder);
}

//--------------------------------------------
//--------------add functions-----------------
//--------------------------------------------

//on add page, attempt add on Enter, regardless of state
if(g('addButton')!=false) document.addEventListener("keydown", function(e){ if(e.keyCode==13){ addUser(); } }); 

function addUser(){ //attempt adding user
	var username=g('username');
	var firstName=g('fname');
	var lastName=g('lname');
	var email=g('email');
	var userType=g('userType');
	var enabled=g('enabled');
	var en=1;
	var inputTest=0;
	
	if(username.value==""){
		username.style.border="3px solid red"; //flag missing field
		inputTest++;
	}
	if(firstName.value==""){ //using multiple ifs rather than else ifs to flag as many fields as are missing
		firstName.style.border="3px solid red";
	}
	if(lastName.value==""){
		lastName.style.border="3px solid red";
		inputTest++;
	}
	if(email.value==""){
		email.style.border="3px solid red";
		inputTest++;
	}
	if(userType.selectedIndex<2){
		userType.style.border="3px solid red";
		inputTest++;
	}


	if(enabled.checked==true) en=1;
	else en=0;

	if(inputTest==0){ //if all fields filled, attempt registration
		if(window.XMLHttpRequest){ x3 = new XMLHttpRequest();
		}else{ x3 = new ActiveXObject("Microsoft.XMLHTTP"); }
		x3.onreadystatechange = function(){
			if(x3.readyState == 4 && x3.status == 200){
				if(x3.responseText=="usernameTaken"){
					var button=g('addButton');
					g('username').style.border="3px solid red";
					button.innerHTML="Username already taken!";
					button.style.border="3px solid "+colour;
					button.style.backgroundColor="#ccc";
					button.style.color=colour;
					setTimeout(function(){
						button.innerHTML="Add User";
						button.style.color="#fff";
						button.style.backgroundColor=colour;
					},2500);
				}else if(x3.responseText=="invalidEmail"){
					var button=g('addButton');
					button.innerHTML="Sorry, that email address doesn't look right!";
					button.style.border="3px solid "+colour;
					button.style.backgroundColor="#ccc";
					button.style.color=colour;
					email.style.border="3px solid red";
					setTimeout(function(){
						button.innerHTML="Add User";
						button.style.color="#fff";
						button.style.backgroundColor=colour;
					},2500);
				}else if(x3.responseText=="error"){
					var button=g('addButton');
					button.innerHTML="There was an error adding this user.";
					button.style.border="3px solid red";
					button.style.backgroundColor="#ccc";
					button.style.color="red";
					setTimeout(function(){
						button.innerHTML="Add User";
						button.style.color="#fff";
						button.style.backgroundColor=colour;
					},2500);
				}
				else if(x3.responseText=="success"){
					var button=g('addButton');
					username.value="";
					firstName.value="";
					lastName.value="";
					email.value="";
					userType.selectedIndex=0;
					button.innerHTML="User Added!";
					button.style.border="3px solid "+colour;
					button.style.backgroundColor="#ccc";
					button.style.color=colour;
					setTimeout(function(){
						button.innerHTML="Add User";
						button.style.color="#fff";
						button.style.backgroundColor=colour;
					},2500);
				}
			}
		}
		x3.open("POST","api.php", true);
		x3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		x3.send("username="+encodeURIComponent(username.value)+"&firstName="+encodeURIComponent(firstName.value)+"&lastName="+encodeURIComponent(lastName.value)+"&email="+encodeURIComponent(email.value)+"&userType="+encodeURIComponent(userType.value)+"&enabled="+en);		
	}else{
		//if fields incomplete...
		var button=g('addButton');
		button.innerHTML="Please complete all fields.";
		button.style.border="3px solid colour";
		button.style.backgroundColor="#ccc";
		button.style.color=colour;
		setTimeout(function(){
			button.innerHTML="Add User";
			button.style.color="#fff";
			button.style.backgroundColor=colour;
		},2500);
	}
}







//----------------------------------------
//--------------utilities-----------------
//----------------------------------------

setTimeout(bodyHeight,1)
window.onresize=bodyHeight;

function bodyHeight(){
	g('content').style.height=window.innerHeight-102+"px";
}

function g(id){ //shortcut for getting element
	return document.getElementById(id);
}

function setColour(c){
	colour=c;
}