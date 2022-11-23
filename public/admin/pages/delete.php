<!-- this page will not bee seen by user -->
<?php
// include ("../includes/logincheck.php");
require_once("../../../private/initialize.php");

// page variables
$page_title = "delete Mountain";

include(INCLUDES_PATH .  "./header.php");

// GRAB CORRECT ID !!!!!!
// echo "<h2>Delete Character</h2>";
$mtnId = $_GET['mtn_id'];

// no id
if (!isset($mtnId)) {
    echo "no id is existing";
    redirect_to('../index.php');
}

//-----------------grab name of mountain---------------------
$mtnData = find_mtn($mtnId);


//-----------------Run Delete query---------------------
if (is_post_request()) {
    delete_mountain($mtnId);
}

?>

<a class="" href="<?php echo BASE_URL ?>public/admin/index.php">BACK HOME</a>

<h2>Delete</h2>
<p class="">Are you sure you want to delete:
<p>
<p><?php echo h($mtnData['title']) ?></p>
<form action="<?php echo "delete.php?mtn_id=" . h(u($mtnData['mtn_id'])); ?>" method="POST">
    <input class=" btn btn-danger" type="submit" name="commit" value="Delete Mountain">
</form>
<a class="btn btn-secondary" href="<?php echo BASE_URL ?>public/admin/index.php">Cancel</a>

<!-- <?php include(INCLUDES_PATH . "/footer.php"); ?> -->