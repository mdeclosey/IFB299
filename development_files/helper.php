<?php
// Connect to DB
$db = mysqli_connect("localhost", "root", "", "ifb299_assignment");

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	?>
	<div style="width: 100%; height: 100%; background-color: white; padding :1em; border: 5px solid black; font-size: 3em; z-index:999999999999">
		Ensure you have a database setup on <b>localhost</b> and the user <b>root</b> has <b>no password</b>.<br>
		The database schema needs to be named <b>ifb299_assignment</b></br>
		If you have not ran the installation then click <a href="install.php">here</a>.<br>
	</div>	
	<?php
}

function requiresAuthentication() {
	// if a user ID is not set then assume not logged in
	if (!isset($_SESSION['user_id'])) {
		header('location: index.php');
		exit;
	}
}
?>