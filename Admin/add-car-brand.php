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
$tableName = "car_brand";
$results = $controller->select($tableName);
?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin stretch-car">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-4 mx-auto mb-5">
								<h4>Add Car Brand</h4>
								<form class="pt-3" id="add-car-brand-form" action="../logic/add-car-brand-logic.php" method="post">
									<!-- Form fields -->
									<div class="input-group mb-3">
										<input type="text" id="brandName" class="form-control form-control-lg" name="brandName" placeholder="Enter car brand name" required>
									</div>
									<div class="mt-3">
										<button id="save-brand-btn" class="btn btn-primary font-weight-medium auth-form-btn" name="save">
											<i class="mdi mdi-content-save-all"></i> ADD BRAND
										</button>
									</div>
								</form>
							</div>
							<div class="col-md-8 mx-auto">
								<h4>Car Brands</h4>
								<div class="table-responsive">
									<table id="car-brands-table" class="table order-column table-hover">
										<thead>
											<tr>
												<th class="text-center">Brand Name</th>
												<th class="text-center">View Brand</th>
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
	</div>

<?php include_once('includes/footer.php'); ?>