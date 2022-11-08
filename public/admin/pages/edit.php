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
    // volcano logic for displaying
    $thisIsVolcano = $_POST['is-volcano'];
    // echo "<p>" . $newIsVolcano . "</p>";
    // check mark list
    $newAccess = $_POST["access"];


    //file logic
    // if file input is empty
    if (!file_exists($_FILES['fileG']['name'])) {
        $ImgPromptGoogle = "please upload a file | ";
        $passVal = 0;
    } else if (($newGoogleImageType != 'jpg') && ($newGoogleImageType != "jpeg")) {
        $ImgPromptGoogle = "This is not a valid jpg image type | ";
        $passVal = 0;
    } else {
        $newGoogleImage = basename($_FILES['fileG']['name']);
        $newGoogleImageType = basename($_FILES['fileG']['type']);
    }




    $newImage = basename($_FILES['mtn-img']['name']);
    $newImageType = basename($_FILES['mtn-img']['type']);

    //Validation
    $passVal = 1;

    //if wrong file type

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
$mnProvince = "";
$onProvince = "";
$qcProvince = "";
$ntProvince = "";
$nsProvince = "";
$nbProvince = "";
$nfProvince = "";
$peiProvince = "";
$ykProvince = "";
$usaProvince = "";

if ($thisProvince == 'ab') {
    $abProvince = "selected";
} else if ($thisProvince == 'bc') {
    $bcProvince = "selected";
} elseif ($thisProvince == 'sk') {
    $skProvince = "selected";
} elseif ($thisProvince == 'nun') {
    $nunProvince = "selected";
} else if ($thisProvince == 'mn') {
    $mnProvince = "selected";
} elseif ($thisProvince == 'on') {
    $onProvince = "selected";
} elseif ($thisProvince == 'qc') {
    $qcProvince = "selected";
} else if ($thisProvince == 'nf') {
    $nfProvince = "selected";
} elseif ($thisProvince == 'nb') {
    $nbProvince = "selected";
} elseif ($thisProvince == 'ns') {
    $nsProvince = "selected";
} else if ($thisProvince == 'pei') {
    $peiProvince = "selected";
} elseif ($thisProvince == 'yk') {
    $ykProvince = "selected";
} elseif ($thisProvince == 'usa') {
    $usaProvince = "selected";
} else if ($thisProvince == "nt")
    $ntProvince = "selected";
else {
}





// Access check convert to value
// we put in a hidden html input value if nothing is sent.
function RadioCheck($access, $value)
{
    if ($access == $value) {
        echo "checked";
    } else {
        echo "";
    }
}

?>
<a href="../index.php" class="back-link">&laquo; back to dashboard</a>
<?php echo "<h2>" . h($page_title) .   "</h2>"; ?>

