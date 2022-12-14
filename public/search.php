<?php
require_once("../private/initialize.php");

//page vars
$page_title = "Search";

include(INCLUDES_PATH . "/header.php");
?>

<section class="search-container">
    <h2>Search Mountains</h2>
    <form id="myform" class="" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
            <input type="text" name="search-item" class="form-control">
        </div>

        <div class="form-group">
            <label for="submit">&nbsp;</label>
            <input type="submit" name="submit" class="green-button" value="search">
        </div>
    </form>
</section>

<!--  OR first_summit LIKE '%$searchTerm%' -->


<?php

$userPrompt = '';
// when search button is clicked
if (is_post_request()) {
    // grab search item from text field
    $searchTerm = $_POST['search-item'];
    // if there is a value in field
    if ($searchTerm) {
        //------------- function for sql search ------------//
        $result = search_mtn($searchTerm);

        // if no rows are returned. no results
        if (!mysqli_num_rows($result)) {
            $userPrompt = "no results";
            // while rows returned are greater than 0
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo print_r($row);
                $title = h($row['title']);
                $description = h($row['description']);
                $firstSummit = h($row['first_summit']);
                $access = h($row['access']);
                $province = h($row['province']);
                $mtnId = h(u($row['mtn_id']));
                $height = h($row['height']);
                $vertical = h($row['vertical_relief']);
                $vertical = h(strval($vertical));
                $mtnImage = h((string)$row['mtn_image']);

                echo "\n<div class='jumbotron row'>";
                echo "\n<div class='col-md-4'>";
                echo "\n\t<h3>$title</h3>";
                echo "\n\t<p class=\"description\">Description: $description</p>";
                echo "\n\t<p>First Summit: $firstSummit </p>";
                echo "\n\t<p>Access Type: $access</p>";
                echo "\n\t<p>Province: $province </p>";
                echo "\n\t<p>Height: $height</p>";
                echo "\n\t<p>Vertical Relief: $vertical</p>";
                echo "\n\t<a href=\"page.php?mtn_id=$mtnId\">View Mountain Page</a>";
                echo "\n</div>";
                echo "\n<div class='col-md-8'>";
                echo "<img src=\"uploads/display/$mtnImage\" class=\"\" /><br/>\n";
                echo "\n</div>";
                echo "\n</div>";
            }
        }
    } else {

        $userPrompt = "please search something before submitting";
    }
} else {
    $searchTerm = "";
}

// user message
if ($userPrompt) {
    echo "<div class='alert alert-primary'>$userPrompt</div>";
}
include(INCLUDES_PATH . "/footer.php");

?>