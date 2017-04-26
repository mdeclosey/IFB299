<?php include('helper.php'); ?>

<?php include('pageHeader.php'); ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="input-group">
					<form action="home.php" method="get" id="frmSearch">
						<input type="text" name="q" class="form-control" placeholder="Search for..." value="<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>">
						<span class="input-group-btn">
							<button class="btn btn-secondary btn-success" type="button" id="btnSearch">Go!</button>
						</span>
					</form>
				</div>
			</div>
			<div class="panel-body">
				<?php
			
					if (isset($_GET['q'])) {
						$searchQuery = mysqli_query($db, "SELECT * FROM properties WHERE street LIKE '%{$_GET['q']}%' OR suburb  LIKE '%{$_GET['q']}%'") or die(mysqli_error($db));
						while ($result = mysqli_fetch_assoc($searchQuery)) {
							echo "<div class=\"panel-body\"><a href=\"properties.php?id={$result['propertyID']}\">{$result['street']}, {$result['suburb']}, {$result['postcode']}</a></div>";
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