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

$controller = new storeController()
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-12 grid-margin stretch-card">
                <div class="card" id="order-card">
                    <div class="card-body p-5">
                        <h1 class="card-title">Order Details</h1>
                        <div class="row">
                            <div class="col-lg-2 col-md-4 text-left">
                                <h5>Order Infomation</h5>
                                <p class="text-muted">Status</p>
                                <h5 class="text-primary" id="status"></h5>
                                <p class="text-muted">Total Amount</p>
                                <h5 class="text-primary" id="totalAmount"></h5>
                                <p class="text-muted">Order Date</p>
                                <h5 class="text-primary" id="order_date"></h5>
                            </div>
                            <div class="col-lg-2 col-md-4 text-left">
                                <h5>Address Information</h5>
                                <p class="text-muted">Delivery Town</p>
                                <h5 class="text-primary" id="city"></h5>
                                <p class="text-muted">Town Region</p>
                                <h5 class="text-primary" id="region"></h5>
                                <p class="text-muted">GPS Address</p>
                                <h5 class="text-primary" id="gps_address"></h5>
                            </div>
                            <div class="col-lg-2 col-md-4 text-left">
                                <h5>Customer Infomation</h5>
                                <p class="text-muted">Customer Name</p>
                                <h5 class="text-primary" id="full_name"></h5>
                                <p class="text-muted">Phone Number</p>
                                <h5 class="text-primary" id="contact"></h5>
                                <p class="text-muted">Email</p>
                                <h5 class="text-primary" id="email"></h5>
                            </div>
                            <div class="col-lg-6 col-md-12 md-mt-5">
                                <h5>Order Items</h5>
                                <div class="table-responsive">
                                    <table id="order-items-table" class="table order-column table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Product Name</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mx-auto mt-3" id="process-order">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-warning" id="confirm-btn"><i class="mdi mdi-thumb-up-outline"></i> Confirm</button>
                                    <button type="button" class="btn btn-outline-info" id="ship-btn"><i class="mdi mdi-truck-delivery"></i> Ship</button>
                                    <button type="button" class="btn btn-outline-success" id="complete-btn"><i class="mdi mdi-check-all"></i> Complete</button>
                                </div>
                            </div>
                            <input type="hidden" name="order" id="order">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('includes/footer.php'); ?>