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
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
                    <div class="card-body">
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
                                <h4>Car Models</h4>
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
	</div>


<?php include_once('includes/footer.php'); ?>