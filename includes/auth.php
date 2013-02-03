<?php
function credentials_valid($email, $password){
  $email = mysql_real_escape_string($email);
  $query = "SELECT `id`, `salt`, `password`
            FROM `users`
            WHERE `email` = '$email' ";

  $result = mysql_query($query);
  if(mysql_num_rows($result)){
    $user = mysql_fetch_assoc($result);
    $password_requested = md5($user['salt'] . $password);
    if($password_requested === $user['password']){
      return $user['id'];
    }
  }
  return false;
}

function valid_salt($email, $salt){
	$email = mysql_real_escape_string($email);
	$query = "SELECT `id`, `salt`
	FROM `users`
	WHERE `email` = '$email' ";

	$result = mysql_query($query);
	if(mysql_num_rows($result)){
		$user = mysql_fetch_assoc($result);
		if($salt === $user['salt']){
			return $user['id'];
		}
	}
	return false;
}

// Logs into the user $user
function log_in($user_id){

  $_SESSION['user_id'] = $user_id;

  $ip = $_SERVER['REMOTE_ADDR'];

  $query = "UPDATE `users`
  SET `logins` = `logins` + 1, `lastip` = '$ip', `lastlogindate` = NOW()
  WHERE `id` = '$user_id'";

  $result = mysql_query($query);

  if(mysql_errno() === 0){
  	return true;
  }else{
  	return false;
  }

}

// Returns the currently logged in user (if any)
function current_user(){

  static $current_user = false;

  if(!$current_user){
    if(isset($_SESSION['user_id'])){
      $user_id = intval($_SESSION['user_id']);
      $query = "SELECT *
                FROM `users`
                WHERE `id` = $user_id";

      $result = mysql_query($query);

      if(mysql_num_rows($result)){

        $current_user = mysql_fetch_assoc($result);

        return $current_user;
      }
    }
  }

  return $current_user;
}

// Requires a current user
function require_login(){
  	if(!current_user()){
    	$_SESSION['redirect_to'] = $_SERVER["REQUEST_URI"];
   	 	header("Location: login.php?login_required=1");
    	exit("You must log in.");
  	}
}

function return_login($cuser){
	if($cuser){
		return true;
	}

	return false;
}

function h($string){
	return htmlspecialchars($string);
}

?>