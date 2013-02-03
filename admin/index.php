<?php

	include "./__header.php";

	if($cuser->userlevel != 0){
		header("Location: ./profile.php");
	}else if(!isset($_SESSION['auth'])){
		header("Location: ../admin.php");
	}

	define("PAGE_TITLE","Admin Area");

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo PAGE_TITLE; ?></title>

<link href="../css/popup.css" rel="stylesheet" type="text/css"/>
<link href="../css/admin.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="bodycon">
	<div id="adminmenu">
		<div class="mi sel"><a href="#">GAME MANAGER</a></div>
		<div class="mi"><a href="#">PAGELINK</a></div>
		<div class="mi"><a href="#">PAGELINK</a></div>
		<div class="mi"><a href="#">PAGELINK</a></div>
		<div class="mi"><a href="#">PAGELINK</a></div>
	</div>

	<div id="content">
		<ul id="actionmenu">
			<li>
				<a href="#" id="addgame" class="actionbutton">
					<span>
					<img src="../images/adm/addgame.png" />
					<br/>
					Add Game
					</span>
				</a>
			</li>
			<li>
				<a href="#" class="actionbutton">
					<span>
					<img src="../images/adm/defico.png" />
					<br/>
					Create New
					</span>
				</a>
			</li>
			<li>
				<a href="#" class="actionbutton">
					<span>
					<img src="../images/adm/defico.png" />
					<br/>
					Create New
					</span>
				</a>
			</li>
		</ul>

	</div>
</div>

<div id="newGame" class="popup">
	<a onClick="closePops()" class="popupX">x</a>
	<h1>Add Game</h1>
		<form name="game" action="index.php" method="post" onsubmit="xmlhttpPost('../_listeners/listn.admin.php', 'game', 'resultgame', null); return false;">
			<input id="submitType" name="submitType" type="hidden" value="0" />
			<div class="notice">Title:</div>
	        <input class="subjectBox" type="text" name="msg_title" id="msg_title" value="" />
	        <div class="spacer"></div>
	        <div class="notice">Banner URL:</div>
	        <input class="subjectBox" type="text" name="msg_banner_url" id="msg_banner_url" value="" />
	        <div class="spacer"></div>
	        <div class="notice">Background Image URL:</div>
	        <input class="subjectBox" type="text" name="msg_bg_url" id="msg_bg_url" value="" />
	        <div class="spacer"></div>
	        <div class="notice">API Name:</div>
	        <input class="subjectBox" type="text" name="msg_api" id="msg_api" value="" />
	        <div class="spacer"></div>
	        <div class="notice">Level:</div>
	        <input class="subjectBox" type="text" name="msg_level" id="msg_level" value="0" />
	        <div class="spacer"></div>
	        <div class="notice">Info/Description:</div>
	        <textarea class="textBox" name="msg_text" id="msg_text"></textarea>
	        <div class="spacer"></div>
	        <div class="spacer"></div>
	        <br />
	        <div id="resultgame" class="ajaxresult"></div>
	        <input id="submit" class="submit" type="submit" value="Submit" />
        </form>
</div>

<div id="backgroundPopup"></div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
<script src="../js/ui/popup.js"></script>
<script src="../js/ui/ajaxsbmt.js"></script>
<script>
$(document).ready(function(){

	$("#addgame").click(function(){
		//centering with css
		selectedPopup = "#newGame";
		loadPopupSize("500", "auto");
		centerPopup();
	});
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});

});

function closePops(){
	disablePopup();
}
</script>

</html>