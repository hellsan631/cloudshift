<?php

/**
 * @name Main Database Class
 * @package Logos Database Layer
 * @version 0.0.1
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */
if (!defined('LOGOS'))
{
	exit;
}

include_once LOGOS_ROOT_PATH.'config.php';

/**
 * MySQL4 Database Abstraction Layer
 * Compatible with:
 * MySQL 3.23+
 * MySQL 4.0+
 * MySQL 4.1+
 * MySQL 5.0+
 * @package Logos Database Layer
 */

class db extends config{
	
	//the database connection settings
	private $dbhost = 'localhost';
	private $dbusername = '';
	private $dbpassword = '';
	private $dbname = 'database';
	private $dbtype = 'mysql'; //mysqli should be passable
	
	//database updated config
	private static $config = config;
	
	//database return settings
	public $link; //the db link
	private $selected; //selected db
	private $secure = FALSE;
	
	/**
	 * Database Constrution method
	 * @access public
	 */
	function __construct(){
		if($this->secure === FALSE){
			try {
				
				$this->setup();
				
				$query = "SELECT key FROM `dbsecure`";
				
				$result = $this->sql_query($query);
				
				if (!$result) {
					throw 'No Key Found';
				}
				
				if($config::securestring != $this->sql_fetchrow($result['key'])){
					throw 'Incorrect Key';
				}
				
				self::sql_close();
				$this->secure = TRUE;
				
			} catch (Exception $e) {
				$this->sql_err($e, $this->link);
			}
		}elseif($this->secure === TRUE){
			$this->setup();
			$this->define_ends();
		}
	}
	
	
	/**
	 * Runs the 3 functions needed to start a DB_Link
	 * @access private
	 */
	private function setup(){
		$this->sql_config();
		$this->sql_connect();
		$this->sql_select();
	}
	
	/**
	 * Connects to the DB
	 * @access private
	 */
	private function sql_connect(){
		
		$this->link = @mysql_connect($this->dbhost, $this->dbusername, $this->dbpassword);
		
		if(!$this->link){
			$this->sql_err('Could not connect to database');
		}
	}
	
	/**
	 * Selects the DB
	 * @access protected
	 */
	protected function sql_select(){
		
		$this->selected = @mysql_select_db($this->dbname);
		
		if(!$this->selected){
			$this->sql_err('Could not select database');
		}
		
	}
	
	/**
	 * Returns the row result from a MYSQL Result Object
	 * @access public
	 * @return FALSE if query failed, object upon success
	 */
	public function sql_fetchrow($result){
		return @mysql_fetch_assoc($result);
	}
	
	/**
	 * Shortend version of mysql query done on the database, doesn't need the link.
	 * @access public
	 * @return FALSE if query failed, object upon success
	 */
	public function sql_q($query){
		return $this->sql_query($query);
	}
	
	/**
	 * Query's the database
	 * @access public
	 * @return FALSE if query failed, object upon success
	 */
	public function sql_query($query){
		return @mysql_query($query, $this->link);
	}
	
	/**
	 * Initiate the database object
	 * @access public
	 */
	public static function sql_close($link = self::link){
		mysql_close($link);
	}
	
	/**
	 * On an error within the database class, this will close the mysql link.
	 * @access private
	 */
	private function sql_err($errorTxt = null, $link = self::link){
		
		$errorstring = $errorTxt.' '.mysql_error($link);
		self::sql_close($link);
		exit($errorstring);
		
	}
	
	/**
	 * Defines the database link with 'DB_LINK'
	 * @access private
	 */
	private function define_ends(){
		define('DB_LINK', $this->link);
	}
	
	/**
	 * Configures the object's variables to connect to a database
	 * @access protected
	 */
	protected function sql_config(){

		$this->dbhost 		= $config::host;
		$this->dbusername 	= $config::username;
		$this->dbpassword   = $config::password;
		$this->dbname 	 	= $config::dbname;
			
	}
	
}

?>