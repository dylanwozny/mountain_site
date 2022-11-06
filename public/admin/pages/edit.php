<!-- ADD VALIDATION FROM INSERT -->
<?php
require_once("../../../private/initialize.php");
include(INCLUDES_PATH . "/mysql_connect.php");


// page variables
$page_title = "Edit Mountain";

//put after vars so page title is read
include(INCLUDES_PATH . "/header.php");
?>


<?php
// if there is no id in url
if (!isset($_GET['mtn_id'])) {
    redirect_to('../index.php');
}
//grab id from url, which is what link you clicked
$mtnId = $_GET['mtn_id'];

//sanitze/escape harmful URL html
$mtnId = h($mtnId);


// if there is an id, if not set default value
if (isset($mtnId)) {
    // FETCH from DB. limit charId to one value
    $result = mysqli_query($con, "SELECT * FROM dyl_mountains LIMIT 1") or die(mysqli_error($con));
} else {
    // no id in url
    redirect_to('../index.php');
}
// get the existing content for the selected character to populate the current form fields
$result2 = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE mtn_id = $mtnId");
while ($row = mysqli_fetch_array($result2)) {
    $thisTitle = $row['title'];
    $thisDescription = $row['description'];
    $thisProvince = $row['province'];
    $thisMainImage = $row['mtn_image'];
    $thisVerticalRelief = $row['vertical_relief'];
    $thisHeight = $row['height'];
    $thisSummit = $row['first_summit'];
    $thisIsVolcano = $row['is_volcano'];
    $thisAccess = $row["access"];
    $thisGoogleImage = $row["google_img"];
}

