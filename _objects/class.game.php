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

require_once ROOT_PATH.CLASS_PATH.'class.security.helper.php';

/**
 * @name Main Game Class
 * @package Logos User Layer
 * @version 0.0.1
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @TODO comment dis code yo
 * @TODO further performance optmization, reduceing memory usage and number of database calls
 */

class game{

	public $title, $user_count, $id, $info, $bgimage, $banner, $level, $api;

	/**
	 * Either loads an object based on its ID, but if ID is null, then will create an object
	 * with the given $array of data;
	 * @param integer $id
	 * @param array $array
	 */
	public function __construct($id, $array = null){

		if($id != null){
			$this->load_game($id);
		}else if($array != null){
			$this->setData($array);
		}

	}

	/**
	 * Loads a game with a given ID from the database
	 * @param integer $id
	 * @return boolean
	 */
	public function load_game($id){

		$query = "SELECT * FROM `games` WHERE `id` = '$id'";

		$result = DB::sql_fetch(DB::sql($query));
		if(setData($result)){
			return true;
		}

		return false;

	}

	/**
	 * Saves the current game object to the database when it already exists.
	 * @return boolean
	 */
	public function save_game(){

		$query = "UPDATE `games`
	 	SET `title` = '$this->title', `user_count` = '$this->user_count', `api` = '$this->api',
	 	`info` = '$this->info', `bgimage` = '$this->bgimage', `banner` = '$this->banner', `level` = '$this->level'
	  	WHERE `id` = '$this->id'";

		if(DB::sql($query)){
			return true;
		}

		return false;

	}

	/**
	 * Creates a new game object in the database.
	 * @return boolean
	 */
	public function write_new_game(){

		$query = "INSERT INTO `games`
		( `title`, `user_count`,  `info`,  `bgimage`, `banner`, `level`, `api`)
		VALUES
		('$this->title', '$this->user_count', '$this->info', '$this->bgimage', '$this->banner', '$this->level', '$this->api')";

		if(DB::sql($query)){
			$this->id = DB::last_id();
			return true;
		}

		return false;

	}

	/**
	 * Sets object data to data from database
	 * @param database result object $result
	 */
	public function setData($result){

		if(!$result){return false;}

		if(isset($result['title'])) 		$this->title		= $result['title'];
		if(isset($result['user_count']))	$this->user_count	= $result['user_count'];
		if(isset($result['id'])) 			$this->id			= $result['id'];
		if(isset($result['info'])) 			$this->info			= $result['info'];
		if(isset($result['bgimage'])) 		$this->bgimage		= $result['bgimage'];
		if(isset($result['banner'])) 		$this->banner		= $result['banner'];
		if(isset($result['level'])) 		$this->level		= $result['level'];

		return true;

	}

	/**
	 * Updates the database with/and returns the user count of a games object
	 * @param integer $id
	 * @return boolean on falure, updated integer count on success
	 */

	public static function updateUserCount($id){

		$id = intval($id);

		$query = "SELECT COUNT(*) FROM `games` WHERE `id` = '$id'";
		$result = @DB::sql_fetch(DB::sql($query));

		if($result){

			$updated_count = intval(($result['COUNT(*)']));

			$query = "UPDATE `games` SET `user_count` = '$updated_count' WHERE `id` = '$id'";

			if(DB::sql($query)){
				return $updated_count;
			}

			return false;

		}

		return false;

	}

	/**
	 * Default method that handles when the object is imploded or deconstruted.
	 * @return Array of current user
	 */
	public function __sleep(){

	}

	/**
	 * Takes the array from __sleep() and turns it into a user object again
	 * @param array userdata
	 * @return void
	 */
	public function __wakeup(array $userdata){

	}

	/**
	 * Turns the user into a string
	 * @return var_dump of $this
	 */
	public function __toString(){
		return "".var_dump($this);
	}

	/**
	 * Destroys the object in a way that saves memory.
	 */
	public function __destruct() {
		foreach ($this as $index => $value) unset($this->$index);
	}


	public static function printTopGames(){

		echo 'hello';
		echo 'world';

	}
}