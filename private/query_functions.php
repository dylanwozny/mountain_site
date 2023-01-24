<?php

require_once("query_functions.php");

function connect_db()
{
    // query function in var
    $connection = mysqli_connect("localhost", "root", "Megatron14", "dwozny2_mountains");
    //check for errors
    confirm_db_connect();
    return $connection;
}

// put reuslts into var
$con = connect_db();



///--------------------------------------------------
///-------------calls to DB--------------------------
///--------------------------------------------------

//-------------- all mountains ----------------
function find_all_mtns()
{
    global $con;
    $sql = "SELECT * FROM dyl_mountains ORDER BY title ASC";
    $mtn_result = mysqli_query($con, $sql);
    //error handling
    confirm_result_set($mtn_result);

    return $mtn_result;
}

//-------------- Single mountains edit/new ----------------
function find_mtn($id)
{
    global $con;
    $id = db_escape($con, $id);
    // single quote around variable for injection security
    $sql = "SELECT * FROM dyl_mountains WHERE mtn_id = '" . $id . "'";

    $result = mysqli_query($con, $sql);
    confirm_result_set($result);
    $mtn = mysqli_fetch_assoc($result);
    // remove from memory. good practice. Not required.
    mysqli_free_result($result);
    return $mtn;
}


// ---------Search Render-----------------------
function search_create_list($searchTerm)
{
    h($searchTerm);
    // if there is a value in field
    if ($searchTerm) {
        //------------- function for sql search ------------//
        $result = search_mtn($searchTerm);
?>

        <div class="container p-0">
            <section class="p-0 d-flex justify-content-start gap-3 flex-wrap">
                <?php
                // if no rows are returned. no results
                if (!mysqli_num_rows($result)) {
                    $userPrompt = "no results for '" . $searchTerm . "' ";
                    // while rows returned are greater than 0
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $title = h($row['title']);
                        $description = h($row['description']);
                        $firstSummit = h($row['first_summit']);
                        $access = h($row['access']);
                        $province = h($row['province']);
                        $mtnId = h(u($row['mtn_id']));
                        $height = h($row['height']);
                        $vertical = h($row['vertical_relief']);
                        $vertical = h(strval($vertical));
                        $mtnImage = h((string)$row['mtn_image']);
                        $isVolcano = $row["is_volcano"];
                        if ($isVolcano) {
                            $volcanoText = 'is a volcano';
                        } else {
                            $volcanoText = 'not a volcano';
                        }
                ?>
                        <div class="home-card d-flex flex-column gap-4 justify-content-between rounded-top shadow-lg p-0 text-capitalize ">
                            <div>
                                <div class="">
                                    <img class="mtn-card-gradient rounded-top img-fluid" src="<?php echo "uploads/thumbnails/" .  h($mtnImage) ?>" alt="">
                                </div>
                                <div class="d-flex justify-content-between align-items-center p-3 gap-2">
                                    <?php
                                    echo "<h4 class=\"displayCategory lh-base m-0\">" . h($title) . "</h4>\n";
                                    echo "<div class=\"displayCategory fs-3 text-secondary lh-base\">" . h($height) . "m</div>\n";
                                    ?>
                                </div>
                                <div class="d-flex p-3 align-items-center justify-content-between gap-4 border border-end-0 border-start-0 border-bottom-0 mb-3 ">
                                    <?php echo "<div class=\"1h-1 fs-4 fw-bold  text-uppercase\">" . h($province) . "</div>\n" ?>
                                    <?php echo "<div class=\"display-category  fs-normal \">" . h($access) . " Access</div>\n"; ?>
                                    <?php echo "<div class=\"display-category   fst-italic\">" . h($volcanoText) . "</div>\n"; ?>
                                </div>
                                <p class="p-3">
                                    <?php echo h($description); ?>
                                </p>
                            </div>

                            <div class="p-3 ms-auto"><a href=<?php echo "\"page.php?mtn_id=" . h(u($mtnId)) . "\"" ?> class='left-auto btn btn-secondary d-block'>Details</a></div>

                        </div>







            <?php
                        //Create html card
                        // echo "\n<div class='jumbotron row'>";
                        // echo "\n<div class='col-md-4'>";
                        // echo "\n\t<h3>$title</h3>";
                        // echo "\n\t<p class=\"description\">Description: $description</p>";
                        // echo "\n\t<p>First Summit: $firstSummit </p>";
                        // echo "\n\t<p>Access Type: $access</p>";
                        // echo "\n\t<p>Province: $province </p>";
                        // echo "\n\t<p>Height: $height</p>";
                        // echo "\n\t<p>Vertical Relief: $vertical</p>";
                        // echo "\n\t<a href=\"page.php?mtn_id=$mtnId\">View Mountain Page</a>";
                        // echo "\n</div>";
                        // echo "\n<div class='col-md-8'>";
                        // echo "<img src=\"uploads/display/$mtnImage\" class=\"\" /><br/>\n";
                        // echo "\n</div>";
                        // echo "\n</div>";
                    }
                }
            } else {

                $userPrompt = "please search something before submitting";
            }

            // return message
            if (isset($userPrompt)) {
                return $userPrompt;
            }
            ?>
            </section>
        </div>
    <?php
}
//------------ Mountain Search -----------------
function search_mtn($searchTerm)
{
    global $con;

    // prevent sqli injection of dynamic data
    $searchTerm = db_escape($con, $searchTerm);

    $sql = "SELECT * FROM dyl_mountains WHERE title LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%' OR first_summit LIKE '%$searchTerm%' OR access LIKE '%$searchTerm%' or province LIKE '%$searchTerm%' or height LIKE '%$searchTerm%' or vertical_relief LIKE '%$searchTerm%'";

    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    confirm_result_set($result);

    return $result;
}

