<?php 

function clean($var){
	return mysql_real_escape_string($var);
}

?>