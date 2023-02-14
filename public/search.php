<?php
require_once("../private/initialize.php");

//page vars
$page_title = "Search";

include(INCLUDES_PATH . "/header.php");
?>

<!-- Grab the search term if navbar is used -->
<?php
if (isset($_GET['search-item'])) {
    $searchTerm = $_GET['search-item'];
    //sanitize
    h($searchTerm);
}

?>

<section>
    <header class="d-flex align-items-center mb-4">
        <svg role="img" class="svg-w2" viewBox="0 0 35.997 36.004">
            <path id="Icon_awesome-search-2" data-name="Icon awesome-search" d="M35.508,31.127l-7.01-7.01a1.686,1.686,0,0,0-1.2-.492H26.156a14.618,14.618,0,1,0-2.531,2.531V27.3a1.686,1.686,0,0,0,.492,1.2l7.01,7.01a1.681,1.681,0,0,0,2.384,0l1.99-1.99a1.7,1.7,0,0,0,.007-2.391Zm-20.883-7.5a9,9,0,1,1,9-9A8.995,8.995,0,0,1,14.625,23.625Z" />
        </svg>
        <h2 class="mb-0 ps-2">Search</h2>
    </header>
    <form id="myform" class="" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group pb-3">
            <input type="text" name="search-item" class="form-control" value="<?php if (isset($searchTerm)) {
                                                                                    echo  h($searchTerm);
                                                                                } ?>">
        </div>

        <div class="form-group mb-4">

            <input type="submit" name="submit" class="btn btn-secondary" value="search">
            <label for="submit"></label>
        </div>
    </form>
</section>

<div class="container p-0">
    <div class="p-0 d-flex justify-content-start gap-3 flex-wrap">

        <!--  OR first_summit LIKE '%$searchTerm%' -->
        <?php

        // when search button is clicked
        if (is_post_request()) {
            // grab search item from text field
            $searchTerm = $_POST['search-item'];
            // if there is a value in field
        }
        ?>
    </div>
</div>

<?php
// call Search function
// catch user message in variable
$userPrompt = search_create_list($searchTerm);



// user message
if (isset($userPrompt)) {
    echo "<div class='alert alert-primary'>$userPrompt</div>";
}
include(INCLUDES_PATH . "/footer.php");

?>