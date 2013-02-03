<?php
/**
 * Version Changelog
* 0.0.1 - Initial Version
*
*/

/**
 * @ignore
*/
if (!defined('LOGOS'))
{
	exit;
}

/**
 * @ignore
 */
if (!defined('DB_LINK'))
{
	exit;
}

/**
 * @name User Comment Class
 * @package Logos User Layer
 * @version 0.0.1
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @TODO further performance optmization, reduceing memory usage and number of database calls
 */

class comment{

	//user variables
	public $id, $author_id, $to_id, $text, $state, $date;

	/**
	 * User class construtor
	 * @param ID of the user to be loaded, defined as NULL to load the standard user object.
	 * @return void
	 */
	public function __construct($id = null){
		if($id != null){
			$this->id = $id;
			if(!$this->load_comment()){
				fail("Couldn't Load Comment");
			}
		}
	}

	/**
	 * Writes a new log file given the user_id, action, and IP
	 * @param $user_id
	 * @param $action
	 * @param $ip
	 * @return boolean
	 */
	public static function write_new_comment($author_id, $to_id, $text, $state = 1){

		$instance = new self();

		$instance->author_id 		= $author_id;
		$instance->to_id 			= $to_id;
		$instance->text   			= $text;
		$instance->state 			= $state;

		$query = "INSERT INTO `user_comments` ( `author_id`, `to_id`, `text`, `state`, `user_page_id`)
		VALUES ('$instance->author_id', '$instance->to_id', '$instance->text', '$instance->state', '$instance->to_id')";

		require_once ROOT_PATH.CLASS_PATH.'class.user.php';

		$to_user = user::load_id($to_id);

		log::write_new_log($instance->author_id , "Commented on <b><a href=\"./profile.php?id=$to_user->id\">$to_user->username</a></b>'s profile.", 1);

		if(DB::sql($query)){
			return true;
		}

		return false;

	}

	public function load_comment($id){

		$query = "SELECT * FROM `user_logs` WHERE `id` = '$id'";

		if($this->load_comment_result(DB::sql($query))){
			return true;
		}

		return false;

	}

	public function load_comment_result($result = null){

		$log = DB::sql_fetch($result);

		try{

			$this->id 				= $log['id'];
			$this->user_id 			= $log['user_id'];
			$this->to_id 			= $log['to_id'];
			$this->text 			= $log['text'];
			$this->state 			= $log['state'];
			$this->date				= $log['date'];

			return true;

		}catch(Exception $e){
			fail("Load Log Exception");
		}

		return false;
	}

}

?>