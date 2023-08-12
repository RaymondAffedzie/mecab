<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:m:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController();
$tableName = "car_brand";
$results = $controller->select($tableName);
?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 mx-auto">
				<div class="card text-center rounded-3 p-5">
					<div class="row">
                        <div class="col-md-4 mx-auto">
							<h4>Add Car Model</h4>
							<form class="pt-3" id="add-car-model-form" action="../logic/add-car-model-logic.php" method="post">
								<!-- Form fields -->
								<div class="input-group mb-3">
									<input type="text" id="modelName" class="form-control form-control-lg" name="modelName" placeholder="Enter car model" required>
								</div>
								<div class="form-group">
									<select id="car_brand_id" class="form-control form-control-lg" name="car_brand_id">
										<?php
										foreach ($results as $data) : ?>
											<option value="<?= $data['car_brand_id']; ?>"><?= $data['brand_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="mt-3">
									<button id="save-model-btn" class="btn btn-primary font-weight-medium auth-form-btn" name="save">
										<i class="mdi mdi-content-save-all"></i> ADD MODEL
									</button>
								</div>
							</form>
						</div>
                        <div class="col-md-8 mx-auto">
                            <h4>List All Car Models</h4>
                            <div class="table-responsive">
								<table id="car-model-table" class="table order-column table-hover">
									<thead>
										<tr>
											<th class="text-center">Car Brand</th>
											<th class="text-center">Car Model</th>
											<th class="text-center">View Model</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
                        	</div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>



    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                Copyright © 2023. MeCAB All rights reserved.
            </span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                <!-- Hand-crafted & made with -->
                <i class="ti-heart text-danger ml-1"></i>
            </span>
        </div>
    </footer>
    <!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<script src="../vendors/js/vendor.bundle.base.js"></script>
<script src="../js/jquery.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="../vendors/sweetalert/sweetalert.min.js"></script>
<script src="../js/off-canvas.js"></script>
<script src="../js/hoverable-collapse.js"></script>
<script src="../js/template.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/todolist.js"></script>
<script src="../js/dashboard.js"></script>
<script>
    $(document).ready(function() {
        // Ajax script for submitting form
        $("#save-model-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var modelName = $("#modelName").val().trim();
            var car_brand_id = $("#car_brand_id").val().trim();

            // Perform validation
            if (modelName === "") {
                swal("Error", "Car model name is required.", "error");
                return;
            }
            if (car_brand_id === "") {
                swal("Error", "Car brand is required.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('car_brand_id', car_brand_id);
            formData.append('modelName', modelName);

            // All inputs are valid, proceed with AJAX request
            $.ajax({
                url: "../logic/add-car-model-logic.php",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle the response and redirect
                    if (response.status === "success") {
                        $("#add-car-model-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            window.location.href = response.redirect; // redirect to desired page
                        });
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });
        });

        // Fetch car brands
        $.ajax({
            url: "../logic/get-car-models.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    // Initialize DataTables
                    var rowNo = 0;
                    var dataTable = $('#car-model-table').DataTable({
                        data: response.parts,
                        columns: [
                            {
                                data: 'brand_name'
                            },
                            {
                                data: 'model_name'
                            },
                            {
                                data: 'car_model_id',
                                render: function(data, type, row) {
                                    // Modify the "View" link to pass the car_brand_id as a query parameter
                                    return '<a href="car-model-details.php?car_model_id=' + data + '">View</a>';
                                }
                            },
                        ],
                        // Add options for pagination, searching, and sorting
                        paging: true,
                        searching: true,
                        ordering: true,
                        // Customize the number of records displayed per page (e.g., 10 records per page)
                        pageLength: 5,
                        // You can customize the page length options if needed
                        lengthMenu: [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, 'All']
                        ],
                    });
                } else {
                    // Handle error case
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching car models: " + error, "error");
            }
        });

        // Logout script
        $('#logoutForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Perform the Ajax request
            $.ajax({
                url: "./../logic/logout.php",
                type: "POST",
                data: $("#logoutForm").serialize() + "&action=logout",
                dataType: "json",
                success: function(response) {
                    // Handle the response from the server
                    if (response.status === 'success') {
                        // If logout was successful, redirect to the login page
                        window.location.href = response.redirect;
                    } else {
                        // If there was an error, display the error message
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    // If there was an error with the Ajax request, display an error message
                    swal("Error", response.message, "error");
                }
            });
        });
    });
</script>
<!-- Add this script at the end of your HTML file, just before the closing </body> tag -->

</body>

</html>