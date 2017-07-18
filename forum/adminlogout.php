<?php
//normal
session_start();
unset($_SESSION['ADMIN']);
require ("config.php");
header("Location:".$config_basedir);
?>