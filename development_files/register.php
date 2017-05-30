<?php include('helper.php'); ?>

<?php
	// catch user registering
	if (isset($_GET['register'])) {
		// validate
		if (isset($_POST['FirstName']) && 
			isset($_POST['LastName']) &&
			isset($_POST['Phone']) &&
			isset($_POST['email']) &&
			isset($_POST['pw'])) {
			$regDB = mysqli_query($db, "INSERT INTO tenants (username, password, fname,
			lname, email, phone) VALUES('{$_POST['username']}', '{$_POST['password']}', 
			'{$_POST['FirstName']}', '{$_POST['LastName']}', '{$_POST['email']}', '{$_POST['Phone']}')");
			
			// check user registered successfully
			if (!$regDB) {
				header('location: index.php');
			} else {
				// Log the user in at the same time
				$_SESSION['user_id'] = mysqli_insert_id($db);
				header('location: index.php');
			}
		}
	}
?>

<?php include('pageHeader.php'); ?>
<form action="tenants.php?save" method="post" id="frmEditTenant">
	<input type="hidden" name="reference" value="register">
	<div class="panel panel-primary">
		<div class="panel-heading">
			Register as a Tenant
		</div>
		<div class="panel-body" style="padding: 2em">
			<div class="form-group row">
			  <label for="example-text-input" class="col-2 col-form-label">Username</label>
			  <div class="col-10">
				<input class="form-control" type="text"id="username" name="username">
			  </div>
			</div>
			<div class="form-group row">
			  <label for="example-text-input" class="col-2 col-form-label">Password</label>
			  <div class="col-10">
				<input class="form-control" type="password" id="password" name="password">
			  </div>
			</div>
			<div class="form-group row">
			  <label for="example-text-input" class="col-2 col-form-label">First Name</label>
			  <div class="col-10">
				<input class="form-control" type="text" id="fname" name="fname">
			  </div>
			</div>
			<div class="form-group row">
			  <label for="example-search-input" class="col-2 col-form-label">Last Name</label>
			  <div class="col-10">
				<input class="form-control" type="text" id="lname" name="lname">
			  </div>
			</div>
			<div class="form-group row">
			  <label for="example-email-input" class="col-2 col-form-label">Email</label>
			  <div class="col-10">
				<input class="form-control" type="email" id="email" name="email">
			  </div>
			</div>
			<div class="form-group row">
			  <label for="example-url-input" class="col-2 col-form-label">Phone</label>
			  <div class="col-10">
				<input class="form-control" type="text" id="phone" name="phone">
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
<?php include('pageFooter.php'); ?>
