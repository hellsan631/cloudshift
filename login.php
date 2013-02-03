<?php

	session_start();
	require_once './_objects/class.logos.setup.php';
	$page = new logos();

	if(isset($_SESSION['user_id'])){//if the user has been logged in
		header("Location: ".ROOT_PATH."profile.php");
	}

	define('PAGE_TITLE', 'Log In!');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos - <?php echo PAGE_TITLE; ?> - Social Gaming</title>

<link href="./css/login.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div id="page-con">

    	<div id="login-con" class="login-cont small conbox">
    		<div id="signup-tag"></div>
    		<div class="content">
	            <div class="shadows">

	                <h1 class="noerror">login</h1>

	                <div id="inside">

						<div id="resultlog" class="error"></div><br />

		                <form name="login" action="login.php" method="post" class="form" onsubmit="xmlhttpPost('<?php echo ROOT_PATH.LISTN_PATH."listn.login.php"?>', 'login', 'resultlog', null); return false;">
		                	<input name="submitType" type="hidden" value="0" />

		                	<input type="text" name="email" id="email" value="Email" /><br /><br />
		                	<input type="text" name="pass" id="pass" value="Password" /><br /><br />

		                	<input id="submit" class="submit" type="submit" value="Login" />
		                </form>

	            	</div>
	            </div>
            </div><br />
            <span id="fp">Forgot Password?</span>
        </div>

        <div id="signup-con" class="signup-cont conbox" >
        	<div id="login-tag"></div>
            <div class="content">
	            <div class="shadows">

	                <h1 class="noerror">signup</h1>

	                <div id="inside">

						<div id="results" class="error"></div><br />

		                <form name="submit" action="login.php" method="post" class="form" onsubmit="xmlhttpPost('<?php echo ROOT_PATH.LISTN_PATH."listn.login.php"?>', 'submit', 'results', null); return false;">
		                	<input name="submitType" type="hidden" value="1" />

							<input type="text" name="username" id="username" value="Username" /><img id="uimg" class="check hidden" src="./images/xmark.png" /><br />
		                	<input type="text" name="semail" id="semail" value="Email" /><img id="eimg" class="check hidden" src="./images/xmark.png" /><br />
		                	<hr />
		                	<input type="text" name="spass" id="spass" value="Password" /><img id="pimg" class="check hidden" src="./images/xmark.png" /><br />
							<input type="text" name="cpass" id="cpass" value="Confirm Password" /><img id="cimg" class="check hidden" src="./images/xmark.png" /><br />

		                	<input id="submits" class="submit" type="submit" value="Submit" />
		                </form>

	            	</div>
	            </div>
            </div>
        </div>

        <div id="fp-con" class="fp-cont conbox" >
        	<div id="back-tag"></div>
            <div class="content">
	            <div class="shadows">

	                <h3 class="noerror">forgot password</h3>

	                <div id="inside">

						<div id="fpresults" class="error"></div><br />

		                <form name="fpsubmit" action="login.php" method="post" class="form" onsubmit="xmlhttpPost('<?php echo ROOT_PATH.LISTN_PATH."listn.login.php"?>', 'fpsubmit', 'fpresults', null); return false;">
		                	<input name="submitType" type="hidden" value="2" />

							<input type="text" name="fpusername" id="fpusername" value="Username" /><br />
		                	<input type="text" name="fpsemail" id="fpsemail" value="Email" /><br />

		                	<input id="fpsubmits" class="submit" type="submit" value="Submit" />
		                </form>

	            	</div>
	            </div>
            </div>
        </div>

        <div id="info-con">
            <div class="contents">
            	<h2>logos</h2>
            	<p>A New Kind of Social Experience</p>
            	<p>Engineered by Gamers, for Gamers</p>
            	<div style="margin-top:-80px; height:425; width:350; margin:-70px auto;" >
            	<img src="./images/game.png" /></div>
            </div>
        </div>
    </div>

<div id="preload"><img src="./images/pleasewait.gif"></div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<script src="./js/ui/ajaxsbmt.js"></script>
<script src="./js/login.js"></script>
</html>
