<?php require_once('../../../private/initialize.php');

//TEST
//if test else set to ''
$test = $_GET['test'] ?? '';

if ($test == '404') {
    error_404();
} elseif ($test == '505') {
    error_505();
} elseif ($test == 'redirect') {
    redirect_to('../index.php');
} else {
    echo 'no error';
}
