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
?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded-3 p-3">
                    <h4 class="text-left">Orders</h4>
                    <div class="table-responsive">
                        <table id="orders-table" class="table order-column table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Data/Time</th>
                                    <th class="text-center">Process Order</th>
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

    <?php include_once('includes/footer.php'); ?>