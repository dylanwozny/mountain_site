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
<header class="justify-content-between banner front-about-p d-flex flex-wrap gap-5">
  <p class="banner__intro flex-grow-0">Welcome to my Application ! I hope you find it somewhat useful. I wanted to create an app about my favourite feature of nature: Mountains !I have chosen to create a catalog of mountain peaks in Canada. I chose this topic because I love visiting Jasper and Banff and have been fascinated by mountains ever since I was a child. I also like to compare mountain stats like height, vertical relief etc. to each other just for fun.Information fields pertaining to the mountains will include: thumbnail picture, name, description,province, vertical relief, elevation profile, height, first summit, access type(vehicle, hiking, helicopter),and if it is a volcano and a google earth image of elevation. Search categories can include province,volcano etc. This information will be stored in a MySQL database.The structure of this application includes a useful homepage, search functionality, edit and delete options , which are secured by an admin log in and individual pages that display all information about that specific chosen mountain. Category links will also appear on the homepage.</p>
  <?php if (!(isset($_SESSION["x5ghy789soci"]))) { ?>
    <div class="banner__login text-center flex-grow-1 rounded-3 shadow p-5 align-self-start">
      <svg class="mb-3" id="Icon_open-account-login" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 31.5">
        <path id="Icon_open-account-login-2" data-name="Icon open-account-login" d="M13.5,0V4.5h18V27h-18v4.5H36V0ZM18,9v4.5H0V18H18v4.5l9-6.75Z" fill="#82756a" />
      </svg>
      <p class="fs-3">Login to edit or add mountains</p>
      <a class="btn btn-primary   " href="<?php echo WWW_ROOT ?>/admin/login.php">Login</a>
    </div>
  <?php } ?>
</header>

<section>
  <div class="jumbotron categories row">

    <!---------- category filtering ---------->
    <h2>Mountain List</h2>
    <span class="fw-light fs-2">Sort By</span>
    <!-------------SEARCH BY SAME METHOD OF PERSONAL WEBSITE------------------------- --->
    <!-- make php put info into html of list cards and the filter with js-->
    <!-- same with other features of list ? height,access, etc. -->
    <!-- -----OR----- -->

    <div class="sort-list container ">
      <ul class="d-flex p-3 fs-5 text-light bg-dark justify-content-around">
        <?php
        // echo "<h2>2500m to 5000m high </h2>";
        // $heightLow = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE height BETWEEN 2500 AND 5000 LIMIT 4");
        // while ($row = mysqli_fetch_array($heightLow)) {
        //   $title = $row['title'];
        //   $mtnId = $row['mtn_id'];
        //   echo "<div><a href=\"page.php?mtn_id=$mtnId\"><p>" . $title . "</p></a></div>";
        // }
        // -------- filter height and render html ----------
        // filter_Height("<h2>3000m to 4000m high </h2>", 3000, 4000);
        ?>
        <li>ALL</li>
        <li>Volcanoes</li>
        <li>Hike Access</li>
        <li>Alberta Mountains</li>
      </ul>
    </div>


  </div>
</section>



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
        <img class="mtn-card-gradient" src="<?php echo "uploads/thumbnails/" .  h($mtnImage) ?>" alt="">
      </div>
      <div class="d-flex justify-content-between pt-3 pb-3">
        <?php
        echo "<h3 class=\"displayCategory\"></span> <span class=\"displayInfo\">" . h($title) . "</h3>\n";
        echo "<div class=\"displayCategory fs-3 text-secondary\"></span> <span class=\"displayInfo\">" . h($height) . "m</div>\n";
        ?>
      </div>
      <div class="d-flex gap-5 pt-3 pb-3">
        <?php echo "<div class=\"displayCategory fs-4 fw-bold text-uppercase\"></span> <span class=\"displayInfo\">" . h($province) . "</div>\n"; ?>
        <?php echo "<div class=\"displayCategory fs-5 fs-normal\"></span> <span class=\"displayInfo\">" . h($access) . " Access</div>\n"; ?>
        <?php echo "<div class=\"displayCategory fs-5 fst-italic\"></span> <span class=\"displayInfo\">" . h($volcanoText) . "</div>\n"; ?>

      </div>
      <p>
        <?php echo h($description); ?>
      </p>

      <a href=<?php echo "\"page.php?mtn_id=" . h(u($mtnId)) . "\"" ?> class='left-auto btn btn-secondary d-block w-25 '>Details</a>
    <?php






  }
    ?>

    </div>

</div>

<?php

include(INCLUDES_PATH . "/footer.php");
?>