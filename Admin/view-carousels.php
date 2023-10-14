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
                        <div class="col-md-12 mb-5">
                            <h4 class="card-title float-left">Carousel</h4>
                            <h4 class="float-right"><a href="add-carousel.php" class="text-decoration-none">Add Carousel</a></h4>
                        </div>
                        <div class="table-responsive">
                            <table id="carousel-table" class="table order-column table-hover">
                                <thead>
                                    <tr>
                                        <th>Carousel Caption</th>
                                        <th>Date</th>
                                        <th>Show details</th>
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
    <?php include_once('includes/footer.php'); ?>