<?php include('helper.php'); ?>

<?php
	// catch user logging in
	if (isset($_GET['login'])) {
		// validate
		if (isset($_POST['username']) && isset($_POST['password'])) {
			$loginDB = mysqli_query($db, "SELECT * FROM users WHERE username={$_POST['username']} && password={$_POST['password']}");
			
			// there should only be one user returned if successful
			if (mysqli_num_rows($loginDB) == 1) {
				$_SESSION['user_id'] = $loginDB['id'];
			}
		}
	}

?>

<?php include('pageHeader.php'); ?>

	<form id="frmLogin" action="login.php?login" method="post">
		<div id="loginForm">
			<table class="form-group table">
			  	<tr>
			    	<td colspan="0"><input type="text" id="username" placeholder="Email" autocomplete="off" class="form-control"></td>
				</tr>
			  	<tr>
			    	<td colspan="0"><input type="password" placeholder="Password" id="pw" class="form-control"></td>
			  	</tr>
			  	<tr>
			    	<td><input type="button" id="log" value="Login" class="btn btn-success"><input type="button" id="registerButton" value="Register" class="btn btn-default"></td>
			  	</tr>
			</table> 	
		</div>
	</form>
	
	<script>
		$(document).ready(function() {
			// Catch register button click
			$('#registerButton').click(function() {
				window.location.href = "register.php";
			});
			
			// Catch login button
			$('#log').click(function() {
				var uname = $('#username');
				var pword = $('#password');
				
				// validate form
				if (uname.val() == '' || pword.val() == '') {
					alert('You must enter a username and password!');
				} else {
					$('#frmLogin').submit();
				}
			});
		});
	</script>
<?php include('pageFooter.php'); ?>