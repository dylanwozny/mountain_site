<!-- ------ ADMIN DASHBOARD----------- -->
<!--  keep static strings for includes-->
<!-- Load up all functions -->
<?php require_once("../../private/initialize.php");
include(INCLUDES_PATH . "/mysql_connect.php");


// page variables
$page_title = "Admin Dashboard";

// <!-- Load header navigation -->
include(INCLUDES_PATH . "/header.php");
?>

<header>
    <h1><?php echo $page_title ?></h1>
</header>

<section class="bg-light rounded-4 p-4 mb-4">
    <a class="btn btn-primary m-auto p-4 " href="">Add new Mountain</a>
</section>

<?php

// default call to DB
$result = mysqli_query($con, "SELECT * FROM dyl_mountains");
?>

<section class="bg-light rounded-4 p-4 ">
    <h2>Current Mountains</h2>
    <table class="table">
        <thead>
            <tr class="flex-md-row">
                <th scope="col-2">Title</th>
                <th class="col-2">mtn_id</th>
                <th class="col-2">edit</th>
            </tr>
        </thead>
        <tbody>
            <!-- render each row when fetching from SQL -->
            <?php
            while ($row = mysqli_fetch_array($result)) {
                $title = $row['title'];
                $titleTruncate = truncate($title, 15);
                $description = $row['description'];
                $description = truncate($description, 15);
                $mtnImage = $row['mtn_image'];
                $mtnImageGoogle = $row['google_img'];
                $province = $row['province'];
                $verticalRelief = $row['vertical_relief'];
                $verticalRelief = strval($verticalRelief);
                $height = $row['height'];
                $firstSummit = $row['first_summit'];
                $volcano = $row['is_volcano'];
                $access = $row['access'];
                $mtnId = $row['mtn_id'];
            ?>

                <tr>
                    <td scope="row"><?php echo $title ?></td>
                    <td><?php echo $mtnId ?></td>
                    <!-- pass mtn id into url -->
                    <td><a class="btn btn-secondary" href="<?php echo 'pages/edit.php?mtn_id=' . $mtnId ?>">Edit</a></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>


</section>


<!-- load in footer -->
<?php include(INCLUDES_PATH . "/footer.php") ?>