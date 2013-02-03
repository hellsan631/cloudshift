<?php
/*
 * This is by no means a secure account protection bypass. 
 * It is in place only to offer a way for users to get their account back from hackers in a alpha-stage build.
 */
	session_start();

	if(isset($_GET['k'])){
		if(isset($_GET['e'])){

			require_once "../includes/database.php";
			$link = db_connect_link();
			require_once "../includes/auth.php";
			include "funks.php";
			
			$email = $_GET['e'];
			$salt = $_GET['k'];
			
			$user_id = valid_salt($email, $salt);
			
			if($user_id){
				
				$salt = md5(microtime());
				$randpw = randPassword($salt);
				$md5pw = md5($salt . $randpw);
				
				$query = "UPDATE users SET `email` = '$email', `salt` = '$salt', `password` = '$md5pw' WHERE `id` ='$user_id'";
				
				$result = mysql_query($query);
				
				if(!$result){fail(mysql_error(),$link);}
				
				$subject = "User Protection";
				$message = "You have declared that your account information was changed without your permission. <br/>
				By clicking on the link provided to you, you have authorized us to reset your account.<br/>
				<br/>
				Email: ".$email."<br/>
				New Password: ".$randpw."<br/>
				<br/>
				Once logged in you can change your password<br/>
				<br/>
				Thanks!<br/>
				Site admin<br/>
				<br/>
				This is an automated response, please do not reply!";
				
				if(mail($email, $subject, $message, "From: Project Logos<admin@projectlogos.com>")){
					fail("Successfully Sent the Email",$link);
				}else{
					fail($message,$link);
				}
			}
			
		}else{fail("no email identifier");}
	}else{fail("no key");}
	
	function fail($failText, $link = null){
		echo $failText;
		
		if($link != null){
			mysql_close($link);
		}
		
		exit;
	}
	
	function randPassword($salt) {
		$i = 0;
		$pass = "";
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($salt, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
	
		return $pass;
	}
?>