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

<header class="d-flex align-items-center mb-4">
    <svg xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 54.894 54.894">
        <path id="Icon_material-dashboard" data-name="Icon material-dashboard" d="M4.5,35H28.9V4.5H4.5Zm0,24.4H28.9V41.1H4.5Zm30.5,0h24.4V28.9H35ZM35,4.5V22.8h24.4V4.5Z" transform="translate(-4.5 -4.5)" />
    </svg>

    <h1 class="ps-3 "><?php echo $page_title ?></h1>
</header>

<section class="admin-new bg-light rounded-4 p-4 mb-4 shadow-lg d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center justify-content-between">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.813 39.813">
            <path id="Icon_awesome-plus" data-name="Icon awesome-plus" d="M36.969,20.328h-12.8V7.531a2.844,2.844,0,0,0-2.844-2.844H18.484a2.844,2.844,0,0,0-2.844,2.844v12.8H2.844A2.844,2.844,0,0,0,0,23.172v2.844a2.844,2.844,0,0,0,2.844,2.844h12.8v12.8A2.844,2.844,0,0,0,18.484,44.5h2.844a2.844,2.844,0,0,0,2.844-2.844v-12.8h12.8a2.844,2.844,0,0,0,2.844-2.844V23.172A2.844,2.844,0,0,0,36.969,20.328Z" transform="translate(0 -4.688)" />
        </svg>
        <p class="fs-4 mb-0 text-capitalize ps-3">New Mountain</p>
    </div>
    <a class="btn btn-primary text-capitalize" href="../admin/pages/new.php">Add</a>
</section>

<?php
// --------call to DB function-------
$result = find_all_mtns();
?>

<section class="bg-light rounded-4 shadow-lg">
    <h2 class="p-3">Current Mountains</h2>
    <table class="table">
        <thead class="bg-dark text-light p-3">
            <tr class="flex-md-row">
                <th class="table-mtn__head--pl" scope="col-2 ">Title</th>
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
                    <td class="table-mtn__head--pl" scope="row"><?php echo h($title); ?></td>
                    <td><?php echo h($height) . "m"; ?></td>
                    <!-- pass mtn id into url -->
                    <td><a class="btn btn-secondary" href="<?php echo 'pages/edit.php?mtn_id=' . h(u($mtnId)); ?>">Edit</a></td>
                </tr>

            <?php }
            // remove from memory. good practice. Not required.

            ?>
        </tbody>
    </table>
</section>


<!-- load in footer -->
<?php include(INCLUDES_PATH . "/footer.php") ?>