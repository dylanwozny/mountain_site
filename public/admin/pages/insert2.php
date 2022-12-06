<!-- DO PNG !!!!!!!!! -->

<?php
// include("../includes/logincheck.php");
// sql connect is already in header ! that was why there is a problem before ????

include("../includes/database.php");

echo "<h2>Insert is done</h2>";

$con = mysqli_connect("localhost", "dwozny2", "Megatron13", "dwozny2_mountains");

//main image
$thisFileName = basename($_FILES['file-img']['name']);
$thisFileType = basename($_FILES['file-img']['type']);

// google earth image
$thisFileNameG = basename($_FILES['fileG']['name']);
$thisFileTypeG = basename($_FILES['fileG']['type']);

// upload the rest of the information
$description = $_POST['description'];
$title = $_POST['title'];
// drop down list
$province = $_POST["province"];
$verticalRelief = $_POST["vertical-relief"];
$verticalRelief = (int)$verticalRelief;
$Mheight = $_POST["height"];
$Mheight = (int)$Mheight;
$firstSummit = $_POST["first-summit"];
// radio button

$IsVolcano = $_POST['is-volcano'];
$isVolcano = (int)$isVolcano;
// $IsVolcano = boolval($IsVolcano);

echo "<p>" . $isVolcano . "</p>";
// check mark list
$access = $_POST["access"];

// $connection = mysqli_connect("localhost", "dwozny2","Megatron13","dwozny2_Mountains");

// if submit pressed
if (isset($_POST['submit'])) {

    //VALIDATION !!!!!!
    $passVal = 1;

    //if wrong file type
    if (($thisFileTypeG != 'jpg') && ($thisFileTypeG != "jpeg")) {
        $ImgPrompt = "This is not a valid jpg image type | ";
        $passVal = 0;
    }

    if (($thisFileType != "jpg") && ($thisFileType != 'jpeg')) {
        $ImgPrompt = "This is not a valid jpg image type | ";
        $passVal = 0;
    }

    if ($description == "" || strlen($description) <= 0 || strlen($description) >= 500) {
        $desMessage = "please give a description between 1 and 500 letter | ";
        $passVal = 0;
    }

    if ($title == "" || strlen($title) <= 0 || strlen($title) >= 40) {
        $titleMessage = "please give a title between 1 and 40 letter | ";
        $passVal = 0;
    }

    if ($verticalRelief == "" || !is_int($verticalRelief) || $verticalRelief >= 10000 || $verticalRelief <= 0) {
        $verMessage = "Vertical Relief must be an integer between 1 and 10 000 | ";
        $passVal = 0;
    }

    if ($Mheight == "" || !is_int($Mheight) || $Mheight >= 10000 || $Mheight <= 0) {
        $heightMessage = "Height must be an integer between 1 and 10 000 | ";
        $passVal = 0;
    }

    if ($firstSummit == "" || strlen($firstSummit) <= 0 || strlen($firstSummit) >= 80) {
        $SumMessage = "please give a summit between 1 and 80 letter | ";
        $passVal = 0;
    }

    if ($passVal) {
        uploadImage();

        // create optimal file size
        list($width, $height) = getimagesize("../uploads/originals/" . $thisFileName);
        $resizeWidth = $width;

        // create optimal for google image
        list($widthG, $heightG) = getimagesize("../uploads/originals/" . $thisFileNameG);
        $resizeWidthG = $widthG;

        if ($width > 800) {
            $resizeWidth = 800;
        }

        if ($widthG > 800) {
            $resizeWidthG = 800;
        }

        if ($height > 500) {

            $ratio = $width / $height;
            $height = 500;
            $resizeWidth = $height * $ratio;
        }

        if ($heightG > 500) {

            $ratioG = $widthG / $heightG;
            $heightG = 500;
            $resizeWidthG = $heightG * $ratioG;
        }

        // create the file in the thumbnail folder and original folder !!!!!!!!!            
        createThumbnailJpg($thisFileName, '../uploads/thumbnails/', 120);
        createThumbnailJpg($thisFileName, '../uploads/display/', $resizeWidth);

        // create the file in the thumbnail folder and original folder !!!!!!!!!            
        createThumbnailJpg($thisFileNameG, '../uploads/thumbnails/', 120);
        createThumbnailJpg($thisFileNameG, '../uploads/display/', $resizeWidthG);

        $sql = "INSERT INTO dyl_mountains (title, description, province, mtn_image, vertical_relief, height, first_summit, is_volcano, access, google_img) VALUES('$title','$description','$province','$thisFileName','$verticalRelief','$Mheight','$firstSummit','$isVolcano','$access','$thisFileNameG')";

        $x = mysqli_query($con, $sql) or die(mysqli_error($con));
    } else {
        $userPrompt = "validation failed | " . "$ImgPrompt" . "$titleMessage" . "$desMessage" . "$verMessage" . "$MheightMessage" . "$SumMessage";
        header("Location:insert.php?message=" . $userPrompt);
    }
}

function uploadImage()
{
    $targetFolder = "../uploads/originals/"; // path to destination
    $thisFileName = basename($_FILES['file-img']['name']); // file information from form
    $thisFileNameG = basename($_FILES['fileG']['name']); // file information from form
    $thisFilePath = $targetFolder . $thisFileName; //append two to get location of where the file 
    $thisFilePathG = $targetFolder . $thisFileNameG; //append two to get location of where the file should end uploadImage

    move_uploaded_file($_FILES['file-img']['tmp_name'], $thisFilePath) or die("could not upload image");
    move_uploaded_file($_FILES['fileG']['tmp_name'], $thisFilePathG) or die("could not upload image");
}


// createThumbnailJpg
function  createThumbnailJpg($thisFileName, $thumbsDestination, $thisThumbWidth)
{
    $thisOgFilePath = '../uploads/originals/' . $thisFileName;

    list($width, $height) = getimagesize($thisOgFilePath);

    $imgRatio = $width / $height;

    $thisThumbHeight = $thisThumbWidth / $imgRatio;

    $thumb = imagecreatetruecolor($thisThumbWidth, $thisThumbHeight);


    $source = imagecreatefromjpeg($thisOgFilePath);

    //resize
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thisThumbWidth, $thisThumbHeight, $width, $height);

    //output_
    $newFilename = $thumbsDestination . $thisFileName;

    imagejpeg($thumb, $newFilename, 80);

    imagedestroy($thumb);
    imagedestroy($source);

    echo "<img src=\"$newFilename\"/>";
    $userPrompt = "image has been uploaded";
    echo $userPrompt;
}




?>