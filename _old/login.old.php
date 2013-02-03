<?php require_once "_header.php"; $title = "Log In!";?>

<?php if(isset($_GET['fp'])): ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos - <?php echo $title; ?> - Social Gaming</title>

<link href="./css/login.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css' />

</head>

<body>
	<div id="bodycon">
	    <div id="page-con">
	    	<div id="name-con">
	    		<form action="authenticate.php" method="post" class="form">
	    			<input id="submitType" name="submitType" type="hidden" value="3" />
	            	<input type="text" name="email" id="email" class="long" value="Reset Password - Enter a valid email address" />
	            	<input id="submit" class="submit right" type="submit" value="Submit" />
	        	</form>
	    	</div>
	    </div>
	</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>

<script>
$("#email")
  .focus(function() {
        if (this.value === this.defaultValue) {
            this.value = '';
			$("#email").addClass("hovered");
        }
  })
  .blur(function() {
        if (this.value === '') {
            this.value = this.defaultValue;
			$("#email").removeClass("hovered");
        }
});
</script>
</html>
<?php elseif(!$cuser): ?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos - <?php echo $title; ?> - Social Gaming</title>

<link href="./css/login/style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Allan:bold' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>
</head>

<body>
<div id="bodycon">
    <div id="page-con">
    	<div id="login-con" class="login-cont small">
            <div class="content shadows">


                <?php if(!isset($_GET['error'])){echo "<h1 class=\"noerror\">login</h1>";}elseif($_GET['error'] == 13){echo "<h1>login</h1>"; }else{ echo "<h1>error</h1>";}?>

                <div id="inside">
                <?php if(isset($_GET['error'])):?>
                	<?php if($_GET['error'] == 1):?>
                		<p class="error">there was a problem logging in</p>
                	<?php elseif($_GET['error'] == 2):?>
                		<p class="error">there was a problem logging in</p>
                	<?php elseif($_GET['error'] == 3):?>
                		<p class="error">the authentication key was bad</p>
                	<?php elseif($_GET['error'] == 4):?>\
                		<p class="error">no key was set. use your email link</p>
                	<?php elseif($_GET['error'] == 5):?>
                		<p class="error">there was an error sending the email</p>
                	<?php elseif($_GET['error'] == 6):?>
                		<p class="error">failed to create new user</p>
                	<?php elseif($_GET['error'] == 7):?>
                		<p class="error">please enter a valid email and password</p>
                	<?php elseif($_GET['error'] == 8):?>
                		<p class="error">error updating username</p>
                	<?php elseif($_GET['error'] == 9):?>
                		<p class="error">please enter a valid username</p>
                	<?php elseif($_GET['error'] == 10):?>
                		<p class="error">invalid email/password</p>
                	<?php elseif($_GET['error'] == 11):?>
                		<p class="error">email address doesn't exist in database</p>
                	<?php elseif($_GET['error'] == 12):?>
                		<p class="error">error sending email with new password</p>
                	<?php elseif($_GET['error'] == 13):?>
                		<p class="error">check your email for your new password</p>
                	<?php elseif($_GET['error'] == 14):?>
                		<p class="error"><a href="login.php?fp=1">Forgot Password?</a></p>
                	<?php elseif($_GET['error'] == 15):?>
                		<p class="error">number of tries (6) exceeded, please wait <?php echo getWait($_SESSION['date'], "5")." min"; ?></p>
                	<?php elseif($_GET['error'] == 17):?>
                		<p class="error">username between 4 and 24 characters required</p>
                	<?php endif ?>
                <?php else: ?>
                <br />
                <?php endif?>

                <form action="authenticate.php" method="post" class="form">
                	<input id="submitType" name="submitType" type="hidden" value="0" />
                	<?php if(isset($_GET['key'])){echo "<input id=\"key\" name=\"key\" type=\"hidden\" value=\"".$_GET['key']."\"/>";} ?>

                	<input type="text" name="email" id="email" value="Email" /><br /><br />
                	<input type="text" name="pass" id="pass" value="Password" /><br /><br />

               		<div id="conPass" class="hidden">
                		<input type="text" name="cpass" id="cpass" value="Confirm Password" /><br />
                	</div>

                	<input id="submit" class="submit" type="submit" value="Login" />
                	<input id="signup" class="submit" type="button" value="Sign Up" />

                </form>

            	</div>
            </div>
        </div>
        <div id="info-con">
            <div class="content">
            	<h2>logos</h2>
            	<p>A New Kind of Social Experience</p>
            	<p>Engineered by Gamers, for Gamers</p>
            	<p style="text-align:center;"><img src="./images/game.png" style="margin-top:-80px;" /></p>
            </div>
        </div>
    </div>

</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>

<script>
$("#pass")
.focus(function() {
      if (this.value === this.defaultValue) {
          this.value = '';
			this.type = 'password';
			$("#pass").addClass("hovered");
      }
})
.blur(function() {
      if (this.value === '') {
          this.value = this.defaultValue;
			this.type = 'text';
			$("#pass").removeClass("hovered");
      }
});

$("#cpass")
.focus(function() {
      if (this.value === this.defaultValue) {
          this.value = '';
			this.type = 'password';
			$("#cpass").addClass("hovered");
      }
})
.blur(function() {
      if (this.value === '') {
          this.value = this.defaultValue;
			this.type = 'text';
			$("#cpass").removeClass("hovered");
      }
});
</script>

<script>
$("#email")
  .focus(function() {
        if (this.value === this.defaultValue) {
            this.value = '';
            $("#email").addClass("hovered");
        }
  })
  .blur(function() {
        if (this.value === '') {
            this.value = this.defaultValue;
            $("#email").removeClass("hovered");
        }
});

$(document).ready(function() {
    $("#signup").toggle(function() {
		$(this).attr("value", "Login");
		$("#login-con").removeClass("small", 500);
		$("#conPass").removeClass("hidden", 500);
		$("#submitType").attr("value", "1");
		$("#submit").attr("value", "Submit");
    }, function() {
		$(this).attr("value", "Sign Up");
		$("#conPass").addClass("hidden", 500);
		$("#login-con").addClass("small", 500);
		$("#submitType").attr("value", "0");
		$("#submit").attr("value", "Login");
    });
});
</script>
</html>

<?php elseif($cuser['userlevel'] == -1): ?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Logos - <?php echo $title; ?> - Social Gaming</title>

<link href="./css/login/style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Allan:bold' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>

</head>

<body>
	<div id="bodycon">
	    <div id="page-con">
	    	<div id="name-con">
	    		<form action="authenticate.php" method="post" class="form">
	    			<input id="submitType" name="submitType" type="hidden" value="2" />
	            	<input type="text" name="username" id="username" class="long" value="Enter a username" />
	            	<input id="submit" class="submit right" type="submit" value="Submit" />
	        	</form>
	    	</div>
	    </div>
	</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>

<script>
$("#username")
  .focus(function() {
        if (this.value === this.defaultValue) {
            this.value = '';
			$("#username").addClass("hovered");
        }
  })
  .blur(function() {
        if (this.value === '') {
            this.value = this.defaultValue;
			$("#username").removeClass("hovered");
        }
});
</script>
</html>
<?php else: ?>
<?php header("Location: profile.php"); ?>
<?php endif; ?>
