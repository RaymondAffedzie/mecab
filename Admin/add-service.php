<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
	header("Location: login.php");
	exit;
}

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 mx-auto">
				<div class="card text-center rounded-3 p-5">
					<div class="row">
						<div class="col-md-6">
							<h4>Add Mechanic Services</h4>
							<form class="pt-3" id="add-service-form" action="../logic/add-service-logic.php" method="post">
								<!-- Form fields -->
								<div class="input-group mb-3">
									<input type="text" id="serviceName" class="form-control form-control-lg" name="serviceName" placeholder="Enter mechanic service">
								</div>
								<div>
									<label for="image-upload">Select Image:</label>
									<input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
								</div>
								<div class="mt-3">
									<button id="save-btn" class="btn btn-primary font-weight-medium auth-form-btn" name="save">
										<i class="mdi mdi-content-save-all"></i> ADD SERVICE
									</button>
								</div>
							</form>
						</div>
						<div class="col-md-6 py-3">
							<div id="image-preview-container">
								<img id="image-preview" src="" alt="Image Preview"  width="100%" height="auto">
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
<script src="../vendors/sweetalert/sweetalert.min.js"></script>
<script src="../js/off-canvas.js"></script>
<script src="../js/hoverable-collapse.js"></script>
<script src="../js/template.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/todolist.js"></script>
<script src="../js/dashboard.js"></script>
<script>
	// Ajax script for submitting form
	$(document).ready(function() {
		$("#save-btn").click(function(e) {
            e.preventDefault();

			// Get form inputs
			var serviceName = $("#serviceName").val().trim();

			// Perform validation
			if (serviceName === "") {
				swal("Error", "Service name is required.", "error");
				return;
			}

			var imageInput = document.getElementById('image-upload');
            var selectedFile = imageInput.files[0]; // Get the selected file

            var allowedExtensions = /(\.png|\.jpeg|\.jpg|\.AVIF)$/i;

            // Check if an image is selected
            if (!selectedFile) {
                swal("Error", "Please select an image.", "error");
                return;
            }

            // Check the file extension
            if (!allowedExtensions.exec(selectedFile.name)) {
                swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG, JPG and AVIF.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('service_name', serviceName);
            formData.append('image', selectedFile);


			// All inputs are valid, proceed with AJAX request
			$.ajax({
				url: "../logic/add-service-logic.php",
				type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
				success: function(response) {
					// Handle the response and redirect
					if (response.status === "success") {
						$("#add-service-form")[0].reset();
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
</script>
<!-- Add this script at the end of your HTML file, just before the closing </body> tag -->

</body>

</html>