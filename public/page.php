<?php

require_once("../private/initialize.php");
include(INCLUDES_PATH . "/header.php");
include(INCLUDES_PATH . "/mysql_connect.php");
?>


<div id="leftCol">
    <?php
    $mtnId = $_GET['mtn_id'];
    if (is_numeric($mtnId)) {

        $result = mysqli_query($con, "SELECT * FROM dyl_mountains WHERE mtn_id = $mtnId");
        while ($row = mysqli_fetch_array($result)) {
            $title = $row['title'];
            $description = $row["description"];
            $mtnImageThumb = $row["mtn_image"];
            $mtnImageGoogle = $row['google_img'];
            $province = $row['province'];
            $verticalRelief = $row['vertical_relief'];
            $verticalRelief = strval($verticalRelief);
            $height = $row['height'];
            $firstSummit = $row['first_summit'];
            $volcano = $row['is_volcano'];
            $access = $row['access'];
            $mtnId = $row["mtn_id"];



            // create message for positive volcano
            if ($volcano == 1) {
                $volcanoTxt = $title . " is a volcano";
            } else {
                $volcanoTxt = $title . " is not a volcano";
            }
    ?>

            <main>
                <section class="row page-header">
                    <div class="col-md-12">
                        <h2 class="mb-4"> <?php echo "$title"; ?></h2>
                        <p class="bold">Description:</p>
                        <p class="mb-4"> <?php echo "$description"; ?> </p>
                    </div>
                </section>
                <section class="row section-1">
                    <div class="">
                        <img src=<?php echo "uploads/display/" . $mtnImageThumb; ?> alt="">
                    </div>
                    <div class="">
                        <ul class="page-txt-stats">
                            <li><?php echo "$volcanoTxt"; ?> </li>
                            <li>First Summit: <?php echo "$firstSummit"; ?></li>
                            <li>Location: <?php echo "$province"; ?></li>
                            <li>Access type: <?php echo "$access"; ?></li>
                        </ul>
                    </div>
                </section>
                <section class="row section-2">
                    <div class="col-md-12 section-2-google">
                        <ul>
                            <li>Vertical Relief: <?php echo "$verticalRelief"; ?>m</li>
                            <li>Height: <?php echo $height; ?>m</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <img src=<?php echo "uploads/display/" . $mtnImageGoogle; ?> alt="">
                    </div>
                    <div class="col-md-12">
                        <?php
                        echo "<a id=\"pageEdit\" class=\"mb-4 green-button\" href=\"admin/edit.php?mtn_id=$mtnId \">Edit</a>";
                        ?>
                    </div>
                </section>
            </main>

    <?php
        }
    } else {
        echo "<div id=\"pageTitle\">Not correct info</div>";
    }

    $next = mysqli_query($con, "SELECT mtn_id FROM dyl_mountains WHERE mtn_id = (SELECT min(mtn_id) FROM dyl_mountains WHERE mtn_id > $mtnId)");
    while ($row = mysqli_fetch_array($next)) {
        $idNext = $row["mtn_id"];
    }

    $prev = mysqli_query($con, "SELECT mtn_id FROM dyl_mountains WHERE mtn_id = (SELECT max(mtn_id) FROM dyl_mountains WHERE mtn_id < $mtnId)");
    while ($row =  mysqli_fetch_array($prev)) {
        $idPrev = $row["mtn_id"];
    }

    if ($idPrev) {
        $nextPrevButton .= "<a href=\"page.php?mtn_id=$idPrev\" class=\"buttonStyle btnLeft\">Previous</a> | ";
    } else {
        $nextPrevButton .= "<a href=\"\" class=\"buttonStyle btnLeft\">Previous</a> |";
    }

    if ($idNext) {
        $nextPrevButton .= "<a href=\"page.php?mtn_id=$idNext\" class=\"buttonStyle btnLeft\">Next</a>";
    } else {
        $nextPrevButton .= "<a href=\"\" class=\"buttonStyle btnLeft\">Next</a>";
    }

    echo "<div class=\"mb-5\" id=\"nextPrevBtnz\">$nextPrevButton</div>";
    ?>
</div>

<?php include(INCLUDES_PATH . "/footer.php"); ?>