<?php

require_once './listn.header.php';
require_once '../_objects/class.mailbox.msg.php';

/*
 * @TODO Comment and the "outbox" delete and display functions.
 */

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$submitType = intval($_POST['submitType']);

	if($submitType == 0){//prints the users inbox

		$offset = intval($_POST['offset']);
		$user_id = intval($_POST['user_id']);

		$instance = mail_msg::print_inbox($user_id, $offset);

		echo json_encode(setData($instance,0));

	}else if($submitType == 5){//prints the users outbox

		$offset = intval($_POST['offset']);
		$user_id = intval($_POST['user_id']);

		$instance = mail_msg::print_outbox($user_id, $offset);

		echo json_encode(setData($instance,1));

	}else if($submitType == 1){//delete a message
		$id = intval($_POST['id']);

		$result = mail_msg::unmessage($id);

		if($result){
			fail("Successfully Deleted");
		}else{
			fail("Error");
		}

	}else if($submitType == 2){//sets a message as read

		$id = intval($_POST['id']);

		mail_msg::read_msg($id);

	}else if($submitType == 3){//returns the message count for inbox
		$user_id = intval($_POST['user_id']);

		$sql = "SELECT COUNT(*) FROM user_mail_messages WHERE `to_id` = '$user_id'";
		$result = @DB::sql_fetch(DB::sql($sql));

		echo intval(($result['COUNT(*)']));

	}else if($submitType == 4){//returns message count for outboxs
		$user_id = intval($_POST['user_id']);

		$sql = "SELECT COUNT(*) FROM user_mail_messages WHERE `author_id` = '$user_id'";
		$result = @DB::sql_fetch(DB::sql($sql));

		echo intval(($result['COUNT(*)']));
	}
}

function setData($instance,$mode){
	$data = array(0,1,2,3,4,5,6,7,8);

	$data[0] = $instance->id;
	$data[1] = $instance->state;
	$data[2] = $instance->avatar;
	$data[3] = $instance->to_username;
	$data[4] = $instance->message_subject;
	$data[5] = $instance->time;
	$data[6] = $instance->message_text;
	$data[7] = $instance->to_id;

	if($mode == 1){
		$data[8] = $instance->author_username;
	}else{
		$data[8] = $data[3];
	}

	return $data;
}

?>

