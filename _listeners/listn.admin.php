<?php
require_once './listn.header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$submitType = intval($_POST['submitType']);

	if($submitType == 0){ //if the type is to add game

		$data = array(
					"title" 	=> $_POST['msg_title'],
					"banner" 	=> $_POST['msg_banner_url'],
					"bgimage" 	=> $_POST['msg_bg_url'],
					"api" 		=> $_POST['msg_api'],
					"level" 	=> $_POST['msg_level'],
					"info" 	=> $_POST['msg_text']
				);

		include ROOT_PATH.CLASS_PATH.'class.game.php';

		$game = new game(0,$data);

		if($game->write_new_game()){
			fail("Game Saved");
		}else{
			fail("Game Not Saved");
		}
	}
}

?>
