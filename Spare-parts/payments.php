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
                    <h4 class="text-left">Payments</h4>
                    <div class="table-responsive">
                        <table id="payments-table" class="table order-column table-hover">
                            <thead>
                                <tr>
                                    <th class="text-left">Payment Reference</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Payment Status</th>
                                    <th class="text-center">Data/Time</th>
                                    <th class="text-center">Confirmed</th>
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

    <?php include_once('includes/footer.php'); ?>