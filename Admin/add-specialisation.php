<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:i:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

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
								<h4 class="card-title float-left">Add mechanic specialisation</h4>
								<h4 class="float-right"><a href="view-specialisations.php" class="text-decoration-none">View Specialisations</a></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<form class="pt-3" id="add-spcialisation-form" action="../logic/add-spcialisation-logic.php" method="post">
									<!-- Form fields -->
									<div class="input-group mb-3">
										<input type="text" id="spcialisation" class="form-control form-control-lg" name="spcialisation" placeholder="Enter mechanic spcialisation">
									</div>
									<div class="input-group mb-3">
										<textarea name="description" id="description" class="form-control" rows="3" placeholder="Description"></textarea>
									</div>
									<div>
										<label for="image-upload">Select Image:</label>
										<input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
									</div>
									<div class="mt-3">
										<button id="save-specialisation-btn" class="btn btn-primary auth-form-btn" name="save">
											<i class="mdi mdi-content-save-all"></i> ADD SPECIALISATION
										</button>
									</div>
								</form>
							</div>
							<div class="col-md-6 py-3">
								<div id="image-preview-container">
									<img id="image-preview" src="" alt="Image Preview" width="100%" height="auto">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include_once('includes/footer.php'); ?>