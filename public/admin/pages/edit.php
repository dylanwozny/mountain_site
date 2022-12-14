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
//-----------id handling-----------------
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
//-----validation messsage vars----------
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
//initliaize errors
$errors = [];

//----------------------------------------
//------basic page load or form submit----
//----------------------------------------
if (is_post_request()) {
    //-----------------(Submit)Put form data into assoc array---------------------
    $mtnData = [];
    //------Google image file logic--------
    // $mtnData["google_image"] = 'no image found';
    $mtnData["mtn_image"] = 'no image found';
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

    // check for files
    $mtnData["google_img"] = 'no image found';
    $mtnData["mtn_img"] = 'no image found';

    // cast files array into var if it exists
    if ($_FILES['file-m']) {
        $mtnData["mtn_img"] = $_FILES['file-m'];
    };

    if ($_FILES['file-g']) {
        $mtnData["google_img"] = $_FILES['file-g'];
    };

    // ----------------------------------------------
    // -----------------File logic-----------------
    // ----------------------------------------------
    // Files are stored in $_FILES super global.
    // Files have associate array of properties

    //-----------------Allow no file to be uploaded---------------------
    $hasImage = false;

    // cast files array into var if it exists
    if ($_FILES['file-m']) {
        $mtnData["mtn_img"] = $_FILES['file-m'];
    };

    if ($_FILES['file-g']) {
        $mtnData["google_img"] = $_FILES['file-g'];
    };

    echo print_r($mtnData);
    // ----------------------------------------------
    //-------- UPLOAD AND VALIDATE------------------
    //----------------------------------------------

    $result = update_mountain($mtnData, $hasImage);
    if ($result === true) {
        //-----------------redirect to mtn page---------------------
        redirect_to(WWW_ROOT . "/page.php?mtn_id=" . $mtnId);
    } else {
        // remove special characters
        $errors = $result;
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

//----------------------------------------
//-----------------Delete-----------------
//----------------------------------------
//----Best Practice to use post request for delete--
//--- and not links.---------------------
if (isset($_POST['delete'])) {
    delete_mountain($mtnData);
}

// ---------------drop down select pre-populate------------------
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


//-----------------Select options logic---------------------
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

//-----------------Radio Check---------------------
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
                <?php if (isset($errors['title'])) {
                    echo " <p class=\"alert alert-danger\">" . "{$errors['title']}" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control"><?php echo h($mtnData['description']); ?></textarea>
                <?php if (isset($errors['description'])) {
                    echo " <p class=\"alert alert-danger\">" . "{$errors['description']}" . "</p>";
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
                <?php if (isset($errors['province'])) {
                    echo " <p class=\"alert alert-danger\">" . "{$errors['province']}" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="file">Main Image to Upload</label>

                <input type="file" id="file-m" name="file-m" class="form-control">
                <?php if (isset($errors['mtn_img'])) {
                    echo " <p class=\"alert alert-danger\">" . "{$errors['mtn_img']}" . "</p>";
                } ?>
                <div class="mb-4" id="pageImg"><img src="../../uploads/thumbnails/<?php echo h($mtnData['mtn_image']); ?>" /></div>

            </div>

            <div class="form-group">
                <label for="vertical-relief">Vertical-Relief:</label>
                <input type="number" name="vertical-relief" id="vertical-relief" class="form-control" value="<?php echo h($mtnData['vertical_relief']); ?>">
                <?php if (isset($errors['vertical_relief'])) {
                    echo " <p class=\"alert alert-danger\">" . "{$errors['vertical_relief']}" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="height">Height (meters):</label>
                <input type="number" name="height" id="height" class="form-control" value="<?php echo h($mtnData['height']); ?>">
                <?php if (isset($errors['height'])) {
                    echo " <p class=\"alert alert-danger\">" . "{$errors['height']}" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="first-summit">First Summit Description:</label>
                <input type="text" name="first-summit" id="first-summit" class="form-control" value="<?php echo h($mtnData['first_summit']) ?>">
                <?php if (isset($errors['first_summit'])) {
                    echo " <p class=\"alert alert-danger\">" . "{$errors['first_summit']}" . "</p>";
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
                <?php if (isset($error['access'])) {
                    echo " <p class=\"alert alert-danger\">" . "{$error['access']}" . "</p>";
                } ?>
            </div>
            <div class="form-group">
                <label for="file-g">Google Image to Upload:</label>
                <input accept="image/jpeg" type="file" id="file-g" name="file-g" class="form-control">
                <?php if (isset($errors['google_img'])) {
                    echo " <p class=\"alert alert-danger\">" . $errors['google_img'] . "</p>";
                } ?>
                <div class="mb-4" id="pageImg"><img src="../../uploads/display/<?php echo $mtnData["google_img"]; ?>" /></div>
            </div>
            <div class="form-group">
                <label for="submit">&nbsp;</label>
                <input type="submit" name="submit" class="green-button" value="edit Mtn">
            </div>
        </form>
        <button class="btn btn-danger" onclick="location.href ='delete.php?mtn_id=<?php echo h($mtnId); ?>'">Delete</button>
        <button class="btn btn-danger" onclick="location.href='../index.php'"> Cancel</button>
    </div>
    <div class="col-md-6">


        <!--  
        echo "<div class=\"mb-4\" id=\"pageImg\"><img src=\"../../uploads/thumbnails/$mtnData['mtn_image']\"/></div>";
        echo "<div class=\"mb-4\" id=\"pageGoogleImg\"><img src=\"../../uploads/display/$mtnData["google_img"]\"/></div>"; -->

    </div>
    <?php

    ?>
</div>
<!-- <?php include(INCLUDES_PATH . "/footer.php"); ?> -->