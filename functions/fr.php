<?php

session_start();
require_once '../_objects/class.logos.setup.php';
$page = new logos('../'); //arguments are path related
require_once ROOT_PATH.CLASS_PATH.'class.database.php';
$db = new DB(); //create the new DB
include_once ROOT_PATH.CLASS_PATH.'class.user.php';

$cuser = @user::load_current(); //creates and loads current user
$self = true;

if(isset($_GET['id'])){
	if($cuser->id != intval($_GET['id'])){
		$pageUser = new user(intval($_GET['id']));
		$self = false;
	}
}

if($self){
	header("Location: ../profile.php");
	exit;
}

if($cuser->sendRequest($pageUser)){
	fail("Successfully added friend through friend request");
}else{
	fail("Could not accept friend request.");
}

?>