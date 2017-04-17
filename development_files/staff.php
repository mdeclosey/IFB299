<?php include('helper.php'); ?>

<?php
/***** Edit client *****/
if (isset($_GET['save'])) {
	if (isset($_POST['id']) && $_POST['id'] > 0) {
		// should perform server side form validation but meh,
		// if jquery caught the save click then it must have been validated already (but consider csrf)
		$update = mysqli_query($db, "UPDATE staff SET fname='{$_POST['fname']}', lname='{$_POST['lname']}', phone='{$_POST['phone']}', email='{$_POST['email']}' WHERE staffID='{$_POST['id']}'");
		
		if ($update) {
			header('location: staff.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		header('location: staff.php');
	}
}

/***** Delete client *****/
if (isset($_GET['delete'])) {
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$delete = mysqli_query($db, "DELETE FROM staff WHERE staffID={$_GET['id']}");
		
		if ($delete) {
			header('location: staff.php'); // redirect to prevent resubmit
		} else {
			echo mysqli_error($db); exit;
		}
	} else {
		header('location: staff.php');
	}
}
?>

<?php include('pageHeader.php'); ?>

<?php

// List staff
if (count($_GET) == 0) {
	$staffList = mysqli_query($db, "SELECT * FROM staff");
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Staff List
			<span style="float:right; margin-top: -5.5px">
				<a href='staff.php?new' class='btn btn-success btn-sm'>
				  <span class='glyphicon glyphicon-plus'></span> New Staff
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
					while ($client = mysqli_fetch_assoc($staffList)) {
						echo "
							<tr>
							  <th scope='row'>{$client['staffID']}</th>
							  <td>{$client['fName']}</td>
							  <td>{$client['lname']}</td>
							  <td>{$client['email']}</td>
							  <td>{$client['phone']}</td>
							  <td>
								<a href='staff.php?edit&id={$client['staffID']}' class='btn btn-success'>
								  <span class='glyphicon glyphicon-edit'></span> Edit
								</a>
								<a href='staff.php?delete&id={$client['staffID']}' class='btn btn-danger'>
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


// Edit staff
if (isset($_GET['edit']) && isset($_GET['id']) && $_GET['id'] > 0) { 
	// Get the staff
	$staff = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM staff WHERE staffID={$_GET['id']}"));
	
?>
	<form action="staff.php?save" method="post" id="frmEditStaff">
		<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Edit <?php echo "{$staff['fName']} {$staff['lname']}"; ?>
			</div>
			<div class="panel-body" style="padding: 2em">
				<div class="form-group row">
				  <label for="example-text-input" class="col-2 col-form-label">First Name</label>
				  <div class="col-10">
					<input class="form-control" type="text" value="<?php echo "{$staff['fName']}"; ?>" id="fname" name="fname">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-search-input" class="col-2 col-form-label">Last Name</label>
				  <div class="col-10">
					<input class="form-control" type="text" value="<?php echo "{$staff['lname']}"; ?>" id="lname" name="lname">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-email-input" class="col-2 col-form-label">Email</label>
				  <div class="col-10">
					<input class="form-control" type="email" value="<?php echo "{$staff['email']}"; ?>" id="email" name="email">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-url-input" class="col-2 col-form-label">Phone</label>
				  <div class="col-10">
					<input class="form-control" type="text" value="<?php echo "{$staff['phone']}"; ?>" id="phone" name="phone">
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
				window.location.href = "staff.php";
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
					$("#frmEditStaff").submit();
				}
			});
		});
	</script>
	<?php
}
?>

<?php include('pageFooter.php'); ?>