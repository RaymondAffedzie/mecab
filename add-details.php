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
	// include_once('includes/navbar.php');

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
	    <!--Top Header-->
		<div class="top-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 col-sm-8 col-md-5 col-lg-4">
                    <p class="phone-no"><i class="anm anm-phone-s"></i> +233 (0)24 769 2388 / +233 (0)24 816 5601</p>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 d-none d-lg-none d-md-block d-lg-block">
                    <div class="text-center"><p class="top-header_middle-text">iRBbA Devs & iQuco Tech</p></div>
                </div>
                <div class="col-2 col-sm-4 col-md-3 col-lg-4 text-right">
                    <span class="user-menu d-block d-lg-none"><i class="anm anm-user-al" aria-hidden="true"></i></span>
                    <?php
                        if (isset($_SESSION['loggedIn'])) {
                        ?>
                        <ul class="customer-links list-inline">
                            <li>
                                <form id="logoutForm" action="./logic/logout.php" method="post">
                                    <button type="submit" name="logout" class="border-0 text-light" style="cursor: pointer;">
                                        <i class="ti-power-off text-primary"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                        <?php
                        } else {
                        ?>
                            <ul class="customer-links list-inline">
                                <li><a href="./login.php">Login</a></li>
                                <li><a href="./register-user.php">Create Account</a></li>
                                <li><a href="./register-store.php">Purchase Store</a></li>
                            </ul>
                        <?php
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
    <!--End Top Header-->

    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Add details</h1>
            </div>
        </div>
    </div>
    <!--End Page Title-->
    
        <div class="container">
        	<div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 main-col offset-md-3">
                	<div class="mb-4">
						<form class="pt-3" id="CustomerLoginForm" action="logic/add-details-logic.php" method="post" class="contact-form">
							<?php
							if ($isRole == 'Customer' || $isRole == 'Admin') {
								echo '
								<input type="hidden" name="role" value="' . $isRole . '"/>
								<div class="form-group mb-3">
									<input type="tel" id="contact" name="contact" placeholder="Enter your Contact Number" required>
								</div>';
							} elseif ($isRole == 'Mechanic') {
								echo '
								<input type="hidden" name="role" value="' . $isRole . '"/>
								<div class="form-group mb-3">
									<input type="tel" id="contact" name="contact" placeholder="Enter your Contact Number" required>
								</div>
								<div class="form-group">
									<select id="specialisation" name="specialisation" required>
										<option value="">Field of work</option>
										<option value="Auto Electrician">Auto Electrician</option>
										<option value="Auto Mechanic">Auto Mechanic</option>
										<option value="Auto Body Repair Technician">Auto Body Repair Technician</option>
										<option value="Auto Tire Technician">Auto Tire Technician</option>
										<option value="Auto Glass Techinician">Auto Glass Technician</option>
									</select>
								</div>
								<div class="form-group">
									<select id="store" name="store" required>
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
								<div class="form-group mb-3">
									<input type="tel" id="contact" name="contact" placeholder="Enter Your Contact Number" required>
								</div>
								<div class="form-group">
									<select id="store" name="store" required>
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
		
		<!-- Including Jquery -->
		<script src="assets/js/vendor/jquery-3.3.1.min.js"></script>
		<script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
		<script src="assets/js/vendor/jquery.cookie.js"></script>
		<script src="assets/js/vendor/wow.min.js"></script>
		<!-- Including Javascript -->
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/plugins.js"></script>
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/lazysizes.js"></script>
		<script src="assets/js/main.js"></script>
		<script src="vendors/sweetalert/sweetalert.min.js"></script>
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
						swal("Error", "Please enter your contact number.", "error");
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
						data: $("#CustomerLoginForm").serialize() + "&action=add_details",
						dataType: "json",
						success: function(response) {
							// Handle the response and redirect
							if (response.status === "success") {
								$("#CustomerLoginForm")[0].reset();
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
							selectField.append("<option value=''>Select your store</option>"); // Add default option
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