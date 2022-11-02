<?php
session_start();
unset($_SESSION["x5ghy789soci"]);
session_destroy();
header("Location: login.php");
?>