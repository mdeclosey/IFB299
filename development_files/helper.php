<?php
include('config.php');

// Connect to DB
$db = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	?>
	<div style="width: 100%; height: 100%; background-color: white; padding :1em; border: 5px solid black; font-size: 3em; z-index:999999999999">
		Ensure you have a database setup on <b><?php echo $DB_SERVER; ?></b> and the user <b><?php echo $DB_USER; ?></b> has the password '<b><?php echo ($DB_PASS != '' ? $DB_PASS : '<i>blank</i>'); ?></b>'.<br>
		The database schema needs to be named <b><?php echo $DB_NAME; ?></b></br>
		These settings are set in <b>config.php</b>. This file is ignored by git so it is unique to you.<br>
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