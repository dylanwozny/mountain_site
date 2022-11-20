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



///-------------------------
// --------call to DB-------
///-------------------------

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

//-------------- Single mountains (page) ----------------
function find_mtn($id)
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE mtn_id = $id");
    return $result;
}


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


//---------- Filter mountains -----------

function filter_Height($textTitle = "<h2>2500m to 5000m high </h2>", $lowest = 2500, $tallest = 5000)
{
    // grab global connection var
    global $con;
    echo $textTitle;
    $heightLow = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE height BETWEEN {$lowest} AND {$tallest} LIMIT 4");
    while ($row = mysqli_fetch_array($heightLow)) {
        $title = $row['title'];
        $mtnId = $row['mtn_id'];
        echo "<div><a href=\"page.php?mtn_id=$mtnId\"><p>" . $title . "</p></a></div>";
    }
}


//---------- Filter mountains by category-----------