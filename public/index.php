<?php
require_once("../private/initialize.php");
include(INCLUDES_PATH . "/header.php");
include(INCLUDES_PATH . "/mysql_connect.php");

// default call to DB
$result = mysqli_query($con, "SELECT * FROM dyl_mountains");

// FILTERING YOUR DB
// $displayby = $_GET['displayby'];
// $displayvalue = $_GET['displayvalue'];

// if (isset($displayby) && isset($displayvalue)) {
//   // HERE IS THE MAGIC: WE TELL OUR DB WHICH COLUMN TO LOOK IN, AND THEN WHICH VALUE FROM THAT COLUMN WE'RE LOOKING FOR
//   $result = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE $displayby LIKE '$displayvalue' ") or die(mysqli_error($con));
// }

$heightLow = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE height BETWEEN 1 AND 2000 LIMIT 2");
while ($row = mysqli_fetch_array($heightLow)) {
  $title = $row['title'];
  $mtnId = $row['mtn_id'];
}
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

  <!-- category filtering -->
  <div class="col-md-6">
    <h2>categories</h2>
    <ul class="categories-flex">
      <li><a href="index.php">all Mountains</a></li>
      <li><a href="index.php?displayby=access&displayvalue=hike">Hiking Access</a></li>
      <li><a href="index.php?displayby=province&displayvalue=ab">Alberta Mountains</a> </li>
      <li><a href="index.php?displayby=is_volcano&displayvalue=1">Volcanos</a> </li>
    </ul>
  </div>
  <div class="col-md-6 mtn-height">
    <?php
    echo "<h2>2500m to 5000m high </h2>";
    $heightLow = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE height BETWEEN 2500 AND 5000 LIMIT 4");
    while ($row = mysqli_fetch_array($heightLow)) {
      $title = $row['title'];
      $mtnId = $row['mtn_id'];
      echo "<div><a href=\"page.php?mtn_id=$mtnId\"><p>" . $title . "</p></a></div>";
    }
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

    echo "<div class=\"thumb col-md-2\">\n";

    echo "<img src=\"uploads/thumbnails/$mtnImage\" class=\"\" /><br/>\n";

    echo "<div class=\"displayCategory\">Title:</span> <span class=\"displayInfo\">" . $title . "</div>\n";
    echo "<div class=\"displayCategory\">Description:</span> <span class=\"displayInfo\">" . $description . "</div>\n";
    echo "<div class=\"displayCategory\">Province:</span> <span class=\"displayInfo\">" . $province . "</div>\n";
    echo "<div class=\"displayCategory\">Height:</span> <span class=\"displayInfo\">" . $height . "</div>\n";


    // CREATE A "detail.php" PAGE FOR A SINGLE ITEM VIEW; SHOW ALL INFO
    echo "<a href=\"page.php?mtn_id=$mtnId\">More info...</a><br />";

    echo "</div>";
  }
  ?>

</div>

<?php
function truncate($text, $chars)
{
  $text = $text . " ";
  if (strlen($text) < $chars) {
    $toBeCont = '';
  } else {
    $toBeCont = "...";
  }
  $text = substr($text, 0, $chars);
  $text = $text . $toBeCont;
  return $text;
}

include(INCLUDES_PATH . "/footer.php");
?>