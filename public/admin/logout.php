<?php
// injects connection string
require_once('../../private/initialize.php');
unset($_SESSION["x5ghy789soci"]);
session_destroy();
header("Location: login.php");
