<?php
    include("../includes/logincheck.php");
    include("../includes/header.php");
    include("../includes/mysql_connect.php");
    
    echo "<h2>Your in insert 3</h2>";
  
    $description = $_POST['description'];
    $title = $_POST['title'];
    // drop down list
    $province = $_POST["province"];
    $verticalRelief = $_POST["vertical_relief"];
    $height = $_POST["height"];
    $firstSummit = $_POST["first_summit"];
    // radio button
    $isVolcano = $_POST['is_volcano'];
    // check mark list
    $access = $_POST["access"];

    echo  $title;
    
    // if submit pressed
    if(isset($_POST['submit'])){

            $sql = "INSERT INTO dyl_Mountains('title', 'description', 'province', 'mtn_image', 'vertical_relief', 'height', 'first_summit', 'is_volcano', 'access', 'google_img') VALUES('$title','$description','$province','$thisFileName','$verticalRelief','$height','$firstSummit','$isVolcano','$access','$thisFileNameG')";

            mysqli_query($con,$sql);


    }

    // INSERT INTO 'dyl_Mountains' ('title', 'description', 'province', 'mtn_image', 'vertical_relief', 'height', 'first_summit', 'is_volcano', 'access', 'google_img', 'mtn_id') VALUES ('test', 'test', 'AB', 'test.jpg', '11', '11', '12890 jjjj', '0', 'hike', 'test.jpg', NULL);