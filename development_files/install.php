<?php
if(file_exists('config.php')) {
	include('config.php');
} else {
	echo 'Please create the <b>config.php</b> file. Copy and paste the following into it.';
	echo '<br><br><span style="color:red">';
	echo '&lt;?php $DB_SERVER = &quot;localhost&quot;; $DB_USER = &quot;root&quot;; $DB_PASS = &quot;&quot;; $DB_NAME = &quot;ifb299_assignment&quot;; ?&gt;';
	echo '</span><br><br>';
	exit;
}
/*********************************
 *	The intentions of this file is to allow for a quick
 *  setup of the database. When modifying this file,
 *  assume the database is empty.
 *  
 *  Always create at least 5 rows in each table!
 *
*********************************/


// Connect to DB
$db = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
mysqli_query($db,"DROP SCHEMA ifb299_assignment");
mysqli_query($db,"CREATE SCHEMA ifb299_assignment");
$db = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);

/***** check connection *****/
if (mysqli_connect_errno()) {
	echo '<br><br><br>Failed to connect to DB<br><br>
	Ensure you have a database setup on <b>'. $DB_SERVER .'</b> and the user <b><?php echo $DB_USER; ?></b> has the password \'<b>'.($DB_PASS != '' ? $DB_PASS : '<i>blank</i>') .'</b>\'.<br>
		The database schema needs to be named <b>'. $DB_NAME. '</b></br>
		These settings are set in <b>config.php</b>. This file is ignored by git so it is unique to you.<br>';
	
	echo '<br><br>Use the script below to create the database and then run this installation script again.<br>';
	echo '<span style="color: red">CREATE SCHEMA "'. $DB_NAME. '"</span>';
	exit;
}

/***** start installation *****/
mysqli_query($db, "START TRANSACTION");

/***** add staff table *****/
mysqli_query($db, 
	"CREATE TABLE IF NOT EXISTS Staff(
	staffID INT AUTO_INCREMENT,
	username varchar(40) NOT NULL,
	password varchar(40) NOT NULL,
	fName varchar(40) NOT NULL,
	lname varchar(40) NOT NULL,
	email varchar(60) NOT NULL,
	phone varchar(60) NOT NULL,
    PRIMARY KEY (staffID)
	);"
) or die(failed('createStaffTable'));

/***** add staff *****/
mysqli_query($db, "
	INSERT INTO staff (username, password, fname, lname, email, phone) VALUES 
		('david', 'david', 'David', 'Jones', 'bobby@example.com', '07 3344 5566'),
		('staff', 'staff', 'Davids', 'Assistant', 'DavesAssistant@example.com', '07 3344 5566'),
		('dallen', 'allend', 'David', 'Allen', 'DavidAllen@example.com', '07 3344 5566'),
		('gavies', 'dreg', 'Greg', 'Davies', 'Greg@example.com', '07 3344 5566'),
		('bobjones', 'jonies', 'Bob', 'Jones', 'bobby@example.com', '07 3344 5566'),
		('phildun', 'dundundun', 'Phil', 'Dunphy', 'phil@example.com', '07 3344 5566'),
		('lukeee', 'phy', 'Luke', 'Dunphy', 'luke@example.com', '07 3344 5566');") or die(failed('createStaff'));

/***** add tenants table *****/
mysqli_query($db, 
	"CREATE TABLE IF NOT EXISTS Tenants(
	tenantID INT AUTO_INCREMENT,
	username varchar(40) NOT NULL,
	password varchar(40) NOT NULL,
	fName varchar(40) NOT NULL,
	lname varchar(40) NOT NULL,
	email varchar(60) NOT NULL,
	phone varchar(60) NOT NULL,
    PRIMARY KEY (tenantID)
	);"
) or die(failed('createTenantsTable'));

/***** add tenants *****/
mysqli_query($db, "
	INSERT INTO tenants (username, password, fname, lname, email, phone) VALUES 
		('tenant', 'tenant', 'Josh', 'Tenant', 'joshtenant@example.com', '07 3344 5566'),
		('billbo', 'jackson', 'Bill', 'Jackson', 'bobby@example.com', '07 3344 5566'),
		('danielaa', 'A-A-RON', 'Daniel', 'Aaron', 'DavidAllen@example.com', '07 3344 5566'),
		('georgestairs', 'clipclopclipclop', 'George', 'Doorstep', 'Greg@example.com', '07 3344 5566'),
		('batman', 'androbin', 'Phil', 'Batman', 'bobby@example.com', '07 3344 5566'),
		('spinachsam', 'ripped', 'Sam', 'Popeye', 'bobby@example.com', '07 3344 5566');") or die(failed('createStaff'));

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
	username varchar(40) NOT NULL,
	password varchar(40) NOT NULL,
	fName varchar(40) NOT NULL,
	lname varchar(40) NOT NULL,
	email varchar(60) NOT NULL,
	phone varchar(60) NOT NULL,
    PRIMARY KEY (ownerID)
	);"
) or die(failed('createOwnersTable'));

