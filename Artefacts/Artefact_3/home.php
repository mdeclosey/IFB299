<?php 
include('helper.php'); 
?>

<?php include('pageHeader.php'); ?>
		<div class="panel panel-primary">
			
			<div class="panel-body">
				<?php
				
					if (isset($_GET['q'])) {
						?>
						<div class="panel-heading">
							<form action="home.php" method="get" id="frmSearch">
								<div class="input-group">
									<input type="text" name="q" class="form-control" placeholder="Search for..." value="<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>">
									<span class="input-group-btn">
										<button class="btn btn-secondary btn-success" type="button" id="btnSearch">Go!</button>
									</span>
								</div>
							</form>
						</div>
						<?php
						$searchQuery = mysqli_query($db, "SELECT *, staff.fName as staff_fname, staff.lname as staff_lname FROM properties 
															LEFT JOIN staff ON properties.staffID = staff.staffID
															LEFT JOIN owners ON properties.ownerID = owners.ownerID
															 WHERE street LIKE '%{$_GET['q']}%' OR suburb  LIKE '%{$_GET['q']}%'
													") or die(mysqli_error($db));
						if (mysqli_num_rows($searchQuery) > 0) {
							?>
										<table class="table">
										  <thead>
											<tr>
											  <th>#</th>
											  <th>Images</th>
											  <th>Property</th>
											  <th>Staff</th>
											  <th>Owner</th>
											  <th>Actions</th>
											</tr>
										  </thead>
											<tbody>
												<?php
												while ($property = mysqli_fetch_assoc($searchQuery)) {
													
													$imageQuery = mysqli_query($db, "SELECT * FROM propertyImages WHERE propertyID = {$property['propertyID']}");
													
													echo "
														<tr>
														  <th scope='row'>{$property['propertyID']}</th>
														  <td>";
													
													// print each image						
													while($results = mysqli_fetch_assoc($imageQuery)){
														echo "<img src='{$results['URL_TO_IMAGE']}' style='height: 7em; margin-right: 1em'>";
													}	  
														  
													echo "</td>
														  <td>{$property['street']}, {$property['suburb']}, {$property['postcode']}</td>
														  <td>{$property['staff_fname']} {$property['staff_lname']}</td>
														  <td>{$property['fName']} {$property['lname']}</td>
														  <td>
															<a href='properties.php?view&id={$property['propertyID']}' class='btn btn-primary'>
															  <span class='glyphicon glyphicon-eye'></span> View Property
															</a>
														  </td>
														</tr>
													";
												}	
												?>
											</tbody>
										</table>
							<?php
						} else {
							echo 'No results.';
						}
						
					} else {
						?><br>
						<span style="font-family: 'Quicksand', sans-serif; font-size: 5em; margin-left: 0.75em; padding-left: 0.2em; border-left: 5px solid navy; color: navy">Welcome</span><br><br>
						<span style="font-family: 'Quicksand', sans-serif; font-size: 3em; margin-left: 1.5em; padding-left: 0.2em">Make a Search for your <strong>NEW</strong> home</span><br><br>
						<div class="panel-heading">
							<form action="home.php" method="get" id="frmSearch">
								<div class="input-group input-group-lg">
									<input type="text" name="q" class="form-control" placeholder="Search for..." value="<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>">
									<span class="input-group-btn">
										<button class="btn btn-secondary btn-success" type="button" id="btnSearch">Go!</button>
									</span>
								</div>
							</form>
						</div>
						<?php
					}				
				?>
			</div>
		</div>
	
		<script>
			$(document).ready(function() {
				$('#btnSearch').on('click', function() {
					$('#frmSearch').submit();
				});
			});
		</script>
<?php include('pageFooter.php'); ?>