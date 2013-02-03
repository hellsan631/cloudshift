<?php

/**
 * Version Changelog
 * 0.0.1 - Initial Version
 * 0.0.2 - Tried to mprove memory usage
 *
 */

/**
 * @name Error Helper Class
 * @package Logos Helper Layer
 * @version 0.0.2
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/*
 * Loaded in class.database.php
 */

/**
 * Error exits, displaying the error on screen
 * @access public
 * @return none
 */
function error($m = '', $t = null){
	if($t == 'MYSQL'){
		exit($m.' '.mysql_errno().' '.mysql_error());
	}else{
		exit($m);
	}
}

/**
 * Fail echos the error first (might be more AJAX safe), before exiting
 * @access public
 * @return none
 */
function fail($m = '', $t = null){
	error($m,$t);
}

/**
 * Tryquit will just echo the error and continue executing the script
 * @access public
 * @return none
 */
function tryquit($m = '', $t = null){
	if($t == 'MYSQL'){
		echo($m.' '.mysql_errno().' '.mysql_error());
	}else{
		echo($m);
	}
}

?>