<?php include('helper.php'); ?>

<?php
/***** New/Edit viewing *****/
if (isset($_GET['save'])) {
    if (isset($_POST['id']) && $_POST['id'] > 0) {
        // if jquery caught the save click then it must have been validated already (but consider csrf)
        print_r($_POST);
        $update = mysqli_query($db, "UPDATE PropertyViews SET propertyID='{$_POST['propertyID']}', staffID='{$_POST['tenantID']}', startDate='{$_POST['startDate']}', endDate='{$_POST['endDate']}' WHERE id='{$_POST['id']}'");

        if ($update) {
            header('location: propertyViews.php'); // redirect to prevent resubmit
        } else {
            echo mysqli_error($db); exit;
        }
    } else {
        // new viewing
        $update = mysqli_query($db, "INSERT INTO PropertyViews (id, propertyID, start_datetime, end_datetime, staffID) VALUES('{$_POST['id']}', '{$_POST['propertyID']}', '{$_POST['start_datetime']}', '{$_POST['end_datetime']}','{$_POST['staffID']}')");

        if ($update) {
            header('location: propertyViews.php'); // redirect to prevent resubmit
        } else {
            echo mysqli_error($db); exit;
        }
    }
}

/***** Delete contract *****/
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
		PropertyViews.id,
		PropertyViews.propertyID,
		PropertyViews.start_datetime,
		PropertyViews.end_datetime,
		PropertyViews.staffID
		FROM PropertyViews
		LEFT JOIN properties ON properties.propertyID=contracts.propertyID
		ORDER BY PropertyViews.start_datetime ASC
	") or die(mysqli_error($db));
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            Contracts List
            <span style="float:right; margin-top: -5.5px">
				<a href='propertyViews.php?new' class='btn btn-success btn-sm'>
				  <span class='glyphicon glyphicon-plus'></span> New inspection form
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
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($view = mysqli_fetch_assoc($viewsList)) {
                    echo "
							<tr>
							  <th scope='row'>{$view['contractID']}</th>
							  <td>{$view['street']}, {$view['suburb']}, {$view['postcode']}</td>
							  <td>{$view['fName']} {$view['lname']}</td>
							  <td>{$view['startDate']}</td>
							  <td>
								<a href='propertyViews.php?edit&id={$view['contractID']}' class='btn btn-success'>
								  <span class='glyphicon glyphicon-edit'></span> Edit
								</a>
								<a href='propertyViews.php?delete&id={$view['contractID']}' class='btn btn-danger'>
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


// Create/Edit property view
if (isset($_GET['edit']) && isset($_GET['id']) && $_GET['id'] > 0 ||
    isset($_GET['new'])) {

    if (isset($_GET['edit'])) {
        // edit mode
        $views= mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM PropertyViews WHERE id={$_GET['id']}"));
        $action = 'Edit Viewing Time #';
    } else {
        // create mode
        // fill an empty array representing the new viewing.
        $views = [
            'contractID' => '',
            'staffID' => '',
            'endDate' => '',
            'startDate' => ''
        ];

        $action = 'New Contract';
    }

    $propertyViews = mysqli_query($db, "SELECT * FROM propertyViews");
    $properties = mysqli_query($db, "SELECT * FROM properties LEFT JOIN staff ON staff.staffID=properties.staffID");
    ?>
    <form action="propertyViews.php?save" method="post" id="frmEditContract">
        <?php if (isset($_GET['edit'])) { ?> <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">  <?php }; ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php echo "{$action} {$contract['contractID']}"; ?>
            </div>
            <div class="panel-body" style="padding: 2em">
                <div class="form-group row">
                    <label for="example-text-input" class="col-2 col-form-label">Property</label>
                    <div class="col-10">
                        <select name="propertyID" id="propertyID" class="form-control">
                            <option disabled>Select property</option>
                            <?php
                            while ($property = mysqli_fetch_assoc($properties)) {
                                if ($property['propertyID'] == propertyViews['propertyID']) {
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
                    <label for="example-search-input" class="col-2 col-form-label">Tenant</label>
                    <div class="col-10">
                        <select name="staffID" id="staffID" class="form-control">
                            <option disabled>Select tenant</option>
                            <?php
                            while ($properties = mysqli_fetch_assoc($tenants)) {
                                if ($tenant['propertyID'] == $propertyViews['propertyID']) {
                                    echo "<option selected value='{$tenant["tenantID"]}'>";
                                } else {
                                    echo "<option value='{$tenant["tenantID"]}'>";
                                }
                                echo "{$tenant["fName"]} {$tenant["lname"]}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-email-input" class="col-2 col-form-label">Start Date</label>
                    <div class="col-10">
                        <input class="form-control" type="date" value="<?php echo $contract['start_datetime']; ?>" id="startDate" name="startDate">
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
                window.location.href = "contracts.php";
            });

            // Save button pressed
            $('#save').click(function() {
                var property = $("#propertyID");
                var staff = $("#staffID");
                var time = $("#startDate");
                var endDate = $("#endDate");

                // validate form need to be logged in and have a valid time
                if (!isset($_SESSION) ||
                    time.val() == '' ||
                    property.val() <= 0 ||
                    staff.val() <= 0 ||
                    endDate.val() == '')
                {
                    alert('Ensure you have filled out the entire form.');
                } else {
                    $("#frmEditContract").submit();
                }
            });
        });
    </script>
    <?php
}
?>

<?php include('pageFooter.php'); ?>