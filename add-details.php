	<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	session_start();

	// Prevent user from accessing this page when not logged in
	if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
		header("Location: login.php");
		exit;
	}

	// Prevent user from accessing this page when user's store is verified
	if (isset($_SESSION['isVerified'])) {
		header("Location: index.php");
	}

	require_once 'controllers/storeController.php';
	include_once('includes/head.php');
	include_once('includes/navbar.php');

	$controller = new storeController();
	// $record = $controller->getUserDetails();
	$stores = $controller->getStores();

	$userId = $_SESSION['userId'];
	$isRole = $_SESSION['role'];

	// $contact = $controller->getUserContact($userId, '');
	// if ($contact) {
	// 	header("Location: already_added_details.php");
	// 	exit;
	// }

	?>
	<!-- partial -->
	<div class="main-panel">
		<div class="content-wrapper">
			<div class="row">
				<div class="col-lg-6  mx-auto">
					<div class="card text-center rounded-3 p-5">
						<h4>Add Details</h4>
						<form class="pt-3" id="add-details-form" action="logic/add-details-logic.php" method="post">
							<!-- Form fields -->
							<?php
							if ($isRole == 'Customer' || $isRole == 'Admin') {
								echo '
								<input type="hidden" name="role" value="' . $isRole . '"/>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="mdi mdi-phone"></i></span>
									</div>
									<input type="tel" id="contact" class="form-control form-control-lg" name="contact" placeholder="Contact Number" required>
								</div>';
							} elseif ($isRole == 'Mechanic') {
								echo '
								<input type="hidden" name="role" value="' . $isRole . '"/>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="mdi mdi-phone"></i></span>
									</div>
									<input type="tel" id="contact" class="form-control form-control-lg" name="contact" placeholder="Contact Number" required>
								</div>
								<div class="form-group">
									<select id="specialisation" class="form-control form-control-lg" name="specialisation" required>
										<option value="">Field of work</option>
										<option value="Auto Electrician">Auto Electrician</option>
										<option value="Auto Mechanic">Auto Mechanic</option>
										<option value="Auto Body Repair Technician">Auto Body Repair Technician</option>
										<option value="Auto Tire Technician">Auto Tire Technician</option>
										<option value="Auto Glass Techinician">Auto Glass Technician</option>
									</select>
								</div>
								<div class="form-group">
									<select id="store" class="form-control form-control-lg" name="store" required>
										<option value="">Select Store</option>';
								foreach ($stores as $store) {
									echo '<option value="' . $store['store_id'] . '">' . $store['store_name'] . '</option>';
								}
								echo '
									</select>
								</div>
								';
							} elseif ($isRole == 'Spare parts' || $isRole == 'Transport' || $isRole == 'Car rentals') {
								echo '
								<input type="hidden" name="role" value="' . $isRole . '"/>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="mdi mdi-phone"></i></span>
									</div>
									<input type="tel" id="contact" class="form-control form-control-lg" name="contact" placeholder="Contact Number" required>
								</div>
								<div class="form-group">
									<select id="store" class="form-control form-control-lg" name="store" required>
										<option value="">Select Store</option>';
								foreach ($stores as $store) {
									echo '<option value="' . $store['store_id'] . '">' . $store['store_name'] . '</option>';
								}
								echo '
									</select>
								</div>
								';
							}
							?>
							<div class="mt-3">
								<button id="save-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">
									<i class="mdi mdi-content-save-all"></i> Save
								</button>
							</div>
						</form>
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

	<script src="vendors/js/vendor.bundle.base.js"></script>
	<script src="js/jquery.js"></script>
	<script src="vendors/sweetalert/sweetalert.min.js"></script>
	<script src="js/off-canvas.js"></script>
	<script src="js/hoverable-collapse.js"></script>
	<script src="js/template.js"></script>
	<script src="js/settings.js"></script>
	<script src="js/todolist.js"></script>
	<script src="js/dashboard.js"></script>
	<script>
		// Ajax script for submitting form
		$(document).ready(function() {
			$("#save-btn").click(function(e) {
				e.preventDefault();

				// Get form inputs
				var contact = $("#contact").val().trim();
				var specialisation = $("#specialisation").val();
				var store = $("#store").val();
				// Perform validation
				if (contact === "") {
					swal("Error", "Please enter a contact number.", "error");
					return;
				}
				if (!validateContact(contact)) {
					swal("Error", "Please enter a valid contact number starting with 0 and containing 10 digits.", "error");
					return;
				}
				if (store === "") {
					swal("Error", "Please select your store", "error");
					return;
				}
				if (specialisation === "") {
					swal("Error", "Please select your field of work", "error");
					return;
				}

				// All inputs are valid, proceed with AJAX request
				$.ajax({
					url: "logic/add-details-logic.php",
					type: "POST",
					data: $("#add-details-form").serialize() + "&action=add_details",
					dataType: "json",
					success: function(response) {
						// Handle the response and redirect
						if (response.status === "success") {
							$("#add-details-form")[0].reset();
							swal("Success", response.message, "success").then(function() {
								window.location.href = response.redirect;
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
		});

		// Contact validation helper function
		function validateContact(contact) {
			var contactPattern = /^0\d{9}$/;
			return contactPattern.test(contact);
		}

		// Ajax script for logout
		$(document).ready(function() {
			// When the form is submitted
			$('#logoutForm').submit(function(e) {
				e.preventDefault(); // Prevent the default form submission

				// Perform the Ajax request
				$.ajax({
					url: "logic/logout.php",
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

		// Fetch stores from the database
		$(document).ready(function() {
			$.ajax({
				url: "logic/get-stores-logic.php",
				type: "POST",
				dataType: "json",
				success: function(response) {
					// Populate the store select field with options
					if (response.status === "success") {
						var stores = response.stores;
						var selectField = $("#store");
						selectField.empty(); // Clear existing options
						selectField.append("<option value=''>Select a store</option>"); // Add default option
						stores.forEach(function(store) {
							selectField.append("<option value='" + store.store_id + "'>" + store.store_name + "</option>"); // Add option for each store
						});
						selectField.removeAttr("disabled"); // Enable the select field
					} else {
						swal("Error", response.message, "error");
					}
				},
				error: function(xhr, status, error) {
					swal("Error", "An error occurred while fetching the stores: " + error, "error");
				}
			});
		});
	</script>
	<!-- Add this script at the end of your HTML file, just before the closing </body> tag -->

	</body>

	</html>