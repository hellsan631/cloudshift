<?php

/**
 * Version Changelog
 * 0.0.1 - Initial Version
 * 0.0.2 - Ability to Write, Read, and Display/Print messages
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
 * @name User Message Class
 * @package Logos User Layer
 * @version 0.0.2
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @TODO comment dis code yo
 */

class mail_msg{

	public $id;
	public $author_id;
	public $author_ip;
	public $to_id;
	public $message_time;
	public $message_subject;
	public $message_text;
	public $message_reported;
	public $message_state;
	public $author_username;
	public $to_username;

	//converted elements
	public $avatar;
	public $time;
	public $state;

	public function __construct($id = null){

		if($id == null){
			$this->id 				= null;
			$this->author_id 		= null;
			$this->author_ip		= null;
			$this->author_username 	= null;
			$this->to_id 			= null;
			$this->message_time		= null;
			$this->message_subject	= null;
			$this->message_text		= null;
			$this->message_state	= null;
			$this->message_reported = null;
			$this->to_username		= null;
		}else{
			$this->id = intval($id);
			$this->loadmail_msg();
		}

	}

	public static function send_message(user $to_user, user $from_user, $subject, $text){

		$instance = new self();

		$instance->author_id = $from_user->id;
		$instance->to_id = $to_user->id;
		$instance->message_subject =  clean($subject);
		$instance->message_text =  clean($text);
		$instance->author_ip = $_SERVER['REMOTE_ADDR'];
		$instance->author_username = $from_user->username;
		$instance->to_username = $to_user->username;

		log::write_new_log($instance->author_id, "Sent <b>$instance->to_username</b> a message.", 0);

		return $instance->write_msg();

	}

	public function write_msg(){

		$query = "INSERT INTO user_mail_messages ( `author_id` , `author_ip` , `to_id` , `message_subject`, `message_text`, `author_username`, `to_username`)
		VALUES ('$this->author_id', '$this->author_ip', '$this->to_id', '$this->message_subject', '$this->message_text', '$this->author_username', '$this->to_username')";

		if(DB::sql($query)){

			return true;
		}

		return false;
	}

	public function loadmail_msg($id = null){

		if($id == null){
			$id = $this->id;
		}

		$query = "SELECT * FROM user_mail_messages WHERE `id` = '$id'";
		$fin = DB::sql_fetch(DB::sql($query));

		$this->load_instance($fin);

	}

	public static function load_instance($instance, $arrayObject){

		$instance->id 				= $arrayObject['id'];
		$instance->author_id 		= $arrayObject['author_id'];
		$instance->author_ip		= $arrayObject['author_ip'];
		$instance->author_username 	= $arrayObject['author_username'];
		$instance->to_id 			= $arrayObject['to_id'];
		$instance->message_time		= $arrayObject['message_time'];
		$instance->message_subject	= $arrayObject['message_subject'];
		$instance->message_text		= $arrayObject['message_text'];
		$instance->message_state	= $arrayObject['message_state'];
		$instance->message_reported = $arrayObject['message_reported'];
		$instance->to_username		= $arrayObject['to_username'];

		return $instance;

	}

	public function load_self($arrayObject){
		$this->id 				= $arrayObject['id'];
		$this->author_id 		= $arrayObject['author_id'];
		$this->author_ip		= $arrayObject['author_ip'];
		$this->author_username 	= $arrayObject['author_username'];
		$this->to_id 			= $arrayObject['to_id'];
		$this->message_time		= $arrayObject['message_time'];
		$this->message_subject	= $arrayObject['message_subject'];
		$this->message_text		= $arrayObject['message_text'];
		$this->message_state	= $arrayObject['message_state'];
		$this->message_reported = $arrayObject['message_reported'];
		$this->to_username		= $arrayObject['to_username'];
	}

	public static function get_outbox($user_id, $offset = 0, $totalres = 1){

		$instance = new self();
		$instance->author_id = intval($user_id);

		$query = "SELECT * FROM user_mail_messages WHERE `author_id` = '$instance->author_id' ORDER BY `message_time` LIMIT $offset, $totalres";

		$result = DB::sql_fetch(DB::sql($query));

		$instance = self::load_instance($instance, $result);

		return $instance;

	}

	public static function print_outbox($user_id, $offset = 0, $totalres = 1){

		$instance = self::get_outbox($user_id, $offset, $totalres);
		$instance->time =  convertTime($instance->message_time);
		$instance->avatar = self::getUserAvatarByID($instance->to_id);

		if($instance->message_state == 0){
			$instance->state = "unread";
		}else{
			$instance->state = "";
		}

		return $instance;

	}

	public static function get_inbox($user_id, $offset = 0, $totalres = 1){

		$instance = new self();
		$instance->to_id = intval($user_id);

		$query = "SELECT * FROM user_mail_messages WHERE `to_id` = '$instance->to_id' ORDER BY `message_time` LIMIT $offset, $totalres";

		$result = DB::sql_fetch(DB::sql($query));

		$instance = self::load_instance($instance, $result);

		return $instance;

	}

	public static function print_inbox($user_id, $offset = 0, $totalres = 1){

		$instance = self::get_inbox($user_id, $offset, $totalres);
		$instance->time =  convertTime($instance->message_time);
		$instance->avatar = self::getUserAvatarByID($instance->author_id);

		if($instance->message_state == 0){
			$instance->state = "unread";
		}else{
			$instance->state = "";
		}

		return $instance;

	}

	public static function delete_msg($id = null){

		if($id == null){
			$id = $this->id;
		}

		$query = "DELETE FROM user_mail_messages WHERE `id` ='$id'";

		$result = @DB::sql($query);

		if($result){
			return true;
		}

		return false;
	}

	public static function unmessage($id = null){

		if($id == null){
			$id = $this->id;
		}

		$instance = new self($id);

		if($instance->author_id != -1){

			$query = "UPDATE user_mail_messages SET `to_id` = '-1' WHERE `id` ='$id'";

			$result = @DB::sql($query);

			if($result){
				return true;
			}

			return false;

		}else{
			return $instance::delete_msg();
		}

	}

	public static function unsend($id = null){

		if($id == null){
			$id = $this->id;
		}

		$instance = new self($id);

		if($instance->to_id != -1){

			$query = "UPDATE user_mail_messages SET `author_id` = '-1' WHERE `id` ='$id'";

			$result = @DB::sql($query);

			if($result){
				return true;
			}

			return false;

		}else{
			return $instance::delete_msg();
		}

	}


	public static function read_msg($id = null){

		if($id == null){
			$id = $this->id;
		}

		$query = "UPDATE user_mail_messages SET `message_state` = '1' WHERE `id` ='$id'";

		$result = @DB::sql($query);

		if($result){
			return true;
		}

		return false;

	}

	public static function getUserAvatarByID($user_id){

		$query = "SELECT avatar
		FROM `users`
		WHERE `id` = '$user_id'";

		$result = DB::sql_fetch(DB::sql($query));

		if($result){
			return $result['avatar'];
		}

		return false;
	}

}