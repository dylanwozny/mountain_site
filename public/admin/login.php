<?php
// injects connection string
require_once('../../private/initialize.php');

// page variables
$page_title = "Login";


include(PRIVATE_PATH . '/includes/header.php');

// values
$msg = '';
$username = '';
$password = '';

// authenticate user 
// user presses submit
if (isset($_POST['submit'])) {
	$username = $_POST["username"];
	$password = $_POST["password"];

	if (($username == "dwozny2") && ($password == "Megatron13")) {

		// session_start(); // start session
		$_SESSION["x5ghy789soci"] = session_id(); // name of the session
		header("Location:index.php"); // redirects user to /admin
	} else {
		if (($username != "") && ($password != "")) {
			$msg = "invalid login";
		} else {
			$msg = "Please Enter a username and Password";
		}
	}
}

?>
<h2 class="mt-5 pt-5">Please log in</h2>
<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<div class="form-group mb-3 text-capitalize">
		<label for="username">username:</label>
		<input type="text" name="username" class="form-control">
	</div>
	<div class="form-group mb-3 text-capitalize">
		<label for="password">password:</label>
		<input type="password" name="password" class="form-control">
	</div>
	<div class="form-group mb-3">
		<input type="submit" name="submit" class="btn btn-primary" value="Login">
	</div>
</form>
<?php
if (isset($msg)) {
	echo "<div class=\"p-3 text-danger fs-3\">$msg</div>";
}

include(INCLUDES_PATH . "/footer.php");
?>