<?php include('helper.php'); ?>

<?php include('pageHeader.php'); ?>
		<div class="panel panel-primary">
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
			<div class="panel-body">
				<?php
			
					if (isset($_GET['q'])) {
						$searchQuery = mysqli_query($db, "SELECT * FROM properties WHERE street LIKE '%{$_GET['q']}%' OR suburb  LIKE '%{$_GET['q']}%'") or die(mysqli_error($db));
						if (mysqli_num_rows($searchQuery) > 0) {
							while ($result = mysqli_fetch_assoc($searchQuery)) {
								echo "<div class=\"panel-body\"><a href=\"properties.php?view&id={$result['propertyID']}\">{$result['street']}, {$result['suburb']}, {$result['postcode']}</a></div>";
							}
						} else {
							echo 'No results.';
						}
						
					} else {
						echo 'Nothing to show.';
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