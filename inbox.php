<?php

	define('REQUIRE_LOGIN', true);
	include("__header.php");
	define('THIS_PAGE', "inbox-mi");

	$includejs = false;

	if(isset($_GET['type'])){
		$type = $_GET['type'];
		if($type == "send"){
			$includejs = true;
		}
	}

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
</head>

<body>
<?php include "includes/menu.php"; ?>

<div id="body-con">
	<div class="mail-con mail-top">
		<div class="inbox-top-item"><b>Inbox:</b></div>
		<div class="inbox-top-item"><b><?php echo $cuser->mailbox->total_count; ?></b> Messages Total</div>
		<div class="inbox-top-item"><b><?php echo $cuser->mailbox->unread; ?></b> Unread Messages</div>
		<div class="inbox-top-item"><b><?php echo 100-$cuser->mailbox->total_count; ?></b> Message Space Left</div>
		<div class="inbox-control" id="swap"><b><?php if($includejs){ echo "Inbox";}else{echo"Outbox";}?></b></div>
	</div>
	<div id="mailcon"></div>
</div>

<div id="newMsg" class="popup">
	<a onClick="disablePopup();" class="popupX">x</a>
	<h1>Send A Message</h1>
	<form name="msg" action="settings.php" method="post" onsubmit="xmlhttpPost('./functions/mail.php', 'newMsg', 'resultAdv', null); return false;">
		<input id="to_id" name="to_id" type="hidden" value="" />
		<div class="h2" id="to"></div>
		<div class="h2" id="from"><?php echo "<b>From:</b> ".$cuser->username;?></div>
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
<script>
var thisuserid = <?php echo $cuser->id; ?>;
$("#<?php echo THIS_PAGE;?>").addClass("selected-mi");
var sendinit = <?php if($includejs){ echo "true";}else{echo"false";}?>;
</script>
<script src="./js/inbox.js"></script>
<script src="./js/ui/popup.js"></script>
<script src="./js/ui/ajaxsbmt.js"></script>
</html>