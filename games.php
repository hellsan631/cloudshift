<?php
include './__header.php';
include './_functions/profile.funk.php';

	$self = true;
	$pageUser = $cuser;

	if(isset($_GET['i'])){
		if($cuser->id != intval($_GET['i'])){
			$pageUser = new user(intval($_GET['i']));
			$self = false;
		}
	}else if(isset($_GET['id'])){
		if($cuser->id != intval($_GET['id'])){
			$pageUser = new user(intval($_GET['id']));
			$self = false;
		}
	}

	define('THIS_PAGE', "profile-mi");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos</title>

<link href="./js/ui/src/jquery.ui.potato.menu.css" rel="stylesheet" type="text/css"/>
<link href="./css/popup.css" rel="stylesheet" type="text/css"/>
<link href="./css/games.css" rel="stylesheet" type="text/css"/>
<link href="./css/menu.css" rel="stylesheet" type="text/css"/>

</head>

<body>
<?php include "includes/menu.php"; ?>
<div id="games-content">
	<div id="game-header">
		<img src="./images/sc2logo_small.png" class="game-icon" />
		<h3>StarCraft 2</h3>
	</div>

	<div id="game-info">
	</div>
</div>
</body>
</html>