<?php

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
 * @name User Mailbox Class
 * @package Logos User Layer
 * @version 0.0.1
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @TODO comment dis code yo
 */

class mailbox{

	public $id, $userid, $total_count, $unread;

	public function __construct($uid = null){

		if($uid != null){
			$this->userid = intval($uid);
			$this->loadmailbox();
		}

	}

	public function loadmailbox($uid = null){

		if($uid == null){
			$uid = $this->userid;
		}

		$query = "SELECT * FROM user_mailbox WHERE `uid` = '$uid'";
		$fin = DB::sql_fetch(DB::sql($query));

		$this->id 			= $fin['id'];
		$this->total_count 	= $fin['total_count'];
		$this->unread		= $fin['unread'];

	}

	public function getReadCount(){
		return $this->total_count - $this->unread;
	}
}

?>