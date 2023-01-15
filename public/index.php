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
<header class="justify-content-between banner front-about-p d-flex flex-wrap">
  <p class="banner__intro">Welcome to my Application ! I hope you find it somewhat useful. I wanted to create an app about my favourite feature of nature: Mountains !I have chosen to create a catalog of mountain peaks in Canada. I chose this topic because I love visiting Jasper and Banff and have been fascinated by mountains ever since I was a child. I also like to compare mountain stats like height, vertical relief etc. to each other just for fun.Information fields pertaining to the mountains will include: thumbnail picture, name, description,province, vertical relief, elevation profile, height, first summit, access type(vehicle, hiking, helicopter),and if it is a volcano and a google earth image of elevation. Search categories can include province,volcano etc. This information will be stored in a MySQL database.The structure of this application includes a useful homepage, search functionality, edit and delete options , which are secured by an admin log in and individual pages that display all information about that specific chosen mountain. Category links will also appear on the homepage.</p>
  <?php if (!(isset($_SESSION["x5ghy789soci"]))) { ?>
    <div class="banner__login text-center flex-grow-0 rounded-3 shadow p-5 align-self-start">
      <svg id="Icon_open-account-login" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 36 31.5">
        <path id="Icon_open-account-login-2" data-name="Icon open-account-login" d="M13.5,0V4.5h18V27h-18v4.5H36V0ZM18,9v4.5H0V18H18v4.5l9-6.75Z" fill="#82756a" />
      </svg>
      <p class="fs-3">Login to edit or add mountains</p>
      <a class="btn btn-primary   " href="<?php echo WWW_ROOT ?>/admin/login.php">Login</a>
    </div>
  <?php } ?>
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
    $description = truncate($description, 155);
    // cast to string to be sanitized
    $mtnImage = (string)$row['mtn_image'];
    //sanitize here
    h($mtnImage);
    $isVolcano = $row["is_volcano"];
    if ($isVolcano) {
      $volcanoText = 'is a volcano';
    } else {
      $volcanoText = 'not a volcano';
    }
    $access = $row['access'];
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
      <div class="thumb col-md-6">
        <div class="flex row">
          <?php
          echo "<h3 class=\"displayCategory\"></span> <span class=\"displayInfo\">" . h($title) . "</h3>\n";
          echo "<div class=\"displayCategory fs-3 text-secondary\"></span> <span class=\"displayInfo\">" . h($height) . "m</div>\n";
          ?>
        </div>
        <div>
          <?php echo "<div class=\"displayCategory fs-4 fw-bold text-uppercase\"></span> <span class=\"displayInfo\">" . h($province) . "</div>\n"; ?>
          <?php echo "<div class=\"displayCategory fs-5 fs-normal\"></span> <span class=\"displayInfo\">" . h($access) . " Access</div>\n"; ?>
          <?php echo "<div class=\"displayCategory fs-5 fst-italic\"></span> <span class=\"displayInfo\">" . h($volcanoText) . "</div>\n"; ?>

        </div>
      <?php


      echo "<div class=\"displayCategory\"></span> <span class=\"displayInfo\">" . h($description) . "|</div>\n";

      // CREATE A "detail.php" PAGE FOR A SINGLE ITEM VIEW; SHOW ALL INFO
      echo "<a href=page.php?mtn_id=" .  h(u($mtnId)) . " class='btn btn-secondary'>Details</a><br />";

      echo "</div>";
    }
      ?>

      </div>

      <?php

      include(INCLUDES_PATH . "/footer.php");
      ?>