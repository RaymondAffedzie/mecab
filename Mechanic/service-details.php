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

$controller = new storeController()
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-6 col-12 grid-margin stretch-card">
                <div class="card" id="service-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Service Details</h1>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="col-md-12 text-left">
                                <div class="mt-3">
                                    <p class="text-muted">Service</p>
                                    <h5 class="text-primary" id="service"></h5>
                                    <p class="text-muted">Duration</p>
                                    <h5 class="text-primary" id="duration"></h5>
                                    <p class="text-muted">Price</p>
                                    <h5 class="text-primary" id="price"></h5>
                                </div>
                            </div>
                            <div class="mx-auto mt-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                    <i class="mdi mdi-grease-pencil"></i> Edit
                                </button>
                                <button id="delete-mechanic-service-btn" class="btn btn-sm btn-outline-danger font-weight-medium mx-auto">
                                    <i class="mdi mdi-delete"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Edit Service</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="settings-close ti-close text-danger"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="update-service-model-form" action="../logic/update-mechanic-service-logic.php" method="post">
                                <input type="hidden" id="service-id">
                                <div class="mb-3">
                                    <label for="service-name">Service</label>
                                    <div class="input-group">   
                                        <input type="text" class="form-control" id="service-name" name="service" placeholder="Enter Service Name" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="service-price">Price</label>
                                    <div class="input-group">
                                        <input type="number" id="service-price" class="form-control" name="price" placeholder="Price">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="service-duration">Duration</label>
                                    <div class="input-group">
                                        <input type="number" id="service-duration" class="form-control" name="duration" min="0" placeholder="Duration">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Hours</span>
                                        </div>
                                    </div>
                                </div>

                                <button id="save-service-update-btn" class="btn btn-block btn-outline-primary" name="save"><i class="settings-save ti-save"></i> Save</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('includes/footer.php'); ?>