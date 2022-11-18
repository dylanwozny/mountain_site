<!-- this page will not bee seen by user -->
<?php
include ("../includes/logincheck.php");
include ("../includes/header.php");



// GRAB CORRECT ID !!!!!!
// echo "<h2>Delete Character</h2>";

$mtnId = $_GET['mtn_id'];

// no id
if (!isset($mtnId)){
    echo "no id is existing";
    exit();
}

// execute query and redirect back to page
$result = mysqli_query($con, "DELETE FROM dyl_mountains WHERE mtn_id=$mtnId") or die(mysqli_error($con));

// header("Location:index.php");

 echo "<h1> Mountain deleted </h1>";

 ?>

<a class="" href="<?php echo BASE_URL ?>index.php">BACK HOME</a>

 