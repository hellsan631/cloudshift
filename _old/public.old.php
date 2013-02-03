<?php include("_header.php"); ?>
<?php
	if(isset($_GET['i'])){
		include "functions/getUser.php";
		$suser = $cuser;
		$cuser = getUserByID(clean($_GET['i']));

		$self = false;

		if(!$cuser){
			header("Location: profile.php");
		}
	}

	define('THIS_PAGE', "profile-mi");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos</title>

<link href="./css/popup.css" rel="stylesheet" type="text/css"/>
<link href="./css/profile.css" rel="stylesheet" type="text/css"/>
<link href="./css/menu.css" rel="stylesheet" type="text/css"/>

<link href='http://fonts.googleapis.com/css?family=Crimson+Text' rel='stylesheet' type='text/css'>

</head>

<body>
<?php include "includes/menu.php"; ?>
<div id="body-con">
	<div id="main-one">
    	<div id="prof-img-con"><img id="prof-img" src="<?php echo $cuser['avatar']; ?>" /></div>
        <div id="main-cont">
        	<div id="content">
                <h1><?php if(!$self){echo "<a href=\"#\" id=\"makeMsg\">".$cuser['username']."</a>";}else{echo $cuser['username'];} ?></h1>
                <h3>Joined 1 month ago / <b>Milwaukee, WI</b></h3>
                <p>I was born in space. First human to ever be born on a space ship. Yep, that's me. People thought it was amazing for a little while. But for the most part, I can't remember anyone outside my own family saying much about the fact.</p>
            </div>
            <?php if($self):?><div id="settings"><a href="settings.php" id="settings-button">Settings</a></div><?php endif ?>
        </div>
    </div>

    <div id="mid">
        <div id="games-con">
            <h1>Top Games</h1>
            <div class="gamesitem-con left">
                <div class="games-item"><img src="./images/sc2.jpg" /></div>
            </div>
            <div class="gamesitem-con right">
                <div class="games-item"><img src="./images/lol.jpg" /></div>
            </div>
        </div>
        <div id="recent-activity-con">
        	<h2>Recent Activity</h2>
        	<div class="recent-item top">
            	<div class="pIcon-con"><img class="pIcon" src="./images/pgfuzz.jpg" /></div>
                <div id="pName" class="act-content"><h3>DriverDan</h3></div>
                <div class="act-content">Added <b>Starcraft 2</b> to their profile</div>
            </div>
            <hr />
            <div class="recent-item">
            	<div class="pIcon-con"><img class="pIcon" src="./images/profile.png" /></div>
                <div id="pName" class="act-content"><h3>SmilesDaFace</h3></div>
                <div class="act-content">Commented on <b>DriverDan</b>'s profile</div>
            </div>
            <hr />
            <div class="recent-item">
            	<div class="pIcon-con"><img class="pIcon" src="./images/profile.png" /></div>
                <div id="pName" class="act-content"><h3>SmilesDaFace</h3></div>
                <div class="act-content">Joined a <b>Starcraft 2</b> tournament</div>
            </div>
            <hr />
            <div class="recent-item">
            	<div class="pIcon-con"><img class="pIcon" src="./images/pgfuzz.jpg" /></div>
                <div id="pName" class="act-content"><h3>DriverDan</h3></div>
                <div class="act-content">Added <b>League of Legends</b> to their profile</div>
            </div>
            <hr />
            <div class="recent-item">
            	<div class="pIcon-con"><img class="pIcon" src="./images/profile.png" /></div>
                <div id="pName" class="act-content"><h3>SmilesDaFace</h3></div>
                <div class="act-content">Commented on <b>DriverDan</b>'s profile</div>
            </div>
            <hr />
            <div class="recent-item">
            	<div class="pIcon-con"><img class="pIcon" src="./images/pgfuzz.jpg" /></div>
                <div id="pName" class="act-content"><h3>DriverDan</h3></div>
                <div class="act-content">Added <b>League of Legends</b> to their profile</div>
            </div>
            <hr />
            <div class="recent-item">
            	<div class="pIcon-con"><img class="pIcon" src="./images/pgfuzz.jpg" /></div>
                <div id="pName" class="act-content"><h3>DriverDan</h3></div>
                <div class="act-content">Added <b>League of Legends</b> to their profile</div>
            </div>
            <hr />
            <div class="recent-item">
            	<div class="pIcon-con"><img class="pIcon" src="./images/profile.png" /></div>
                <div id="pName" class="act-content"><h3>SmilesDaFace</h3></div>
                <div class="act-content">Commented on <b>DriverDan</b>'s profile</div>
            </div>
        </div>
    </div>
</div>

<div id="newMsg" class="popup">
	<a onClick="closePops()" class="popupX">x</a>
	<h1>Send A Message</h1>
	<form name="msg" action="settings.php" method="post" onsubmit="xmlhttpPost('./functions/mail.php', 'msg', 'resultAdv', '<img src=\'./images/pleasewait.gif\'>'); return false;">
		<input id="to_id" name="to_id" type="hidden" value="<?php echo $cuser['id']; ?>" />
		<div class="h2"><?php echo "<b>To:</b> ".$cuser['username'];?></div>
		<div class="h2"><?php echo "<b>From:</b> ".$suser['username'];?></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="notice">Subject:</div>
        <input class="subjectBox" type="text" name="msg_subject" id="msg_subject" value="please enter a subject" />
        <div class="spacer"></div>
        <div class="spacer"></div>
        <div class="notice">Message:</div>
        <textarea class="textBox" name="msg_text" id="msg_text"></textarea>
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
	$("#submit").click(function(){
		$("#submit").attr("disabled", true);
	;
	});
	$("#makeMsg").click(function(){
		//centering with css
		selectedPopup = "#newMsg";
		centerPopup();
		//load popup
		loadPopupSize("500", "545");
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
<script>
$("#<?php echo THIS_PAGE;?>").addClass("selected-mi");
</script>
</html>