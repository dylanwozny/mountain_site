<?php

use function PHPSTORM_META\type;

require_once('../../../private/initialize.php');

// page variables
$page_title = "Add New";


include(PRIVATE_PATH . '/includes/header.php');

// include("../includes/logincheck.php");
// sql connect is already in header ! that was why there is a problem before ????
// OLD VALIDATION MESSAGE
// $userPrompt = $_GET['message'];
// if ($userPrompt) {
//     echo "<div class='alert alert-danger'> $userPrompt </div>";
// }
// echo "<h2>Insert Your Image</h2>";

// If the form has been submitted
// else

if (is_post_request()) {

    //----------------------------------------
    //-----------------Grab values from form---------------------
    //----------------------------------------
    $thisTitle = $_POST['title'];
    $thisDescription = $_POST['description'];
    $thisProvince = $_POST['province'];

    $thisVerticalRelief = $_POST['vertical-relief'];
    $thisHeight = $_POST['height'];
    $thisHeight = (int)$thisHeight;
    $thisSummit = $_POST['first-summit'];
    $thisSummit = (int)$thisSummit;

    $thisAccess = $_POST["access"];
    $thisIsVolcano = $_POST['is-volcano'];
    $thisIsVolcano = (int)$thisIsVolcano;
    //----------------------------------------------
    // ----------VALIDATION SERVER SIDE------------
    //----------------------------------------------
    // putting in temp name for image files 
    $checkImgG = $_FILES['file-g']['tmp_name'];
    $checkImgM = $_FILES['file-m']['tmp_name'];
    // Validation pass flag
    $validPass = 0;

    // echo gettype($thisTitle) . "<br/>";
    // echo gettype($thisDescription) . "<br/>";
    // echo gettype($thisProvince) . "<br/>";
    // echo gettype($thisVerticalRelief) . "<br/>";
    // echo gettype($thisHeight) . "<br/>";
    // echo gettype($thisSummit) . "<br/>";
    // echo gettype($thisAccess) . "<br/>";
    // echo gettype($thisIsVolcano) . "<br/>";
    // echo gettype($checkImgG) . "<br/>";
    // echo gettype($checkImgM) . "<br/>";



    $result = insert_mountain($thisTitle, $thisDescription, $thisProvince, $thisVerticalRelief, $thisHeight, $thisSummit, $thisAccess, $thisIsVolcano, $checkImgM, $checkImgG);
    $new_id = mysqli_insert_id($con);
    redirect_to(WWW_ROOT . "/page.php?mtn_id=" . $new_id);
} else {
    redirect_to("new.php");
}

?>


<?php
include(INCLUDES_PATH . "/footer.php");
?>