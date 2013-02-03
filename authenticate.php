<?php
session_start();
require_once "includes/database.php";
db_connect();
require_once "includes/auth.php";

include "functions/funks.php";
include "functions/getUser.php";

/*
 * Authenticate.php
 * 
 * Back-end php file for use with Login.php
 * 
 * Todo:
 * Fix some error codes so that they dump mysql errors instead of just a redirect.
 * More Secure using the Sha256 algorithem. ex: $hash = hash('sha256', $pass1);
 * Bug Fixes when they appear
 * Load balancing to minimize DB calls during regestration and user login
 * Admin options for various things.
 * Clean should? also htmlspecialcharacters? -> more secure?
 * Login.php should someday be ajax, ?but might be less secure in doing so?
 * Close all mysql db connections early
 */

/*
 * First IF "Catch" Statement for checking to see the user has exceeded the max number of logins.
 */

if(isset($_SESSION['trycount']) && $_SESSION['trycount'] > 6){ //if the trycount of the session is set and exceeds 6
	if(!isset($_SESSION['date'])){ //if the session time (known as date) is not set, begin the count down
		$_SESSION['date'] = time();
		header("Location: login.php?error=15");
		exit;
	}elseif(getWait($_SESSION['date'], "5") == "cunt"){ //if the countdown is reached, as denoted by the word "cunt". 
		unset($_SESSION['trycount']); //Other instances of true and false returns for getWait() did not work
		unset($_SESSION['date']);
	}else{
		header("Location: login.php?error=15"); //if the time is set and has not expired, then boom.
		exit;
	}
}

//submitType tells what kind of form login.php is using. Forget password, signup, and login (normal login and first time login to varify things)
$submitType = $_POST['submitType'];

