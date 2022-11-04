<?php
require_once("../private/initialize.php");
include(INCLUDES_PATH . "/header.php");
include(INCLUDES_PATH . "/mysql_connect.php");

$searchTerm = $_POST['search-item'];
$userPrompt = '';
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
if ($searchTerm != "") {
    $sql = "SELECT * FROM dyl_mountains WHERE title LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%' OR first_summit LIKE '%$searchTerm%' OR access LIKE '%$searchTerm%' or province LIKE '%$searchTerm%' or height LIKE '%$searchTerm%' or vertical_relief LIKE '%$searchTerm%'";

    $result = mysqli_query($con, $sql) or die(mysqli_error($con));

    while ($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $description = $row['description'];
        $firstSummit = $row['first_summit'];
        $access = $row['access'];
        $province = $row['province'];
        $mtnId = $row['mtn_id'];
        $height = $row['height'];
        $vertical = $row['vertical_relief'];
        $vertical = strval($vertical);
        $mtnImage = $row['mtn_image'];

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
} else {

    $userPrompt = "please search something before submitting";
}


if ($userPrompt) {
    echo "<div class='alert alert-primary'>$userPrompt</div>";
}
include(INCLUDES_PATH . "/footer.php");

?>