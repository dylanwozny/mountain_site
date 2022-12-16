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

  <!-- Latest compiled and minified CSS -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Secular+One&display=swap" rel="stylesheet">



  <!-- Latest compiled and minified JavaScript -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>


  <!-- Google Icons: https://material.io/tools/icons/
  also, check out Font Awesome or Glyphicons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  <!-- Your Custom styles for this project -->
  <!--  Note how we can use WWW_ROOT constant to resolve all links no matter where the file resides. -->
  <!-- FOR DEVELOPMENT USE LOCAL BOOSTRAP SO INTELLESENSE WORKS -->
  <link href="<?php echo WWW_ROOT ?>/css/bootstrap-lumen.css" rel="stylesheet">
  <link href="<?php echo WWW_ROOT ?>/css/styles.css" rel="stylesheet">



  <!-- Themes from https://bootswatch.com/ : Use the Themes dropdown to select a theme you like; copy/paste the bootstrap.css. Here, we have named the downloaded theme as a new file and can overwrite the default.  -->


</head>

<body>
  <div class="container-lg bg-dark">

    <nav class="container navbar navbar-expand-lg navbar-dark bg-dark border-0 pt-3 pb-3">

      <a class="navbar-brand" href="<?php echo WWW_ROOT ?>/index.php">Mountains of Canada</a>
      <?php if ((isset($_SESSION["x5ghy789soci"]))) { ?>
        <div>
          <p> <?php echo $_SESSION['username'] ?? ''; ?></p>

        </div>
      <?php } ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class=" navbar-nav mr-auto">
          <!-- WWW_ROOT is the root path constant -->
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo WWW_ROOT ?>/index.php">Home</a>
          </li>
          <li>
            <a class="nav-link" href="<?php echo WWW_ROOT ?>/search.php">Search</a>
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

  <main role="main" class="container">
    <?php echo display_session_message() ?>