<?php require_once('../../../private/initialize.php');

// page variables
$page_title = "Add New";


include(PRIVATE_PATH . '/includes/header.php');

// include("../includes/logincheck.php");
// sql connect is already in header ! that was why there is a problem before ????
// OLD VALIDATION MESSAGE
$userPrompt = $_GET['message'];
if ($userPrompt) {
    echo "<div class='alert alert-danger'> $userPrompt </div>";
}
echo "<h2>Insert Your Image</h2>";

// If the form has been submitted
// else
if (is_post_request()) {
} else {
    redirect_to('new.php');
}

?>


<?php
include(INCLUDES_PATH . "/footer.php");
?>