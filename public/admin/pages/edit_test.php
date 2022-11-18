<?php require_once('../../../private/initialize.php');


// page variables
$page_title = "Add New";


include(PRIVATE_PATH . '/includes/header.php');
//grab id from url, which is what link you clicked
$mtnId = $_GET['mtn_id'];

//sanitze/escape harmful URL html
$mtnId = h($mtnId);
echo $mtnId;


// if there is an id, if not set default value
if (isset($mtnId)) {
    // FETCH from DB. limit charId to one value
    $result = mysqli_query($con, "SELECT * FROM dyl_mountains LIMIT 1") or die(mysqli_error($con));
} else {
    // no id in url
    $mtnId = 1;
}


// get the existing content for the selected character to populate the current form fields
$result2 = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE mtn_id = $mtnId");
while ($row = mysqli_fetch_array($result2)) {
    $thisTitle = $row['title'];
    $thisDescription = $row['description'];
    $thisProvince = $row['province'];
    $thisMainImage = $row['mtn_image'];
    $thisVerticalRelief = $row['vertical_relief'];
    $thisHeight = $row['height'];
    $thisSummit = $row['first_summit'];
    $thisIsVolcano = $row['is_volcano'];
    $thisAccess = $row["access"];
    $thisGoogleImage = $row["google_img"];
}

if (!$result2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// drop down list pre-populate
$abProvince = "";
$bcProvince = "";
$skProvince = "";
$nunProvince = "";

if ($thisProvince == 'ab') {
    $abProvince = "selected";
} else if ($thisProvince == 'bc') {
    $bcProvince = "selected";
} elseif ($thisProvince == 'sk') {
    $skProvince = "selected";
} elseif ($thisProvince == 'nun') {
    $nunProvince = "selected";
} else {
}


// volcano
$vtest = "hello";

if ($thisIsVolcano === "1") {
    $vtest = "checked";
} else {
    $vtest = "";
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
?>



<a href="../index.php" class="back-link">&laquo; back to dashboard</a>

<header>
    <h1><?php echo "{$page_title}" ?></h1>
</header>
<section>
    <form id="myform" name="myform" method="post" enctype="multipart/form-data" class="cssform" action="insert2.php">
        <div class="form-group">
            <label for="file">Main Image to Upload</label>
            <input type="file" id="file" name="file-img" class="form-control" value="" />
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo $thisTitle ?>" />
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" value="" rows="5" cols="25"></textarea>
        </div>
        <div class="form-group">
            <label for="province">Province:</label>
            <select name="province" id="province">
                <option value="none">-Select province-</option>
                <option value="ab">AB</option>
                <option value="bc">BC</option>
                <option value="sk">SK</option>
                <option value="qc">QC</option>
                <option value="mn">MN</option>
                <option value="on">ON</option>
                <option value="nl">NL</option>
                <option value="nv">NV</option>
                <option value="nb">NB</option>
                <option value="on">ON</option>
                <option value="pei">PEI</option>
                <option value="yk">YK</option>
                <option value="nw">NW</option>
                <option value="nun">NUN</option>
                <option value="usa">USA</option>
            </select>
        </div>
        <div class="form-group">
            <label for="vertical-relief">Vertical-Relief:(in Meters)</label>
            <input type="number" name="vertical-relief" id="vertical-relief" class="form-control" value="" />
        </div>
        <div class="form-group">
            <label for="height">Height:(in Meters)</label>
            <input type="number" name="height" id="height" class="form-control" value="" />
        </div>
        <div class="form-group">
            <label for="first-summit">First Summit:</label>
            <input type="text" name="first-summit" id="first-summit" class="form-control" value="" />
        </div>
        <div class="form-group">
            <label for="is-volcano">Is Volcano:</label>
            <input type="hidden" name="is-volcano" id="is-volcano" class="form-control" value="0" />
            <input type="checkbox" name="is-volcano" id="is-volcano" class="form-control" value="1" />
        </div>
        <div class="form-group">
            <label for="access">Access:</label>
            <div class="form-check">
                <input type="radio" name="access" id="access" value="hike" class="form-check-input" /><label for="access" class="form-check-label">Hike</label>
            </div>
            <div class="form-check">
                <input type="radio" name="access" id="access" value="vehicle" class="form-check-input" /><label for="vehicle" class="form-check-label">vehicle</label>
            </div>
            <div class="form-check">
                <input type="radio" name="access" id="access" value="helicopter" class="form-check-input" /><label for="helicopter" class="form-check-label">helicopter</label>
            </div>
        </div>
        <div class="form-group">
            <label for="fileG">Google Image to Upload:</label>
            <input type="file" id="filG" name="fileG" class="form-control" value="" />
        </div>
        <div class="form-group">
            <label for="submit">&nbsp;</label>
            <input type="submit" name="submit" class="btn btn-info" value="Insert Mountain" />
        </div>
    </form>
</section>

<?php
include(INCLUDES_PATH . "/footer.php");
?>