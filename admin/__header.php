<?php

//header might be able to be placed in the logos setup, along with the database,
//using one 1 to assign and do everything with arguements to the constructor.

session_start();
require_once '../_objects/class.logos.setup.php';
new logos('../'); //arguments are path related
require_once ROOT_PATH.CLASS_PATH.'class.database.php';
new DB(); //create the new DB
include_once ROOT_PATH.CLASS_PATH.'class.user.php';

global $cuser; $cuser = @user::load_current(); //creates and loads current user

if(!$cuser && REQUIRE_LOGIN){
	header("Location: ./logout.php");
}

?>
