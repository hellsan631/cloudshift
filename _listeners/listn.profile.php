<?php

require './listn.header.php';
require '../_objects/class.user.php';
require '../_objects/class.mailbox.msg.php';
require '../_objects/class.user.comments.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$submitType = intval($_POST['submitType']);

	if($submitType == 0){
		$user_id = intval($_POST['user_id']);
		$cuser = user::load_current();

		if($cuser->id == $user_id){
			fail("You cannot friend youself");
		}else{
			$friend = user::load_id($user_id);
			if($cuser->sendRequest($friend)){
				fail("Friend Request Sent Successfully");
			}else{
				fail("Error Sending Friend Request");
			}
		}
	}else if($submitType == 1){
		$to_id = user::load_id(intval($_POST['user_id']));
		$cuser = user::load_current();
		$text = clean($_POST['text']);
		$data = array(0,1,2);

		if(comment::write_new_comment($cuser->id, $to_id->id, $text)){
			$data[0] = 1;
			$data[1] = "Comment Posted";
			$data[2] = $to_id->username;

			echo json_encode($data);
		}else{
			$data[0] = 0;
			$data[1] = "Failed to Post Comment";

			echo json_encode($data);
		}

	}

}