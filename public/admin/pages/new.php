<?php require_once('../../../private/initialize.php');

// page variables
$page_title = "Add New";


include(PRIVATE_PATH . '/includes/header.php');

// default vars
$thisTitle = '';
$thisDescription = '';
$thisProvince = '';
$thisMainImage = '';
$thisVerticalRelief = '';
$thisHeight = '';
$thisSummit = '';
$thisIsVolcano = '';
$thisAccess = '';
$thisGoogleImage = '';

//validation messsage vars
$userPrompt = "";
$titleMessage = "";
$desMessage = "";
$ImgPromptMain = "";
$verMessage = "";
$newHeightMessage = "";
$SumMessage = "";
$ImgPromptGoogle = "";
$heightMessage = "";
$volcanoMessage = "";
$accessMessage = "";
$provinceMessage = "";

// file upload
$uploadOk = 1;
$imageFileType = '';

//------Google image file logic--------
$gImg = 'select a file';
$mImg = '';

// if post request/ form submitted
if (is_post_request()) {
    $thisTitle = $_POST['title'];
    $thisDescription = $_POST['description'];
    $thisProvince = $_POST['province'];

    $thisVerticalRelief = $_POST['vertical-relief'];
    $thisHeight = $_POST['height'];
    $thisSummit = $_POST['first-summit'];

    $thisAccess = $_POST["access"];
    $thisIsVolcano = $_POST['is-volcano'];
    //----------------------------------------------
    // ----------VALIDATION SERVER SIDE------------
    //----------------------------------------------
    // putting in temp name for image files 
    $checkImgG = $_FILES['file-g']['tmp_name'];
    $checkImgM = $_FILES['file-m']['tmp_name'];
    // Validation pass flag
    $validPass = 0;

    //-------------FILES------------
    // Google Image
    // check for empty upload and .jpg file type.
    if ($checkImgG === "") {
        $ImgPromptGoogle = "Please upload an image";
        $validPass = 1;
    } elseif ($_FILES['file-g']['type'] != "image/jpeg") {
        $ImgPromptGoogle = ".jpg images only";
        echo $_FILES['file-g']['type'];
        $validPass = 1;
    } else {
        $ImgPromptGoogle = "";
        $gImg = $_FILES['file-g']['name'];
        echo $gImg;
        $validPass = 0;
    }
    // Main Image
    // check for empty upload and .jpg file type.

    if ($checkImgM === "") {
        $ImgPromptMain = "please upload an image";
        $validPass = 1;
    } elseif ($_FILES['file-m']['type'] != "image/jpeg") {
        $ImgPromptMain = '.jpg images only';
        echo $_FILES['file-m']['type'];
        $validPass = 1;
    } else {
        $ImgPromptMain = "";
        $mImg = $_FILES['file-m']['name'];
        echo $mImg;
        $validPass = 0;
    }

    //-------------TEXT and NUMBERS------------
    if ($thisDescription == "" || strlen($thisDescription) <= 0 || strlen($thisDescription) >= 500) {
        $desMessage = "please give a description between 1 and 500 letters";
        $validPass = 0;
    }

    if ($thisTitle == "" || strlen($thisTitle) <= 0 || strlen($thisTitle) >= 40) {
        $titleMessage = "please give a title between 1 and 40 letters";
        $validPass = 0;
    }

    if ($thisVerticalRelief == "" || is_int($thisVerticalRelief) || $thisVerticalRelief >= 10000 || $thisVerticalRelief <= 0) {
        $verMessage = "Vertical Relief must be an integer between 1 and 10 000 ";
        $passVal = 0;
    }
    if ($thisHeight == "" || $thisHeight >= 10000 || $thisHeight <= 0) {
        $heightMessage = "Height must be an integer between 1 and 10 000 | ";
        $passVal = 0;
    }

    if ($thisSummit == "" || strlen($thisSummit) <= 0 || strlen($thisSummit) >= 80) {
        $SumMessage = "please give a summit description between 1 and 80 letters | ";
        $passVal = 0;
    }
    // -------- Access radio Buttons----------
    if (!$thisAccess) {
        $accessMessage = "please select a access type";
    }
    //-------- Province drop down--------------
    if ($thisProvince === "none") {
        $provinceMessage = "Please select a province";
        echo $thisProvince;
    }
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

<a href="../index.php" class="back-link">&laquo; back to dashboard</a>

<header>
    <h1><?php echo "{$page_title}" ?></h1>
</header>
<section>
    <div class="row">
        <div class="col-md-6">
            <?php
            if ($userPrompt) {
                echo "<div class='alert alert-primary'>$userPrompt</div>";
            }
            ?>
            <!-- h(remove special characters function) -->
            <form id="myform" enctype="multipart/form-data" name="myform" method="post" action="<?php echo h("create.php") ?>">
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
                    <?php if ($provinceMessage) {
                        echo " <p class=\"alert alert-danger\">" . "$provinceMessage" . "</p>";
                    } ?>
                </div>
                <div class="form-group">
                    <label for="file">Main Image to Upload</label>
                    <input type="file" id="file-m" name="file-m" class="form-control" value="<?php echo h($thisMainImage) ?>">
                    <?php if ($ImgPromptMain) {
                        echo " <p class=\"alert alert-danger\">" . "$ImgPromptMain" . "</p>";
                    } ?>
                </div>
                <div class="form-group">
                    <label for="vertical-relief">Vertical-Relief:</label>
                    <input type="number" name="vertical-relief" id="vertical-relief" class="form-control" value="<?php echo h($thisVerticalRelief); ?>">
                    <?php if ($verMessage) {
                        echo " <p class=\"alert alert-danger\">" . "$verMessage" . "</p>";
                    } ?>
                </div>
                <div class="form-group">
                    <label for="height">Height (meters):</label>
                    <input type="number" name="height" id="height" class="form-control" value="<?php echo h($thisHeight); ?>">
                    <?php if ($heightMessage) {
                        echo " <p class=\"alert alert-danger\">" . "$heightMessage" . "</p>";
                    } ?>
                </div>
                <div class="form-group">
                    <label for="first-summit">First Summit Description:</label>
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
                    <?php if ($accessMessage) {
                        echo " <p class=\"alert alert-danger\">" . "$accessMessage" . "</p>";
                    } ?>
                </div>
                <div class="form-group">
                    <label for="file-g">Google Image to Upload:</label>
                    <input accept="image/jpeg" type="file" id="file-g" name="file-g" class="form-control">
                    <?php if ($ImgPromptGoogle) {
                        echo " <p class=\"alert alert-danger\">" . "$ImgPromptGoogle" . "</p>";
                    } ?>
                </div>
                <div class="form-group">
                    <label for="submit">&nbsp;</label>
                    <input type="submit" name="submit" class="green-button" value="new image">
                </div>
            </form>
        </div>

    </div>
</section>

<?php
include(INCLUDES_PATH . "/footer.php");
?>