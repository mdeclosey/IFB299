<?php
// Connect to DB
$db = mysqli_connect("localhost", "root", "", "ifb299_assignment");

/***** check connection *****/
if (mysqli_connect_errno()) {
	echo '<br><br><br>Failed to connect to DB<br><br>
	Ensure you have a MySQL server running on <b>localhost</b>, <br>with the <b>root</b><br>having <b>no password</b>.<br>The DB schema is named <b>ifb299_assignment</b>.';
	
	echo '<br><br>Use this script to create the database and then run this installation script again.<br>';
	echo '<span style="color: red">CREATE SCHEMA "ifb299_assignment"</span>';
	exit;
}

/***** start installation *****/
mysqli_query($db, "START TRANSACTION");

/***** add staff table *****/
mysqli_query($db, 
	"CREATE TABLE IF NOT EXISTS Staff(
	staffID INT AUTO_INCREMENT,
	fName varchar(40) NOT NULL,
	lname varchar(40) NOT NULL,
	email varchar(60) NOT NULL,
	phone varchar(60) NOT NULL,
    PRIMARY KEY (staffID)
	);"
) or die(failed('createStaffTable'));

/***** add staff *****/
mysqli_query($db, "
	INSERT INTO staff (fname, lname, email, phone) VALUES 
		('Bob', 'Jones', 'bobby@example.com', '07 3344 5566'),
		('David', 'Allen', 'DavidAllen@example.com', '07 3344 5566'),
		('Greg', 'Davies', 'Greg@example.com', '07 3344 5566'),
		('Bob', 'Jones', 'bobby@example.com', '07 3344 5566'),
		('Phil', 'Dunphy', 'phil@example.com', '07 3344 5566'),
		('Luke', 'Dunphy', 'luke@example.com', '07 3344 5566');") or die(failed('createStaff'));

/***** add tenants table *****/
mysqli_query($db, 
	"CREATE TABLE IF NOT EXISTS Tenants(
	tenantID INT AUTO_INCREMENT,
	fName varchar(40) NOT NULL,
	lname varchar(40) NOT NULL,
	email varchar(60) NOT NULL,
	phone varchar(60) NOT NULL,
    PRIMARY KEY (tenantID)
	);"
) or die(failed('createTenantsTable'));

/***** add tenants *****/
mysqli_query($db, "
	INSERT INTO tenants (fname, lname, email, phone) VALUES 
		('Bill', 'Jackson', 'bobby@example.com', '07 3344 5566'),
		('Daniel', 'Aaron', 'DavidAllen@example.com', '07 3344 5566'),
		('George', 'Doorstep', 'Greg@example.com', '07 3344 5566'),
		('Phil', 'Batman', 'bobby@example.com', '07 3344 5566'),
		('Sam', 'Popeye', 'bobby@example.com', '07 3344 5566');") or die(failed('createStaff'));









function failed($at) {
	global $db;
	echo '<span style="font-size: 3em; color: red">Failed @ ' . $at. ' </span>';
	echo '<br><br>' . mysqli_error($db);
	mysqli_query($db, "ROLLBACK; END TRANSACTION;"); // note; CREATE, ALTER, DELETE table cannot be rolled back
	exit;
}

// end the transaction and commit
mysqli_query($db, "COMMIT");
echo '<span style="font-size: 3em; color: green">Success</span><br><br><a href="index.php">Leave now</a>';
?>