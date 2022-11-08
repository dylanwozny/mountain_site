<?php require_once('../../../private/initialize.php');

// page variables
$page_title = "Add New";


include(PRIVATE_PATH . '/includes/header.php');

//TEST
//if test else set to ''
$test = $_GET['test'] ?? '';

if ($test == '404') {
    error_404();
} elseif ($test == '505') {
    error_505();
} elseif ($test == 'redirect') {
    redirect_to('../index.php');
}

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

// file upload
$uploadOk = 1;
$imageFileType = '';

//------Google image file logic--------
$gImg = 'select a file';

// if post request/ form submitted
if (is_post_request()) {
    $thisTitle = $_POST['title'];
    $thisDescription = $_POST['description'];
    $thisProvince = $_POST['province'];

    $thisVerticalRelief = $_POST['vertical-relief'];
    $thisHeight = $_POST['height'];
    $thisSummit = $_POST['first-summit'];

    $thisAccess = $_POST["access"];
    // $thisGoogleImage = $_POST["file-g"];
    // $thisMainImage = $_POST['mtn-img'];


    // volcano logic for displaying
    $thisIsVolcano = $_POST['is-volcano'];



    // if file input is empty
    // if ($check !== '') {
    //     echo "file is an image -" . $check;
    //     $uploadOk = 0;
    // } else {
    //     echo "File is not an image.";
    //     $uploadOk = 0;
    // }
    $check = $_FILES['file-g']['tmp_name'];

    if ($check === "") {
        $ImgPromptGoogle = "Please upload an image";
        $valisPass = 0;
    } elseif ($_FILES['file-g']['type'] != "image/jpeg") {
        $ImgPromptGoogle = ".jpg images only";
        echo $_FILES['file-g']['type'];
        $valisPass = 1;
    } else {
        $ImgPromptGoogle = "";
        $gImg = $_FILES['file-g']['name'];
        echo $gImg;
    }





    //------Standard image file logic--------
    //     if (!isset($_FILES['mtn-img'])) {
    //         $ImgPromptGoogle = "please upload a file | ";
    //         $passVal = 0;
    //     } else if (($newGoogleImageType != 'jpg') && ($newGoogleImageType != "jpeg")) {
    //         $ImgPromptGoogle = "This is not a valid jpg image type | ";
    //         $passVal = 0;
    //     } else {
    //         $newImage = basename($_FILES['mtn-img']['name']);
    //         $newImageType = basename($_FILES['mtn-img']['type']);
    //     }
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
            <form id="myform" enctype="multipart/form-data" name="myform" method="post" action="<?php echo h("new.php") ?>">
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