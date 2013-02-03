<?php

require_once './listn.header.php';
require_once '../_objects/class.user.php';
require_once '../_objects/class.mailbox.msg.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(!isset($_POST['to_id'])){
		fail("Recipient ID not Set");
	}

	if(!isset($_POST['msg_text'])){
		fail("Message is Blank");
	}

	if(!isset($_POST['msg_subject'])){
		fail("Message Subject is Blank");
	}

	$to_user = user::load_id(intval($_POST['to_id']));

	if(!$to_user){
		fail("Invalid Recipient ID");
	}

	$from_user = user::load_current();

	$subject =  shine($_POST['msg_subject']);
	$text =  shine($_POST['msg_text']);

	if(mail_msg::send_message($to_user, $from_user, $subject, $text)){
		fail("Message Sent!");
	}else{
		fail("Error Sending Message");
	}

}

?>