//---------- Filter mountains -----------

function filter_Height($textTitle = "<h2>2500m to 5000m high </h2>", $lowest = 2500, $tallest = 5000)
{
    // grab global connection var
    global $con;
    echo $textTitle;
    $lowest = db_escape($con, $lowest);
    $tallest = db_escape($con, $tallest);


    $heightLow = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE height BETWEEN '{$lowest}' AND '{$tallest}' LIMIT 4");
    confirm_result_set($heightLow);
    while ($row = mysqli_fetch_array($heightLow)) {
        $title = $row['title'];
        $mtnId = $row['mtn_id'];
        echo "<div><a href=\"page.php?mtn_id=$mtnId\"><p>" . $title . "</p></a></div>";
    }
}


//---------- Filter mountains by category-----------


// --------- Check if query succeeded ----------
function confirm_result_set($result_set)
{
    if (!$result_set) {
        exit('Data Base Query failed');
    }
}


// ---------Disconnect from db. Placed in footer.-------
function db_disconnect($con)
{
    if (isset($con)) {
        mysqli_close($con);
    }
}

// ----------Check connection Error Handling-------------------
// true or false if there is an error
function confirm_db_connect()
{
    if (mysqli_connect_errno()) {
        // fetch the error string message
        $msg = "Failed to connect to MySQL: " . mysqli_connect_error();
        // stop php executing
        exit($msg);
    }
}

//-----------------grab one mtn(for page)---------------------
function find_mtn_page($id)
{
    // single quote around variable for injection security
    global $con;
    $id = db_escape($con, $id);
    $result = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE mtn_id = '{$id}'");
    $oneMtn = mysqli_fetch_assoc($result);
    confirm_result_set($result);
    mysqli_free_result($result);
    return $oneMtn;
}


//----------------------------------------
//-----------------INSERT---------------------
//----------------------------------------

