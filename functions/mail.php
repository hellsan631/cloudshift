<?php
	if(!isset($_SESSION)){
		session_start();
		require_once "../includes/database.php";
		$link = db_connect_link();
		require_once "../includes/auth.php";
		include_once "funks.php";
		include_once 'getUser.php';
		global $cuser; $cuser = current_user();
	}

	if(!return_login($cuser)){
		fail("Not Logged In!", $link);
	}

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		if(!isset($_POST['to_id'])){
			fail("Recipient ID not Set", $link);
		}
		if(!isset($_POST['msg_text'])){
			fail("Message is Blank", $link);
		}
		if(!isset($_POST['msg_subject'])){
			fail("Message Subject is Blank", $link);
		}

		$to_id = clean($_POST['to_id']);

		if(!getUserByID($to_id)){
			fail("Invalid Recipient ID", $link);
		}

		$message_text = clean(cleanHTML($_POST['msg_text']));
		$message_subject = clean($_POST['msg_subject']);
		$authoruser = getUserByID(intval($_POST['to_id']));
		$author_username = $authoruser['username'];

		$errors = sendMessage($cuser['id'], $cuser['lastip'], $to_id, $message_subject, $message_text, $author_username);

		if($errors){
			fail("Message Sent!", $link);
		}else{
			fail(mysql_error(), $link);
		}

	}

	function sendMessage($author_id, $author_ip, $to_id, $message_subject, $message_text, $author_username){

		$sql = "INSERT INTO user_mail_messages ( author_id , author_ip , to_id , message_subject, message_text, author_username) VALUES ('$author_id', '$author_ip', '$to_id', '$message_subject', '$message_text', '$author_username')";

		if(!mysql_query($sql)){
			return false;
		}

		return true;

	}

	function print_inbox($user_id, $offset = 0, $totalres = 10){

		$query = "SELECT * FROM user_mail_messages WHERE `to_id` = '$user_id' ORDER BY `message_time` LIMIT $offset, $totalres";

		$result = mysql_query($query);

		if(!$result) {
			fail(mysql_error());
		}

		$totalres =  mysql_num_rows($result);
		$i = 0;

		while($totalres > $i){
			$row = mysql_fetch_array($result);

			$mail['id'] = $row['id'];
			$mail['subject'] = $row['message_subject'];
			$mail['text'] = $row['message_text'];
			$mail['from'] = $row['author_username'];
			$mail['state'] = $row['message_state'];
			$mail['time'] = convertTime($row['message_time']);
			$mail['avatar'] = getUserAvatarByID($row['author_id']);
			if($row['message_state'] == 0){
				$mail['state'] = "unread";
				$mail['idstate'] = 0;
			}else{
				$mail['state'] = "";
				$mail['idstate'] = 1;
			}

			include "templates/tpl-inbox-small.php";
			$i++;
		}

	}

	function convertTime($timestamp){

		$timeElapsed = strtotime($timestamp);

		if(time()-$timeElapsed < 166400){
			$timeElapsed = humanTiming($timeElapsed)." ago";
		}else{
			$timeElapsed = date("M j",$timeElapsed);
		}

		return $timeElapsed;
	}

	function humanTiming ($time)
	{

		$time = time() - $time; // to get the time since that moment

		$tokens = array (
				31536000 => 'y',
				2592000 => 'm',
				604800 => 'w',
				86400 => 'd',
				3600 => 'hr',
				60 => 'min',
				1 => 'sec'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}

	}


	function get_unread_count($user_id = null){
		return 1;
	}

	function fail($failText, $link = null){
		if($link != null){
			mysql_close($link);
		}
		echo $failText;
		exit;
	}

	function cleanHTML($text){
		return htmlspecialchars($text);
	}

?>