<?php include('helper.php'); ?>

<?php
/***** Edit property *****/
if (isset($_GET['save'])) {
	if (isset($_POST['id']) && $_POST['id'] > 0) {
		// should perform server side form validation but meh,
		// if jquery caught the save click then it must have been validated already (but consider csrf)
		print_r($_POST);
		$update = mysqli_query($db, "UPDATE properties SET staffID='{$_POST['staffID']}', ownerID='{$_POST['ownerID']}', street='{$_POST['street']}', suburb='{$_POST['suburb']}', postcode='{$_POST['postcode']}' WHERE propertyID='{$_POST['id']}'");
		
		if ($update) {
			header('location: properties.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		header('location: properties.php');
	}
}

/***** Delete property *****/
if (isset($_GET['delete'])) {
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$delete = mysqli_query($db, "DELETE FROM properties WHERE propertyID={$_GET['id']}");
		
		if ($delete) {
			header('location: properties.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		header('location: properties.php');
	}
}
?>

<?php include('pageHeader.php'); ?>

<?php

// List propertys
if (count($_GET) == 0) {
	$propertyList = mysqli_query($db, "
		SELECT *, staff.fName as staff_fname, staff.lname as staff_lname FROM properties 
		INNER JOIN staff ON properties.staffID = staff.staffID
		INNER JOIN owners ON properties.ownerID = owners.ownerID
		") or die(mysqli_error($db));
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Properties List 
			<span style="float:right; margin-top: -5.5px">
				<a href='properties.php?new' class='btn btn-success btn-sm'>
				  <span class='glyphicon glyphicon-plus'></span> New Property
				</a>
			</span>
		</div>
		<div class="panel-body">
			<table class="table">
			  <thead>
				<tr>
				  <th>#</th>
				  <th>Property</th>
				  <th>Staff</th>
				  <th>Owner</th>
				  <th>Actions</th>
				</tr>
			  </thead>
				<tbody>
					<?php
					while ($property = mysqli_fetch_assoc($propertyList)) {
						echo "
							<tr>
							  <th scope='row'>{$property['propertyID']}</th>
							  <td>{$property['street']}, {$property['suburb']}, {$property['postcode']}</td>
							  <td>{$property['staff_fname']} {$property['staff_lname']}</td>
							  <td>{$property['fName']} {$property['lname']}</td>
							  <td>
								<a href='properties.php?edit&id={$property['propertyID']}' class='btn btn-success'>
								  <span class='glyphicon glyphicon-edit'></span> Edit
								</a>
								<a href='properties.php?delete&id={$property['propertyID']}' class='btn btn-danger'>
								  <span class='glyphicon glyphicon-trash'></span> Delete
								</a>
							  </td>
							</tr>
						";
					}	
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
}


// Edit property
if (isset($_GET['edit']) && isset($_GET['id']) && $_GET['id'] > 0) { 
	// Get the property
	$property = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM properties WHERE propertyID={$_GET['id']}"));
	$staff = mysqli_query($db, "SELECT * FROM staff");
	$owners = mysqli_query($db, "SELECT * FROM owners");
?>
	<form action="properties.php?save" method="post" id="frmEditProperty">
		<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Edit property #<?php echo "{$_GET['id']}"; ?>
			</div>
			<div class="panel-body" style="padding: 2em">
				<div class="form-group row">
					<label for="example-text-input" class="col-2 col-form-label">Street</label>
					<div class="col-10">
						<input class="form-control" type="text" value="<?php echo "{$property['street']}"; ?>" id="street" name="street">
					</div>
				</div>
				<div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">Suburb</label>
					<div class="col-10">
						<input class="form-control" type="text" value="<?php echo "{$property['suburb']}"; ?>" id="suburb" name="suburb">
					</div>
				</div>
				<div class="form-group row">
					<label for="example-email-input" class="col-2 col-form-label">Postcode</label>
					<div class="col-10">
						<input class="form-control" type="email" value="<?php echo "{$property['postcode']}"; ?>" id="postcode" name="postcode">
					</div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-2 col-form-label">Staff</label>
				  <div class="col-10">
					<select name="staffID" id="staffID" class="form-control">
						<option disabled>Select staff</option>
						<?php
						while ($staf = mysqli_fetch_assoc($staff)) {
							if ($property['staffID'] == $staf['staffID']) {
								echo "<option selected value='{$staf["staffID"]}'>";
							} else {
								echo "<option value='{$staf["staffID"]}'>";
							}
							echo "{$staf["fName"]} {$staf["lname"]}</option>";
						}
						?>
					</select>
				  </div>
				</div>
				<div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">Owner</label>
					<div class="col-10">
						<select name="ownerID" id="ownerID" class="form-control">
							<option disabled>Select owner</option>
							<?php
							while ($owner = mysqli_fetch_assoc($owners)) {
								if ($property['ownerID'] == $owner['ownerID']) {
									echo "<option selected value='{$owner["ownerID"]}'>";
								} else {
									echo "<option value='{$owner["ownerID"]}'>";
								}
								echo "{$owner["fName"]} {$owner["lname"]}</option>";
							}
							?>
						</select>
				  </div>
				</div>
				<div class="form-group row">
				  <div class="col-10">
					<button type="button" id="save" class='btn btn-success'>
					  <span class='glyphicon glyphicon-ok-circle'></span> Save
					</button>
					<button type="button" id="cancel" class='btn btn-secondary'>
					  <span class='glyphicon glyphicon-remove-circle'></span> Cancel
					</button>
				  </div>
				</div>
			</div>
		</div>
	</form>
	
	<script>
		$(document).ready(function() {
			// Cancel button pressed
			$('#cancel').click(function() {
				window.location.href = "properties.php";
			});
			
			// Save button pressed
			$('#save').click(function() {
				var owner = $("#ownerID");
				var staff = $("#staffID");
				var street = $("#street");
				var suburb = $("#suburb");
				var postcode = $("#postcode");
				
				// validate form
				if (owner.val() <= 0 ||
					staff.val() <= 0 ||
					street.val() == '' ||
					suburb.val() == '' ||
					postcode.val() == '') 
				{
					alert('Ensure you have filled out the entire form.');
				} else {
					$("#frmEditProperty").submit();
				}
			});
		});
	</script>
	<?php
}
?>

<?php include('pageFooter.php'); ?>