<?php
// injects connection string
	include("../includes/header.php");
// values
	$username = $_POST["username"];
	$password = $_POST["password"];

// authenticate user 
// user presses submit
if(isset($_POST['submit'])){
	if (($username == "dwozny2") && ($password == "Megatron13")) {
		
		session_start(); // start session
		$_SESSION["x5ghy789soci"] = session_id(); // name of the session
		header("Location:insert.php"); // redirects user to /admin
	}

	else{
		if(($username !="") && ($password !="")){
			$msg = "invalid login";
		}
		else{
			$msg = "Please Enter a username and Password";
		}
	}
		
			
}
	
?>
<h2 class="mt-5 pt-5">Please log in</h2>
<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<div class="form-group">
			<label for="username">username:</label>
			<input type="text" name="username" class="form-control">
		</div>
		<div class="form-group">
			<label for="password">password:</label>
			<input type="password"  name="password" class="form-control">
		</div>
		<div class="form-group">
			<label for="submit">&nbsp;</label>
			<input type="submit" name="submit" class="btn btn-info" value="Login">
		</div>
</form>
<?php
	if($msg){
		echo "<div>$msg</div>";
	}
	include("../includes/footer.php");
?>