<?php
$login_required = true;
$title = "User Settings";
require_once "_header.php";

function fname($cuser){

	if(!isset($cuser['fname'])){
		echo "First Name";
	}else{
		echo $cuser['fname'];
	}

}

function lname($cuser){

	if(!isset($cuser['fname'])){
		echo "Last Name";
	}else{
		echo $cuser['lname'];
	}

}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos - <?php echo $title; ?> - Social Gaming</title>

<link href="./css/popup.css" rel="stylesheet" type="text/css"/>
<link href="./css/menu.css" rel="stylesheet" type="text/css"/>
<link href="./css/settings.css" rel="stylesheet" type="text/css" />

</head>

<body>
<?php include "includes/menu.php"; ?>

<div id="bodycon">
    <div id="page-con">
    	<div id="settings-menu-con" class="left">
    		<div class="title">
    			Account Settings
    		</div>
    		<div class="item-menu selected">
    			Overview
    		</div>
    		<div class="item-menu">
    			Sharing
    		</div>
    		<div class="item-menu">
    			Privacy
    		</div>
    		<div class="item-menu">
    			Email
    		</div>
    		<div class="oops"></div>
    		<div class="title bottom">
    			Team Settings
    		</div>
    		<div class="item-menu">
    			Overview
    		</div>
    		<div class="item-menu">
    			Sharing
    		</div>
    		<div class="item-menu">
    			Privacy
    		</div>
    	</div>
    	<div id="settings-con" class="right">
    		<div id="settings-header">
	    		<h2>Overview</h2>
    		</div>
    		<hr />
    		<div id="settings-options">
    			<h3>Account Information</h3>
    			<div class="setCon">
    				<div class="setTitle left">
    					Identity
    				</div>
    				<div class="setInfo right">
    					<div id="username" class="setNormal"><a href="#"><?php echo $cuser['username']; ?></a></div>
    					<div id="realname" class="setNormal"><?php echo $cuser['fname']; ?> <?php echo $cuser['lname']; ?></div>
    					<div id="email" class="setNormal"><b><?php echo $cuser['email']; ?></b></div>
    					<a href="#" id="advanced" class="setSmallLink">advanced</a>
    				</div>
    			</div>
    			<div class="setCon">
    				<div class="setTitle left">
    					Avatar/Background Image
    				</div>
    				<div class="setInfo right">
    					<div id="picture" class="setNormal"><img class="smallImg" src="<?php echo $cuser['avatar']; ?>" /></div>
    					<br/>
    					<div id="bgpicture" class="setNormal"><img class="bgImg" src="<?php echo $cuser['background']; ?>" /></div>
    					<a href="#" id="changeAva" class="setSmallLink">Change</a>
    				</div>
    			</div>
    			<div class="setCon">
    				<div class="setTitle left">
    					Password
    				</div>
    				<div class="setInfo right">
    					<div id="username" class="setNormal"><a href="#" id="changepass">Change Password</a></div>
    					<div class="setSmall">You will need to confirm your current password</div>
    				</div>
    			</div>
    			<?php if(isset($_SESSION['error'])):?>
    			<div class="setCon">
    				<div class="setTitle left">
    					Error:
    				</div>
    				<div class="setInfo right">
    					<?php echo $_SESSION['error']; unset($_SESSION['error']);?>
    				</div>
    			</div>
    			<?php endif ?>
    		</div>
    	</div>

    </div>
</div>

<div id="popupCP" class="popup">
	<a onClick="closePops()" class="popupX">x</a>
	<h1>Change Password</h1>
	<br />
		<form name="cp" action="settings.php" method="post" onsubmit="xmlhttpPost('./functions/func_user.php', 'cp', 'resultCP', null); return false;">
			<input id="submitType" name="submitType" type="hidden" value="0" />
	        <input class="passBox" type="text" name="oldPass" id="oldPass" value="Old Password" />
	        <input class="passBox" type="text" name="newPass" id="newPass" value="New Password" />
	        <input class="passBox" type="text" name="conPass" id="conPass" value="Confirm Password" />
	        <div class="spacer"></div>
	        <div id="resultCP" class="ajaxresult"></div>
	        <input id="submit" class="submit" type="submit" value="Submit" />
        </form>
