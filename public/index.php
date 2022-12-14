<!-- // 1 ------ u() check for escape values on each db value submitted --------
// 2 ------- follow admin page function query structure -------
// 3 ------ update filtering options to return new values ------ -->
<?php
require_once("../private/initialize.php");


//page vars
$page_title = "Home Page";

// <!-- Load header navigation -->
include(INCLUDES_PATH . "/header.php");



//---------default call to DB------------
$result = find_all_mtns();

// FILTERING YOUR DB
// $displayby = $_GET['displayby'];
// $displayvalue = $_GET['displayvalue'];

// if (isset($displayby) && isset($displayvalue)) {
//   // HERE IS THE MAGIC: WE TELL OUR DB WHICH COLUMN TO LOOK IN, AND THEN WHICH VALUE FROM THAT COLUMN WE'RE LOOKING FOR
//   $result = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE $displayby LIKE '$displayvalue' ") or die(mysqli_error($con));
// }

// $heightLow = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE height BETWEEN 1 AND 2000 LIMIT 2");
// while ($row = mysqli_fetch_array($heightLow)) {
//   $title = $row['title'];
//   $mtnId = $row['mtn_id'];
// }
?>

<div class="clearfix">
  <h1><?php echo APP_NAME ?></h1>
  <div class="underline-center"></div>
</div>

<!-- FINISH INTRO -->
<header class="front-about-p">
  <p>Welcome to my Application ! I hope you find it somewhat useful. I wanted to create an app about my favourite feature of nature: Mountains !I have chosen to create a catalog of mountain peaks in Canada. I chose this topic because I love visiting Jasper and Banff and have been fascinated by mountains ever since I was a child. I also like to compare mountain stats like height, vertical relief etc. to each other just for fun.Information fields pertaining to the mountains will include: thumbnail picture, name, description,province, vertical relief, elevation profile, height, first summit, access type(vehicle, hiking, helicopter),and if it is a volcano and a google earth image of elevation. Search categories can include province,volcano etc. This information will be stored in a MySQL database.The structure of this application includes a useful homepage, search functionality, edit and delete options , which are secured by an admin log in and individual pages that display all information about that specific chosen mountain. Category links will also appear on the homepage.</p>
</header>

<div class="jumbotron categories row">

  <!---------- category filtering ---------->
  <div class="col-md-6">
    <h2>Mountain List</h2>
    <span class="fw-light fs-2">Sort By</span>
    <ul class="categories-flex">
      <li><a href="index.php">all Mountains</a></li>
      <li><a href="index.php?displayby=access&displayvalue=hike">Hiking Access</a></li>
      <li><a href="index.php?displayby=province&displayvalue=ab">Alberta Mountains</a> </li>
      <li><a href="index.php?displayby=is_volcano&displayvalue=1">Volcanos</a> </li>
    </ul>
  </div>
  <div class="col-md-6 mtn-height">
    <?php
    // echo "<h2>2500m to 5000m high </h2>";
    // $heightLow = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE height BETWEEN 2500 AND 5000 LIMIT 4");
    // while ($row = mysqli_fetch_array($heightLow)) {
    //   $title = $row['title'];
    //   $mtnId = $row['mtn_id'];
    //   echo "<div><a href=\"page.php?mtn_id=$mtnId\"><p>" . $title . "</p></a></div>";
    // }
    // -------- filter height and render html ----------
    filter_Height("<h2>3000m to 4000m high </h2>", 3000, 4000);
    ?>

  </div>
</div>



<div class="row">
  <?php
  while ($row = mysqli_fetch_array($result)) {
    $title = $row['title'];
    $titleTruncate = truncate($title, 15);
    $description = $row['description'];
    $description = truncate($description, 15);
    // cast to string to be sanitized
    $mtnImage = (string)$row['mtn_image'];
    //sanitize here
    h($mtnImage);
    $mtnImageGoogle = $row['google_img'];
    $province = $row['province'];
    $height = $row['height'];
    $mtnId = $row['mtn_id'];

  ?>

    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img class="mtn-card-gradient" src="<?php echo "uploads/thumbnails/" .  h($mtnImage) ?>" alt="">
        </div>
      </div>


    <?php


    echo "<div class=\"thumb col-md-6\">\n";

    // echo "<img src=\"uploads/thumbnails/$mtnImage\" class=\"\" /><br/>\n";

    echo "<h3 class=\"displayCategory\"></span> <span class=\"displayInfo\">" . h($title) . "</h3>\n";
    echo "<div class=\"displayCategory\">Description:</span> <span class=\"displayInfo\">" . h($description) . "</div>\n";
    echo "<div class=\"displayCategory\">Province:</span> <span class=\"displayInfo\">" . h($province) . "</div>\n";
    echo "<div class=\"displayCategory\">Height:</span> <span class=\"displayInfo\">" . h($height) . "</div>\n";


    // CREATE A "detail.php" PAGE FOR A SINGLE ITEM VIEW; SHOW ALL INFO
    echo "<a href=page.php?mtn_id=" .  h(u($mtnId)) . ">More info...</a><br />";

    echo "</div>";
  }
    ?>

    </div>

    <?php

    include(INCLUDES_PATH . "/footer.php");
    ?>