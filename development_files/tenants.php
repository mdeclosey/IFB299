<?php include('helper.php'); ?>

<?php
/***** Create/Edit client *****/
if (isset($_GET['save'])) {
	if (isset($_POST['id']) && $_POST['id'] > 0) {
		// should perform server side form validation but meh,
		// if jquery caught the save click then it must have been validated already (but consider csrf)
		$update = mysqli_query($db, "UPDATE tenants SET fname='{$_POST['fname']}', lname='{$_POST['lname']}', phone='{$_POST['phone']}', email='{$_POST['email']}' WHERE tenantID='{$_POST['id']}'");
		
		if ($update) {
			header('location: tenants.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		// new tenant
		$update = mysqli_query($db, "INSERT INTO tenants (fname, lname, phone, email) VALUES('{$_POST['fname']}', '{$_POST['lname']}', '{$_POST['phone']}', '{$_POST['email']}')");
		
		if ($update) {
			header('location: tenants.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	}
}

/***** Delete client *****/
if (isset($_GET['delete'])) {
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$delete = mysqli_query($db, "DELETE FROM tenants WHERE tenantID={$_GET['id']}");
		
		if ($delete) {
			header('location: tenants.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		header('location: tenants.php');
	}
}
?>

<?php include('pageHeader.php'); ?>

<?php

// List tenants
if (count($_GET) == 0) {
	$tenantList = mysqli_query($db, "SELECT * FROM tenants");
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Tenants List
			<span style="float:right; margin-top: -5.5px">
				<a href='tenants.php?new' class='btn btn-success btn-sm'>
				  <span class='glyphicon glyphicon-plus'></span> New Tenant
				</a>
			</span>
		</div>
		<div class="panel-body">
			<table class="table">
			  <thead>
				<tr>
				  <th>#</th>
				  <th>First Name</th>
				  <th>Last Name</th>
				  <th>Email</th>
				  <th>Phone</th>
				  <th>Actions</th>
				</tr>
			  </thead>
				<tbody>
					<?php
					while ($client = mysqli_fetch_assoc($tenantList)) {
						echo "
							<tr>
							  <th scope='row'>{$client['tenantID']}</th>
							  <td>{$client['fName']}</td>
							  <td>{$client['lname']}</td>
							  <td>{$client['email']}</td>
							  <td>{$client['phone']}</td>
							  <td>
								<a href='tenants.php?edit&id={$client['tenantID']}' class='btn btn-success'>
								  <span class='glyphicon glyphicon-edit'></span> Edit
								</a>
								<a href='tenants.php?delete&id={$client['tenantID']}' class='btn btn-danger'>
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


// Create/Edit tenant
if (isset($_GET['edit']) && isset($_GET['id']) && $_GET['id'] > 0 ||
	isset($_GET['new'])) { 
	
	if (isset($_GET['edit'])) {
		// edit mode
		$tenant = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM tenants WHERE tenantID={$_GET['id']}"));
		$action = 'Edit';
	} else {
		// create mode
		// fill an empty array representing the new tenant. for quick hacks of the existing edit form
		$tenant = [
			'id' => '',
			'fName' => '',
			'lname' => '',
			'email' => '',
			'phone' => ''
		];
		
		$action = 'New Tenant';
	}
?>
	<form action="tenants.php?save" method="post" id="frmEditTenant">
		<?php if (isset($_GET['edit'])) { ?> <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">  <?php }; ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo "{$action} {$tenant['fName']} {$tenant['lname']}"; ?>
			</div>
			<div class="panel-body" style="padding: 2em">
				<div class="form-group row">
				  <label for="example-text-input" class="col-2 col-form-label">First Name</label>
				  <div class="col-10">
					<input class="form-control" type="text" value="<?php echo "{$tenant['fName']}"; ?>" id="fname" name="fname">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-search-input" class="col-2 col-form-label">Last Name</label>
				  <div class="col-10">
					<input class="form-control" type="text" value="<?php echo "{$tenant['lname']}"; ?>" id="lname" name="lname">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-email-input" class="col-2 col-form-label">Email</label>
				  <div class="col-10">
					<input class="form-control" type="email" value="<?php echo "{$tenant['email']}"; ?>" id="email" name="email">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-url-input" class="col-2 col-form-label">Phone</label>
				  <div class="col-10">
					<input class="form-control" type="text" value="<?php echo "{$tenant['phone']}"; ?>" id="phone" name="phone">
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
				window.location.href = "tenants.php";
			});
			
			// Save button pressed
			$('#save').click(function() {
				var fname = $("#fname");
				var lname = $("#lname");
				var phone = $("#phone");
				var email = $("#email");
				
				// validate form
				if (fname.val() == '' ||
					lname.val() == '' ||
					phone.val() == '' ||
					email.val() == '') 
				{
					alert('Ensure you have filled out the entire form.');
				} else {
					$("#frmEditTenant").submit();
				}
			});
		});
	</script>
	<?php
}
?>

<?php include('pageFooter.php'); ?>