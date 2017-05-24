<?php include('helper.php'); ?>

<?php include('pageHeader.php') ?>

	<?php

// List staff
if (count($_GET) == 0) {
	$staffList = mysqli_query($db, "SELECT * FROM staff");
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Contact Us:
			<span style="float:right; margin-top: -5.5px">
			</span>
		</div>
		<div class="panel-body">
			<table class="table">
			  <thead>
				<tr>
				  <th>Agent</th>
				  <th>Email</th>
				  <th>Contact Number</th>
				</tr>
			  </thead>
				<tbody>
					<?php
					while ($client = mysqli_fetch_assoc($staffList)) {
						echo "
							<tr>
							  <td>{$client['fName']} {$client['lname']}</td>
							  <td>{$client['email']}</td>
							  <td>{$client['phone']}</td>
							  </td>
							</tr>
						";
					}
}	
					?>
				</tbody>
			</table>
		</div>
	</div>

<?php ?>

<?php include('pageFooter.php'); ?>