/***** add owner *****/
mysqli_query($db, "
	INSERT INTO owners (username, password, fname, lname, email, phone) VALUES 
		('owner', 'owner', 'Noah', 'Owner', 'amat@example.com', '07 3344 5566'),
		('amathews', 'amat', 'Adrian', 'Mathews', 'amat@example.com', '07 3344 5566'),
		('brichard', 'brich', 'Borris', 'Richard', 'booor@example.com', '07 3344 5566'),
		('cc', 'cchi', 'Craig', 'Chip', 'creg@example.com', '07 3344 5566'),
		('dougb', 'doug', 'Doug', 'Bird', 'dugg@example.com', '07 3344 5566'),
		('em', 'clean', 'Emily', 'Clean', 'clem@example.com', '07 3344 5566'),
		('dantan', 'ielle', 'Danielle', 'Tan', 'tanielle@example.com', '07 3344 5566');") or die(failed('createOwners'));



/***** add property_views table *****/
mysqli_query($db,
    "CREATE TABLE IF NOT EXISTS PropertyViews(
        id INT AUTO_INCREMENT,
        propertyID INT,
        start_datetime DateTime NOT NULL,
	end_dateTime DateTime NOT NULL,
        staffID INT NOT NULL,
        PRIMARY KEY (ID)
        );"
) or die(failed('createPropertyViewsTables'));


/***** add property view times *****/
mysqli_query($db, "
    INSERT INTO PropertyViews(id, propertyID, start_datetime, end_dateTime, staffID) VALUES
      ('1','1', '2017-06-01 12:00:00', '2017-06-01 12:15:00', '1'),
      ('2','2', '2017-06-02 13:00:00', '2017-06-02 12:15:00', '2'),
      ('3','3', '2017-06-03 12:00:00', '2017-06-03 12:15:00', '3'),
      ('4','4', '2017-06-04 12:00:00', '2017-06-04 12:15:00', '4');"
) or die(failed('createPropertyViews'));


/***** add property_images table *****/
mysqli_query($db,
    "CREATE TABLE IF NOT EXISTS propertyImages(
      id INT AUTO_INCREMENT,
      propertyID INT NOT NULL,
      URL_TO_IMAGE VARCHAR(200),
	PRIMARY KEY (id)
      );"
) or die(failed("createPropertyImagesTable"));



/***** add property image items *****/
mysqli_query($db,
    "INSERT INTO propertyImages(propertyID, URL_TO_IMAGE) VALUES
    ('1', 'images/house1/house1b.jpg'),
    ('1', 'images/house1/house1a.jpg'),
    ('2', 'images/house2/house2b.jpg'),
    ('2', 'images/house2/house2a.jpg'),
    ('3', 'images/house3/house3b.jpg'),
    ('3', 'images/house3/house3a.jpg'),
    ('4', 'images/house4/house4b.jpg'),
    ('4', 'images/house4/house4a.jpg'),
    ('5', 'images/house5/house5b.jpg'),
    ('5', 'images/house5/house5a.jpg')");

/***** add property view tenants table *****/
mysqli_query($db,
    "CREATE TABLE IF NOT EXISTS property_view_tenants(
      id INT AUTO_INCREMENT,
      property_inspection_id INT NOT NULL,
      tenant_id INT NOT NULL,
      PRIMARY KEY (id)
      );"
) or die(failed("createPropertyViewTenantsTable"));

mysqli_query($db,
    "INSERT INTO property_view_tenants(property_inspection_id, tenant_id) VALUES
    (1, 4),
    (2, 1),
    (3, 2),
    (4, 3),
    (5, 5);"
)or die(failed("createPropertyViewTenants"));

/***** add tenants-owners-staff view as 'users' for login *****/
mysqli_query($db,
	"CREATE VIEW users AS 
			SELECT 'owner' as user_type, ownerID as id, username, `password`, fName, lname FROM owners
		UNION
			SELECT  'staff' as user_type, staffID as id, username, `password`, fName, lname FROM staff
		UNION
			SELECT  'tenant' as user_type, tenantID as id, username, `password`, fName, lname FROM tenants
	;");

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
