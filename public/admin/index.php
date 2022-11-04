<!-- ------ ADMIN DASHBOARD----------- -->
<!--  keep static strings for includes-->
<!-- Load up all functions -->
<?php require_once("../../private/initialize.php");


// page variables
$page_title = "Admin Dashboard";

// <!-- Load header navigation -->
include(INCLUDES_PATH . "/header.php");
?>

<section>
    <h1><?php echo $page_title ?></h1>
    <ul class="row">
        <li class="">Create New</li>
        <li>Edit</li>

    </ul>
</section>


<!-- load in footer -->
<?php include(INCLUDES_PATH . "/footer.php") ?>