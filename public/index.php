<!-- // 1 ------ u() check for escape values on each db value submitted --------
// 2 ------- follow admin page function query structure -------
// 3 ------ update filtering options to return new values ------ -->
<?php
require_once("../private/initialize.php");


//page vars
$page_title = "Home Page";

// <!-- Load header navigation -->
include(INCLUDES_PATH . "/header.php");

?>

<!-- FINISH INTRO -->
<header class=" banner front-about-p mb-6">
  <div class="banner__bck-filter pt-7">
    <h1 class="container text-light"><?php echo APP_NAME ?></h1>
    <div class="container justify-content-between d-flex flex-wrap gap-3 pb-md-6">
      <div class="banner__intro flex-grow-0">

        <p class="text-light">Welcome to my Application ! I hope you find it somewhat useful. I wanted to create an app about my favourite feature of nature: Mountains !I have chosen to create a catalog of mountain peaks in Canada. I chose this topic because I love visiting Jasper and Banff and have been fascinated by mountains ever since I was a child. I also like to compare mountain stats like height, vertical relief etc. to each other just for fun.</p>
      </div>
      <?php if (!(isset($_SESSION["x5ghy789soci"]))) { ?>
        <div class="banner__login text-center flex-grow-1 rounded-3 shadow p-2 p-lg-4 align-self-start mb-4">
          <svg class="mb-1" id="Icon_open-account-login" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 31.5">
            <path id="Icon_open-account-login-2" data-name="Icon open-account-login" d="M13.5,0V4.5h18V27h-18v4.5H36V0ZM18,9v4.5H0V18H18v4.5l9-6.75Z" fill="#82756a" />
          </svg>
          <p class="fs-3 mb-3">Login to edit or add mountains</p>
          <a class="btn btn-primary   " href="<?php echo WWW_ROOT ?>/admin/login.php">Login</a>
        </div>
      <?php } ?>
    </div>
  </div>
</header>
<main role="main" class="mb-5 container flex-grow-1">
  <section>
    <div class="jumbotron categories row" id="linkJump">

      <!---------- category filtering ---------->
      <h2>Mountain List</h2>
      <p class="fw-light fs-3">Sort By</p>
      <!-------------SEARCH BY SAME METHOD OF PERSONAL WEBSITE------------------------- --->
      <!-- make php put info into html of list cards and the filter with js-->
      <!-- same with other features of list ? height,access, etc. -->
      <!-- -----OR----- -->

      <div class="sort-list container ">
        <ul class="d-flex fs-5 p-0 mb-4 text-light gap-1 justify-content-flex-start flex-wrap">
          <?php
          ?>
          <?php
          // added to url to jump to linkJump on next page
          $idJump = "#linkJump"; ?>
          <li><a class=" rounded-pill  btn btn-dark p-1 d-block no-decoration" href="index.php <?php echo $idJump ?>">All</a></li>
          <li><a class=" rounded-pill btn btn-dark p-1 d-block no-decoration " href="<?php echo WWW_ROOT . "/" . "index" ?>.php?filter=access<?php echo $idJump ?>">Hiking Access</a></li>
          <li><a class=" rounded-pill btn btn-dark p-1 d-block no-decoration " href="<?php echo WWW_ROOT . "/" . "index" ?>.php?filter=province<?php echo $idJump ?>">Alberta</a></li>
          <li><a class=" rounded-pill btn btn-dark p-1 d-block no-decoration " href="<?php echo WWW_ROOT . "/" . "index" ?>.php?filter=volcano<?php echo $idJump ?>">Volcanoes</a></li>
        </ul>
      </div>


      <?php
      $pageCategory = "";
      $pageValue = "";

      // button filter logic
      if (isset($_GET['filter'])) {
        $filterCategory = $_GET['filter'];

        if ($filterCategory === "province") {
          $pageCategory = "province";
          $pageValue = "ab";
        } elseif ($filterCategory === "access") {
          $pageCategory = "access";
          $pageValue = "hike";
        } elseif ($filterCategory === "volcano") {
          $pageCategory = "is_volcano";
          $pageValue = '1';
        }



        $result = pagination(6, "index", $pageCategory, $pageValue);
      } else {
        // db call and pagination logic
        $result = pagination(6, "index");
      }

      ?>

    </div>
  </section>


  <?php



  pagination_Render($result['count'], $result['current'], $result['name'], $pageCategory);
  ?>
  <div class=" container p-0 mb-2">
    <div class="p-0 d-flex justify-content-start gap-3 align-items-start flex-wrap">
      <?php
      while ($row = mysqli_fetch_array($result['mtns'])) {
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

        <div class="home-card d-flex flex-column rounded-top rounded-bottom shadow-lg p-0 text-capitalize ">
          <div>
            <div class="">
              <img class="mtn-card-gradient rounded-top img-fluid" src="<?php echo "uploads/thumbnails/" .  h($mtnImage) ?>" alt="">
            </div>
            <div class="d-flex justify-content-between align-items-end p-3 gap-2">
              <?php
              echo "<h4 class=\"displayCategory lh-base m-0\">" . h($title) . "</h4>\n";
              echo "<div class=\"displayCategory fs-3 text-secondary lh-base\">" . h($height) . "m</div>\n";
              ?>
            </div>
            <div class="d-flex p-3 pt-1 pb-1 align-items-center justify-content-between gap-1 border border-end-0 border-start-0 mb-3 ">
              <?php echo "<div class=\"1h-1 fs-4 fw-bold  text-uppercase\">" . h($province) . "</div>\n" ?>
              <?php echo "<div class=\"display-category  fs-normal \">" . h($access) . " Access</div>\n"; ?>
              <?php echo "<div class=\"display-category   fst-italic\">" . h($volcanoText) . "</div>\n"; ?>
            </div>
            <p class="p-3 pt-0">
              <?php echo h($description); ?>
            </p>
          </div>

          <div class="p-3 pt-0 ms-auto"><a href=<?php echo "\"page.php?mtn_id=" . h(u($mtnId)) . "\"" ?> class='left-auto btn btn-primary d-block'>Details</a></div>

        </div>
      <?php

      }
      ?>
    </div>
  </div>

  <?php
  pagination_Render($result['count'], $result['current'], $result['name'], $pageCategory);
  ?>


  <?php

  include(INCLUDES_PATH . "/footer.php");
  ?>