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
		if($_POST['submitType'] == 0){
			if($_POST['idstate'] == 0){
				$id = $_POST['id'];
				$sql = "UPDATE user_mail_messages SET `message_state` = '1' WHERE `id` ='$id'";
				
				if(!mysql_query($sql)){
					fail(mysql_error());
				}
				fail("hello");				
			}
		}elseIf($_POST['submitType'] == 1){
			$id = $_POST['id'];
			$sql = "DELETE FROM user_mail_messages WHERE `id` ='$id'";
			
			if(!mysql_query($sql)){
				fail(mysql_error());
			}
			
			fail("Successfully Deleted");
		}
	}
	
	function fail($failText, $link = null){
		if($link != null){
			mysql_close($link);
		}
		echo $failText;
		exit;
	}
	
?>