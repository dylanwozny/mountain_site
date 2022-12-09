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
    // single quote around variable for injection security
    global $con;
    $result = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE mtn_id = '{$id}'");
    confirm_result_set($result);
    $mtn = mysqli_fetch_assoc($result);
    // remove from memory. good practice. Not required.
    mysqli_free_result($result);
    return $mtn;
}

//------------ Mountain Search -----------------
function search_mtn($searchTerm)
{
    global $con;
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
        $mtn_image_name = upload_Image($mtnData['mtn_img']);
        $mtn_G_image_name = upload_Image($mtnData['google_img']);

        //-----------------Create Thumbnail---------------------
        create_thumbnail_Jpg($mtn_image_name, 120, PUBLIC_PATH . '/uploads/thumbnails/');

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
        $sql .= "'" . $mtnData['height'] . "',";
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
function upload_image($image)
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

    // set the files upload destination
    $destination = PUBLIC_PATH . "/uploads/display/" . $filename;

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
    $thumb = imagecreatetruecolor($thisThumbWidth, $thisThumbHeight);



    // creates an image from the original
    $source = imagecreatefromjpeg($thisOgFilePath);

    //resize
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thisThumbWidth, $thisThumbHeight, $width, $height);

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
    //------------------validation before update--------------------
    // could of just had flag that ignores no image error..
    $errors = validate_mtn($mtnData);

    // does the data given have image files ?
    $hasFile = true;

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
                        return $errors;
                    }
                }

                if ($errors['google_img']) {
                    // if images empty don't upload
                    if ($errors['google_img'] == "no file uploaded") {
                        // remove mtn_img from query
                        $removeGImg = true;
                    } else {
                        return $errors;
                    }
                }

                // only image errors, set flag that lets the if logic below know
                // continue with function and pass validation
                $hasFile = false;
            }
            // File are required. Return errors.
        } else {
            return $errors;
        }
    }


    // if the upload has a image attached update and create thumbnail images, else
    // update everything else except images, no thumbnail.
    if ($hasFile) {
        //-----------------Upload Image---------------------
        // uploading image and catching the images name to be put in sql query.
        $mtn_image_name = upload_Image($mtnData['mtn_img']);
        $mtn_G_image_name = upload_Image($mtnData['google_img']);

        //-----------------Create Thumbnail---------------------
        create_thumbnail_Jpg($mtn_image_name, 120, PUBLIC_PATH . '/uploads/thumbnails/');
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
    $sql .= " WHERE mtn_id =" . "'$mtnid' ";
    $sql .= "LIMIT 1";

    //-----------------Run the query---------------------
    $deleteResult = mysqli_query($con, $sql);

    //-----------------redirect to mtn page or stop---------------------
    if ($deleteResult) {
        redirect_to("../index.php");
    } else {
        echo mysqli_error($con);
        db_disconnect($con);
        exit;
    }
}
