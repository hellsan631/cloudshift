<?php

/**
 * Version Changelog
 * 0.0.1 - Initial Version
 * 0.0.2 - Added/Improved user login functions
 * 0.0.3 - Added Friendlist Code Section
 * 0.0.4 - Reduced memory usage
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

require ROOT_PATH.CLASS_PATH.'class.security.helper.php';
require ROOT_PATH.CLASS_PATH.'class.user.log.php';


/**
 * @name Main User Class
 * @package Logos User Layer
 * @version 0.0.4
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @TODO further performance optmization, reduceing memory usage and number of database calls
 */

class user{

	//user variables
	public $id, $username, $email, $avatar, $userlevel, $firstname, $lastname, $logins, $mailbox, $isfriend = false, $login = false, $background, $games;
	private $salt, $password, $lastip, $lastlogindate, $securitykey;

	/**
	 * User class construtor
	 * @param ID of the user to be loaded, defined as NULL to load the standard user object.
	 * @return void
	 */
	public function __construct($id = null){

		if($id != null){
			$this->id = $id;
			if(!$this->user_load()){
				fail("Couldn't Load User");
			}
		}

	}

	/**
	 * Loading and creation of user data in static methods
	 */

	/**
	 * Writes a new user to database given an array of userdata
	 * @param Array of userdata for use in user signup and creation
	 * @return BOOLEAN based on success of user creation
	 */
	public static function write_new_user(array $userdata){

		$instance = new self();

		$instance->username 		= $userdata['username'];
		$instance->email 			= $userdata['email'];
		$instance->salt 			= $userdata['salt'];
		$instance->password 		= $userdata['password'];
		$instance->userlevel 		= $userdata['userlevel'];
		$instance->securitykey		= $userdata['securekey'];

		$query = "INSERT INTO `users` ( `username`, `email`,  `salt`,  `password`, `userlevel`, `securitykey`)
		VALUES ('$instance->username', '$instance->email', '$instance->salt', '$instance->password', '$instance->userlevel', '$instance->securitykey')";

		if(!DB::sql($query)){
			return false;
		}

		$instance->id = DB::last_id();

		$query = "INSERT INTO `user_mailbox` (`uid`) VALUES ('$instance->id')";

		if(!DB::sql($query)){
			return false;
		}


		return true;

	}

	/**
	 * Creates a new class instance and returns the loaded user, similar to construtor.
	 * @param int user ID to load data
	 * @return User object that was loaded
	 */
	public static function load_id($user_id){

		return new self(intval($user_id));
	}

	/**
	 * Loads the current user into a new class and returns the instance
	 * @return Current user
	 */
	public static function load_current(){
		$instance = new self();
		$instance->current_user();

		return $instance;
	}

	/**
	 * User Magic Methods to deal with user class
	 */

	/**
	 * Default method that handles when the object is imploded or deconstruted.
	 * @return Array of current user
	 */
	public function __sleep(){
		return false;
	}

