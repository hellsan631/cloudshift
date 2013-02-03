<?php
function getUserByEmail($email){
	static $user = NULL;
	
	$query = "SELECT * 
                FROM `users` 
                WHERE `email` = '$email'";
                
	$result = mysql_query($query);
	
	if(mysql_errno() === 0){
		$user = mysql_fetch_assoc($result);
		return $user;
	}

    return false;
}
function getUserByID($user_id){
	static $user = NULL;

	$query = "SELECT *
	FROM `users`
	WHERE `id` = '$user_id'";

	$result = mysql_query($query);

	if(mysql_errno() === 0){
		$user = mysql_fetch_assoc($result);
		return $user;
	}

	return false;
}
function getUserAvatarByID($user_id){
	static $user = NULL;
	
	$query = "SELECT avatar
	FROM `users`
	WHERE `id` = '$user_id'";
	
	$result = mysql_query($query);
	
	if(mysql_errno() === 0){
		$user = mysql_fetch_assoc($result);
		return $user['avatar'];
	}
	
	return false;
}
?>