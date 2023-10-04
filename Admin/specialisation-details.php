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
            <div class="col-md-12 col-lg-12 col-sm-12 col-12 grid-margin stretch-card">
                <div class="card" id="specialisation-card">
                    <div class="card-body">
                        <h1 class="card-title">Specialisation Details</h1>
                        <div class="row">
                            <div class="col-lg-7 col-md-12">
                                <div class="my-3">
                                    <img alt="" id="image" width="480px" height="auto">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12 text-left">
                                <div class="mt-3">
                                    <p class="text-muted">specialisation</p>
                                    <h5 class="text-primary" id="name"></h5>
                                    <p id="description"></p>
                                </div>
                            </div>
                        </div>
                        <div class="mx-auto mt-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                <i class="mdi mdi-grease-pencil"></i> Edit
                            </button>
                            <button id="delete-specialisation-btn" class="btn btn-sm btn-outline-danger font-weight-medium mx-auto">
                                <i class="mdi mdi-delete"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Edit Specialisation</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="settings-close ti-close text-danger"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="pt-3" id="update-specialisation-form" action="../logic/update-specialisation-logic.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" value="" id="specialisation_id" name="specialisation_id">
                                <div class="form-group">
                                    <label for="specialisation_name">specialisation Name</label>
                                    <input type="text" class="form-control" id="specialisation_name" name="specialisation_name">
                                </div>
                                <div class="form-group">
                                    <label for="specialisation_description">Description</label>
                                    <textarea name="description" id="specialisation_description" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="image-upload">Select Image:</label>
                                    <input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
                                </div>

                                <div id="image-preview-container">
                                    <img id="image-preview" src="" alt="Image Preview" width="100%" height="auto">
                                </div>

                                <div class="mt-3">
                                    <button id="save-specialisation-update-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">SAVE</button>
                                </div>
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