function insert_mountain($mtnData)
{
    global $con;
    // validation
    $errors = validate_mtn($mtnData);
    // return errors if there is any
    if (!empty($errors)) {
        return $errors;
    } else {

        //-----------------Upload Image---------------------
        // uploading image and catching the images name to be put in sql query.
        $mtn_image_name = upload_Image($mtnData['mtn_img'], "display");
        $mtn_G_image_name = upload_Image($mtnData['google_img'], "google-img");

        //-----------------Create Thumbnail---------------------
        create_thumbnail_Jpg($mtn_image_name, 500, PUBLIC_PATH . '/uploads/thumbnails/');

        // going thru array and preventing sql injection if its a string
        foreach ($mtnData as $data) {
            if (is_string($data)) {
                db_escape($con, $data);
            }
        }

        // sql query 
        $sql = "INSERT INTO dyl_mountains(";
        $sql .= "title,description,province,mtn_image,";
        $sql .= "vertical_relief,height,first_summit,is_volcano,";
        $sql .= "access,google_img)";
        $sql .= " VALUES('" . $mtnData['title'] . "',";
        $sql .= "'" . $mtnData['description'] . "',";
        $sql .= "'" . $mtnData['province'] . "',";
        $sql .= "'" . $mtn_image_name . "',";
        $sql .= "'" . $mtnData['vertical_relief'] . "',";
        $sql .= "'" . db_escape($con, $mtnData['height']) . "',";
        $sql .= "'" . $mtnData['is_volcano'] . "',";
        $sql .= "'" . $mtnData['first_summit'] . "',";
        $sql .= "'" . $mtnData['access'] . "',";
        $sql .= "'" . $mtn_G_image_name . "')";

        $result = mysqli_query($con, $sql);


        if ($result) {
            return true;
        } else {
            echo mysqli_error($con);
            db_disconnect($con);
            exit;
        }
    }
}


//-------------------------------------------
//-----------------FILE upload logic---------
//-------------------------------------------
function upload_image($image, $location)
{
    // grab the files name 
    $mainImageName = $image['name'];

    // -----------replace unwanted characters. For security sake.------------
    $pathInfo = pathinfo($mainImageName);
    $base = $pathInfo['filename'];
    // replace regex
    $base = preg_replace("/[^\w-]/", "_", $base);

    // set the file name
    $filename = $base . "." . $pathInfo['extension'];

    // add slashed to file path name
    $location = "/" . $location . "/";

    // set the files upload destination
    $destination = PUBLIC_PATH . "/uploads" . $location . $filename;

    echo "<br/>" . "The cleaned name" . $filename . "<br/>";
    echo "<br/>" . "The cleaned name" . $image["tmp_name"] . "<br/>";
    //  write the file to the specified folder. 
    // MAKE SURE SERVER HAS WRITE PERMISSION
    if (!move_uploaded_file($image["tmp_name"], $destination)) {
        exit("cant upload file");
    }

    // return file name for sql storage
    return $filename;
}

//-------------------------------------------
//-----------------Thumbnail Creation-------
//-------------------------------------------
function create_thumbnail_Jpg($imgName, $thisThumbWidth, $thumbsDestination)
{
    // orginal file location
    $thisOgFilePath = PUBLIC_PATH . "/uploads/display/" . $imgName;

    list($width, $height) =  getimagesize(
        $thisOgFilePath
    );
    // resize to become a thumbnail

    echo $width . $height;
    // get the original image ratio
    $imgRatio = $width / $height;

    // create the thumb height by processing the given width
    $thisThumbHeight = $thisThumbWidth / $imgRatio;

    // create a image with the calculated width and height
    $thumb = imagecreatetruecolor(550, $thisThumbHeight);

    // creates an image from the original
    $source = imagecreatefromjpeg($thisOgFilePath);

    //resize
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, 550, $thisThumbHeight, $width, $height);

    // crop to fit cards correctly
    $thumb = imagecrop($thumb, array(
        "x" => 0,
        "y" => 0,
        "width" => 550,
        "height" => 360
    ));


    //output_
    $newFilename = $thumbsDestination . $imgName;

    //save file
    imagejpeg($thumb, $newFilename, 80);

    // remove from memory
    imagedestroy($thumb);
    imagedestroy($source);
}



