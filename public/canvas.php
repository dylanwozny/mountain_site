<?php

use LDAP\Result;

include("includes/header.php");
include("includes/mysql_connect.php");


?>
<header class="clearfix">
    <h1>Canvas for PHP learning</h1>
    <div class="underline-center"></div>

</header>
<section>
    <h2>Variables</h2>
    <!--  -->
    <?php

    $var1 = 10;
    $var2 = 5;
    // USE "" quotes to have variable inside
    echo "
    <ul>
        <li>{$var1} dollars </li>
        <li></li>
        <li></li>
    </ul>";
    ?>
</section>
<section>
    <h2>functions</h2>
    <?php
    $first = "The brown Fox jumped over the tree";
    $second = " and kept running.";
    $third = $first . $second;
    ?>

    <h3>Useful functions in PHP</h3>
    <h4>Strings</h4>
    <p><strong><?php echo $third ?></strong></p>
    <ul>
        <li>Lowercase: <?php echo strtolower($third) ?></li>
        <li>Uppercase: <?php echo strtoupper($third) ?></li>
        <li>Uppercase first word: <?php echo ucfirst($third) ?></li>
        <li>Uppercase Words: <?php echo ucwords($third) ?></li>
    </ul>

    <h4>Integers</h4>

    <?php
    $num1 = 1;
    $num5 = 5; ?>

    <p><strong> <?php echo $num1 + $num5 ?></strong></p>
    <li></li>

    <h4>Floating Points</h4>

    <?php
    $float1 = 1.21;
    $float2 = 2.55; ?>

    <p><strong> <?php echo $float1 + $float2 ?></strong></p>
    <ul>
        <li><?php echo "Is {$float1} a float ?" . is_int($float1); ?></li>
        <li><?php echo "Is {$float2} a float ? " . is_float($float2); ?></li>
    </ul>

    <h4>Arrays</h4>
    <!-- you use either to set an array -->
    <?php $list = [0, 1, 2, 3];
    $list1 = array(0, 1, 2, 3);

    ?>
    <ul>
        <!-- debug for reading array -->
        <!-- <pre> formats the array in html -->
        <pre>
        <li><?php echo print_r($list) ?></li>
        </pre>
        <li><?php echo $list[2]; ?></li>
        <!-- add to the list array -->
        <li><?php echo $list[5] = "bug" ?></li>
        <pre>
        <li><?php echo print_r($list) ?></li>
        </pre>
    </ul>

    <h4>Associate Array (similar to objects)</h4>
    <p>Array in indexed by label, not number</p>

    <?php $numbers = ["first_name" => "Dylan", "last_name" => "Wozny", "age" => 31] ?>
    <ul>
        <li>First Name: <?php echo $numbers["first_name"] ?></li>
        <li>Last Name: <?php echo $numbers["last_name"] ?></li>
        <li>Age: <?php echo $numbers["age"] ?></li>
        <li>
            <pre>
            <?php echo print_r($numbers) ?>
        </pre>
        </li>
        <li></li>
    </ul>

    <h4>Array Functions</h4>
    <a href="https://www.php.net/manual/en/ref.array.php">Link to PHP manual array functions List</a>

    <h4>Boolean</h4>
    <?php
    $result1 = true;
    $result2 = false; ?>

    <ul>
        <li>false is: <?php echo $result2 ?></li>
        <li>true is: <?php echo $result1 ?></li>
    </ul>

    <h4> NULL</h4>
    <p>Null is no value. NOT 0 or ""</p>

    <h4>Type Casting and juggling</h4>
    <p>PHP auto converts variable into a type when combining</p>
    <p>Start with string of 2</p>
    <?php $count = "2"; ?>
    <ul>
        <li>Type: <?php echo gettype($count) ?></li>
        <!-- PHP will convert this string into a integer. THIS IS TYPE JUGGLING -->
        <?php $count += 3 ?>
        <li>Type: <?php echo gettype($count) ?></li>
        <?php $cats = "i have" . $count . "cats." ?>
        <!-- converts back into string -->
        <li>Cats <?php echo gettype($cats) ?></li>
        <br>
        <li>
            <p><strong> Converting ourselfs. Best practice</strong></p>
        </li>
        <!-- Change to integer -->
        <?php settype($count, "integer") ?>
        <li>type <?php echo $count ?></li>
        <li>Use settype() to convert type</li>
    </ul>

    <h4>Constant</h4>
    <p>All capitals</p>
    <p>unique and set by functions</p>
    <p>No $ </p>
    <p>Cant change value</p>

    <?php define("MAX_WIDTH", 980) ?>
    <ul>
        <li>
            <?php echo MAX_WIDTH; ?>
        </li>

        <li></li>
        <li></li>
    </ul>