<div class="row">
    <div class="col-md-6">
        <?php
        if ($userPrompt) {
            echo "<div class='alert alert-primary'>$userPrompt</div>";
        }
        ?>
        <!-- h(remove special characters function) -->
        <form id="myform" name="myform" method="post" action="edit.php?mtn_id=<?php echo h(u($mtnId)) ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" value="<?php echo h($thisTitle); ?>">
                <?php if ($titleMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$titleMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control"><?php echo h($thisDescription); ?></textarea>
                <?php if ($desMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$desMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="province">Province:</label>
                <select name="province" id="province" value="<?php echo h($thisProvince); ?>">
                    <option value="none">-Select province-</option>
                    <option value="ab" <?php echo "$abProvince" ?>>AB</option>
                    <option value="bc" <?php echo "$bcProvince" ?>>BC</option>
                    <option value="sk" <?php echo "$skProvince" ?>>SK</option>
                    <option value="qc" <?php echo "$qcProvince" ?>>QC</option>
                    <option value="mn" <?php echo "$mnProvince" ?>>MN</option>
                    <option value="on" <?php echo "$onProvince" ?>>ON</option>
                    <option value="nf" <?php echo "$nfProvince" ?>>Nf</option>
                    <option value="ns" <?php echo "$nsProvince" ?>>NS</option>
                    <option value="nb" <?php echo "$nbProvince" ?>>NB</option>
                    <option value="pei" <?php echo "$peiProvince" ?>>PEI</option>
                    <option value="yk" <?php echo "$ykProvince" ?>>YK</option>
                    <option value="nt" <?php echo "$ntProvince" ?>>NW</option>
                    <option value="nun" <?php echo "$nunProvince" ?>>NUN</option>
                    <option value="usa" <?php echo "$usaProvince" ?>>USA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="file">Main Image to Upload</label>
                <input type="file" id="file" name="mtn-img" class="form-control" value="<?php echo h($thisMainImage) ?>">
                <?php if ($ImgPromptMain) {
                    echo " <p class=\"alert alert-danger\">" . "$ImgPromptMain" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="vertical-relief">Vertical-Relief:</label>
                <input type="text" name="vertical-relief" id="vertical-relief" class="form-control" value="<?php echo h($thisVerticalRelief); ?>">
                <?php if ($verMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$verMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="height">Height:</label>
                <input type="text" name="height" id="height" class="form-control" value="<?php echo h($thisHeight); ?>">
                <?php if ($newHeightMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$newHeightMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="first-summit">First Summit:</label>
                <input type="text" name="first-summit" id="first-summit" class="form-control" value="<?php echo h($thisSummit) ?>">
                <?php if ($SumMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$SumMessage" . "</p>";
                } ?>
            </div>
            <!-- NEED THIS FOR CHECK BOX -->
            <div class="form-group">
                <label for="is-volcano">Is Volcano:</label>
                <input type="hidden" name="is-volcano" id="is-volcano" class="form-control" value="0">
                <input type="checkbox" name="is-volcano" id="is-volcano" class="form-control" value="1" <?php if ($thisIsVolcano == "1") {
                                                                                                            echo "checked";
                                                                                                        }; ?> />

            </div>
            <div class="form-group">
                <label for="access">Access:</label>
                <input type="hidden" name="access" id="access" class="form-control" value="0">
                <br />Hike<input type="radio" name="access" id="access" class="form-control" value="hike" <?php RadioCheck(h($thisAccess), "hike"); ?>>
                Vehicle<input type="radio" name="access" id="access" class="form-control" value="vehicle" <?php RadioCheck(h($thisAccess), "vehicle"); ?>>
                Helicopter<input type="radio" name="access" id="access" class="form-control" value="helicopter" <?php RadioCheck(h($thisAccess), "helicopter"); ?>>
            </div>
            <div class="form-group">
                <label for="fileG">Google Image to Upload:</label>
                <input type="file" id="fileG" name="fileG" class="form-control" value="">
                <?php if ($ImgPromptGoogle) {
                    echo " <p class=\"alert alert-danger\">" . "$ImgPromptGoogle" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="submit">&nbsp;</label>
                <input type="submit" name="submit" class="green-button" value="Edit image">
            </div>
        </form>
        <button class="btn btn-danger" onclick="location.href ='delete.php?mtn_id=<?php echo h($mtnId); ?>'">Delete image</button>
    </div>
    <div class="col-md-6">
        <div class="mb-4" id="pageImg"><img src="../../uploads/thumbnails/<?php echo h($thisMainImage); ?>" /></div>
        <div class="mb-4" id="pageImg"><img src="../../uploads/display/<?php echo h($thisGoogleImage); ?>" /></div>
        <!--  
        echo "<div class=\"mb-4\" id=\"pageImg\"><img src=\"../../uploads/thumbnails/$thisMainImage\"/></div>";
        echo "<div class=\"mb-4\" id=\"pageGoogleImg\"><img src=\"../../uploads/display/$thisGoogleImage\"/></div>"; -->

    </div>
</div>
<!-- <?php include(INCLUDES_PATH . "/footer.php"); ?> -->