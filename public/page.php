<?php

require_once("../private/initialize.php");
include(INCLUDES_PATH . "/header.php");


?>


<div id="leftCol">
    <?php
    $mtnId = $_GET['mtn_id'];
    if (is_numeric($mtnId)) {
        //-----------------single mtn function call---------------------
        $theMtn = find_mtn_page($mtnId);

        $title = $theMtn['title'];
        $description = $theMtn["description"];
        $mtnImageThumb = (string)$theMtn["mtn_image"];
        $mtnImageGoogle = (string)$theMtn['google_img'];
        $province = $theMtn['province'];
        $verticalRelief = $theMtn['vertical_relief'];
        $verticalRelief = strval($verticalRelief);
        $height = $theMtn['height'];
        $firstSummit = $theMtn['first_summit'];
        $volcano = $theMtn['is_volcano'];
        $access = $theMtn['access'];
        $mtnId = $theMtn["mtn_id"];

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
                    <h2 class="mb-4"> <?php echo h($title); ?></h2>
                    <p class="bold">Description:</p>
                    <p class="mb-4"> <?php echo h($description); ?> </p>
                </div>
            </section>
            <section class="row section-1">
                <div class="">
                    <img src=<?php echo "uploads/display/" . h($mtnImageThumb); ?> alt="">
                </div>
                <div class="">
                    <ul class="page-txt-stats">
                        <li><?php echo h($volcanoTxt); ?> </li>
                        <li>First Summit: <?php echo h($firstSummit); ?></li>
                        <li>Location: <?php echo h($province); ?></li>
                        <li>Access type: <?php echo h($access); ?></li>
                    </ul>
                </div>
            </section>
            <section class="row section-2">
                <div class="col-md-12 section-2-google">
                    <ul>
                        <li>Vertical Relief: <?php echo h($verticalRelief); ?>m</li>
                        <li>Height: <?php echo h($height); ?>m</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <img class="img-fluid" src=<?php echo "uploads/google-img/" . h($mtnImageGoogle); ?> alt="">
                </div>
                <?php if ((isset($_SESSION["x5ghy789soci"]))) { ?>
                    <div class="col-md-12">
                        <?php
                        echo "<a id=\"pageEdit\" class=\"mb-4 green-button\" href=\"admin/pages/edit.php?mtn_id=" . h(u($mtnId)) . "\">Edit</a>";
                        ?>
                    </div>
                <?php } ?>
            </section>
        </main>

    <?php
        //----------------------------------------
        //-----------------pagination (unfinished)---------------------
        //----------------------------------------

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