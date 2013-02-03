<?php $login_required = true;

	include("_header.php");
	include_once "functions/getUser.php";
	include_once "functions/mail.php";
	define('THIS_PAGE', "inbox-mi");

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos</title>

<link href="./css/popup.css" rel="stylesheet" type="text/css"/>
<link href="./css/inbox.css" rel="stylesheet" type="text/css"/>
<link href="./css/profile.css" rel="stylesheet" type="text/css"/>
<link href="./css/menu.css" rel="stylesheet" type="text/css"/>

<link href='http://fonts.googleapis.com/css?family=Crimson+Text' rel='stylesheet' type='text/css'>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>

</head>

<body>
<?php include "includes/menu.php"; ?>

<div id="body-con">
	<div class="mail-con mail-top">
		<div class="inbox-top-item"><b>Inbox:</b></div> <div class="inbox-top-item"><b>0</b> Messages Total</div> <div class="inbox-top-item"><b>0</b> Unread Messages</div> <div class="inbox-top-item"><b>100</b> Message Space Left</div>
	</div>
	<?php
		//do menu, and make the "actions" work.
		//also, stats above should work too.
		print_inbox($cuser['id']);
	?>
</div>

<div id="newMsg" class="popup">
	<a onClick="closePops()" class="popupX">x</a>
	<h1>Send A Message</h1>
	<form name="msg" action="settings.php" method="post" onsubmit="xmlhttpPost('./functions/mail.php', 'msg', 'resultAdv', '<img src=\'./images/pleasewait.gif\'>'); return false;">
		<input id="to_id" name="to_id" type="hidden" value="<?php echo $cuser['id']; ?>" />
		<div class="h2">To: <input class="subjectBox" type="text" name="to_u" id="to_u" value="" /></div>
		<div class="h2"><?php echo "<b>From:</b> ".$cuser['username'];?></div>
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
<script src="./js/ui/popup.js"></script>
<script src="./js/ui/ajaxsbmt.js"></script>
<script>
$(document).ready(function(){
	//popup button events
	$("#submit").click(function(){
		this.attr("disabled", true);
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

function closePops(){disablePopup();}
</script>
<script>
$("#<?php echo THIS_PAGE;?>").addClass("selected-mi");
</script>
</html>