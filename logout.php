<?php
session_start();
unset($_SESSION['user_id']);
if(isset($_SESSION['redirect_to'])){unset($_SESSION['redirect_to']);}
session_unset();
session_destroy();
header("Location: login.php");
?>