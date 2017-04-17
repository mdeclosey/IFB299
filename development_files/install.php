<?php
/*********************************
 *	The intentions of this file is to allow for a quick
 *  setup of the database. When modifying this file,
 *  assume the database is empty.
 *  
 *  Always create at least 5 rows in each table!
 *
*********************************/

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

/***** add contracts table *****/
mysqli_query($db, 
	"CREATE TABLE IF NOT EXISTS Contracts(
	contractID INT AUTO_INCREMENT,
	propertyID INT NOT NULL,
	tenantID INT NOT NULL,
	startDate date NOT NULL,
	endDate date NOT NULL,
    PRIMARY KEY (contractID)
	);"
) or die(failed('createContractsTable'));

/***** add contracts *****/
mysqli_query($db, "
	INSERT INTO contracts (propertyID, tenantID, startDate, endDate) VALUES 
		('1', '1', '2014-01-01', '2014-07-01'),
		('2', '2', '2015-01-01', '2015-07-01'),
		('3', '3', '2016-01-01', '2016-07-01'),
		('4', '4', '2017-01-01', '2017-07-01'),
		('5', '5', '2018-01-01', '2018-07-01');") or die(failed('createContracts'));

/***** add properties table *****/
mysqli_query($db, 
	"CREATE TABLE IF NOT EXISTS Properties(
	propertyID INT AUTO_INCREMENT,
	ownerID INT NOT NULL,
	staffID INT NOT NULL,
	street VARCHAR(60) NOT NULL,
	suburb VARCHAR(60) NOT NULL,
	postcode VARCHAR(60) NOT NULL,
    PRIMARY KEY (propertyID)
	);"
) or die(failed('createPropertiesTable'));

/***** add properties *****/
mysqli_query($db, "
	INSERT INTO properties (ownerID, staffID, street, suburb, postcode) VALUES 
		('1', '1', '10 Adelaide Street', 'Brisbane', '4000'),
		('2', '2', '20 Adelaide Street', 'Brisbane', '4000'),
		('3', '3', '30 Adelaide Street', 'Brisbane', '4000'),
		('4', '4', '40 Adelaide Street', 'Brisbane', '4000'),
		('5', '5', '50 Adelaide Street', 'Brisbane', '4000');") or die(failed('createProperties'));

/***** add owners table *****/
mysqli_query($db, 
	"CREATE TABLE IF NOT EXISTS Owners(
	ownerID INT AUTO_INCREMENT,
	fName varchar(40) NOT NULL,
	lname varchar(40) NOT NULL,
	email varchar(60) NOT NULL,
	phone varchar(60) NOT NULL,
    PRIMARY KEY (ownerID)
	);"
) or die(failed('createOwnersTable'));

/***** add owner *****/
mysqli_query($db, "
	INSERT INTO owners (fname, lname, email, phone) VALUES 
		('Adrian', 'Mathews', 'amat@example.com', '07 3344 5566'),
		('Borris', 'Richard', 'booor@example.com', '07 3344 5566'),
		('Craig', 'Chip', 'creg@example.com', '07 3344 5566'),
		('Doug', 'Bird', 'dugg@example.com', '07 3344 5566'),
		('Emily', 'Clean', 'clem@example.com', '07 3344 5566'),
		('Danielle', 'Tan', 'tanielle@example.com', '07 3344 5566');") or die(failed('createOwners'));










function failed($at) {
	global $db;
	echo '<span style="font-size: 3em; color: red">Failed @ ' . $at. ' </span>';
	echo '<br><br>' . mysqli_error($db);
	mysqli_query($db, "ROLLBACK; END TRANSACTION;"); // note; CREATE, ALTER, DELETE table cannot be rolled back
	exit;
}

// end the transaction and commit
mysqli_query($db, "END TRANSACTION;");
echo '<span style="font-size: 3em; color: green">Success</span><br><br><a href="index.php">Leave now</a>';
?>