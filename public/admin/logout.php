<?php
// injects connection string
session_start();
require_once('../../private/initialize.php');
unset($_SESSION["x5ghy789soci"]);
session_destroy();
header("Location: login.php");