if($submitType == 0){ //this is the login type.
	
	$user_id = credentials_valid($_POST['email'], $_POST['pass']); //auth.php checks to see if the user has logged in with a correct password
	
	if($user_id){
		
		$user = getUserByEmail(clean($_POST['email'])); //then select user by email. Note, this can be shortened and queryies minimized
		
		//user_id should just return the user - minimizes queries
		//can be optmized by combining some code and shortened
		
		if($user){
			if($user['userlevel'] > -1){
				
				if(log_in($user_id)){
				
					if(isset($_SESSION['trycount'])){
						unset($_SESSION['trycount']);
					}
					
					if(isset($_SESSION['date'])){
						unset($_SESSION['date']);
					}
					
					if($_SESSION['redirect_to']){
						header("Location: " . $_SESSION['redirect_to']);
						unset($_SESSION['redirect_to']);
					
					}else{
						header("Location: ./profile.php"); //customized maybe? to select default login->page
					}
					
				}else{
					header("Location: login.php?error=1"); //password is bad
				}
				
			}elseif($user['userlevel'] == -1){
				
				if(isset($_POST['key'])){
					if($user['salt'] == $_POST['key']){
						
						if(log_in($user_id)){
						
							header("Location: login.php");//logs into the user and sends them to update their username
							
						}else{
							header("Location: login.php?error=2");//could not login
						}
						
					}else{
						header("Location: login.php?error=3"); //key is not valid
					}
				}else{
					header("Location: login.php?error=4"); //key should be set
				}
			}//endif userlevel
		}
	 
	}else{//if its not valid, increase try count and throw error
		
		if(isset($_SESSION['trycount'])){ 
			$_SESSION['trycount'] += 1;
			header("Location: login.php?error=14");//this error is forget password error
			exit;
		}else{
			$_SESSION['trycount'] = 1;
			header("Location: login.php?error=10");
			exit;
		}
		
	}
}elseif ($submitType == 1){//if the submit is to signup
	$user = $_POST;
	
	$user = cleanUser($user); //cleans user
	$errors = infoError($user); //checks for errors in user data
	
	// If no validation errors
	if(0 == count($errors)){
	
		//get username and password
		$email = $user['email'];
		$pass = $user['pass'];
		
		//generate a salt with microtime and password
		$salt = md5(microtime() . $pass);
		
		// Generate password from salt
		$password = md5($salt . $pass);
		
		$query = "INSERT INTO `users` ( `email`,  `salt`,  `password`, `userlevel`) VALUES ('$email', '$salt', '$password', '-1')";
		
		$result = mysql_query($query);
		
		//should be query or die
		if(mysql_errno() === 0){
			
			$subject = "Thanks for Registering!";
			
			$message = "You've regestered for an account at Logos
	
			Click this activation link and then login. After login, you will be prompted to create your username.
			
			http://hellsan631.dyndns.tv:8080/Logos/login.php?key=".$salt."
			 
			Thanks!
			Site admin
			 
			This is an automated response, please do not reply!";
			
			if(mail($email, $subject, $message, "From: Project Logos<admin@projectlogos.com>")){
				header("Location: login.php?error=13");//sent the email, back to login page
			}else{
				header("Location: login.php?error=5");//failed to send email, email server down
			}
			
		}else{
			header("Location: login.php?error=6");//query did not work
		}
	}else{
		header("Location: login.php?error=7");//there was an error with user information
	}
}elseif ($submitType == 2){//creation of a username, sent here by auth.php after login
	
	$username = clean($_POST['username']);
	
	if(0 === preg_match("/\S+/", $username)){
		$errors['uname'] = "Please enter a username."; //if the username is blank
	}
	if(strlen($username) < 3 || strlen($username) > 25){
		header("Location: login.php?error=17"); //if the username isn't the desired length
		exit;
	}
	
	if(count($errors) == 0){ //if there are no errors
		$cuser = current_user();
		$id = $cuser['id'];
		$userlevel = 5; //default user level, should be changable in admin page
		
		$query = "UPDATE `users`
		SET `username` = '$username', `userlevel` = '$userlevel'
		WHERE `id` = '$id'";
		
		$result = mysql_query($query); //mysql or die(mysql_error)
		
		if(mysql_errno() === 0){
			header("Location: ./profile.php");//go to profile
		}else{
			unset($_SESSION['user_id']);
			header("Location: login.php?error=8");//if there was an error with mysql, unset userid
		}
	}else{
		unset($_SESSION['user_id']); //unset userid to login again. This should not have to happen (but it does to display the error)
		header("Location: login.php?error=9");
		
	}
}elseif ($submitType == 3){//forgot password
	
	$email = clean($_POST['email']);
	
	$query = "SELECT `salt`, `password`
	FROM `users`
	WHERE `email` = '$email' ";
	
	$result = mysql_query($query) or die(mysql_error());//might throw error early
	$exist = mysql_num_rows($result);
	
	if($exist == 0){
		header("Location: login.php?error=11");//email doesn't exist
	}
	
	$user = mysql_fetch_array($result);
	
	$salt = $user['salt'];
	$randpw = randPassword($user['salt']);
	$md5pw = md5($salt . $randpw);//generate new userpassword from salt
	
	$query = "UPDATE users SET `password` = '$md5pw' WHERE `email` ='$email'";
	$result = mysql_query($query) or die(mysql_error());
	
	$subject = "Forgot Password for Project Logos";
	$message = "Hi, we have reset your password.
	
	New Password:".$randpw."
	
	Once logged in you can change your password
	
	Thanks!
	Site admin
	
	This is an automated response, please do not reply!";
	
	if(mail($email, $subject, $message, "From: Project Logos<admin@projectlogos.com>")){
		header("Location: login.php?error=13");//sent the email
	}else{
		echo $message;
	}
}

/*
 * Helper Functions
 */

function infoError($user){
	$errors = array();

	if(filter_var($user['email'], FILTER_VALIDATE_EMAIL) == false){
		$errors['email'] = "The Email is invalid";
	}

	// Check password is valid
	if(0 === preg_match("/.{6,}/", $user['pass'])){
		$errors['pass'] = "The password entered was invalid";
	}

	// Check password confirmation_matches
	if(0 !== strcmp($user['pass'], $user['cpass'])){
		$errors['cpass'] = "Passwords do not match";
	}

	return $errors;
}

function cleanUser($user){ //cleans the user data, protecting from mysql escape strings.
	if(isset($user['email'])){
		$user['email'] = clean($user['email']);
	}
	if(isset($user['pass'])){
		$user['pass'] = clean($user['pass']);
	}
	if(isset($user['cpass'])){
		$user['cpass'] = clean($user['cpass']);
	}
	
	return $user;
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