</div>

<div id="popupAva" class="popup">
	<a onClick="closePops()" class="popupX">x</a>
	<h1>Avatar</h1>
	<br />
		<form name="ava" enctype="multipart/form-data" method="post" action="./functions/func_user.php">
			<input id="submitType" name="submitType" type="hidden" value="2" />
	        <p style="font-weight:bold">Avatar: <input type="file" name="userfile"/></p>
	        <div class="spacer"></div>

	        <div id="resultAva" class="ajaxresult"></div>
	        <input id="submit" class="submit" type="submit" value="Submit" >
        </form>
</div>

<div id="popupAdv" class="popup">
	<a onClick="closePops()" class="popupX">x</a>
	<h1>Advanced Menu</h1>
	<br />
		<form name="adv" action="settings.php" method="post" onsubmit="xmlhttpPost('./functions/func_user.php', 'adv', 'resultAdv', null); return false;">
			<input id="submitType" name="submitType" type="hidden" value="1" />
			<div class="notice">If you want to change anything, <br/>Please enter your current password</div>
	        <input class="passBox" type="text" name="oldPassC" id="oldPassC" value="Current Password" />
	        <div class="spacer"></div>
	        <div class="notice">Real Name</div>
	        <input class="passBox" type="text" name="fname" id="fname" value="<?php fname($cuser); ?>" />
	        <input class="passBox" type="text" name="lname" id="lname" value="<?php lname($cuser); ?>" />
	        <div class="spacer"></div>
	        <div class="notice">Username</div>
	        <input class="passBox" type="text" name="username" id="username" value="<?php echo $cuser['username'];?>" />
	        <div class="spacer"></div>
	        <div class="notice">Email</div>
	        <input class="passBox" type="text" name="email" id="email" value="<?php echo $cuser['email'];?>" />
	        <div class="spacer"></div>
	        <div id="resultAdv" class="ajaxresult"></div>
	        <input id="submit" class="submit" type="submit" value="Submit" />
        </form>
</div>

<div id="backgroundPopup"></div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
<script src="./js/ui/popup.js"></script>
<script src="./js/ui/ajaxsbmt.js"></script>
<script>
$(document).ready(function(){
	//popup button events

	$("#changepass").click(function(){
		//centering with css
		selectedPopup = "#popupCP";
		centerPopup();
		//load popup
		loadPopupSize("260", "275");
	});
	$("#changeAva").click(function(){
		//centering with css
		selectedPopup = "#popupAva";
		centerPopup();
		//load popup
		loadPopupSize("645", "400");
	});
	$("#advanced").click(function(){
		//centering with css
		selectedPopup = "#popupAdv";
		centerPopup();
		//load popup
		loadPopupSize("260", "445");
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

function closePops(){disablePopup();}

$("#oldPass")
.focus(function() {
      if (this.value === this.defaultValue) {
          this.value = '';
			this.type = 'password';
			$("#oldPass").addClass("hovered");
      }
})
.blur(function() {
      if (this.value === '') {
          this.value = this.defaultValue;
			this.type = 'text';
			$("#oldPass").removeClass("hovered");
      }
});
$("#oldPassC")
.focus(function() {
      if (this.value === this.defaultValue) {
          this.value = '';
			this.type = 'password';
			$("#oldPassC").addClass("hovered");
      }
})
.blur(function() {
      if (this.value === '') {
          this.value = this.defaultValue;
			this.type = 'text';
			$("#oldPassC").removeClass("hovered");
      }
});
$("#newPass")
.focus(function() {
      if (this.value === this.defaultValue) {
          this.value = '';
			this.type = 'password';
			$("#newPass").addClass("hovered");
      }
})
.blur(function() {
      if (this.value === '') {
          this.value = this.defaultValue;
			this.type = 'text';
			$("#newPass").removeClass("hovered");
      }
});
$("#conPass")
.focus(function() {
      if (this.value === this.defaultValue) {
          this.value = '';
			this.type = 'password';
			$("#conPass").addClass("hovered");
      }
})
.blur(function() {
      if (this.value === '') {
          this.value = this.defaultValue;
			this.type = 'text';
			$("#conPass").removeClass("hovered");
      }
});
</script>
</html>