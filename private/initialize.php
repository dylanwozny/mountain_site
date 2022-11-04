<!-- This file loads all -->
<?php

// CONSTANT PATHS ON HARD DRIVE
define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/public');
define("INCLUDES_PATH", PRIVATE_PATH . '/includes');

//CONSTANT URL PATHS

// Assign the root URL to a PHP constant
// * Do not need to include the domain
// * Use same document root as webserver
// * Can set a hardcoded value:
// define("WWW_ROOT", '/~kevinskoglund/globe_bank/public');
// define("WWW_ROOT", '');
// * Can dynamically find everything in URL up to "/public"
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);


// truncate custom function
function truncate($text, $chars)
{
    $text = $text . " ";
    if (strlen($text) < $chars) {
        $toBeCont = '';
    } else {
        $toBeCont = "...";
    }
    $text = substr($text, 0, $chars);
    $text = $text . $toBeCont;
    return $text;
}


require_once("functions.php");
