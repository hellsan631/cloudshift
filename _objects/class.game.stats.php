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
require_once ROOT_PATH.CLASS_PATH.'class.mailbox.php';

/**
 * @name Main Game Stats Class
 * @package Logos User Layer
 * @version 0.0.1
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @TODO comment dis code yo
 * @TODO further performance optmization, reduceing memory usage and number of database calls
 */

class game_stats{

	public function __construct(){

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
}