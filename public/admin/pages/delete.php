<?php
require_once("../../../private/initialize.php");

// page variables
$page_title = "delete Mountain";

include(PRIVATE_PATH . '/includes/header.php');


// if (!(isset($_SESSION["x5ghy789soci"]))) {
//     redirect_to(WWW_ROOT . "/index.php");
// }
// GRAB CORRECT ID !!!!!!
// echo "<h2>Delete Character</h2>";
$mtnId = $_GET['mtn_id'];

// no id
// if (!isset($mtnId)) {
//     echo "no id is existing";
//     redirect_to('../index.php');
// }

//-----------------grab name of mountain---------------------
$mtnData = find_mtn($mtnId);


//-----------------Run Delete query---------------------
if (is_post_request()) {

    $deleteResult = delete_mountain($mtnId);
}

?>
<div class="d-flex align-items-center mb-2 ">
    <svg class="svg-w2 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25.064 30.849">
        <path id="Icon_metro-bin" data-name="Icon metro-bin" d="M6.427,11.568v19.28a1.934,1.934,0,0,0,1.928,1.928H25.707a1.934,1.934,0,0,0,1.928-1.928V11.568H6.427Zm5.784,17.352H10.283v-13.5h1.928Zm3.856,0H14.139v-13.5h1.928Zm3.856,0H17.995v-13.5h1.928Zm3.856,0H21.851v-13.5h1.928ZM28.117,5.784H21.851V3.374a1.45,1.45,0,0,0-1.446-1.446H13.657a1.45,1.45,0,0,0-1.446,1.446v2.41H5.945A1.45,1.45,0,0,0,4.5,7.23V9.64H29.563V7.23a1.45,1.45,0,0,0-1.446-1.446Zm-8.194,0H14.139V3.88h5.784v1.9Z" transform="translate(-4.499 -1.928)" />
    </svg>

    <h2 class="mb-0">Delete</h2>
</div>
<a class="back-link mb-0 fs-6 d-block" href="<?php echo BASE_URL ?>public/admin/index.php">&laquo; BACK HOME</a>


<p class="fst-italic fs-5 mb-3">Are you sure you want to delete <span class="fs-4 fst-italic fw-bold"><?php echo h($mtnData['title']) ?>?</span></p>
<form class="d-flex " action="<?php echo "delete.php?mtn_id=" . h(u($mtnData['mtn_id'])); ?>" method="POST">
    <input class=" btn btn-danger me-5" type="submit" name="commit" value="Delete">
    <a class="btn btn-outline-secondary" href="<?php echo BASE_URL ?>public/admin/index.php">Cancel</a>
</form>


<?php include(INCLUDES_PATH . "/footer.php"); ?>