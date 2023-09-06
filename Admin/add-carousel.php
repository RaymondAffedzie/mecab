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
						<div class="col-md-6 mx-auto">
							<h4>Add Carousel</h4>
							<form class="pt-3" id="add-carousel-form" action="../logic/add-carousel-logic.php" method="post" enctype="multipart/form-data">
								<!-- Form fields -->
								<div class="input-group mb-3">
									<input type="text" id="carouselName" class="form-control form-control-lg" name="carouselName" placeholder="Enter carousel name">
								</div>
								<label for="carouselImage">Carousel Image</label> <br>
								<div class="input-group mb-3">
									<input type="file" id="carouselImage" class="form-control form-control-lg" name="carouselImage">
								</div>
								<div class="mt-3">
									<button id="add-carousel-btn" class="btn btn-primary font-weight-medium auth-form-btn" name="save">
										<i class="mdi mdi-content-save-all"></i> ADD CAROUSEL
									</button>
								</div>
							</form>
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
	$(document).ready(function() {
		$("#add-carousel-btn").click(function(e) {
			e.preventDefault();

			var carouselName = $("#carouselName").val().trim();

			if (carouselName === '') {
				swal("Error", "Please enter carousel name.", "error");
				return;
			}

			var imageInput = document.getElementById('carouselImage');
			var selectedFile = imageInput.files[0]; // Get the selected file

			var allowedExtensions = /(\.png|\.jpeg|\.jpg|\.avif)$/i;

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
			formData.append('carouselName', carouselName);
			formData.append('carouselImage', selectedFile);

			$.ajax({
				url: '../logic/add-carousel-logic.php',
				type: 'POST',
				data: formData,
				dataType: 'json',
				contentType: false,
				processData: false,
				success: function(response) {
					if (response.status === 'success') {
						$("#add-carousel-form")[0].reset();
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
	});
</script>
</body>

</html>