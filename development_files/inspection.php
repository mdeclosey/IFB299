<?php include('helper.php'); ?>

<?php
/***** New/Edit contract *****/
if (isset($_GET['save'])) {
	if (isset($_POST['id']) && $_POST['id'] > 0) {
		// should perform server side form validation but meh,
		// if jquery caught the save click then it must have been validated already (but consider csrf)
		$update = mysqli_query($db, "UPDATE property_view_tenants SET property_inspection_id='{$_POST['propertyID']}', tenant_id='{$_POST['tenantID']}' WHERE id='{$_POST['id']}'");
		
		// if the update was successful
		if ($update) {
			header('location: inspection.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		// new contract
		$update = mysqli_query($db, "INSERT INTO property_view_tenants (property_inspection_id, tenant_id) VALUES('{$_POST['propertyID']}', '{$_POST['tenantID']}')");
		
		// if the update was successful
		if ($update) {
			header('location: inspection.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	}
}

/***** Delete contract *****/
if (isset($_GET['delete'])) {
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$delete = mysqli_query($db, "DELETE FROM property_view_tenants WHERE id={$_GET['id']}");
		
		if ($delete) {
			header('location: inspection.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		header('location: inspection.php');
	}
}
?>

<?php include('pageHeader.php'); ?>

<?php

// List contracts
if (count($_GET) == 0) { // this line checks we are only listing contracts, nothing else
	if ($_SESSION['user_type'] == 'david') { // list all property contracts because david is logged in
		$inspectList = mysqli_query($db, "
			SELECT 
			property_view_tenants.id, 
			property_view_tenants.property_inspection_id, 
			properties.street, 
			properties.suburb, 
			properties.postcode, 
			properties.staffID,
			property_view_tenants.tenant_id, 
			tenants.fName,
			tenants.lname,
			PropertyViews.start_datetime,
			PropertyViews.end_dateTime,
			staff.fName as staff_fName,
			staff.lname as staff_lname
			FROM property_view_tenants
			LEFT JOIN tenants ON tenants.tenantID = property_view_tenants.tenant_id
			LEFT JOIN properties ON properties.propertyID = property_view_tenants.property_inspection_id
			LEFT JOIN staff ON properties.staffID = staff.staffID
			LEFT JOIN PropertyViews ON PropertyViews.propertyID = property_view_tenants.property_inspection_id
			ORDER BY PropertyViews.start_datetime ASC
		") or die(mysqli_error($db));
	} else { // only list property contracts for the current users' properties
		$inspectList = mysqli_query($db, "
			SELECT 
			property_view_tenants.id, 
			property_view_tenants.property_inspection_id, 
			properties.street, 
			properties.suburb, 
			properties.postcode, 
			properties.staffID AS myStaff,
			property_view_tenants.tenant_id, 
			tenants.fName,
			tenants.lname,
			PropertyViews.start_datetime,
			PropertyViews.end_dateTime,
			staff.fName as staff_fName,
			staff.lname as staff_lname
			FROM property_view_tenants
			LEFT JOIN tenants ON tenants.tenantID=property_view_tenants.tenant_id
			LEFT JOIN properties ON properties.propertyID=property_view_tenants.property_inspection_id
			LEFT JOIN staff ON properties.staffID = staff.staffID
			LEFT JOIN PropertyViews ON PropertyViews.propertyID=property_view_tenants.property_inspection_id
			WHERE properties.staffID = {$_SESSION['user_id']}
			ORDER BY PropertyViews.start_datetime ASC
		") or die(mysqli_error($db));
	}
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Viewing List 
			<span style="float:right; margin-top: -5.5px">
				<a href='inspection.php?new' class='btn btn-success btn-sm'>
				  <span class='glyphicon glyphicon-plus'></span> Register Tenant for Inspection
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
				  <th>Staff</th>
				  <th>Date Time</th>
				  <th>Actions</th>
				</tr>
			  </thead>
				<tbody>
					<?php
					
					// loop over each contract and display it
					while ($inspection = mysqli_fetch_assoc($inspectList)) {
						$start = date('l jS F Y g:ia ', strtotime($inspection['start_datetime']));
						$start_end   = $start . ' - ' . date('g:ia', strtotime($inspection['end_dateTime']));
						echo "
							<tr>
							  <th scope='row'>{$inspection['id']}</th>
							  <td>{$inspection['street']}, {$inspection['suburb']}, {$inspection['postcode']}</td>
							  <td>{$inspection['fName']} {$inspection['lname']}</td>
							  <td>{$inspection['staff_fName']} {$inspection['staff_lname']}</td>
							  <td>{$start_end}</td>
							  <td>
								<a href='inspection.php?edit&id={$inspection['id']}' class='btn btn-success'>
								  <span class='glyphicon glyphicon-edit'></span> Edit
								</a>
								<a href='inspection.php?delete&id={$inspection['id']}' class='btn btn-danger'>
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
		echo "<script>console.log('test');</script>";
		$contract = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM property_view_tenants WHERE property_inspection_id={$_GET['id']}"));
		echo "<script>console.log('test');</script>";
		$action = 'Edit Inspection #';
	} else {
		// create mode
		// fill an empty array representing the new tenant. for quick hacks of the existing edit form
		$contract = [
			'property_inspection_id' => '',
			'tenant_id' => '',
			
		];
		
		$action = 'Inspection Registration';
	}
	
	$tenants = mysqli_query($db, "SELECT * FROM tenants");
	$properties = mysqli_query($db, "SELECT *, propertyviews.id as propertyviews_id FROM properties RIGHT JOIN propertyviews ON properties.propertyID=propertyviews.propertyID ORDER BY PropertyViews.start_datetime ASC");
?>
	<form action="inspection.php?save" method="post" id="frmEditContract">
		<?php if (isset($_GET['edit'])) { ?> <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">  <?php }; ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo "{$action} {$contract['property_inspection_id']}"; ?>
			</div>
			<div class="panel-body" style="padding: 2em">
				<div class="form-group row">
				  <label for="example-text-input" class="col-2 col-form-label">Property</label>
				  <div class="col-10">
					<select name="propertyID" id="propertyID" class="form-control">
						<option disabled>Select property inspection</option>
						<?php
						while ($property = mysqli_fetch_assoc($properties)) {
							if ($property['propertyviews_id'] == $contract['property_inspection_id']) {
								echo "<option selected value='{$property["propertyviews_id"]}'>";
							} else {
								echo "<option value='{$property["propertyviews_id"]}'>";
							}
							
							$start = date('l jS F Y g:ia ', strtotime($property['start_datetime']));
							$start_end   = $start . ' - ' . date('g:ia', strtotime($property['end_dateTime']));
							
							echo "{$property["street"]} {$property["suburb"]} {$property["postcode"]} @  {$start_end}</option>";
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
							if ($tenant['tenantID'] == $contract['tenant_id']) {
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
				window.location.href = "inspection.php";
			});
			
			// Save button pressed
			$('#save').click(function() {
				var property = $("#propertyID");
				var tenant = $("#tenantID");
				
				// validate form
				if (property.val() <= 0 ||
					tenant.val() <= 0) 
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
