<!-- ADD VALIDATION FROM INSERT -->
<?php
require_once("../../../private/initialize.php");

// page variables
$page_title = "Edit Mountain";

//put after vars so page title is read
include(INCLUDES_PATH . "/header.php");
?>


<?php
//----------------------------------------
//-----------------id handling------------
//----------------------------------------
// if there is no id in url
if (!isset($_GET['mtn_id'])) {
    redirect_to('../index.php');
}
//grab id from url, which is what link you clicked
$mtnId = $_GET['mtn_id'];
//sanitze/escape harmful URL html
$mtnId = h($mtnId);


//----------------------------------------
//---------//validation messsage vars-----
//----------------------------------------
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

//----------------------------------------
//------basic page load or form submit----
//----------------------------------------
if (is_post_request()) {
    //-----------------(Submit)Put form data into assoc array---------------------
    $mtnData = [];
    //------Google image file logic--------
    $mtnData["google_img"] = 'select a file';
    $mtnData["mtn_image"] = '';
    $mtnData["title"] = $_POST["title"];
    $mtnData["description"] = $_POST["description"];
    $mtnData["province"] = $_POST["province"];
    $mtnData["vertical_relief"] = $_POST["vertical-relief"];
    $mtnData["vertical_relief"] = (int)$mtnData["vertical_relief"];
    $mtnData["height"] = $_POST["height"];
    $mtnData["height"] = (int)$mtnData["height"];
    $mtnData["first_summit"] = $_POST["first-summit"];
    $mtnData["is_volcano"] = $_POST['is-volcano'];
    $mtnData["access"] = $_POST["access"];
    $mtnData["mtn_id"] = $mtnId;

    //----------------------------------------------
    // ----------VALIDATION SERVER SIDE------------
    //----------------------------------------------
    // putting in temp name for image files 
    $checkImgG = $_FILES['file-g']['tmp_name'];
    $checkImgM = $_FILES['file-m']['tmp_name'];
    // Validation pass flag
    $validPass = true;
    // flags forimage upload or not
    // false if empty and no upload
    $boolGoogleImg = true;
    $boolMainImg = true;

    //-------------FILES------------
    // Google Image
    // if there is no image value submitted allow it to still upload
    if ($_FILES['file-g']['name']) {
        echo $_FILES['file-g']['name'];
        // check for empty upload and .jpg file type.
        if ($checkImgG === "") {
            $ImgPromptGoogle = "Please upload an image";
            $validPass = false;
        } elseif ($_FILES['file-g']['type'] != "image/jpeg") {
            $ImgPromptGoogle = ".jpg images only";
            echo $_FILES['file-g']['type'];
            $validPass = false;
        } else {
            $ImgPromptGoogle = "";
            $mtnData["google_img"] = $_FILES['file-g']['name'];
            echo $mtnData["google_img"];
        }
    } else {
        echo "no file uploaded";
        $boolGoogleImage = false;
        $mtnData["google_img"] = $mtnData["google_img"];
    }


    // Main Image
    // if there is no image value submitted allow it to still upload

    if ($_FILES['file-m']['name']) {
        echo $_FILES['file-g']['name'];
        // check for empty upload and .jpg file type.
        if ($checkImgM === "") {
            $ImgPromptMain = "please upload an image";
            $validPass = false;
        } elseif ($_FILES['file-m']['type'] != "image/jpeg") {
            $ImgPromptMain = '.jpg images only';
            echo $_FILES['file-m']['type'];
            $validPass = false;
        } else {
            $ImgPromptMain = "";
            $mtnData["mtn_image"] = $_FILES['file-m']['name'];
            echo $mtnData["mtn_image"];
        }
    } else {
        echo "no file uploaded";
        $boolMainImg = false;
        $mtnData["mtn_image"] = $mtnData['mtn_image'];
    }


    //-------------TEXT and NUMBERS------------
    if ($mtnData["description"] == "" || strlen($mtnData["description"]) <= 0 || strlen($mtnData["description"]) >= 500) {
        $desMessage = "please give a description between 1 and 500 letters";
        $validPass = false;
    }

    if ($mtnData["title"] == "" || strlen($mtnData["title"]) <= 0 || strlen($mtnData["title"]) >= 40) {
        $titleMessage = "please give a title between 1 and 40 letters";
        $validPass = false;
    }

    if ($mtnData["vertical_relief"] === "" || !is_int($mtnData["vertical_relief"]) || $mtnData["vertical_relief"] >= 10000 || $mtnData["vertical_relief"] <= 0) {
        $verMessage = "Vertical Relief must be an integer between 1 and 10 000 ";
        $validPass = false;
        echo $mtnData["vertical_relief"];
    }
    if ($mtnData["height"] == "" || $mtnData["height"] >= 10000 || $mtnData["height"] <= 0) {
        $heightMessage = "Height must be an integer between 1 and 10 000 | ";
        $validPass = false;
    }

    if ($mtnData["first_summit"] == "" || strlen($mtnData["first_summit"]) <= 0 || strlen($mtnData["first_summit"]) >= 80) {
        $SumMessage = "please give a summit description between 1 and 80 letters | ";
        $validPass = false;
    }
    // -------- Access radio Buttons----------
    if (!$mtnData["access"]) {
        $accessMessage = "please select a access type";
    }
    //-------- Province drop down--------------
    if ($mtnData["province"] === "none") {
        $provinceMessage = "Please select a province";
        echo $mtnData["province"];
    }


    // ----------------------------------------------
    //-------- upload if edit image pressed---------
    //----------------------------------------------
    if ($validPass) {
        //----------------update function call----------------------
        update_mountain($mtnData);
        $userPrompt = "Mountain Edited !";
        //-----------------redirect to mtn page---------------------
        redirect_to(WWW_ROOT . "/page.php?mtn_id=" . $mtnId);
    }
} else {
    //-------------------------------------------------
    //-(page load)Select function for form population----
    //--------------------------------------------------

    // if there is an id, if not set default value
    if (isset($mtnId)) {
        $mtnData = find_mtn($mtnId);
    } else {
        // no id in url
        redirect_to('../index.php');
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



if ($mtnData['province'] == 'ab') {
    $abProvince = "selected";
} else if ($mtnData['province'] == 'bc') {
    $bcProvince = "selected";
} elseif ($mtnData['province'] == 'sk') {
    $skProvince = "selected";
} elseif ($mtnData['province'] == 'nun') {
    $nunProvince = "selected";
} else if ($mtnData['province'] == 'mn') {
    $mnProvince = "selected";
} elseif ($mtnData['province'] == 'on') {
    $onProvince = "selected";
} elseif ($mtnData['province'] == 'qc') {
    $qcProvince = "selected";
} else if ($mtnData['province'] == 'nf') {
    $nfProvince = "selected";
} elseif ($mtnData['province'] == 'nb') {
    $nbProvince = "selected";
} elseif ($mtnData['province'] == 'ns') {
    $nsProvince = "selected";
} else if ($mtnData['province'] == 'pei') {
    $peiProvince = "selected";
} elseif ($mtnData['province'] == 'yk') {
    $ykProvince = "selected";
} elseif ($mtnData['province'] == 'usa') {
    $usaProvince = "selected";
} else if ($mtnData['province'] == "nt")
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
        <form id="myform" enctype="multipart/form-data" name="myform" method="post" action="edit.php?mtn_id=<?php echo h(u($mtnId)) ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" value="<?php echo h($mtnData['title']); ?>">
                <?php if ($titleMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$titleMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control"><?php echo h($mtnData['description']); ?></textarea>
                <?php if ($desMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$desMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="province">Province:</label>
                <select name="province" id="province" value="<?php echo h($mtnData['province']); ?>">
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
                <input type="file" id="file-m" name="file-m" class="form-control" value="<?php echo h($mtnData['mtn_image']) ?>">
                <?php if ($ImgPromptMain) {
                    echo " <p class=\"alert alert-danger\">" . "$ImgPromptMain" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="vertical-relief">Vertical-Relief:</label>
                <input type="number" name="vertical-relief" id="vertical-relief" class="form-control" value="<?php echo h($mtnData['vertical_relief']); ?>">
                <?php if ($verMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$verMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="height">Height (meters):</label>
                <input type="number" name="height" id="height" class="form-control" value="<?php echo h($mtnData['height']); ?>">
                <?php if ($heightMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$heightMessage" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="first-summit">First Summit Description:</label>
                <input type="text" name="first-summit" id="first-summit" class="form-control" value="<?php echo h($mtnData['first_summit']) ?>">
                <?php if ($SumMessage) {
                    echo " <p class=\"alert alert-danger\">" . "$SumMessage" . "</p>";
                } ?>
            </div>
            <!-- NEED THIS FOR CHECK BOX -->
            <div class="form-group">
                <label for="is-volcano">Is Volcano:</label>
                <input type="hidden" name="is-volcano" id="is-volcano" class="form-control" value="0">
                <input type="checkbox" name="is-volcano" id="is-volcano" class="form-control" value="1" <?php if ($mtnData["is_volcano"] == "1") {
                                                                                                            echo "checked";
                                                                                                        }; ?> />


            </div>
            <div class="form-group">
                <label for="access">Access:</label>
                <input type="hidden" name="access" id="access" class="form-control" value="0">
                <br />Hike<input type="radio" name="access" id="access" class="form-control" value="hike" <?php RadioCheck(h($mtnData["access"]), "hike"); ?>>
                Vehicle<input type="radio" name="access" id="access" class="form-control" value="vehicle" <?php RadioCheck(h($mtnData["access"]), "vehicle"); ?>>
                Helicopter<input type="radio" name="access" id="access" class="form-control" value="helicopter" <?php RadioCheck(h($mtnData["access"]), "helicopter"); ?>>
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
                <input type="submit" name="submit" class="green-button" value="edit image">
            </div>
        </form>
        <button class="btn btn-danger" onclick="location.href ='delete.php?mtn_id=<?php echo h($mtnId); ?>'">Delete image</button>
        <button class="btn btn-danger" onclick="location.href='../index.php'"> Cancel</button>
    </div>
    <div class="col-md-6">
        <div class="mb-4" id="pageImg"><img src="../../uploads/thumbnails/<?php echo h($mtnData['mtn_image']); ?>" /></div>
        <div class="mb-4" id="pageImg"><img src="../../uploads/display/<?php echo h($mtnData["google_img"]); ?>" /></div>
        <!--  
        echo "<div class=\"mb-4\" id=\"pageImg\"><img src=\"../../uploads/thumbnails/$mtnData['mtn_image']\"/></div>";
        echo "<div class=\"mb-4\" id=\"pageGoogleImg\"><img src=\"../../uploads/display/$mtnData["google_img"]\"/></div>"; -->

    </div>
    <?php

    ?>
</div>
<!-- <?php include(INCLUDES_PATH . "/footer.php"); ?> -->