<?php require_once('../../../private/initialize.php');

// page variables
$page_title = "Add New";


include(PRIVATE_PATH . '/includes/header.php');

// include("../includes/logincheck.php");
// sql connect is already in header ! that was why there is a problem before ????

$userPrompt = $_GET['message'];

if ($userPrompt) {
	echo "<div class='alert alert-danger'> $userPrompt </div>";
}
echo "<h2>Insert Your Image</h2>";

?>

<!-- jsut display page, redirects to insert 2 which has the query -->
<form id="myform" name="myform" method="post" enctype="multipart/form-data" class="cssform" action="insert2.php">
	<div class="form-group">
		<label for="file">Main Image to Upload</label>
		<input type="file" id="file" name="file-img" class="form-control" value="">
	</div>
	<div class="form-group">
		<label for="title">Title:</label>
		<input type="text" name="title" id="title" class="form-control" value="">
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
		<input type="number" name="vertical-relief" id="vertical-relief" class="form-control" value="">
	</div>
	<div class="form-group">
		<label for="height">Height:(in Meters)</label>
		<input type="number" name="height" id="height" class="form-control" value="">
	</div>
	<div class="form-group">
		<label for="first-summit">First Summit:</label>
		<input type="text" name="first-summit" id="first-summit" class="form-control" value="">
	</div>
	<div class="form-group">
		<label for="is-volcano">Is Volcano:</label>
		<input type="checkbox" name="is-volcano" id="is-volcano" class="form-control">
	</div>
	<div class="form-group">
		<label for="access">Access:</label>
		<br />Hike<input type="radio" name="access" id="access" class="form-control" value="hike">
		Vehicle<input type="radio" name="access" id="access" class="form-control" value="vehicle">
		Helicopter<input type="radio" name="access" id="access" class="form-control" value="helicopter">
	</div>
	<div class="form-group">
		<label for="fileG">Google Image to Upload:</label>
		<input type="file" id="filG" name="fileG" class="form-control" value="">
	</div>
	<div class="form-group">
		<label for="submit">&nbsp;</label>
		<input type="submit" name="submit" class="btn btn-info" value="Insert Mountain">
	</div>


</form>
<?php
include(INCLUDES_PATH . "/footer.php");
?>