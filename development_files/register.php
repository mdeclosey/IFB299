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
			$regDB = mysqli_query($db, "INSERT INTO staff...");
			
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

	<form id="frmReg" action="register.php?register" method="post">
		<div id="loginForm">
			<table class="form-group table">
			  	<tr>
			    	<td colspan="0"><input type="text" id="FirstName" name="FirstName" placeholder="First Name" autocomplete="off" class="form-control"></td>
				</tr>
				<tr>
			    	<td colspan="0"><input type="text" id="LastName" name="LastName" placeholder="Last Name" autocomplete="off" class="form-control"></td>
				</tr>
				<tr>
			    	<td colspan="0"><input type="text" id="Phone" name="Phone" placeholder="Phone Number" autocomplete="off" class="form-control"></td>
				</tr>
				<tr>
			    	<td colspan="0"><input type="text" id="email" name="email" placeholder="Email" autocomplete="off" class="form-control"></td>
				</tr>
			  	<tr>
			    	<td colspan="0"><input type="password" name="pw" placeholder="Password" id="pw" class="form-control"></td>
			  	</tr>
			  	<tr>
			    	<td><input type="button" id="log" value="Register" class="btn btn-success"></td>
			  	</tr>
			</table> 			
		</div>
	</form>
	
	<script>
	$(document).ready(function () {
		$('#log').click(function() {
			var fname = $('#FirstName');
			var lname = $('#LastName');
			var phone = $('#Phone');
			var email = $('#email');
			var pword = $('#pw');
			
			if (fname.val() == '' ||
				lname.val() == '' ||
				phone.val() == '' ||
				email.val() == '' ||
				pword.val() == '') {
					alert('Ensure all fields are filled out');
			} else {
				$('#frmReg').submit();
			}
		});		
	});
	</script>
<?php include('pageFooter.php'); ?>