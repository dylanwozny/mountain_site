<!-- ------ ADMIN DASHBOARD----------- -->
<!--  keep static strings for includes-->
<!-- Load up all functions -->
<?php require_once("../../private/initialize.php");
// include(INCLUDES_PATH . "/mysql_connect.php");


// page variables
$page_title = "Admin Dashboard";

// <!-- Load header navigation -->
include(INCLUDES_PATH . "/header.php");
?>

<header>
    <h1><?php echo $page_title ?></h1>
</header>

<section class="bg-light rounded-4 p-4 mb-4">
    <a class="btn btn-primary m-auto p-4 " href="../admin/pages/new.php">Add new Mountain</a>
</section>

<?php
// --------call to DB function-------
$result = find_all_mtns();

?>

<section class="bg-light rounded-4 p-4 ">
    <h2>Current Mountains</h2>
    <table class="table">
        <thead>
            <tr class="flex-md-row">
                <th scope="col-2">Title</th>
                <th class="col-2">Height</th>
                <th class="col-2">Edit</th>
            </tr>
        </thead>
        <tbody>
            <!-- render each row when fetching from SQL -->
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row['title'];
                $titleTruncate = truncate($title, 15);
                // $description = $row['description'];
                // $description = truncate($description, 15);
                // $mtnImage = $row['mtn_image'];
                // $mtnImageGoogle = $row['google_img'];
                // $province = $row['province'];
                // $verticalRelief = $row['vertical_relief'];
                // $verticalRelief = strval($verticalRelief);
                $height = $row['height'];
                // $firstSummit = $row['first_summit'];
                // $volcano = $row['is_volcano'];
                // $access = $row['access'];
                $mtnId = $row['mtn_id'];
            ?>

                <tr>
                    <td scope="row"><?php echo h($title); ?></td>
                    <td><?php echo h($height) . "m"; ?></td>
                    <!-- pass mtn id into url -->
                    <td><a class="btn btn-secondary" href="<?php echo 'pages/edit.php?mtn_id=' . h(u($mtnId)); ?>">Edit</a></td>
                </tr>

            <?php }
            // remove from memory. good practice. Not required.
            mysqli_free_result($result);
            ?>
        </tbody>
    </table>
</section>


<!-- load in footer -->
<?php include(INCLUDES_PATH . "/footer.php") ?>