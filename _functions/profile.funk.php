<?php

	function displayComments($userID){

		$first = true;

		$result = DB::sql_fetch(DB::sql("SELECT COUNT(*) FROM user_comments WHERE `user_page_id` = '$userID'"));

		$count =  intval(($result['COUNT(*)']));

		$result = DB::sql("SELECT * FROM `user_comments` WHERE `user_page_id` = '$userID' ORDER BY `date` DESC LIMIT 10");
		$total = 0;

		while($count > $total && $result){

			$fetch = DB::sql_fetch($result);

			$name = user::load_id($fetch['author_id']);
			$text = $fetch['text'];

			$echos = "<div class=\"comment\"><h3><a href=\"./profile.php?id=$name->id\">$name->username</a></h3>$text</div>";

			echo $echos;

			$total++;

		}
	}

	function displayRecentActivity($userID){

		$result = DB::sql_fetch(DB::sql("SELECT COUNT(*) FROM user_logs WHERE (`user_id` = '$userID' AND `state` = '1')"));

		$count =  intval(($result['COUNT(*)']));


		//if($count == 0) return false;

		$query = "SELECT * FROM user_logs WHERE (`user_id` = '$userID' AND `state` = '1') ORDER BY `date` DESC LIMIT 10";

		$result = DB::sql($query);

		//echo var_dump($result);

		$total = 0;

		while($count > $total && $result){

			$fetch = DB::sql_fetch($result);

			$user = user::load_id(intval($fetch['user_id']));

			$name = $user->username;
			$text = $fetch['action'];
			$avatar = $user->avatar;

			if($total == 0){
				$echos = "<div class=\"recent-item top\">";
			}else{
				$echos = "<div class=\"recent-item\">";
			}

			$echos = $echos."<div class=\"pIcon-con\"><a href=\"./profile.php?id=$user->id\"><img class=\"pIcon\" src=\"$avatar\" /></a></div>
			                <div class=\"act-content\"><h3><a href=\"./profile.php?id=$user->id\">$name</a></h3>
			                $text</div>
			            </div>";

			echo $echos;

			$total++;

		}

	}
?>