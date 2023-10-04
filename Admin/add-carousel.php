<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:i:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
	header("Location: ../login.php");
	exit;
}

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController();
?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<h4 class="card-title float-left">Add Carousel</h4>
								<h4 class="float-right"><a href="view-carousels.php" class="text-decoration-none">View Carousels</a></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<form class="pt-3" id="add-carousel-form" action="../logic/add-carousel-logic.php" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group mb-3">
												<label for="caption">Caption</label>
												<input type="text" id="caption" class="form-control form-control-lg" name="caption" placeholder="Caption">
											</div>
											<div class="form-group mb-3">
												<label for="image-upload">Select Image:</label>
												<input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
											</div>
										</div>
										<div class="col-md-6 py-3">
											<div id="image-preview-container">
												<img id="image-preview" src="" alt="Image Preview" width="100%" height="auto">
											</div>
										</div>
									</div>
									<div class="mt-3">
										<button id="save-carousel-btn" class="btn btn-primary font-weight-medium auth-form-btn" name="save">
											<i class="mdi mdi-content-save-all"></i> SAVE
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include_once('includes/footer.php'); ?>