<?php
session_start();
if (file_exists(stream_resolve_include_path('config.php'))) {
	include('config.php');
} else {
	header('location: install.php');
}

// Connect to DB
if (isset($DB_SERVER) && isset($DB_USER) && isset($DB_PASS) && isset($DB_NAME)) {
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
	} else {
		// success
		// now check there are tables in the database
		$tblChk = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as num_tables FROM information_schema.tables WHERE table_schema = '{$DB_NAME}'"));
		if ($tblChk['num_tables'] == 0) {
			// no tables, throw an error
			?>
			<div style="width: 100%; height: 100%; background-color: white; padding :1em; border: 5px solid black; font-size: 3em; z-index:999999999999">
				There are no tables in the database. Have you ran the installation script?
				If you have not ran the installation then click <a href="install.php">here</a>.<br>
			</div>	
			<?php
		}
	}
	
} else {
	?>
	<div style="width: 100%; height: 100%; background-color: white; padding :1em; border: 5px solid black; font-size: 3em; z-index:999999999999">
		You need to create a config.php file!<br>
		Copy and paste the following code into a new file named <i>config.php</i><br>
		<span style="font-style: italic; font-family: Courier New; font-size: 0.33em">
			&lt;?php<br>$DB_SERVER = &quot;localhost&quot;;<br>$DB_USER = &quot;root&quot;;<br>$DB_PASS = &quot;&quot;;<br>$DB_NAME = &quot;ifb299_assignment&quot;;<br>?&gt;
		</span>
		<br><br>
		and then run <a href="install.php">install.php</a>
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