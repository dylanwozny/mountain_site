<?php


//-----------------make sure data is presence---------------------
//return true/false
function is_blank($value)
{
    return !isset($value) || trim($value) === '';
}


//-----------------make sure length of string is greater than value---------------------
//return true/false

function has_length_greater_than($value, $min)
{
    $length = strlen($value);
    return $length > $min;
}


//-----------------max string value---------------------
//return true/false
function has_length_less_than($value, $max)
{
    $length = strlen($value);
    return $length < $max;
}

//-----------------has exact length---------------------
function has_length_exact($value, $exact)
{
    $length = strlen($value);

    return $length === $exact;
}




//----------------------------------------
//---Combination Validation for Length----
//----------------------------------------
//use associate array for parameter options and checks all validation in elseif
function has_length($value, $options = [])
{

    //-----------------min function---------------------
    // is the argument for that option given ? If so, does that function return false?
    if (isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
        return false;
    } elseif (isset($options['max']) && !has_length_greater_than($value, $options['max'] + 1)) {
        return false;
    } elseif (isset($options['exact']) && !has_length_exact($value, $options['exact'])) {
        return false;
    } else {
        return true;
    }
}

//----------------------------------------
//--patterns included in string ?---------
//----------------------------------------

//-----------------does not contain this data---------------------
function has_exclusion_of($value, $set)
{
    return !in_array($value, $set);
}

//-----------------has this data---------------------
function has_string($value, $required_string)
{
    return strpos($value, $required_string) !== false;
}

// ---------------- Email validation -----------------
function has_valid_email($value)
{
    // REGEX. Regular expression to find pattern
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
}
//-----------------integer rules---------------------
function has_min_int($value, $min)
{
    return ($value >= $min);
}

function has_max_int($value, $max)
{
    return $value <= $max;
}
//----------------------------------------
//---------integer all function-----------
//----------------------------------------
function has_min_max_int($value, $options)
{
    //-----------------min function---------------------
    // is the argument for that option given ? If so, does that function return false?


    if (isset($options['min']) && !has_min_int($value, $options['min'])) {
        echo "too low";
        return false;
    } elseif (isset($options['max']) && !has_max_int($value, $options['max'])) {
        echo "too high";
        return false;
    } elseif (!is_int($value)) {
        echo "not an integer";
        return false;
    } else {
        echo "just right";
        return true;
    }
}

//----------------------------------------
//-----------------FILE Validation---------------------
//----------------------------------------





//-------------------------------------------
//-----Function wrapping all validations-----
//-------------------------------------------
// function validates all form data
// will return the associate array of error description if there
//are errors.
// will return nothing in errors and pass if no errors are present
function validate_mtn($data)
{

    //-----------------Associate Array storing error values---------------------

    $errors = [];

    /*//----------------------------------------
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
    */
    //----------------------------------------
    //-----------------validation---------------------
    //----------------------------------------
    //-----------------DESCRIPTION---------------------
    // checking description, putting in options from function.
    if (!has_length($data["description"], $options['min'] = 1, $options['max'] = 225)) {
        // return error message with associate array name to display
        $errors['description'] = "please only use between 1-225 characters";
    }

    if (is_blank($data["description"])) {
        $errors['description'] = "please give a description";
    }

    //-----------------Title---------------------
    if (!has_length($data["title"], $options['min'] = 1, $options['max'] = 30)) {
        // return error message with associate array name to display
        $errors['title'] = "please only use between 1-30 characters";
    }

    if (is_blank($data["title"])) {
        $errors['title'] = "please give a title";
    }

    //-----------------Vertical Relief---------------------
    if (!has_min_int($data['vertical_relief'], 1) || !has_max_int($data['vertical_relief'], 9000) || !is_int($data['vertical_relief'])) {
        $errors['vertical_relief'] = "please give an integer between 1 and 8000";
    }

    //-----------------Height---------------------
    if (!has_min_int($data['height'], 1) || !has_max_int($data['height'], 9000) || !is_int($data['height'])) {
        $errors['height'] = "please give an integer between 1 and 8000";
    }

    //-----------------First Summit---------------------
    if (!has_length($data["first_summit"], $options['min'] = 1, $options['max'] = 225)) {
        // return error message with associate array name to display
        $errors['summmit'] = "please only use between 1-225 characters";
    }


    if (is_blank($data["first_summit"])) {
        $errors['first_summit'] = "please give a description of the first summit";
    }

    //-----------------Access---------------------
    if (!$data['access']) {
        $errors['access'] = "please choose an access type";
    }

    //----------------- is volcano------------------
    if (!isset($data['is_volcano'])) {
        $errors['is_volcano'] = "wrong volcano value. Pls check the box or leave blank";
    }

    //-----------------Province---------------------
    if (($data['province']) === 'none') {
        $errors['province'] = "please select a province from the list";
    }
    //----------------------------------------
    //-----------------File Validation---------------------
    //----------------------------------------

    // if(!isset(($data['google_img']))){
    //     echo "IMG not given"

    // }

    //-----------------Return Errors---------------------
    return $errors;
}
