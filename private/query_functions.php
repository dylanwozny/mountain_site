<?php

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
///-------------calls to DB---------------------------
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

function insert_mountain($title, $desc, $prov, $vert, $height, $summit, $access, $vol, $img, $imgG)
{
    global $con;
    $sql = "INSERT INTO dyl_Mountains(title, description, province, mtn_image, vertical_relief, height, first_summit, is_volcano, access, google_img) VALUES('$title','$desc','$prov','$img','$vert','$height','$summit','$vol','$access','$imgG')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        return true;
    } else {
        echo mysqli_error($con);
        db_disconnect($con);
        exit;
    }
}

//----------------------------------------
//-----------------UPDATE---------------------
//----------------------------------------
//-----------------Associate array passed property---------------------
function update_mountain($mtnData)
{
    global $con;
    $sql = "UPDATE dyl_mountains SET ";
    $sql .= "title ='" . $mtnData['title'] . "',";
    $sql .= "description ='" . $mtnData['description'] . "',";
    $sql .= "province ='" . $mtnData['province'] . "',";
    $sql .= "mtn_image ='" . $mtnData['mtn_image'] . "',";
    $sql .= "vertical_relief ='" . $mtnData['vertical_relief'] . "',";
    $sql .= "height ='" . $mtnData['height'] . "',";
    $sql .= "first_summit ='" . $mtnData['first_summit'] . "',";
    $sql .= "is_volcano ='" . $mtnData['is_volcano'] . "',";
    $sql .= "access ='" . $mtnData['access'] . "',";
    $sql .= "google_img ='" . $mtnData['google_img'] . "'";
    $sql .= "WHERE mtn_id ='" . $mtnData['mtn_id'] . "'";
    $sql .= " LIMIT 1";

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
