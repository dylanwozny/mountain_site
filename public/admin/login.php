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
<header class=" d-flex align-items-center mb-4">
	<svg viewBox="0 0 28 28" class="svg-w2">
		<path id="Icon_awesome-user-alt-2" data-name="Icon awesome-user-alt" d="M14,15.75A7.875,7.875,0,1,0,6.125,7.875,7.877,7.877,0,0,0,14,15.75Zm7,1.75H17.987a9.52,9.52,0,0,1-7.973,0H7a7,7,0,0,0-7,7v.875A2.626,2.626,0,0,0,2.625,28h22.75A2.626,2.626,0,0,0,28,25.375V24.5A7,7,0,0,0,21,17.5Z" />
	</svg>

	<h2 class="mb-0 ms-3">Please log in</h2>
</header>

<form id="myform" name="myform " method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<div class="col-8">
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
	</div>
</form>
<?php
if (isset($msg)) {
	echo "<div class=\"p-3 text-danger fs-3\">$msg</div>";
}

include(INCLUDES_PATH . "/footer.php");
?>