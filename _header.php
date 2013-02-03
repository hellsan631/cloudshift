<?php
session_start();
require_once "includes/database.php";
db_connect();
require_once "includes/auth.php";
include_once "functions/funks.php";

global $cuser; $cuser = current_user();
global $self; $self = true;
// Call require_login() if needed
// This must be done before any output is sent
// because a header() based redirect is used
if(isset($login_required)){
  require_login();
}
?>
