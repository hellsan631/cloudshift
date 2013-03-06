<?php

include '../class.database.config.php';

function db_connect(){
  $config = new config();

  $link = mysql_connect($config->host, $config->username, $config->password);
  if(!$link){
    exit('Could not connect to database: '. mysql_error());
  }

  $selected = mysql_select_db($config->database);
  if(!$selected){
    exit("Could not select database '$config->database'");
  }
}

function db_connect_link(){
  $config = new config();

  $link = mysql_connect($config->host, $config->username, $config->password);
  if(!$link){
    exit('Could not connect to database: '. mysql_error());
  }

  $selected = mysql_select_db($config->database);
  if(!$selected){
    exit("Could not select database '$config->database'");
  }

  return $link;
}



?>