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
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,300&family=Merriweather:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">




  <!-- Latest compiled and minified JavaScript -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>


  <!-- Google Icons: https://material.io/tools/icons/
  also, check out Font Awesome or Glyphicons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  <!-- Your Custom styles for this project -->
  <!--  Note how we can use WWW_ROOT constant to resolve all links no matter where the file resides. -->
  <!-- FOR DEVELOPMENT USE LOCAL BOOTSTRAP SO INTELLESENSE WORKS -->

  <link href="<?php echo WWW_ROOT ?>/css/custom.min.css" rel="stylesheet">




  <!-- Themes from https://bootswatch.com/ : Use the Themes dropdown to select a theme you like; copy/paste the bootstrap.css. Here, we have named the downloaded theme as a new file and can overwrite the default.  -->


</head>

<body>
  <div class="shadow-sm border border-bottom sticky-top bg-light">

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
          <a class="navbar-brand " href="<?php echo WWW_ROOT ?>/index.php">Canadian Mountains</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class=" navbar-nav mr-auto w-100 align-items-center">
            <!-- WWW_ROOT is the root path constant -->
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo WWW_ROOT ?>/index.php">Home</a>
              <div>
                <div></div>
              </div>
            </li>
            <li class="d-flex justify-content-center align-items-center">
              <a class="nav-link d-flex justify-content-center align-items-center" href="<?php echo WWW_ROOT ?>/search.php">Search</a>
            </li>
            <li>
              <a class="nav-link" href="<?php echo WWW_ROOT ?>/canvas.php">Canvas</a>
            </li>
            <li>
              <a class="nav-link" href="<?php echo WWW_ROOT ?>/larval.php">Larval</a>
            </li>
            <?php if ((isset($_SESSION["x5ghy789soci"]))) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                  <a class="dropdown-item" href="<?php echo WWW_ROOT ?>/admin/index.php">menu</a>
                </div>
              </li>
            <?php } ?>
            <!-- TODO: MAKE search into a reusable function and add to header -->
            <li class="ms-auto">
              <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
              </form>
            </li>
            <li>
              <?php
              if (!(isset($_SESSION["x5ghy789soci"]))) {
                echo "<a class=\"nav-link\" href=\"" . WWW_ROOT . "/admin/login.php\">Login</a>";
                // echo "<p>" . session_id() . "</p>";
              } else {
                echo "<a class=\"nav-link\" href=\"" . WWW_ROOT . "/admin/logout.php\">Logout</a>";
                // echo "<p>" . session_id() . "</p>";
              }
              ?>
            </li>
          </ul>
      </nav>
    </div>
  </div>

  <main role="main" class="container">
    <?php echo display_session_message() ?>