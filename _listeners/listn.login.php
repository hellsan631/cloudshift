<?php
//a replacement for authenticate.php
//echo "Location: ./index.php";

/*
* Authenticate.php
*
* Back-end php file for use with Login.php
*
* Todo:
* More Secure using bcrypt;
* Bug Fixes when they appear
* Finish forgot password, and final auth for user.
* Make the page Responsive to different size-d media
* Combine CSS you jerk
*/

require_once './listn.header.php';
require_once ROOT_PATH.CLASS_PATH.'class.user.php';
require_once ROOT_PATH.CLASS_PATH.'class.security.auth.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_SESSION['trycount']) && $_SESSION['trycount'] > 6){ //if the trycount of the session is set and exceeds 6
		if(!isset($_SESSION['date'])){ //if the session time (known as date) is not set, begin the count down
			$_SESSION['date'] = time();
			e::error('maximum number of trys exceeded');
		}elseif(getWait($_SESSION['date'], "6") == false){ //if the countdown is reached
			unset($_SESSION['trycount']);
			unset($_SESSION['date']);
		}else{e::error('you must wait '.getWait($_SESSION['date'], "5").' min to try again');}
	}

	if(!isset($_POST['submitType'])){
		fail('Submit Type Not Set');
	}

	$submitType = intval($_POST['submitType']);

	if($submitType == 0){

		if(!isset($_POST['email']) || $_POST['email'] == "Email"){fail('please enter your email');}
		if(!isset($_POST['pass']) || $_POST['pass'] == "Password"){fail('please enter a password');}

		$auth = auth::credentials_valid($_POST['email'], $_POST['pass']);

		if($auth){

			$newuser = user::load_id($auth);

			if($newuser->userlevel == -1){
				fail('Check Your Email for Verification Link');
			}

			if(user::log_in(intval($auth))){

				if(isset($_SESSION['trycount'])){unset($_SESSION['trycount']);}

				if(isset($_SESSION['date'])){unset($_SESSION['date']);}

				if(isset($_SESSION['redirect_to'])){
					$location = $_SESSION['redirect_to'];
					unset($_SESSION['redirect_to']);
					echo 'Location: ' . $location;

				}else{
					echo 'Location: ./profile.php'; //customized maybe? to select default login->page
				}

			}else{
				e::error('Login Error');
			}
		}else{

			if(!isset($_SESSION['trycount'])){
				$_SESSION['trycount'] = 0;
			}

			$_SESSION['trycount'] += 1;
			e::error('Invalid Login, '.(6-$_SESSION['trycount']).' tries left');

		}
	}elseif($submitType == 1){

		if(!isset($_POST['username']) || $_POST['username'] == "Username"){fail('please enter a username');}
		if(!isset($_POST['semail']) || $_POST['semail'] == "Email"){fail('please enter your email');}
		if(!isset($_POST['spass']) || $_POST['spass'] == "Password"){fail('please enter a password');}
		if(!isset($_POST['cpass']) || $_POST['cpass'] == "Confirm Password"){fail('please enter a confirm password');}

		$user = $_POST;

		$user = cleanUser($user); //cleans user
		infoError($user); //checks for errors in user data

		//get username and password
		$email = $user['semail'];
		$pass = $user['spass'];

		//generate a salt with microtime and password
		$salt = s::hash(microtime() . $pass);
		$secure = s::hash(microtime().$salt);

		// Generate password from salt
		$password = s::add_salt($pass, $salt);

		$newuser = new user();

		$userdata = array('username' => $user['username'], 'email' => $email, 'password' => $password, 'salt' => $salt, 'userlevel' => -1, 'securekey' => $secure);

		if(!@$newuser->write_new_user($userdata)){
			fail('Failed to Write User');
		}

		$subject = 'Thanks for Registering!';

		$message = "You've regestered for an account at Logos<br /><br />

		Click this activation link and then login.<br /><br />

		http://localhost:8080/Logos/functions/account.php?key=$secure<br /><br />

		Thanks!<br />
		Site admin<br /><br />

		This is an automated response, please do not reply!";

		if(@mail($email, $subject, $message, 'From: Project Logos<admin@projectlogos.com>')){
			fail('Success! Please Check Your Email');//sent the email, back to login page
		}else{
			fail('Failed to Send Email');//failed to send email, email server down
		}

	}elseif($submitType == 2){

		if(!isset($_POST['fpusername']) && !isset($_POST['fpsemail'])){
			fail('please enter your email or username');
		}

		if($_POST['fpusername'] == "Username" && $_POST['fpsemail'] == "Email"){
			fail('please enter your email or username');
		}

		$query = "SELECT `salt`, `password`
		FROM `users`
		WHERE";

		if(isset($_POST['fpusername'])){
			$temp =  clean($_POST['fpusername']);
			$query = $query."`username` = '$temp' ";

		}else if(isset($_POST['fpsemail'])){
			$temp =  clean($_POST['fpsemail']);
			$query = $query."`email` = '$temp' ";
		}

		$result = DB::sql($query);

		$exist = DB::sql_row_count($result);

		if($exist == 0){
			fail("email doesn't exist");
		}

		$user = DB::sql_fetch($result);

		$salt = $user['salt'];
		$randpw = randPassword($salt);
		$password = s::add_salt($randpw, $salt);//generate new userpassword from salt
		$query = "UPDATE users SET `password` = '$password' WHERE";

		if(isset($_POST['fpusername'])){
			$temp =  clean($_POST['fpusername']);
			$query = $query."`username` = '$temp' ";

		}else if(isset($_POST['fpsemail'])){
			$temp =  clean($_POST['fpsemail']);
			$query = $query."`email` = '$temp' ";
		}

		DB::sql($query);

		$subject = "Forgot Password for Project Logos";
		$message = "Hi, we have reset your password.

		New Password: $randpw

		Once logged in you can change your password

		Thanks!
		Site admin

		This is an automated response, please do not reply!";

		if(mail($email, $subject, $message, "From: Project Logos<admin@projectlogos.com>")){
			fail('Password Sent Successfully');
		}else{
			fail('Unable to contact mail server. '.$message);
		}

	}
}

function getWait($date, $minuetsAdded){

	$timeRemaining = strtotime("+".$minuetsAdded." minutes", $date) - time();

	if($timeRemaining < 0){
		return false;
	}else{
		return intval(round($timeRemaining/60));
	}
}

function infoError($user){

	if(filter_var($user['username'], FILTER_SANITIZE_STRING) == false ||  strlen($user['username']) < 5 ){
		fail('Invalid Username');
	}

	if(filter_var($user['semail'], FILTER_VALIDATE_EMAIL) == false){
		fail('Invalid Email');
	}

	// Check password is valid
	if(0 === preg_match("/.{6,}/", $user['spass'])){
		fail('Invalid Password');
	}

	// Check password confirmation_matches
	if(0 !== strcmp($user['spass'], $user['cpass'])){
		fail('Passwords do not match');
	}

}

function cleanUser($user){ //cleans the user data, protecting from mysql escape strings.
	if(isset($user['username'])){
		$user['username'] =  shine($user['username']);
	}
	if(isset($user['semail'])){
		$user['semail'] =  clean($user['semail']);
	}
	if(isset($user['spass'])){
		$user['spass'] =  shine($user['spass']);
	}
	if(isset($user['cpass'])){
		$user['cpass'] =  shine($user['cpass']);
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