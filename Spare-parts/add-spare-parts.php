<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
    $message = "Error: [$errno] $errstr - $errfile:$errline - [Date/time] - $eventDate";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page when not verified
if (!$_SESSION['isVerified']) {
	// User's store is not verified
	header("location: ../../verification.php");
	exit;
}

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
	header("Location: ../login.php");
	exit;
}

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController();
$carBrands = $controller->getCarBrands();
?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="card rounded-3 p-5">
					<h4 class="text-center">Add Spare Part</h4>
					<form class="pt-3" id="add-spare-part-form" action="../logic/add-spare-part-logic.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6">
								<fieldset style="border: 1px solid #ccc; border-radius: 4px; padding: 5px;">
									<legend style="color: #fe6633; font-size: 12px;">Required</legend>
									<div class="form-group mb-3">
										<label for="name">Spare Part name</label>
										<input type="text" id="name" class="form-control form-control-lg" name="name" placeholder="Spare part name" required>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div>
												<label for="image-upload">Select Image:</label>
												<input type="file" class="form-control" id="image-upload" name="image" accept="image/*" required>
											</div>
										</div>
										<div class="col-md-6">
											<div id="image-preview-container">
												<img id="image-preview" src="" alt="Image Preview"  width="134px" height="186px">
											</div>
										</div>
									</div>
									<div class="form-group mb-3">
										<label for="price">Price</label>
										<input type="number" id="price" class="form-control form-control-lg" name="price" required>
									</div>
									<div class="form-group">
										<label for="category">Spare part Category</label>
										<select id="category" class="form-control form-control-lg" name="category" required>
											<option value=""></option>
										</select>
									</div>
								</fieldset>
							</div>
							<div class="col-md-6">
								<fieldset style="border: 1px solid #ccc; border-radius: 4px; padding: 5px;">
									<legend style="color: #015500; font-size: 12px;">Optional</legend>
									<div class="form-group mb-3">
										<label for="description">Spare Part Description</label>
										<textarea class="form-control form-control-lg" name="description" id="description" placeholder="Description" cols="5" rows="3"></textarea>
									</div>
								</fieldset>
								<fieldset style="border: 1px solid #ccc; border-radius: 4px; padding: 5px;">
									<legend style="color: #015500; font-size: 12px;">Required for some spare parts</legend>
									<div class="form-group">
										<label for="car_brand">Car brand</label>
										<select id="car_brand" class="form-control form-control-lg" name="car_brand_id">
											<option value=""></option>
										</select>
									</div>
									<div class="form-group">
										<label for="car_model">Car model</label>
										<select id="car_model" class="form-control form-control-lg" name="car_model_id" disabled>
											<option value=""></option>
										</select>
									</div>
								</fieldset>
							</div>
						</div>
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
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->


