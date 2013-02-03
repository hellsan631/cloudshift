<?php include("__header.php"); ?>
<?php

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

	define('THIS_PAGE', "connect-mi");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos</title>
<link href="./js/ui/src/jquery.ui.potato.menu.css" rel="stylesheet" type="text/css"/>
<link href="./css/popup.css" rel="stylesheet" type="text/css"/>

<link href="./css/connect.css" rel="stylesheet" type="text/css"/>
<link href="./css/menu.css" rel="stylesheet" type="text/css"/>

</head>

<body>
<?php include "includes/menu.php"; ?>
<div id="body-con">
	<div id="content-con">
		<h2>Info Panel</h2>
		<div id="content"></div>
	</div>
	<div id="list-con">
		<h2>Friends List</h2>
		<div id="list">

		</div>
	</div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
<script>
var thisuserid = <?php echo $cuser->id; ?>;
$("#<?php echo THIS_PAGE;?>").addClass("selected-mi");
</script>
<script src="./js/connect.js"></script>
</html>