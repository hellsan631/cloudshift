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
<link href="./css/profile.css" rel="stylesheet" type="text/css"/>
<link href="./css/menu.css" rel="stylesheet" type="text/css"/>

</head>

<body>
<?php include "includes/menu.php"; ?>
<div id="body-con">
	<div id="main-one">
		<div id="main-cont" style="background: url(<?php echo $pageUser->background; ?>);">
			<div id="avatar-con">
				<img src="<?php echo $pageUser->avatar; ?>" id="useravatar"/>
			</div>

			<div id="low-menu">
				<h1><?php echo "$pageUser->username"; ?></h1>
				<?php if(!$self): ?>
				<div id="makeMsg" class="setting"><a href="#"><span>Message</span><div class="icon icon-comments"></div></a></div>
				<div id="makeFriend" class="setting"><a href="#"><span>Send Friend Request</span><div class="icon icon-user"></div></a></div>
				<?php else: ?>
				<div id="settings" class="setting"><a href="settings.php"><span>Settings</span><div class="icon icon-cog"></div></a></div>
				<?php endif ?>
			</div>
			<?php
// 	        <ul id="menu1">
// 	        	<li></h1>
// 		        <ul>
//
//			        <li id="settings"></li> -->
//
//		        <li id="makeMsg"></li> -->
//			        <li id="makeFriend"></li> -->
//
// 		        </ul> -->
//        	</li> -->
//	        </ul> -->
	        ?>
        </div>
    </div>

    <div id="mid">
        <div id="games-con">
            <h1>Top Games</h1>

            <?php
	            if($pageUser->games > 0){

	            }else{
	            	echo' <div class="gamesitem-con left"><div class="games-item"><img id="addGameButton" src="./images/lol.jpg" /></div></div>
	            	<div class="gamesitem-con right"><div class="games-item"><img id="addGameButton" src="./images/bf3.jpg" /></div></div>';
	            }
            ?>


			<div id="comment-box-con">
				<h1>Comment Box</h1>
				<div id="comment-box">
					<textarea name="enter_comment" id="enter_comment"></textarea>
					<button class="right" id="comment_submit">Submit</button>
					<div id="comment-area">
						<?php
							displayComments($pageUser->id);
						?>
					</div>
				</div>
			</div>
        </div>
        <div id="recent-activity-con">
        	<h2>Recent Activity</h2>
        	<?php displayRecentActivity($pageUser->id); ?>
        </div>
    </div>
</div>

<div id="newMsg" class="popup">
	<a onClick="closePops()" class="popupX">x</a>
	<h1>Send A Message</h1>
	<form name="msg" action="settings.php" method="post" onsubmit="xmlhttpPost('./_listeners/listn.sendmail.php', 'msg', 'resultAdv', null); return false;">
		<input id="to_id" name="to_id" type="hidden" value="<?php echo $pageUser->id; ?>" />
		<div class="h2"><?php echo "<b>To:</b> $pageUser->username";?></div>
		<div class="h2"><?php echo "<b>From:</b> $cuser->username";?></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="notice">Subject:</div>
        <input class="subjectBox" type="text" name="msg_subject" id="msg_subject" value="please enter a subject" />
        <div class="spacer"></div>
        <div class="spacer"></div>
        <div class="notice">Message:</div>
        <textarea class="textBox" name="msg_text" id="msg_text"></textarea>
        <div class="spacer"></div>
        <div id="resultAdv" class="ajaxresult"></div>
        <input id="submit" class="submit" type="submit" value="Submit" />
    </form>
</div>

<div id="addGame" class="popup">
	<a onClick="closePops()" class="popupX">x</a>
	<h1>Add A Game</h1>
	<form name="msg" action="settings.php" method="post" onsubmit="xmlhttpPost('./_listeners/listn.addgame.php', 'msg', 'resultAdv', null); return false;">
		<?php
			include ROOT_PATH.CLASS_PATH.'class.game.php';
			game::printTopGames();
		?>
        <div id="resultAdv" class="ajaxresult"></div>
        <input id="submit" class="submit" type="submit" value="Submit" />
    </form>
</div>

<div id="backgroundPopup"></div>
</body>
<?php echo "<script>var thisid = $pageUser->id;</script>";?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="./js/ui/potato.menu.min.js"></script>
<script src="./js/ui/popup.js"></script>
<script src="./js/ui/ajaxsbmt.js"></script>
<script src="./js/profile.js"></script>
<script type="text/javascript">
(function($) {
    $(document).ready(function(){
        $('#menu1').ptMenu();
    });
})(jQuery);
</script>
<?php if($cuser): ?>
<script src="./js/ui/ajaxsbmt.js"></script>
<script>
$(document).ready(function(){

	$("#addGameButton").click(function(){
		//centering with css
		selectedPopup = "#addGame";
		centerPopup();
		//load popup
		loadPopupSize("500", "545");
	});

	//popup button events
	$("#submit").click(function(){
		$("#submit").attr("disabled", true);
	;
	});

	$("#makeMsg").click(function(){
		//centering with css
		selectedPopup = "#newMsg";
		centerPopup();
		//load popup
		loadPopupSize("500", "545");
	});
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});

});

function closePops(){
	disablePopup();
}
</script>
<?php endif; ?>
<script>
$("#<?php echo THIS_PAGE;?>").addClass("selected-mi");
</script>
</html>