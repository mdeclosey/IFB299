<?php include('helper.php'); ?>

<?php
/***** Edit client *****/

/***** Delete client *****/
if (isset($_GET['delete']) && isset($_GET['id']) && $_GET['id'] > 0) {
	$delete = mysqli_query($db, "DELETE FROM tenants WHERE tenantID={$_GET['id']}");
	
	if ($delete) {
		header('location: tenants.php'); // redirect to prevent resubmit
	} else {
		echo mysqli_error($db); exit;
	}
}
?>

<?php include('pageHeader.php'); ?>

<?php

// List clients
if (count($_GET) == 0) {
	$clientList = mysqli_query($db, "SELECT * FROM tenants");
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Tenants List
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
					while ($client = mysqli_fetch_assoc($clientList)) {
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
								</button>
							  </td>
							</tr>
						";
					}	
					?>
				</tbody>
			</table>
		</div>
	</div>
	<script>
		
	</script>
	<?php
}

?>

<?php include('pageFooter.php'); ?>