	/**
	 * Takes the array from __sleep() and turns it into a user object again
	 * @param array userdata
	 * @return void
	 */
	public function __wakeup(){
		return false;
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

	/**
	 * User Login and Loading functions
	 */

	/**
	 * Gets the current user set in session_id and loads it ad current user object
	 * @param void
	 * @return BOOLEAN based on success
	 */
	public function current_user(){

		if(isset($_SESSION['user_id'])){

			$check = $this->user_load(intval($_SESSION['user_id']));

			if($check){
				$this->login = true;
			}

			return $check;
		}

		return false;
	}

	/**
	 * Handles the Login of the user object
	 * @param user id
	 * @return BOOLEAN based on success
	 */
	public static function log_in($user_id = null){

		if($user_id == null){$user_id = $this->id;}

	  	$ip = $_SERVER['REMOTE_ADDR'];

	  	$query = "UPDATE `users`
	 	SET `logins` = `logins` + 1, `lastip` = '$ip', `lastlogindate` = NOW()
	  	WHERE `id` = '$user_id'";

	  	if(DB::sql($query)){
	  		return true;
	  	}

	  	return false;
	}


	/**
	 * Loads the user from database table
	 * @param user id
	 * @return BOOLEAN based on success
	 */
	public function user_load($user_id = null){

		if($user_id == null){$user_id = $this->id;}

		$user_id = intval($user_id);

		$query = "SELECT * FROM `users` WHERE `id` = $user_id";

		if($this->setup_user(DB::sql($query))){
			return true;
		}

		return false;

	}

	/**
	 * Checks to see if the current user is logged in, otherwise redirects them
	 * @param current user
	 * @return void
	 */
	public static function require_login(user $current = null){

		if($current == null){$current->current_user();}

		if(!$current->login){
			$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
			header("Location: login.php?login_required=1");
			exit("You must log in.");
		}

	}


	/**
	 * Gets the last time of login
	 * @return Ambigous <Ambigous, string, number>
	 */
	public function getLastLogin(){
		return convertTime($this->lastlogindate);
	}

	/**
	 * Loads the user data from the database along with the users mailbox
	 * @param database result object from user_load()
	 * @return BOOLEAN based on success
	 */
	public function setup_user($result){

		$user = DB::sql_fetch($result);

		try{

			$this->id = $user['id'];

			$this->username 		= $user['username'];
			$this->email 			= $user['email'];
			$this->salt 			= $user['salt'];
			$this->password 		= $user['password'];

			if(isset($user['avatar'])) 		$this->avatar 		= $user['avatar'];
			if(isset($user['background'])) 	$this->background 	= $user['background'];

			$this->userlevel 		= $user['userlevel'];

			if(isset($user['fname']))		$this->firstname	= $user['fname'];
			if(isset($user['lname']))		$this->lastname 	= $user['lname'];

			$this->logins			= $user['logins'];
			$this->lastip 			= $user['lastip'];
			$this->lastlogindate 	= $user['lastlogindate'];

			$this->games			= $user['games'];

			require_once ROOT_PATH.CLASS_PATH.'class.mailbox.php';

			$this->mailbox 			= new mailbox($this->id);

			$this->securitykey 		= $user['securitykey'];

			return true;

		}catch(Exception $e){
			fail("Setup User Exception");
		}

		return false;
	}

	/**
	 * User Friendslist Functions
	 */

	/**
	 * Checks to see if there is already a request and deals with the results
	 * This is the method that should be called when adding a friend.
	 * @param user $user
	 * @return boolean
	 */
	public function sendRequest(user $user){

		if($this->id == $user->id){
			return false;
		}

		$query = "SELECT * FROM `user_friends` WHERE (`accept_id_one` = '$this->id' OR `accept_id_two` = '$this->id') AND (`accept_id_one` = '$user->id' OR `accept_id_two` = '$user->id')";

		$result = DB::sql_fetch(DB::sql($query));

		if($result){

			if($result['accept_id_one'] == $this->id){

				return false;

			}else if($result['accept_id_two'] == $this->id){

				if($this->addFriend($user)){
					return true;
				}else{
					return false;
				}

			}

		}else{//friend request
			return $this->requestFriend($user);
		}

	}

	/**
	 * Adds friend-request to database, and sends the friend request message
	 * @param user $user
	 * @return boolean
	 */
	public function requestFriend(user $user){

		$query = "INSERT INTO `user_friends` (`accept_id_one`, `id_one_status`, `accept_id_two`) VALUES ('$this->id', '1', '$user->id')";

		if(DB::sql($query)){

			include_once ROOT_PATH.CLASS_PATH.'class.mailbox.msg.php';

			$subject = "".$this->username."'s Friend Request";
			$text = "$this->username would like to become your friend! </br>
			<a href=\"./functions/fr.php?id=$this->id\">Click Here</a> to accept, or delete this message to ignore";

			if(mail_msg::send_message($user, $this, $subject, $text)){
				return true;
			}else{
				return false;
			}

		}

		return false;

	}

	/**
	 * Updates the user friend request to show that both users have added or sent friend requests
	 * @param user $user
	 * @return boolean
	 */
	public function addFriend(user $user){

		$query = "UPDATE `user_friends` SET `id_two_status` = '1'
		WHERE (`accept_id_one` = '$this->id' OR `accept_id_two` = '$this->id') AND (`accept_id_one` = '$user->id' OR `accept_id_two` = '$user->id')";

		if(DB::sql($query)){
			return true;
		}

		return false;

	}

	/**
	 * Selects mutuial friends of given user id with offset for listing
	 * @param int $user_id
	 * @param int $offset
	 * @param int $totalres
	 * @return user on success, false on falure
	 */

	public static function select_true_friend($user_id, $offset = 0, $totalres = 1){

		$query = "SELECT * FROM user_friends
		WHERE (`accept_id_one` = '$user_id' OR `accept_id_two` = '$user_id') AND (`id_one_status` = '1' AND `id_two_status` = '1')
		ORDER BY `date_of_friend` LIMIT $offset, $totalres";

		$result = DB::sql_fetch(DB::sql($query));

		if($result){
			if($result['accept_id_one'] == $user_id){
				$correct_id = $result['accept_id_two'];
			}else{
				$correct_id = $result['accept_id_one'];
			}

			$instance = new self($correct_id);
		}else{
			$instance = false;
		}

		return $instance;

	}

}