if (!$result2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

//validation messsage vars
$userPrompt = "";
$titleMessage = "";
$desMessage = "";
$ImgPromptMain = "";
$verMessage = "";
$newHeightMessage = "";
$SumMessage = "";
$ImgPromptGoogle = "";

// if user submits changes, then get the new info from the form and update the db
// VAR MESSAGES NEED TO BE MOVED OUTSIDE
if (is_post_request()) {

    $newTitle = $_POST["title"];
    $newDescription = $_POST["description"];
    // drop down list
    $newProvince = $_POST["province"];
    $newMtnImage = $_POST["mtn-img"];
    $newVerticalRelief = $_POST["vertical-relief"];
    $newVerticalRelief = (int)$newVerticalRelief;
    $newHeight = $_POST["height"];
    $newHeight = (int)$newHeight;
    $newFirstSummit = $_POST["first-summit"];
    // radio button
    $newIsVolcano = $_POST['is-volcano'];
    $newIsVolcano = boolval($newIsVolcano);
    // echo "<p>" . $newIsVolcano . "</p>";
    // check mark list
    $newAccess = $_POST["access"];


    $newGoogleImage = basename($_FILES['fileG']['name']);
    $newGoogleImageType = basename($_FILES['fileG']['type']);

    $newImage = basename($_FILES['mtn-img']['name']);
    $newImageType = basename($_FILES['mtn-img']['type']);

    //Validation
    $passVal = 1;

    //if wrong file type
    if (($newGoogleImageType != 'jpg') && ($newGoogleImageType != "jpeg")) {
        $ImgPromptGoogle = "This is not a valid jpg image type | ";
        $passVal = 0;
    }

    if (($newImageType != "jpg") && ($newImageType != 'jpeg')) {
        $ImgPromptMain = "This is not a valid jpg image type | ";
        $passVal = 0;
    }

    if ($newDescription == "" || strlen($newDescription) <= 0 || strlen($newDescription) >= 500) {
        $desMessage = "please give a description between 1 and 500 letter | ";
        $passVal = 0;
    }

    if ($newTitle == "" || strlen($newTitle) <= 0 || strlen($newTitle) >= 40) {
        $titleMessage = "please give a title between 1 and 40 letter | ";
        $passVal = 0;
    }

    if ($newVerticalRelief == "" || !is_int($newVerticalRelief) || $newVerticalRelief >= 10000 || $newVerticalRelief <= 0) {
        $verMessage = "Vertical Relief must be an integer between 1 and 10 000 | ";
        $passVal = 0;
    }

    if ($newHeight == "" || !is_int($newHeight) || $newHeight >= 10000 || $newHeight <= 0) {
        $newHeightMessage = "Height must be an integer between 1 and 10 000 | ";
        $passVal = 0;
    }

    if ($newFirstSummit == "" || strlen($newFirstSummit) <= 0 || strlen($newFirstSummit) >= 80) {
        $SumMessage = "please give a summit between 1 and 80 letter | ";
        $passVal = 0;
    }

    //echo original image if nothing is uploaded -----!!!!
    if ($newImage == "") {
        $newImage = $thisMainImage;
    }

    if ($newGoogleImage == "") {
        $newGoogleImage = $thisGoogleImage;
    }

    if ($passVal) {

        //define query
        $sql = "UPDATE dyl_mountains
                SET title = '$newTitle',
                description = '$newDescription',
                province = '$newProvince',
                mtn_image = '$newImage',
                vertical_relief = '$newVerticalRelief',
                height = '$newHeight',
                first_summit = '$newFirstSummit',
                is_volcano = '$newIsVolcano',
                access = '$newAccess',
                google_img = '$newGoogleImage'
                WHERE mtn_id = $mtnId";

        // pass query into function that connects to DB
        $x = mysqli_query($con, $sql) or die(mysqli_error($con));
        $userPrompt = "Mountain Edited !";

        //------------------- put image logic in here !-----------
    }
}

// VAR MESSAGES NEED TO BE MOVED OUTSIDE
if (isset($_POST['delete'])) {
}



// drop down list pre-populate
$abProvince = "";
$bcProvince = "";
$skProvince = "";
$nunProvince = "";

if ($thisProvince == 'ab') {
    $abProvince = "selected";
} else if ($thisProvince == 'bc') {
    $bcProvince = "selected";
} elseif ($thisProvince == 'sk') {
    $skProvince = "selected";
} elseif ($thisProvince == 'nun') {
    $nunProvince = "selected";
} else {
}


// volcano
$vtest = "hello";

if ($thisIsVolcano === "1") {
    $vtest = "checked";
} else {
    $vtest = "";
}


// Access check
function RadioCheck($access, $value)
{
    if ($access == $value) {
        echo "checked";
    } else {
        echo "";
    }
}

?>
<?php echo "<h2>" . h($page_title) .   "</h2>"; ?>
<a href="../index.php" class="back-link">&laquo; back to dashboard</a>
<div class="row">
    <div class="col-md-6">
        <?php
        if ($userPrompt) {
            echo "<div class='alert alert-primary'>$userPrompt</div>";
        }
        ?>
        <form id="myform" name="myform" method="post" action="edit.php?mtn_id=<?php echo h(u($mtnId)) ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" value="<?php echo $thisTitle; ?>">
                <?php if ($titleMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$titleMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control"><?php echo $thisDescription; ?></textarea>
                <?php if ($desMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$desMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="province">Province:</label>
                <select name="province" id="province" value="<?php echo $thisProvince; ?>">
                    <option value="none">-Select province-</option>
                    <option value="ab" <?php echo "$abProvince" ?>>AB</option>
                    <option value="bc" <?php echo "$bcProvince" ?>>BC</option>
                    <option value="sk" <?php echo "$skProvince" ?>>SK</option>
                    <option value="qc">QC</option>
                    <option value="mn">MN</option>
                    <option value="on">ON</option>
                    <option value="nl">NL</option>
                    <option value="nv">NV</option>
                    <option value="nb">NB</option>
                    <option value="on">ON</option>
                    <option value="pei">PEI</option>
                    <option value="yk">YK</option>
                    <option value="nw">NW</option>
                    <option value="nuv" <?php echo "$nunProvince" ?>>NUN</option>
                    <option value="usa">USA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="file">Main Image to Upload</label>
                <input type="file" id="file" name="mtn-img" class="form-control" value="<?php echo $thisMainImage ?>">
                <?php if ($ImgPromptMain) {
                    echo " <p class=\"alert alert-danger\">" . "$ImgPromptMain" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="vertical-relief">Vertical-Relief:</label>
                <input type="text" name="vertical-relief" id="vertical-relief" class="form-control" value="<?php echo $thisVerticalRelief; ?>">
                <?php if ($verMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$verMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="height">Height:</label>
                <input type="text" name="height" id="height" class="form-control" value="<?php echo $thisHeight; ?>">
                <?php if ($newHeightMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$newHeightMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="first-summit">First Summit:</label>
                <input type="text" name="first-summit" id="first-summit" class="form-control" value="<?php echo $thisSummit ?>">
                <?php if ($SumMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$SumMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="is-volcano">Is Volcano:</label>
                <input type="checkbox" name="is-volcano" id="is-volcano" class="form-control" <?php echo $vtest; ?>>
            </div>
            <div class="form-group">
                <label for="access">Access:</label>
                <br />Hike<input type="radio" name="access" id="access" class="form-control" value="hike" <?php RadioCheck($thisAccess, "hike"); ?>>
                Vehicle<input type="radio" name="access" id="access" class="form-control" value="vehicle" <?php RadioCheck($thisAccess, "vehicle"); ?>>
                Helicopter<input type="radio" name="access" id="access" class="form-control" value="helicopter" <?php RadioCheck($thisAccess, "helicopter"); ?>>
            </div>
            <div class="form-group">
                <label for="fileG">Google Image to Upload:</label>
                <input type="file" id="filG" name="fileG" class="form-control" value="">
                <?php if ($ImgPromptGoogle) {
                    echo " <p class=\"alert alert-danger\">" . "$ImgPromptGoogle" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="submit">&nbsp;</label>
                <input type="submit" name="submit" class="green-button" value="Edit image">
            </div>
        </form>
        <button class="btn btn-danger" onclick="location.href ='delete.php?mtn_id=<?php echo $mtnId; ?>'">Delete image</button>
    </div>
    <div class="col-md-6">
        <?php
        echo "<div class=\"mb-4\" id=\"pageImg\"><img src=\"../../uploads/thumbnails/$thisMainImage\"/></div>";
        echo "<div class=\"mb-4\" id=\"pageGoogleImg\"><img src=\"../../uploads/display/$thisGoogleImage\"/></div>";
        ?>
    </div>
</div>
<!-- <?php include(INCLUDES_PATH . "/footer.php"); ?> -->