<script src="../vendors/js/vendor.bundle.base.js"></script>
<script src="../js/jquery.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="../vendors/sweetalert/sweetalert.min.js"></script>
<script src="../js/off-canvas.js"></script>
<script src="../js/hoverable-collapse.js"></script>
<script src="../js/template.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/todolist.js"></script>
<script src="../js/dashboard.js"></script>
<script>
	// Fetch car brands and car models
	$(document).ready(function() {

		// Get spare parts categories
		$.ajax({
			url: "../logic/spare-parts-category-logic.php",
			type: "GET",
			dataType: "json",
			success: function(response) {
				if (response.status === "success") {
					var categories = response.categories;
					var selectField = $("#category");
					selectField.empty();
					selectField.append("<option value=''>Select category of spare part</option>");
					categories.forEach(function(category) {
						selectField.append("<option value='" + category.category_id + "'>" + category.category_name + "</option>");
					});
					selectField.removeAttr("disabled");
				} else {
					swal("Error", response.message, "error");
				}
			},
			error: function(xhr, status, error) {
				swal("Error", "An error occurred while fetching categories: " + error, "error");
			}
		});

		// Fetch car brands
		$.ajax({
			url: "../logic/get-car-brands-logic.php",
			type: "GET",
			dataType: "json",
			success: function(response) {
				if (response.status === "success") {
					var carBrands = response.car_brands;
					var selectField = $("#car_brand");
					selectField.empty();
					selectField.append("<option value=''>Select car brand</option>");
					carBrands.forEach(function(brand) {
						selectField.append("<option value='" + brand.car_brand_id + "'>" + brand.brand_name + "</option>");
					});
					selectField.removeAttr("disabled");
				} else {
					swal("Error", response.message, "error");
				}
			},
			error: function(xhr, status, error) {
				swal("Error", "An error occurred while fetching the car brands: " + error, "error");
			}
		});

		// Fetch car models based on selected car brand
		$("#car_brand").change(function() {
			var selectedBrand = $(this).val();
			var carModelSelect = $("#car_model");

			if (selectedBrand !== "") {
				$.ajax({
					url: "../logic/get-car-models-logic.php",
					type: "GET",
					data: {
						car_brand_id: selectedBrand
					},
					dataType: "json",
					success: function(response) {
						if (response.status === "success") {
							var carModels = response.car_models;
							carModelSelect.empty();
							carModelSelect.append("<option value=''>Select car model</option>");
							carModels.forEach(function(model) {
								carModelSelect.append("<option value='" + model.car_model_id + "'>" + model.model_name + "</option>");
							});
							carModelSelect.removeAttr("disabled");
						} else {
							swal("Error", response.message, "error");
							carModelSelect.empty().attr("disabled", true);
						}
					},
					error: function(xhr, status, error) {
						swal("Error", "An error occurred while fetching the car models: " + error, "error");
						carModelSelect.empty().attr("disabled", true);
					}
				});
			} else {
				carModelSelect.empty().attr("disabled", true);
			}
		});
	});

	// Function to validate the form fields and form submission
	function validateForm() {
		var carBrand 	  = document.getElementById('car_brand').value.trim();
		var carModel 	  = document.getElementById('car_model').value.trim();
		var sparePartName = document.getElementById('name').value.trim();
		var category      = document.getElementById('category').value.trim();
		var price         = document.getElementById('price').value.trim();
		var description   = document.getElementById('description').value.trim();
		var image         = document.getElementById('image-upload').files[0]; // Get the selected file

		if (sparePartName.trim() === '') {
			swal("Error", "Please enter spare part name.", "error");
			return;
		}

		if (category.trim() === '') {
			swal("Error", "Please enter spare part category", "error");
			return;
		}

		if (!/^\d+(\.\d{2})?$/.test(price)) {
			swal("Error", "Price should be a number with no more than two decimal places.", "error");
			return;
		}

		if (description.length > 500) {
			swal("Error", "Description should not exceed 500 characters.", "error");
			return;
		}

		var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;
		if (!allowedExtensions.exec(image.name)) {
			swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG, and JPG.", "error");
			return;
		}

		var formData = new FormData();
		formData.append('car_brand_id', carBrand);
		formData.append('car_model_id', carModel);
		formData.append('spare_part_name', sparePartName);
		formData.append('category', category);
		formData.append('price', price);
		formData.append('description', description);
		formData.append('image', image);

		$.ajax({
			url: '../logic/add-spare-part-logic.php',
			type: 'POST',
			data: formData,
			dataType: 'json',
			contentType: false,
			processData: false,
			success: function(response) {
				if (response.status === 'success') {
					$("#add-spare-part-form")[0].reset();
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

		return false;
	}

	// Function to preview the selected image
	function previewImage(input) {
		var imagePreview = document.getElementById('image-preview');
		var imagePreviewContainer = document.getElementById('image-preview-container');

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				imagePreview.setAttribute('src', e.target.result);
				imagePreviewContainer.style.display = 'block';
			};

			reader.readAsDataURL(input.files[0]);
		} else {
			imagePreview.setAttribute('src', '');
			imagePreviewContainer.style.display = 'none';
		}
	}

	// Listen for changes in the file input
    document.getElementById('image-upload').addEventListener('change', function() {
        previewImage(this);
    });

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
</script>
</body>

</html>