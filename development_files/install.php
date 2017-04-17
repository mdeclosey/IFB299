<?php
// Connect to DB
$db = mysqli_connect("localhost", "root", "", "ifb299_assignment");

// Check connection
if (mysqli_connect_errno()) {
	echo '<br><br><br>Failed to connect to DB<br><br>
	Ensure you have a MySQL server running on <b>localhost</b>, <br>with the <b>root</b><br>having <b>no password</b>.<br>The DB schema is named <b>ifb299_assignment</b>.';
	
	echo '<br><br>Use this script to create the database and then run this installation script again.<br>';
	echo '<span style="color: red">CREATE SCHEMA "ifb299_assignment"</span>';
	exit;
}

// start a transcation
mysqli_query($db, "START TRANSACTION");

// run create staff table
$createStaffTable = mysqli_query($db, 
	"CREATE TABLE IF NOT EXISTS Staff(
	staffID INT AUTO_INCREMENT,
	fName varchar(40) NOT NULL,
	lname varchar(40) NOT NULL,
	email varchar(60) NOT NULL,
	phone varchar(60) NOT NULL,
    PRIMARY KEY (staffID)
	);"
);
	
if (!$createStaffTable) {
	failed('$createStaffTable');
}

// add staff
$createStaff = mysqli_query($db, "
						INSERT INTO staff (fname, lname, email, phone) VALUES ('Bob', 'Jones', 'bobby@example.com', '07 3344 5566');
						INSERT INTO staff (fname, lname, email, phone) VALUES ('David', 'Allen', 'DavidAllen@example.com', '07 3344 5566');
						INSERT INTO staff (fname, lname, email, phone) VALUES ('Greg', 'Davies', 'Greg@example.com', '07 3344 5566');
						INSERT INTO staff (fname, lname, email, phone) VALUES ('Bob', 'Jones', 'bobby@example.com', '07 3344 5566');
						INSERT INTO staff (fname, lname, email, phone) VALUES ('Bob', 'Jones', 'bobby@example.com', '07 3344 5566');");
						
if (!$createStaff) {
	failed('$createStaff');
}


// end the transaction and commit
mysqli_query($db, "COMMIT");

function failed($at) {
	global $db;
	echo '<h1>Failed @ ' . $at. ' </h1>';
	echo '<br><br>' . mysqli_error($db);
	mysqli_query($db, "ROLLBACK");
	exit;
}
?>