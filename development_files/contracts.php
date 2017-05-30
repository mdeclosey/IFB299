<?php include('helper.php'); ?>

<?php
/***** New/Edit contract *****/
if (isset($_GET['save'])) {
	if (isset($_POST['id']) && $_POST['id'] > 0) {
		// should perform server side form validation but meh,
		// if jquery caught the save click then it must have been validated already (but consider csrf)
		$update = mysqli_query($db, "UPDATE contracts SET propertyID='{$_POST['propertyID']}', tenantID='{$_POST['tenantID']}', startDate='{$_POST['startDate']}', endDate='{$_POST['endDate']}' WHERE contractID='{$_POST['id']}'") or die(mysqli_error($db));
		
		// if the update was successful
		if ($update) {
			header('location: contracts.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		// new contract
		$update = mysqli_query($db, "INSERT INTO contracts (propertyID, tenantID, startDate, endDate) VALUES('{$_POST['propertyID']}', '{$_POST['tenantID']}', '{$_POST['startDate']}', '{$_POST['endDate']}')") or die(mysqli_error($db));
		
		// if the update was successful
		if ($update) {
			header('location: contracts.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	}
}

/***** Delete contract *****/
if (isset($_GET['delete'])) {
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$delete = mysqli_query($db, "DELETE FROM contracts WHERE contractID={$_GET['id']}");
		
		if ($delete) {
			header('location: contracts.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		header('location: contracts.php');
	}
}
?>

<?php include('pageHeader.php'); ?>

<?php

// List contracts
if (count($_GET) == 0) { // this line checks we are only listing contracts, nothing else
	if ($_SESSION['user_type'] == 'david') { // list all property contracts because david is logged in
		$contractList = mysqli_query($db, "
			SELECT 
			contracts.contractID, 
			properties.street, 
			properties.suburb, 
			properties.postcode, 
			contracts.startDate, 
			contracts.endDate,
			tenants.fName,
			tenants.lname
			FROM contracts
			LEFT JOIN tenants ON tenants.tenantID=contracts.tenantID
			LEFT JOIN properties ON properties.propertyID=contracts.propertyID
			ORDER BY contracts.contractID ASC
		") or die(mysqli_error($db));
	} else { // only list property contracts for the current users' properties
		$contractList = mysqli_query($db, "
			SELECT 
			contracts.contractID, 
			properties.street, 
			properties.suburb, 
			properties.postcode, 
			contracts.startDate, 
			contracts.endDate,
			tenants.fName,
			tenants.lname
			FROM contracts
			LEFT JOIN tenants ON tenants.tenantID=contracts.tenantID
			LEFT JOIN properties ON properties.propertyID=contracts.propertyID
			WHERE properties.staffID = {$_SESSION['user_id']}
			ORDER BY contracts.contractID ASC
		") or die(mysqli_error($db));
	}
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Contracts List 
			<span style="float:right; margin-top: -5.5px">
				<a href='contracts.php?new' class='btn btn-success btn-sm'>
				  <span class='glyphicon glyphicon-plus'></span> New Contract
				</a>
			</span>
		</div>
		<div class="panel-body">
			<table class="table">
			  <thead>
				<tr>
				  <th>#</th>
				  <th>Property</th>
				  <th>Tenant</th>
				  <th>Start Date</th>
				  <th>End Date</th>
				  <th>Actions</th>
				</tr>
			  </thead>
				<tbody>
					<?php
					
					// loop over each contract and display it
					while ($contract = mysqli_fetch_assoc($contractList)) {
						echo "
							<tr>
							  <th scope='row'>{$contract['contractID']}</th>
							  <td>{$contract['street']}, {$contract['suburb']}, {$contract['postcode']}</td>
							  <td>{$contract['fName']} {$contract['lname']}</td>
							  <td>{$contract['startDate']}</td>
							  <td>{$contract['endDate']}</td>
							  <td>
								<a href='contracts.php?edit&id={$contract['contractID']}' class='btn btn-success'>
								  <span class='glyphicon glyphicon-edit'></span> Edit
								</a>
								<a href='contracts.php?delete&id={$contract['contractID']}' class='btn btn-danger'>
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


// Create/Edit contract form
if (isset($_GET['edit']) && isset($_GET['id']) && $_GET['id'] > 0 ||
	isset($_GET['new'])) { 
	
	if (isset($_GET['edit'])) {
		// edit mode
		$contract = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM contracts WHERE contractID={$_GET['id']}"));
		$action = 'Edit Contract #';
	} else {
		// create mode
		// fill an empty array representing the new tenant. for quick hacks of the existing edit form
		$contract = [
			'contractID' => '',
			'tenantID' => '',
			'tenantID' => '',
			'endDate' => '',
			'startDate' => ''
		];
		
		$action = 'New Contract';
	}
	
	$tenants = mysqli_query($db, "SELECT * FROM tenants");
	if ($_SESSION['user_type'] == 'david') {
		$properties = mysqli_query($db, "SELECT * FROM properties LEFT JOIN staff ON staff.staffID=properties.staffID");
	} else {
		$properties = mysqli_query($db, "SELECT * FROM properties LEFT JOIN staff ON staff.staffID=properties.staffID WHERE properties.staffID='" . $_SESSION['user_id'] . "'");
	}
?>
	<form action="contracts.php?save" method="post" id="frmEditContract">
		<?php if (isset($_GET['edit'])) { ?> <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">  <?php }; ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo "{$action} {$contract['contractID']}"; ?>
			</div>
			<div class="panel-body" style="padding: 2em">
				<div class="form-group row">
				  <label for="example-text-input" class="col-2 col-form-label">Property</label>
				  <div class="col-10">
					<select name="propertyID" id="propertyID" class="form-control">
						<option disabled>Select property</option>
						<?php
						while ($property = mysqli_fetch_assoc($properties)) {
							if ($property['tenantID'] == $contract['tenantID']) {
								echo "<option selected value='{$property["propertyID"]}'>";
							} else {
								echo "<option value='{$property["propertyID"]}'>";
							}
							echo "{$property["street"]} {$property["suburb"]} {$property["postcode"]}</option>";
						}
						?>
					</select>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-search-input" class="col-2 col-form-label">Tenant</label>
				  <div class="col-10">
					<select name="tenantID" id="tenantID" class="form-control">
						<option disabled>Select tenant</option>
						<?php
						while ($tenant = mysqli_fetch_assoc($tenants)) {
							if ($tenant['tenantID'] == $contract['tenantID']) {
								echo "<option selected value='{$tenant["tenantID"]}'>";
							} else {
								echo "<option value='{$tenant["tenantID"]}'>";
							}
							echo "{$tenant["fName"]} {$tenant["lname"]}</option>";
						}
						?>
					</select>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-email-input" class="col-2 col-form-label">Start Date</label>
				  <div class="col-10">
					<input class="form-control" type="date" value="<?php echo $contract['startDate']; ?>" id="startDate" name="startDate">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-url-input" class="col-2 col-form-label">End Date</label>
				  <div class="col-10">
					<input class="form-control" type="date" value="<?php echo $contract['endDate']; ?>" id="endDate" name="endDate">
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
				window.location.href = "contracts.php";
			});
			
			// Save button pressed
			$('#save').click(function() {
				var property = $("#propertyID");
				var tenant = $("#tenantID");
				var startDate = $("#startDate");
				var endDate = $("#endDate");
				
				// validate form
				if (property.val() <= 0 ||
					tenant.val() <= 0 ||
					startDate.val() == '' ||
					endDate.val() == '') 
				{
					alert('Ensure you have filled out the entire form.');
				} else {
					$("#frmEditContract").submit();
				}
			});
		});
	</script>
	<?php
}
?>

<?php include('pageFooter.php'); ?>