// 
// 
// NEED ONLY UPDATE ONE IMAG LOGIC
// 
// 
// 
//----------------------------------------
//-----------------UPDATE-----------------
//----------------------------------------
//-----------------Associate array passed property---------------------
// hasFile checks for img upload. If none, do not upload the image;
function update_mountain($mtnData, $needFile = true)
{
    global $con;

    // upload image flags
    $removeGImg = false;
    $removeMtnImg = false;
    //------------------validation before update--------------------
    // could of just had flag that ignores no image error..
    $errors = validate_mtn($mtnData);

    // escape html special characters on each array error
    foreach ($errors as $error) {
        h($error);
    }


    // does the data given have image files ?
    $hasFile = true;

    // prevent sql injection
    foreach ($mtnData as $data) {
        if (is_string($data)) {
            db_escape($con, $data);
        }
    }

    //-----------------Validation logic allowing no images-------
    // has error messages
    if (!empty($errors)) {
        // does this upload require a file image ?
        if (!$needFile) {
            // determine if there are errors inside all other messages
            if (!empty($errors['title']) || !empty($errors['description']) || !empty($errors['province']) || !empty($errors['vertical_relief']) || !empty($errors['height']) || !empty($errors['first_summit']) || !empty($errors['access'])) {
                // return errors but set image errors to nothing
                $errors['mtn_img'] = null;
                $errors['google_img'] = null;
                return $errors;
            } else {
                // checking for which image is empty
                if ($errors['mtn_img']) {
                    // if images empty don't upload
                    if ($errors['mtn_img'] == "no file uploaded") {
                        // remove mtn_img from query
                        $removeMtnImg = true;
                    } else {
                        return $errors['mtn_img'];
                    }
                }

                if ($errors['google_img']) {
                    // if images empty don't upload
                    if ($errors['google_img'] == "no file uploaded") {
                        // remove mtn_img from query
                        $removeGImg = true;
                    } else {
                        return $errors['google_img'];
                    }
                }

                if (!empty($errors['google_img']) && !empty($errors['google_img'])) {

                    // only image errors, set flag that lets the if logic below know
                    // continue with function and pass validation
                    $hasFile = false;
                }
            }
            // File are required. Return errors.
        } else {
            return $errors;
        }
    }


    // if the upload has a image attached update and create thumbnail images, else
    // update everything else except images, no thumbnail.
    if ($hasFile) {
        if ($removeGImg) {
            // no google create or upload
            //-----------------Upload Image---------------------
            // uploading image and catching the images name to be put in sql query.
            $mtn_image_name = upload_Image($mtnData['mtn_img'], "display");

            //-----------------Create Thumbnail---------------------
            create_thumbnail_Jpg($mtn_image_name, 500, PUBLIC_PATH . '/uploads/thumbnails/');
            // create_thumbnail_Jpg($mtn_G_image_name, 120, PUBLIC_PATH . '/uploads/thumbnails/');
            $sql = "UPDATE dyl_mountains SET ";
            $sql .= "title ='" . $mtnData['title'] . "',";
            $sql .= "description ='" . $mtnData['description'] . "',";
            $sql .= "province ='" . $mtnData['province'] . "',";
            $sql .= "mtn_image ='" . $mtn_image_name . "',";
            $sql .= "vertical_relief ='" . $mtnData['vertical_relief'] . "',";
            $sql .= "height ='" . $mtnData['height'] . "',";
            $sql .= "first_summit ='" . $mtnData['first_summit'] . "',";
            $sql .= "is_volcano ='" . $mtnData['is_volcano'] . "',";
            $sql .= "access ='" . $mtnData['access'] . "',";
            $sql .= "WHERE mtn_id ='" . $mtnData['mtn_id'] . "'";
            $sql .= " LIMIT 1";
        } elseif ($removeMtnImg) {
            // no ntm img upload
            //-----------------Upload Image---------------------
            // uploading image and catching the images name to be put in sql query.
            $mtn_G_image_name = upload_Image($mtnData['google_img'], "google-img");

            //-----------------Create Thumbnail---------------------
            // create_thumbnail_Jpg($mtn_G_image_name, 120, PUBLIC_PATH . '/uploads/thumbnails/');
            $sql = "UPDATE dyl_mountains SET ";
            $sql .= "title ='" . $mtnData['title'] . "',";
            $sql .= "description ='" . $mtnData['description'] . "',";
            $sql .= "province ='" . $mtnData['province'] . "',";
            $sql .= "vertical_relief ='" . $mtnData['vertical_relief'] . "',";
            $sql .= "height ='" . $mtnData['height'] . "',";
            $sql .= "first_summit ='" . $mtnData['first_summit'] . "',";
            $sql .= "is_volcano ='" . $mtnData['is_volcano'] . "',";
            $sql .= "access ='" . $mtnData['access'] . "',";
            $sql .= "google_img ='" . $mtn_G_image_name . "'";
            $sql .= "WHERE mtn_id ='" . $mtnData['mtn_id'] . "'";
            $sql .= " LIMIT 1";
        } else {
            // upload both
            //-----------------Upload Image---------------------
            // uploading image and catching the images name to be put in sql query.
            $mtn_image_name = upload_Image($mtnData['mtn_img'], "display");
            $mtn_G_image_name = upload_Image($mtnData['google_img'], "google-img");

            //-----------------Create Thumbnail---------------------
            create_thumbnail_Jpg($mtn_image_name, 500, PUBLIC_PATH . '/uploads/thumbnails/');
            // create_thumbnail_Jpg($mtn_G_image_name, 120, PUBLIC_PATH . '/uploads/thumbnails/');
            $sql = "UPDATE dyl_mountains SET ";
            $sql .= "title ='" . $mtnData['title'] . "',";
            $sql .= "description ='" . $mtnData['description'] . "',";
            $sql .= "province ='" . $mtnData['province'] . "',";
            $sql .= "mtn_image ='" . $mtn_image_name . "',";
            $sql .= "vertical_relief ='" . $mtnData['vertical_relief'] . "',";
            $sql .= "height ='" . $mtnData['height'] . "',";
            $sql .= "first_summit ='" . $mtnData['first_summit'] . "',";
            $sql .= "is_volcano ='" . $mtnData['is_volcano'] . "',";
            $sql .= "access ='" . $mtnData['access'] . "',";
            $sql .= "google_img ='" . $mtn_G_image_name . "'";
            $sql .= "WHERE mtn_id ='" . $mtnData['mtn_id'] . "'";
            $sql .= " LIMIT 1";
        }
    } else {
        $sql = "UPDATE dyl_mountains SET ";
        $sql .= "title ='" . $mtnData['title'] . "',";
        $sql .= "description ='" . $mtnData['description'] . "',";
        $sql .= "province ='" . $mtnData['province'] . "',";
        $sql .= "vertical_relief ='" . $mtnData['vertical_relief'] . "',";
        $sql .= "height ='" . $mtnData['height'] . "',";
        $sql .= "first_summit ='" . $mtnData['first_summit'] . "',";
        $sql .= "is_volcano ='" . $mtnData['is_volcano'] . "',";
        $sql .= "access ='" . $mtnData['access'] . "'";
        $sql .= "WHERE mtn_id ='" . $mtnData['mtn_id'] . "'";
        $sql .= " LIMIT 1";
    }



    //-----------------Run the query---------------------
    $updateResult = mysqli_query($con, $sql);

    //-----------------redirect to mtn page or stop---------------------
    if ($updateResult) {
        return true;
    } else {
        echo mysqli_error($con);
        db_disconnect($con);
        exit;
    }
}

//--------------------------------------------
//-----------------DELETE---------------------
//--------------------------------------------

function delete_mountain($mtnid)
{
    global $con;



    $sql = "DELETE FROM dyl_mountains";
    $sql .= " WHERE mtn_id ='" . db_escape($con, $mtnid) . "'";
    $sql .= "LIMIT 1";

    //-----------------Run the query---------------------
    $deleteResult = mysqli_query($con, $sql);

    //-----------------redirect to mtn page or stop---------------------
    if ($deleteResult) {
        //------ store message in session temp to display ---
        $_SESSION['message'] = 'mountain has been deleted.';
        redirect_to("../index.php");
    } else {
        echo mysqli_error($con);
        db_disconnect($con);
        exit;
    }
}
