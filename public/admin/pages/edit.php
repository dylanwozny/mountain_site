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
//initliaize errors
$errors = [];
// echo out files array for image properties
echo print_r($_FILES);

//----------------------------------------
//------basic page load or form submit----
//----------------------------------------
if (is_post_request()) {
    //-----------------(Submit)Put form data into assoc array---------------------
    $mtnData = [];
    //------Google image file logic--------
    $mtnData["google_img"] = 'no image found';
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


    //----------------------------------------------
    // -----------------File logic-----------------
    //----------------------------------------------
    // Files are stored in $_FILES super global.
    // Files have associate array of properties
    // echo print_r($_FILES);
    //-----------------VALIDATION---------------------
    // is there a image flag for uploading.
    $hasImage = true;
    // check file upload for errors
    if ($_FILES['file-m']['error'] !== UPLOAD_ERR_OK) {
        switch ($_FILES['file-m']['error']) {
            case UPLOAD_ERR_PARTIAL:
                exit('partial upload of image');
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "NO FILE UPLOADED";
                // set flag for no image to exclude
                // updating images.(for edit only)
                $hasImage = false;
                break;
            case UPLOAD_ERR_EXTENSION:
                exit("files upload stopped by a php extension");
                break;
            case UPLOAD_ERR_EXTENSION:
                exit("files upload to large");
                break;
            case UPLOAD_ERR_INI_SIZE:
                exit("files upload to large for default value of php");
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                exit("temp directory full or not found");
                break;
            case UPLOAD_ERR_CANT_WRITE:
                exit("could not write file");
                break;
            default:
                exit("unknown error");
                break;
        }
    }
    // check file. 
    // this checks $_FILES associate property
    if ($_FILES['file-m']['size'] > 1048576) {
        exit('file size to large');
    }

    // array of allowed file types
    $allowedTypes = ["image/jpeg", "image/gif"];
    if (!isset($_FILES['file-m']['type']) && !in_array($_FILES['file-m']['type'], $allowedTypes)) {
        exit("invalid files type");
    }


    //------------- uploading the file --------------

    // grab the files name 
    $mainImageName = $_FILES['file-m']['name'];
    // $googleImageName = $_FILES = ['file-g']['name'];

    echo $mainImageName;

    // -----------replace unwanted characters. For security sake.------------
    $pathInfo = pathinfo($_FILES['file-m']['name']);
    $base = $pathInfo['filename'];
    // replace regex
    $base = preg_replace("/[^\w-]/", "_", $base);

    // set the file name
    $filename = $base . "." . $pathInfo['extension'];

    // set the files upload destination
    $destination = PUBLIC_PATH . "/uploads/display/" . $filename;

    echo "<br/>" . "The cleaned name" . $filename . "<br/>";
    echo "<br/>" . "The cleaned name" . $_FILES['file-m']["tmp_name"] . "<br/>";
    //  write the file to the specified folder. 
    // MAKE SURE SERVER HAS WRITE PERMISSION
    if (!move_uploaded_file($_FILES['file-m']["tmp_name"], $destination)) {
        exit("cant upload file");
    }

    //----------------------------------------
    //-----------------IMAGE UPLOADS 1 DO REST...---------------------
    //----------------------------------------
    // modify to be put into function and reusable.
    // must also create a thumbnail.

    // //-------------FILES------------
    // // Google Image
    // // if there is no image value submitted allow it to still upload
    // if ($_FILES['file-g']['name']) {
    //     echo $_FILES['file-g']['name'];
    //     // check for empty upload and .jpg file type.
    //     if ($checkImgG === "") {
    //         $ImgPromptGoogle = "Please upload an image";
    //         $validPass = false;
    //     } elseif ($_FILES['file-g']['type'] != "image/jpeg") {
    //         $ImgPromptGoogle = ".jpg images only";
    //         echo $_FILES['file-g']['type'];
    //         $validPass = false;
    //     } else {
    //         $ImgPromptGoogle = "";
    //         $mtnData["google_img"] = $_FILES['file-g']['name'];
    //         echo $mtnData["google_img"];
    //     }
    // } else {
    //     echo "no file uploaded";
    // }


    // // Main Image
    // // if there is no image value submitted allow it to still upload

    // if ($_FILES['file-m']['name']) {
    //     echo $_FILES['file-g']['name'];
    //     // check for empty upload and .jpg file type.
    //     if ($checkImgM === "") {
    //         $ImgPromptMain = "please upload an image";
    //         $validPass = false;
    //     } elseif ($_FILES['file-m']['type'] != "image/jpeg") {
    //         $ImgPromptMain = '.jpg images only';
    //         echo $_FILES['file-m']['type'];
    //         $validPass = false;
    //     } else {
    //         $ImgPromptMain = "";
    //         $mtnData["mtn_image"] = $_FILES['file-m']['name'];
    //         echo $mtnData["mtn_image"];
    //     }
    // } else {
    //     echo "no file uploaded";
    // }


    // ----------------------------------------------
    //-------- upload if edit image pressed---------
    //----------------------------------------------
    //----------------update function call----------------------

    $result = update_mountain($mtnData, $hasImage);
    if ($result === true) {
        $userPrompt = "Mountain Edited !";
        //-----------------redirect to mtn page---------------------
        redirect_to(WWW_ROOT . "/page.php?mtn_id=" . $mtnId);
    } else {
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
//-----------------Delete---------------------
//----------------------------------------
//----Best Practice to use post request for delete--
//--- and not links.---------------------
if (isset($_POST['delete'])) {
    delete_mountain($mtnData);
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
                <?php if ($ImgPromptMain) {
                    echo " <p class=\"alert alert-danger\">" . "$ImgPromptMain" . "</p>";
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
                <input hidden type="text" name="file-g-url" id="file-g-url" value="<?php echo $mtnData['mtn_image']; ?>">
                <input accept="image/jpeg" type="file" id="file-g" name="file-g" class="form-control">
                <?php if ($ImgPromptGoogle) {
                    echo " <p class=\"alert alert-danger\">" . "$ImgPromptGoogle" . "</p>";
                } ?>
                <div class="mb-4" id="pageImg"><img src="../../uploads/display/<?php echo h($mtnData["google_img"]); ?>" /></div>
            </div>
            <div class="form-group">
                <label for="submit">&nbsp;</label>
                <input type="submit" name="submit" class="green-button" value="edit image">
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