</section>
<section>
    <h2>Logical Expressions, If statements</h2>
    <strong>
        <p> Use brackets !</p>
    </strong>
    <?php
    $a = 4;
    $b = 3;
    ?>
    <?php if ($a > $b) {
        echo "<p>{$a} is larger than {$b}</a>";
    } ?>

    <?php $new_user = true;
    if ($new_user) {
        echo "<p>Welcome new user</p>";
        echo "<p>We are glad you joined us.</p>";
    }
    ?>

    <h4>Else If</h4>
    <p>Else if: Do this to check until condition is met then skips the rest</p>
    <p>many ifs: each condition is checked no skipping</p>


    <h4>Operators</h4>
    <strong>
        <p></p>
    </strong>
    <p>Equal ==</p>
    <p> greater than or less ></p>
    <p>Not !=</p>
    <p>Logical Operators And, Or: && ||</p>

    <h4>Switch Statement</h4>
    <p>mostly not used</p>
    <p>used if one value can be 10 different things </p>
    <p>Easier to read</p>
</section>
<section>
    <h3>Loops</h3>
    <h4>for</h4>
    <p>do this and add while condition</p>
    <h4>While</h4>
    <p>while condition do</p>
    <h4>For Each</h4>
    <p>foreach($ages as $age){<br />
        echo "Age: {$age}"}</p>

    <p>as $age ----> this is refering the current value/variable in the loop</p>
    <p><strong>For each is handy on Db data</strong></p>
    <p>Foreach on associate array</p>
    <?php
    $person = array(
        "first_name" => "Kevin",
        "last_name" => "Skoglund",
        "address" => "123 main street"
    );

    foreach ($person as $attribute => $data) {
        $attr_nice = ucwords(str_replace("_", " ", $attribute));
        echo "<span>{$attr_nice}: {$data}</span><br />";
    }
    ?>
    <br>

    <h4>Continue</h4>
    <p>continue loop earlier</p>
    <p>useful with very long loops. Don't want to execute everything in loop</p>

    <h4>break</h4>
    <p>ends the whole process</p>
    <p>we have reached the definitive answer to the question</p>

    <h4>Array pointer </h4>
    <p>points at a current item in an array</p>

</section>
<section>
    <h3>Functions</h3>
    <h4>Arguments</h4>
    <?php
    $name = "bob";
    function better_hello($greeting, $target, $punct)
    {
        echo $greeting . " " . $target . $punct . "<br />";
    }

    echo "<p>" .  better_hello("hello", $name, "!") . "</p>";

    ?>
    <h4>Return values</h4>
    <?php function add($val, $val2)
    {
        $sum = $val + $val2;
        return $sum;
    }

    $theAddition = add(4, 7);
    echo $theAddition;

    ?>

    <p>Better to echo outside function</p>

    <h4>Multiple Return values</h4>

    <P><strong>Return an Array !</strong></P>
    <?php
    // function returned with array
    function add_subt($val, $val2)
    {
        $add = $val + $val2;
        $subt = $val - $val2;
        return [$add, $subt];
    }
    // list just puts the array returned into arguemnet vars.
    list($add_result, $subt_result) = add_subt(20, 7);
    echo "<p> add:" . $add_result . "</p>";
    echo "<p> sub:" . $subt_result . "</p>";
    ?>

    <h4>Scope</h4>

    <p>use global to call var inside function</p>
    <p>use this with caution</p>

    <p><strong>Catch the return in a var is better</strong></p>

    <h4>Defaults</h4>
    <p>either use all arguments have defaults or none do</p>
</section>
<section>
    <h3>Debugging</h3>
    <p>try just html page first to make sure server is working</p>
    <p>then try php tag</p>
    <h4>list of common problems</h4>
    <ul>
        <li>Typos</li>
        <li>missing ;</li>
        <li>missing parenthesis</li>
        <li>lowercase and uppercase vars</li>
        <li>= vs. ==</li>
    </ul>
    <h4>Warning and Errors</h4>
    <p>turn on error reporting</p>
    <p>go to php.ini file.</p>
    <p>display_error = On error_reporting = E_ALL</p>
    <p>in php code </p>
    <p>return the current level</p>
    <ul>
        <li>fatal error: understands but cant do it. ex. calling a class that is undefined</li>
        <li>Syntax Error: error in code ex. extra parenthesis</li>
        <li>Warning: able to execute code but encounter a problem it over came ex. incorrect path</li>
        <li>Notice: PHP offering advice</li>
        <li>look at log of errors. C:/xampp/logs/php.error.log</li>
        <li></li>
    </ul>

    <h4>Troubleshoooting</h4>
    <ul>
        <li>echo</li>
        <li>print_r</li>
        <li>gettype</li>
        <li>var_dump</li>
        <li>get_defined_vars</li>
        <li>debug_backtrace</li>

    </ul>

    <a href="https://www.linkedin.com/learning/php-essential-training-2017/debug-and-troubleshoot-14761609?autoSkip=true&autoplay=true&resume=false&u=2109516">Linked in learning video series</a>
</section>