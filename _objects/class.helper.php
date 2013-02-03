<?php

/**
 * Version Changelog
 * 0.0.1 - Initial Version
 * 0.0.2 - Added Time Conversions and tried to improve memory usage
 * 0.0.3 - Removed "Object" Associasion
 *
 */

/**
 * @name Helper Class
 * @package Logos Helper Layer
 * @version 0.0.3
 * @copyright (c) 2012 Mathew Kleppin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/*
 * Contains any methods used throughout multiple different pages that are globally defined
 * Loaded in class.database.php
 */

/**
 * Returns the mysql_real_escape_string version of the input string
 * @access public
 * @return string
 */
function clean($var = ''){
	return mysql_real_escape_string($var);
}

/**
 * Returns the htmlspecialcharacters version of the input string
 * @access public
 * @return string
 */
function scrub($var = ''){
	return htmlspecialchars($var);
}

/**
 * Trys to clean and scrub a var, and returns it afterwards
 * @access public
 * @return string
 */
function shine($var = ''){
	return clean(scrub($var));
}

/**
 * Converts a timestamp into a readable time
 * @param unknown_type $timestamp
 * @return Ambigous <string, number>
 */
function convertTime($timestamp){

	$timeElapsed = strtotime($timestamp);

	if(time()-$timeElapsed < 166400){
		$timeElapsed = humanTiming($timeElapsed)." ago";
	}else{
		$timeElapsed = date("M j",$timeElapsed);
	}

	return $timeElapsed;
}

/**
 * Converts a timestamp into a readable time
 * @param unknown_type $timestamp
 * @return Ambigous <string, number>
 */
function humanTiming($time){

	$time = time() - $time; // to get the time since that moment

	$tokens = array (
			31536000 => 'y',
			2592000 => 'm',
			604800 => 'w',
			86400 => 'd',
			3600 => 'hr',
			60 => 'min',
			1 => 'sec'
	);

	foreach ($tokens as $unit => $text) {
		if ($time < $unit) continue;
		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
	}

}


?>