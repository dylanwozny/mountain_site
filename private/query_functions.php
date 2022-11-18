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
function find_all_mtns()
{
    global $con;
    $sql = "SELECT * FROM dyl_mountains ORDER BY title ASC";
    $mtn_result = mysqli_query($con, $sql);
    //error handling
    confirm_result_set($mtn_result);

    return $mtn_result;
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
