<?php
require_once './listn.header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$submitType = intval($_POST['submitType']);

	if($submitType == 0){
		$user_id = intval($_POST['user_id']);

		$sql = "SELECT COUNT(*) FROM user_friends
		WHERE (`accept_id_one` = '$user_id' OR `accept_id_two` = '$user_id') AND (`id_one_status` = '1' AND `id_two_status` = '1') ";
		$result = @DB::sql_fetch(DB::sql($sql));

		echo intval(($result['COUNT(*)']));
	}else if($submitType == 1){

		include_once '../_objects/class.user.php';

		$user_id = intval($_POST['user_id']);
		$offset = intval($_POST['offset']);

		$friend = user::select_true_friend($user_id, $offset);

		echo json_encode(setData($friend));
	}
}

function setData(user $instance){
	$data = array(0,1,2,3);

	$data[0] = $instance->id;
	$data[1] = $instance->avatar;
	$data[2] = $instance->username;
	$data[3] = $instance->getLastLogin();

	return $data;
}

?>