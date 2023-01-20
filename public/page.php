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
            <section class="page-header page-mtn">

                <div class="d-flex align-items-baseline">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 45 36">
                        <path id="Icon_awesome-mountain" data-name="Icon awesome-mountain" d="M44.643,32.534l-20.25-31.5a2.25,2.25,0,0,0-3.786,0L.357,32.534A2.25,2.25,0,0,0,2.25,36h40.5a2.25,2.25,0,0,0,1.893-3.466ZM22.5,6.411l6,9.339h-6L18,20.25l-2.676-2.676Z" transform="translate(0)" />
                    </svg>

                    <h1 class="ps-3 mb-5 ">Single View</h1>
                </div>

                <h2 class="page-mtn__title mb-4 bg-dark text-light p-3 rounded"> <?php echo h($title); ?></h2>

                <div class="page-grid">

                    <div class="page-mtn__images">
                        <div class="page-mtn__main-img mb-4 ">
                            <img class="img-fluid rounded-4 shadow" src=<?php echo "uploads/display/" . h($mtnImageThumb); ?> alt="">
                        </div>
                        <div class="page-mtn__google-img">
                            <div class="col-md-12">
                                <img class="img-fluid rounded-4 shadow" src=<?php echo "uploads/google-img/" . h($mtnImageGoogle); ?> alt="">
                            </div>
                        </div>
                    </div>
                    <article class="page-mtn__content rounded-4 shadow ">
                        <div class="d-flex justify-content-between mb-5">
                            <div class="page-mtn__details w-100">
                                <ul class="page-txt-stats p-0">
                                    <li class=" d-flex border-bottom pb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 30">
                                            <path d="M18,3A10.492,10.492,0,0,0,7.5,13.5C7.5,21.375,18,33,18,33S28.5,21.375,28.5,13.5A10.492,10.492,0,0,0,18,3Zm0,14.25a3.75,3.75,0,1,1,3.75-3.75A3.751,3.751,0,0,1,18,17.25Z" transform="translate(-7.5 -3)" />
                                        </svg>
                                        <span class="fs-3 text-uppercase me-2 fs-heading fw-bold"><?php echo h($province); ?></span>
                                        <div class="page-mtn__height fs-3 text-secondary fw-bold ms-auto">
                                            Height:<?php echo h($height) ?>
                                        </div>
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26.784 30.849">
                                            <path data-name="Icon metro-fire" d="M12.241,32.777c-2.056-4.278-.961-6.729.619-9.039A14.4,14.4,0,0,0,15.037,18.7a5.913,5.913,0,0,1,.816,4.534,11.443,11.443,0,0,0,2.494-8.57c5.432,3.8,7.754,12.016,4.625,18.107,16.64-9.415,4.139-23.5,1.963-25.09.725,1.587.863,4.273-.6,5.577C21.851,3.856,15.717,1.928,15.717,1.928c.725,4.852-2.63,10.157-5.865,14.121A10.485,10.485,0,0,0,8.6,10.928c-.228,3.514-2.914,6.379-3.641,9.9C3.973,25.6,5.7,29.088,12.241,32.777Z" transform="translate(-4.701 -1.928)" />
                                        </svg>
                                        <p class="fw-bold text-secondary mb-0 "><?php echo h($volcanoTxt); ?>
                                        </p>
                                    </li>
                                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 27">
                                            <path d="M12,16.5h4.5v15h3v-15H24l-6-6ZM6,4.5v3H30v-3Z" transform="translate(-6 -4.5)" />
                                        </svg>
                                        <p class=" mb-0  fw-bold">Vertical Relief: &nbsp<?php echo h($verticalRelief); ?>m</p>
                                    </li>
                                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.875 34.875">
                                            <path d="M18,.563A17.438,17.438,0,1,0,35.438,18,17.44,17.44,0,0,0,18,.563ZM18,8.3a2.953,2.953,0,1,1-2.953,2.953A2.953,2.953,0,0,1,18,8.3Zm3.938,17.859a.844.844,0,0,1-.844.844H14.906a.844.844,0,0,1-.844-.844V24.469a.844.844,0,0,1,.844-.844h.844v-4.5h-.844a.844.844,0,0,1-.844-.844V16.594a.844.844,0,0,1,.844-.844h4.5a.844.844,0,0,1,.844.844v7.031h.844a.844.844,0,0,1,.844.844Z" transform="translate(-0.563 -0.563)" />
                                        </svg>
                                        <p class="mb-0  fst-italic fw-bold">First Summit: &nbsp<?php echo h($firstSummit); ?></p>
                                    </li>
                                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.125 31.5">
                                            <g id="Icon_ionic-md-walk" data-name="Icon ionic-md-walk" transform="translate(-8.438 -2.25)">
                                                <path id="Path_38" data-name="Path 38" d="M20.25,7.875a2.813,2.813,0,1,0-2.813-2.812A2.8,2.8,0,0,0,20.25,7.875Z" />
                                                <path id="Path_39" data-name="Path 39" d="M20.25,16.313h7.313V13.5H22.5L19.35,8.625A2.548,2.548,0,0,0,17.175,7.35a3.559,3.559,0,0,0-.9.123L8.438,10.125V18H11.25V12.375L14.1,11.25,8.438,33.75H11.25L15.237,22.2,18.773,27v6.75h2.672v-9L17.435,18l1.388-4.35Z" />
                                            </g>
                                        </svg>
                                        <p class="mb-0  ">Access type: &nbsp<?php echo h($access); ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="page-mtn__footer d-flex justify-content-between flex-wrap align-items-end gap-4">
                            <p class="p-0 m-0"> <?php echo h($description); ?> </p>
                            <?php if ((isset($_SESSION["x5ghy789soci"]))) { ?>
                                <?php
                                echo "<a id=\"pageEdit\" class=\" btn btn-primary \" href=\"admin/pages/edit.php?mtn_id=" . h(u($mtnId)) . "\">Edit</a>";
                                ?>
                            <?php } else {
                                echo "<a id=\"pageEdit\" class=\" btn btn-primary green-button \" href=\"admin/login.php\">Edit</a>";
                            } ?>
                        </div>
                    </article>


                </div>



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