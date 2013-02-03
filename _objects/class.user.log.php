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
 * @name User Logging Class
 * @package Logos User Layer
 * @version 0.0.1
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @TODO further performance optmization, reduceing memory usage and number of database calls
 */

class log{

	//user variables
	public $id, $user_id, $action, $ip, $action_id, $date, $state;

	/**
	 * User class construtor
	 * @param ID of the user to be loaded, defined as NULL to load the standard user object.
	 * @return void
	 */
	public function __construct($id = null){
		if($id != null){
			$this->id = $id;
			if(!$this->load_log()){
				fail("Couldn't Load Log");
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
	public static function write_new_log($user_id, $action, $state = 1, $action_id = 0){

		$instance = new self();

		$instance->user_id 			= $user_id;
		$instance->action 			= clean($action);
		$instance->action_id   		= $action_id;
		$instance->ip 				= $_SERVER['REMOTE_ADDR'];
		$instance->state			= $state;

		$query = "INSERT INTO user_logs (`user_id`, `action`, `ip`, `actionID`, `state`)
		VALUES ('$instance->user_id', '$instance->action', '$instance->ip', '$instance->action_id', '$instance->state')";

		if(DB::sql($query)){
			return true;
		}

		return false;

	}

	public function load_log($id){

		$query = "SELECT * FROM `user_logs` WHERE `id` = '$id'";

		if($this->load_log_result(DB::sql($query))){
			return true;
		}

		return false;

	}

	public static function search_log($user_id, $action_id = null, $offset = 0, $totalres = 1){

		$instance = new self();

		if($action_id == null){$action_id = '%';}

		$query = "SELECT * FROM `user_logs` WHERE (`user_id` = '$user_id' AND `action_id` = '$action_id') ORDER BY `id` LIMIT $offset, $totalres";

		if($instance->load_log_result(DB::sql($query))){
			return $instance;
		}

		return false;

	}

	public function load_log_result($result = null){

		$log = DB::sql_fetch($result);

		try{

			$this->id 				= $log['id'];
			$this->user_id 			= $log['user_id'];
			$this->action 			= $log['action'];
			$this->ip				= $log['ip'];
			$this->date 			= $log['date'];

			if(isset($log['action_id'])) 	$this->action_id 	= $log['action_id'];

			return true;

		}catch(Exception $e){
			fail("Load Log Exception");
		}

		return false;
	}

}

?>