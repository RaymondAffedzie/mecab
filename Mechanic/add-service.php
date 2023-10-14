<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s"); // Fixed the time format
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
            <div class="col-md-12 grid-margin stretch-car">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mx-auto mb-5">
                                <h4>Add Service</h4>
                                <form class="pt-3" id="add-mechanic-service-form" action="../logic/add-mechanic-service-logic.php" method="post">
                                    <!-- Form fields -->
                                    <div class="mb-3">
                                        <label for="service">Services</label>
                                        <div class="input-group">
                                            <input type="text" id="service" class="form-control form-control-lg" name="service" placeholder="Enter service" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <div class="input-group">
                                            <input type="number" id="price" class="form-control form-control-lg" name="price" placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="duration">Duration</label>
                                        <div class="input-group">
                                            <input type="number" id="duration" class="form-control form-control-lg" name="duration" min="0" placeholder="Duration">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button id="save-service-btn" class="btn btn-primary" name="save">
                                            <i class="mdi mdi-content-save-all"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8 mx-auto">
                                <h4>Services</h4>
                                <div class="table-responsive">
                                    <table id="services-table" class="table order-column table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Service</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Duration(Hours)</th>
                                                <th class="text-center">View</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
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
    <?php
    include_once('includes/footer.php')
    ?>