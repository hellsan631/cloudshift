<?php

	/**
	 * @name Database Configurations File
	 * @package Logos Database Layer
	 * @version 0.0.1
	 * @copyright (c) 2012 Mathew Kleppin
	 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
	 *
	 */

	class config{

		//database access settings (should improve this with inclusion of 'port')
		protected static $host     = "localhost";
		protected static $username = "admin";
		protected static $password = "hellsan631";
		protected static $database = "logos";
		
		//secure string to look for inside the DB
		protected static $securestring = "f2f76cd60f0e6a91e54c5f621bd8fc860d044bd595e6e76a0926a77dda93414836652cdddcd5470db2c0eb41f6142387d2e4f1f58a476ed1689a3bfa7dbc9d12";
	}

?>