<?php

include("mysql_connect.php"); // here we include the connection script; since this file(header.php) is included at the top of every page we make, the connection will then also be included. Also, config options like WWW_ROOT are also available to us.
?>

<?php
// check for vars and if not, set default values
if (!isset($page_title)) {
  $page_title = "mountain website";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <!--  This CONSTANT is defined in your mysql_connect.php file. -->
  <title><?php echo APP_NAME . " " . h($page_title); ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,300&family=Source+Serif+Pro:wght@300;400;600;700&family=Roboto:wght@300&display=swap" rel="stylesheet">




  <!-- Latest compiled and minified JavaScript -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>


  <!-- Google Icons: https://material.io/tools/icons/
  also, check out Font Awesome or Glyphicons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  <!-- Your Custom styles for this project -->
  <!--  Note how we can use WWW_ROOT constant to resolve all links no matter where the file resides. -->
  <!-- FOR DEVELOPMENT USE LOCAL BOOTSTRAP SO INTELLESENSE WORKS -->
  <link href="<?php echo WWW_ROOT ?>/css/reset.css" rel="stylesheet">

  <link href="<?php echo WWW_ROOT ?>/css/custom.min.css" rel="stylesheet">




  <!-- Themes from https://bootswatch.com/ : Use the Themes dropdown to select a theme you like; copy/paste the bootstrap.css. Here, we have named the downloaded theme as a new file and can overwrite the default.  -->


</head>

<!-- variables to set that effect fullscreen layout of homepage -->
<?php
$mainHtml = '<main role="main" class="mb-5 container flex-grow-1">';
$navMargin = "mb-6";


if ($page_title === "Home Page") {
  $navMargin = "mb-0";
  $mainHtml = "";
}
?>

<body class="d-flex flex-column">
  <div class="shadow-sm border border-bottom sticky-top bg-light <?php echo $navMargin ?>">

    <div class="container">
      <nav class="navbar f navbar-expand-lg navbar-light pb-0 pt-0">
        <div class="d-flex align-items-center ">
          <a href="<?php echo WWW_ROOT ?>/index.php">
            <svg viewBox="5 5 65 55">
              <defs>
                <filter id="Path_37" x="0" y="0" width="76.563" height="69.046" filterUnits="userSpaceOnUse">
                  <feOffset dy="3" input="SourceAlpha" />
                  <feGaussianBlur stdDeviation="3" result="blur" />
                  <feFlood flood-opacity="0.161" />
                  <feComposite operator="in" in2="blur" />
                  <feComposite in="SourceGraphic" />
                </filter>
              </defs>
              <g transform="translate(9 6)">
                <g transform="matrix(1, 0, 0, 1, -9, -6)" filter="url(#Path_37)">
                  <path id="Path_37-2" data-name="Path 37" d="M28.909,4.442a3,3,0,0,1,5.183,0L60.368,49.488A3,3,0,0,1,57.777,54H5.223a3,3,0,0,1-2.591-4.512Z" transform="translate(6.78 3.05)" fill="#1c94db" />
                </g>
                <text id="M" transform="translate(14.781 48.046)" fill="#fbf9f8" font-size="30" font-family="Lato-Bold, Lato" font-weight="700" letter-spacing="0.103em">
                  <tspan x="0" y="0">M</tspan>
                </text>
                <text id="C" transform="translate(22.781 23.046)" fill="#fbf9f8" font-size="18" font-family="Lato-Bold, Lato" font-weight="700" letter-spacing="0.103em">
                  <tspan x="0" y="0">C</tspan>
                </text>
              </g>
            </svg>
          </a>
          <a class="navbar-brand" href="<?php echo WWW_ROOT ?>/index.php">Canadian Mountains</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class=" navbar-nav mr-auto w-100 align-items-center">
            <!-- WWW_ROOT is the root path constant -->
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo WWW_ROOT ?>/index.php"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29.281 22.77">
                  <path d="M14.251,8.161,4.88,15.879V24.21a.813.813,0,0,0,.813.813l5.7-.015A.813.813,0,0,0,12.2,24.2V19.33a.813.813,0,0,1,.813-.813h3.253a.813.813,0,0,1,.813.813v4.862a.813.813,0,0,0,.813.816l5.694.016a.813.813,0,0,0,.813-.813V15.874l-9.37-7.713A.62.62,0,0,0,14.251,8.161Zm14.8,5.246-4.25-3.5V2.863a.61.61,0,0,0-.61-.61H21.349a.61.61,0,0,0-.61.61V6.554L16.188,2.81a2.44,2.44,0,0,0-3.1,0L.22,13.407a.61.61,0,0,0-.081.859l1.3,1.576a.61.61,0,0,0,.86.083L14.251,6.077a.62.62,0,0,1,.778,0l11.957,9.848a.61.61,0,0,0,.859-.081l1.3-1.576a.61.61,0,0,0-.086-.861Z" transform="translate(0.001 -2.254)" />
                </svg>Home</a>
              <div>
                <div></div>
              </div>
            </li>
            <?php if ((isset($_SESSION["x5ghy789soci"]))) { ?>
              <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54.894 54.894">
                    <path d="M4.5,35H28.9V4.5H4.5Zm0,24.4H28.9V41.1H4.5Zm30.5,0h24.4V28.9H35ZM35,4.5V22.8h24.4V4.5Z" transform="translate(-4.5 -4.5)" />
                  </svg>
                  Admin</a>
                <div class="dropdown-menu p-0 border-2 border-dark" aria-labelledby="dropdown01">
                  <a class="dropdown-item" href="<?php echo WWW_ROOT ?>/admin/index.php">Dashboard</a>
                </div>
              </li>
            <?php } ?>
            <!-- TODO: MAKE search into a reusable function and add to header -->

            <li class="nav-logout">
              <?php
              if (!(isset($_SESSION["x5ghy789soci"]))) {

                echo "<a class=\"nav-link\" href=\"" . WWW_ROOT . "/admin/login.php\">" ?> <svg viewBox="0 0 28 28">
                  <path id="Icon_awesome-user-alt-2" data-name="Icon awesome-user-alt" d="M14,15.75A7.875,7.875,0,1,0,6.125,7.875,7.877,7.877,0,0,0,14,15.75Zm7,1.75H17.987a9.52,9.52,0,0,1-7.973,0H7a7,7,0,0,0-7,7v.875A2.626,2.626,0,0,0,2.625,28h22.75A2.626,2.626,0,0,0,28,25.375V24.5A7,7,0,0,0,21,17.5Z" />
                </svg>
                Login </a>
              <?php
              } else {
                echo "<a class=\"nav-link\" href=\"" . WWW_ROOT . "/admin/logout.php\">" ?><svg viewBox="0 0 36 31.5">
                  <path id="Icon_open-account-login-2" data-name="Icon open-account-login" d="M13.5,0V4.5h18V27h-18v4.5H36V0ZM18,9v4.5H0V18H18v4.5l9-6.75Z" />
                </svg>Logout</a>
              <?php
              }
              ?>
            </li>
            <li class="ms-auto  border-bottom nav-search pl-lg-4 pb-1 pt-1">
              <form class="d-flex search-form " action="<?php echo WWW_ROOT  ?>/search.php?search-item=<?php echo h(u($searchTerm)) ?>">
                <input class="form-control ms-0 border-end-0 border search-form__input" name="search-item" type="search" placeholder="mountain names" aria-label="Search">
                <svg role="img" viewBox="0 0 35.997 36.004">
                  <path id="Icon_awesome-search-2" data-name="Icon awesome-search" d="M35.508,31.127l-7.01-7.01a1.686,1.686,0,0,0-1.2-.492H26.156a14.618,14.618,0,1,0-2.531,2.531V27.3a1.686,1.686,0,0,0,.492,1.2l7.01,7.01a1.681,1.681,0,0,0,2.384,0l1.99-1.99a1.7,1.7,0,0,0,.007-2.391Zm-20.883-7.5a9,9,0,1,1,9-9A8.995,8.995,0,0,1,14.625,23.625Z" />
                </svg>
                <button class="btn btn-outline-secondary search-form__button" type="submit">Search</button>
              </form>
            </li>
          </ul>
      </nav>
    </div>
  </div>

  <?php
  if (is_post_request()) {
    if (isset($_POST['search-item'])) {
      $searchTerm = $_POST['search-item'];
    }
  }


  ?>



  <?php echo $mainHtml ?>
  <?php echo display_session_message() ?>