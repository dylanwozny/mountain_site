<?php

require_once("../../../private/initialize.php");

// page variables
$page_title = "Edit Mountain";

//put after vars so page title is read
include(PRIVATE_PATH . '/includes/header.php');

if (!(isset($_SESSION["x5ghy789soci"]))) {
    redirect_to(WWW_ROOT . "/index.php");
}


//----------------------------------------
//-----------id handling-----------------
//----------------------------------------
// if there is no id in url
// if (!isset($_GET['mtn_id'])) {
//     redirect_to('../index.php');
// }


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

    // ----------------------------------------------
    //-------- UPLOAD AND VALIDATE------------------
    //----------------------------------------------

    $result = update_mountain($mtnData, $hasImage);
    if ($result === true) {
        //------ store message in session temp to display ---
        $_SESSION['message'] = 'mtn has been edited.';
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
<header class=" d-flex align-items-center mb-4">
    <svg class=" svg-w2 me-2" id="Icon_awesome-pencil-alt" viewBox="0 0 25.998 25.999">
        <path id="Icon_awesome-pencil-alt-2" data-name="Icon awesome-pencil-alt" d="M25.284,7.217,22.943,9.558a.61.61,0,0,1-.863,0L16.443,3.922a.61.61,0,0,1,0-.863L18.784.717a2.443,2.443,0,0,1,3.448,0l3.052,3.052A2.434,2.434,0,0,1,25.284,7.217ZM14.432,5.069,1.1,18.4.021,24.574a1.22,1.22,0,0,0,1.412,1.412L7.6,24.9,20.937,11.569a.61.61,0,0,0,0-.863L15.3,5.069a.616.616,0,0,0-.868,0ZM6.3,17.262a.708.708,0,0,1,0-1.005l7.82-7.82a.711.711,0,0,1,1.005,1.005l-7.82,7.82a.708.708,0,0,1-1.005,0ZM4.469,21.532H6.907v1.843l-3.275.574L2.052,22.37l.574-3.275H4.469Z" transform="translate(-0.002 -0.005)" />
    </svg>
    <?php echo "<h2 class='mb-0'>" . h($page_title) .   "</h2>"; ?>
</header>
<a class="back-link fs-5 mb-2 d-block" href="../index.php">&laquo; back to dashboard</a>
<div class="edit-form border shadow-lg p-4">
    <div class="">
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
                <div class="mb-4 " id="pageImg"><img class="img-fluid" src="../../uploads/thumbnails/<?php echo h($mtnData['mtn_image']); ?>" /></div>

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
            <div class="form-check mb-3">
                <label class="form-check-label" for="is-volcano">Is Volcano:</label>
                <input type="hidden" name="is-volcano" id="is-volcano" value="0">
                <input type="checkbox" name="is-volcano" id="is-volcano" class="form-check-input" value="1" <?php if ($mtnData["is_volcano"] == "1") {
                                                                                                                echo "checked";
                                                                                                            }; ?> />


            </div>
            <div class="form-group">
                <label for="access">Access:</label>
                <input type="hidden" name="access" id="access" class="form-control" value="0">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="access" id="access" value="hike" <?php RadioCheck(h($mtnData["access"]), "hike"); ?>>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Hike
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="access" id="access" value="vehicle" <?php RadioCheck(h($mtnData["access"]), "vehicle"); ?>>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Vehicle
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="access" id="access" value="helicopter" <?php RadioCheck(h($mtnData["access"]), "helicopter"); ?>>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Helicopter
                    </label>
                    <?php if (isset($error['access'])) {
                        echo " <p class=\"alert alert-danger\">" . "{$error['access']}" . "</p>";
                    } ?>
                </div>
            </div>
            <div class="form-group">
                <label for="file-g">Google Image to Upload:</label>
                <input accept="image/jpeg" type="file" id="file-g" name="file-g" class="form-control">
                <?php if (isset($errors['google_img'])) {
                    echo " <p class=\"alert alert-danger\">" . $errors['google_img'] . "</p>";
                } ?>
                <div class="mb-4" id="pageImg"><img class="img-fluid" src="../../uploads/google-img/<?php echo $mtnData["google_img"]; ?>" /></div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
                <div class="form-group me-5">
                    <input type="submit" name="submit" class=" btn btn-primary" value="Edit">
                    <a class="btn btn-secondary" href="../index.php"> Cancel</a>
                </div>
                <div>
                    <a class="btn btn-danger" href="delete.php?mtn_id=<?php echo h($mtnId); ?>">Delete</a>

                </div>
            </div>
        </form>

    </div>
    <?php

    ?>
</div>
<?php include(INCLUDES_PATH . "/footer.php"); ?>