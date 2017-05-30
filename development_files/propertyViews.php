<?php include('helper.php'); ?>

<?php
/***** New/Edit viewing *****/
if (isset($_GET['save'])) {

    if (isset($_POST['id']) && $_POST['id'] > 0) {
        // if jquery caught the save click then it must have been validated already (but consider csrf)
	
        print_r($_POST);
	
        $update = mysqli_query($db, "UPDATE PropertyViews SET propertyID={$_POST['propertyID']}, start_datetime='{$_POST['start_datetime']}', end_dateTime='{$_POST['end_datetime']}' WHERE id='{$_POST['id']}'");

        if ($update) {
            header('location: propertyViews.php'); // redirect to prevent resubmit
        } else {
            echo mysqli_error($db); exit;
        }
    } else {
        // new viewing
	$update = mysqli_query($db, "INSERT INTO PropertyViews (propertyID, start_datetime, end_dateTime, staffID) VALUES('{$_POST['propertyID']}', '{$_POST['start_datetime']}', '{$_POST['end_datetime']}','{$_POST['propertyID']}')");

        if ($update) {
            header('location: propertyViews.php'); // redirect to prevent resubmit
        } else {
            echo mysqli_error($db); exit;
        }
    }
}

/***** Delete viewing *****/
if (isset($_GET['delete'])) {
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $delete = mysqli_query($db, "DELETE FROM PropertyViews WHERE id={$_GET['id']}");

        if ($delete) {
            header('location: propertyViews.php'); // redirect to prevent resubmit
        } else {
            echo mysqli_error($db); exit;
        }
    } else {
        header('location: propertyViews.php');
    }
}
?>

<?php include('pageHeader.php'); ?>


<?php
// List properties
if (count($_GET) == 0) {
    $viewsList = mysqli_query($db, "
		SELECT
		PropertyViews.id as PropertyViews_id,
		properties.street, 
		properties.suburb, 
		properties.postcode,
		staff.fname,
		staff.lname, 
		PropertyViews.id,
		PropertyViews.propertyID,
		PropertyViews.start_datetime,
		PropertyViews.end_datetime,
		PropertyViews.staffID
		FROM PropertyViews
		LEFT JOIN properties ON PropertyViews.propertyID=properties.propertyID
		LEFT JOIN staff ON PropertyViews.staffID=staff.staffID
		ORDER BY PropertyViews.start_datetime ASC
	") or die(mysqli_error($db));
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            Property Viewings
            <span style="float:right; margin-top: -5.5px">
				<a href='propertyViews.php?new' class='btn btn-success btn-sm'>
				  <span class='glyphicon glyphicon-plus'></span> New Viewing Schedule
				</a>
			</span>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Property</th>
                    <th>Staff</th>
                    <th>Date Time</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($view = mysqli_fetch_assoc($viewsList)) {
					$start = date('l jS F Y g:ia ', strtotime($view['start_datetime']));
					$start_end   = $start . ' - ' . date('g:ia', strtotime($view['end_datetime']));
                    echo "
							<tr>
							  <th scope='row'>{$view['PropertyViews_id']}</th>
							  <td>{$view['street']}, {$view['suburb']}, {$view['postcode']}</td>
							  <td>{$view['fname']} {$view['lname']}</td>
							  <td>{$start_end}</td>
							  <td>
								<a href='propertyViews.php?edit&id={$view['id']}' class='btn btn-success'>
								  <span class='glyphicon glyphicon-edit'></span> Edit
								</a>
								<a href='propertyViews.php?delete&id={$view['PropertyViews_id']}' class='btn btn-danger'>
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


// Create/Edit contract
if (isset($_GET['edit']) && isset($_GET['id']) && $_GET['id'] > 0 ||
	isset($_GET['new'])) { 
	
	if (isset($_GET['edit'])) {
		// edit mode
		$views = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM PropertyViews WHERE id={$_GET['id']}"));
		$action = 'Edit Viewing Time #';
	} else {
		// create mode
		// fill an empty array representing the new tenant. for quick hacks of the existing edit form
		$views = [
			'id' => '',
			'start_datetime' => '',
			'end_datetime' => '',
		];
		
		$action = 'New Viewing Time';
	}
	

	$properties = mysqli_query($db, "SELECT * FROM properties");
	$staff = mysqli_query($db, "SELECT * FROM staff");
?>
	<form action="propertyViews.php?save" method="post" id="frmEditView">
		<?php if (isset($_GET['edit'])) { ?> <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">  <?php }; ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo "{$action} {$views['id']}"; ?>
			</div>
			<div class="panel-body" style="padding: 2em">
				<div class="form-group row">
				  <label for="example-text-input" class="col-2 col-form-label">Property</label>
				  <div class="col-10">
					<select name="propertyID" id="propertyID" class="form-control">
						<option disabled>Select property</option>
						<?php
						while ($property = mysqli_fetch_assoc($properties)) {
							if ($property['propertyID'] == $views['propertyID']) {
								echo "<option selected value='{$property["propertyID"]}'>";
							} else {
								echo "<option value='{$property["propertyID"]}'>";
							}
							echo "{$property["street"]} {$property["suburb"]} {$property["postcode"]}</option>";
							
							
						}
						?>
					</select>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-email-input" class="col-2 col-form-label">Start Date</label>
				  <div class="col-10">
					<input class="form-control" type="datetime-local" value="<?php echo date("Y-m-d h:i:00", $views['start_datetime']); ?>" id="start_datetime" name="start_datetime">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-url-input" class="col-2 col-form-label">End Date</label>
				  <div class="col-10">
					<input class="form-control" type="datetime-local" value="<?php echo $views['end_datetime']; ?>" id="end_datetime" name="end_datetime">
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
				window.location.href = "propertyViews.php";
			});
			
			// Save button pressed
			$('#save').click(function() {
				var property = $("#propertyID");
				var startDate = $("#start_datetime");
				var endDate = $("#end_datetime");
				
				// validate form
				if (
					startDate.val() == '' ||
					endDate.val() == '') 
				{
					alert('Ensure you have filled out the entire form.');
				} else {
					$("#frmEditView").submit();
				}
			});
		});
	</script>
	<?php
}
?>
<?php include('pageFooter.php'); ?>
