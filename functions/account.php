<?php

session_start();
require_once '../_objects/class.logos.setup.php';
$page = new logos('../');
require_once ROOT_PATH.CLASS_PATH.'class.database.php';
$db = new DB();
include_once ROOT_PATH.CLASS_PATH.'class.user.php';

$changed = false;

if(isset($_GET['key'])){

	$key = clean($_GET['key']);

	if(strlen($key) <= 4){
		error("Key length invalid");
	}

	$query = "SELECT `id` FROM users WHERE `securitykey` = '$key'";
	$result = DB::sql($query);

	if(@$result){
		$result = DB::sql_fetch($result);
	}

	$tempuser = new user();

	if(@$result['id']){

		$tempuser = user::load_id($result['id']);

		if($tempuser->userlevel == -1){

			$query = "UPDATE users SET `userlevel` = '5' WHERE `id` = '$tempuser->id'";
			$result = DB::sql($query);

			if($result){

				$query = "UPDATE users SET `securitykey` = '0' WHERE `id` = '$tempuser->id'";
				$result = DB::sql($query);

				if($result){
					$changed = true;
				}

			}
		}else{

			error("You are already authenticated");

		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos</title>

<link href="../css/profile.css" rel="stylesheet" type="text/css"/>

<link href='http://fonts.googleapis.com/css?family=Crimson+Text' rel='stylesheet' type='text/css'>

</head>
<body>
<div id="main-cont" style="margin:0 auto; width:100%;">
<?php

if($changed){
	echo "<h1>You've been successfully Registered</h1>";
}else{
	echo "<h1>Invalid Security Key/Already Registered</h1>";
}

?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
(function() {
    var timer = 0;

    if (!timer) {

    	timer = setTimeout(changewindow, 1000);

    }

    function changewindow() {

        timer = 0;

        window.location = "../login.php";

    }

})();

</script>
</body>
</html>