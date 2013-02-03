<?php

	include "./__header.php";

	if($cuser->userlevel != 0){
		header("Location: ./profile.php");
	}

	define("PAGE_TITLE","Admin Login");

?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos - <?php echo PAGE_TITLE; ?> - Social Gaming</title>

<link href="./css/login.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="bodycon">
    <div id="page-con">

    	<div id="login-con" class="login-cont small conbox">
    		<div class="content">
	            <div class="shadows">

	                <h1 class="noerror">admin</h1>

	                <div id="inside">

						<div id="resultlog" class="error"></div><br />

		                <form name="login" action="login.php" method="post" class="form" onsubmit="xmlhttpPost('<?php echo ROOT_PATH.LISTN_PATH."listn.admin.login.php"?>', 'login', 'resultlog', null); return false;">
		                	<input name="submitType" type="hidden" value="0" />

		                	<input type="text" name="email" id="email" value="Email" /><br /><br />
		                	<input type="text" name="pass" id="pass" value="Password" /><br /><br />

		                	<input id="submit" class="submit" type="submit" value="Login" />
		                </form>

	            	</div>
	            </div>
            </div><br />
        </div>

        <div id="info-con">
            <div class="contents">
            	<br/>
            	<br/>
            	<br/>
            	<h2>logos</h2>
            	<p>super secert admin base, no gurls aloud</p>
            	<p>to access the admin area, please login again</p>
            </div>
        </div>
    </div>

</div>
<div id="preload"><img src="./images/pleasewait.gif"></div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<script src="./js/ui/ajaxsbmt.js"></script>
<script src="./js/login.js"></script>
</html>
