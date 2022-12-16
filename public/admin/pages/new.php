<?php require_once('../../../private/initialize.php');

// page variables
$page_title = "Add New";


include(PRIVATE_PATH . '/includes/header.php');


if (!(isset($_SESSION["x5ghy789soci"]))) {
    redirect_to(WWW_ROOT . "/index.php");
}
// setting vars for first page load
$mtnData = [];

$mtnData["mtn_image"] = 'no image found';
$mtnData["title"] = "";
$mtnData["description"] = "";
$mtnData["province"] = "";
$mtnData["vertical_relief"] = "";
$mtnData["vertical_relief"] = "";
$mtnData["height"] = "";
$mtnData["height"] = "";
$mtnData["first_summit"] = "";
$mtnData["is_volcano"] = "";
$mtnData["access"] = null;

// check for files
$mtnData["google_img"] = 'no image found';
$mtnData["mtn_img"] = 'no image found';



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

$errors = [];

// if post request/ form submitted
if (is_post_request()) {

    //----------------------------------------
    //-----------------Grab values from form---------------------
    //----------------------------------------
    //-----------------(Submit)Put form data into assoc array---------------------


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

    // check for files
    $mtnData["google_img"] = 'no image found';
    $mtnData["mtn_img"] = 'no image found';
    //---------------------------------------
    //----------------------------------------------
    // ----------VALIDATION SERVER SIDE------------
    //----------------------------------------------
    // putting in temp name for image files 
    // cast files array into var if it exists
    if ($_FILES['file-m']) {
        $mtnData["mtn_img"] = $_FILES['file-m'];
    };

    if ($_FILES['file-g']) {
        $mtnData["google_img"] = $_FILES['file-g'];
    };

    //-----------------insert query---------------------
    $result = insert_mountain($mtnData);

    if ($result === true) {
        //-----------------grab new id---------------------
        $new_id = mysqli_insert_id($con);
        //------ store message in session temp to display ---
        $_SESSION['message'] = 'mtn has been created.';
        // redirect to new mountain page
        redirect_to(WWW_ROOT . "/page.php?mtn_id=" . $new_id);
    } else {
        // grab errors from validation
        $errors = $result;
    }
} else {
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
            <form id="myform" enctype="multipart/form-data" name="myform" method="post" action="<?php echo h("new.php") ?>">
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
                    <input type="hidden" name="access" id="access" class="form-control">
                    <br />Hike<input type="radio" name="access" id="access" class="form-control" value="hike" <?php RadioCheck(h($mtnData["access"]), "hike"); ?>>
                    Vehicle<input type="radio" name="access" id="access" class="form-control" value="vehicle" <?php RadioCheck(h($mtnData["access"]), "vehicle"); ?>>
                    Helicopter<input type="radio" name="access" id="access" class="form-control" value="helicopter" <?php RadioCheck(h($mtnData["access"]), "helicopter"); ?>>
                    <?php echo $mtnData['access'];
                    if (isset($errors['access'])) {
                        echo " <p class=\"alert alert-danger\">" . "{$errors['access']}" . "</p>";
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
                    <input type="submit" name="submit" class="green-button" value="Add Mtn">
                </div>
            </form>
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
</section>

<?php
include(INCLUDES_PATH . "/footer.php");
?>