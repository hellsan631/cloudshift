<?php
	session_start();
	require_once "../includes/database.php";
	$link = db_connect_link();
	require_once "../includes/auth.php";
	include "funks.php";
	
	global $cuser; $cuser = current_user();
	$submitType = clean($_POST['submitType']);
	
	if(!return_login($cuser)){
		fail("Not Logged In!", $link);
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if($submitType == 0){ //change password
			
			$oldPass = clean($_POST['oldPass']);
			
			$user_id = credentials_valid($cuser['email'], $oldPass);
			
			if($user_id){
				$newPass = clean($_POST['newPass']);
				$conPass = clean($_POST['conPass']);
				
				if($newPass == $conPass){
					
					if(0 === preg_match("/.{6,}/", $newPass)){fail("Password invalid", $link);}
					
					$email = $cuser['email'];
					$salt = md5(microtime() . $newPass);
					$password = md5($salt . $newPass);
					
					$query = "UPDATE users SET `password` = '$password', `salt` = '$salt' WHERE `id` ='$user_id'";
					$result = mysql_query($query) or die(mysql_error());
					
					$subject = "Account Updated";
					$message = "Your account's password has recently been changed. This is a notification of that change. 
					If you did not authorize this account change, then contact support immidately.
										
					Thanks!
					Site admin
					
					This is an automated response, please do not reply!";
					
					if(mail($email, $subject, $message, "From: Project Logos<admin@projectlogos.com>")){
						fail("Success!", $link);
					}else{
						fail("Email Server not Responding", $link);
					}
					
				}else{fail("Password did not match", $link);}
				
			}else{
				fail("Incorrect Password", $link);
			}		
			
		}elseif($submitType == 1){
			
			$oldPass = clean($_POST['oldPassC']);
			
			$user_id = credentials_valid($cuser['email'], $oldPass);
			
			if($user_id){
				
				$fname = clean($_POST['fname']);
				$lname = clean($_POST['lname']);
				$username = clean($_POST['username']);
				$email = clean($_POST['email']);
				
				$prevEmail = $cuser['email'];
				
				$query = "UPDATE users SET ";
				
				$update = 0;

				if($fname != "First Name"){
					$query = $query."`fname` = '$fname' "; 
					$update++;
				}
				if($lname != "Last Name"){
					if($update == 1){$query = $query.",";}
					$query = $query."`lname` = '$lname' ";
					$update++;
				}
				if($username != $cuser['username'] && $username != ""){
					if($update >= 1){$query = $query.",";}
					$query = $query."`username` = '$username' ";
					$update++;
				}
				if($email != $prevEmail && $email != ""){
					
					if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
						fail("email was invalid", $link);
					}
					
					if($update >= 1){
						$query = $query.",";
					}
					
					$query = $query."`email` = '$email' ";
					$update++;
				}
				
				if($update == 0){
					fail("nothing to update", $link);
				}
				
				$query = $query."WHERE `id` ='$user_id'";
				
				$result = mysql_query($query) or die(fail(mysql_error(), $link));
				
				$subject = "Account Updated";
				$message = "Your account information has recently been updated or changed. This is a notification of that change. 
				If you did not authorize this account change, then contact support immidately.
				
				You may click this link to undo this action.
				http://hellsan631.dyndns.tv:8080/Logos/functions/protect.php?k=".$cuser['salt']."&e=".$prevEmail."
									
				Thanks!
				Site admin
				
				This is an automated response, please do not reply!";
				
				if(mail($prevEmail, $subject, $message, "From: Project Logos<admin@projectlogos.com>")){
					fail("Success!", $link);
				}else{
					fail("Email Server not Responding", $link);
				}	
				
			}else{
				fail("Incorrect Password", $link);
			}
			
		}elseif($submitType == 2){
			
			if(!isset($_FILES['userfile'])) {
				fail("Please select a file", $link, 2);
			}
			else
			{
				try {
					$user_id = $cuser['id'];
					if($user_id){				
						if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {
					        // check the file is less than the maximum file size
					        if($_FILES['userfile']['size'] < 300000){
					        								
								$query = "SELECT * FROM user_images WHERE `user_id` = '$user_id'";
							
								$result = mysql_query($query);
							
								if(!$result) {
									fail(mysql_error(), $link, 2);
								}
								
								$size = getimagesize($_FILES['userfile']['tmp_name']);
								$imgData = addslashes(file_get_contents($_FILES['userfile']['tmp_name']));
							
								if(mysql_num_rows($result) > 0){
									
									$file = mysql_fetch_assoc($result);
									
									$file_url = "./functions/view.php?id=".$file['id'];
									
									$sql = "UPDATE user_images SET `type` = '{$size['mime']}', `data` = '{$imgData}', `size` = '{$size[3]}', `name` = '{$_FILES['userfile']['name']}' WHERE `user_id` ='$user_id'";
									
									if(!mysql_query($sql)){
										fail(mysql_error(), $link, 2);
									}
									
									$sql = "UPDATE users SET `avatar` = '$file_url' WHERE `id` ='$user_id'";
									
									if(!mysql_query($sql)){
										fail(mysql_error(), $link, 2);
									}
									
									fail("<img src=\"".$file_url."\" />", $link, 2);
									
								}else{
									$sql = "INSERT INTO user_images ( type , data , size , name, user_id) VALUES ('{$size['mime']}', '{$imgData}', '{$size[3]}', '{$_FILES['userfile']['name']}', '$user_id')";
									
									if(!mysql_query($sql)){
										fail(mysql_error(), $link, 2);
									}
									
									$file_url = "./functions/view.php?id=".mysql_insert_id();
									
									$sql = "UPDATE users SET `avatar` = '$file_url' WHERE `id` ='$user_id'";
									
									if(!mysql_query($sql)){
										fail(mysql_error(), $link, 2);
									}
									
									fail("<img src=\"".$file_url."\" />", $link, 2);
								}
															
							}else{fail("File too big", $link, 2);}
						}else{fail("Failed to Upload", $link, 2);}
					}else{fail("Not Logged In!", $link, 2);}
					//success
					
				}
				catch(Exception $e) {
					fail($e->getMessage(), $link, 2);
				}
			}
			
		}else{
			fail("Invalid Submit Type", $link);
		}
	}
	
	function fail($failText, $link, $submitType = 0){
		
		if($submitType == 2){
			mysql_close($link);
			
			$_SESSION['error'] = $failText;
			
			header("Location: ../settings.php");
			exit;
		}else{
			mysql_close($link);
			echo $failText;
			exit;
		}
	}
	
?>