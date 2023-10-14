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
                <div class="card" id="spare-part-card">
                    <div class="card-body">
                        <h1 class="card-title">Category Details</h1>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="col-md-6 text-left">
                                <div class="my-3">
                                    <img alt="" id="image" width="480px" height="auto">
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Category name</p>
                                    <h5 class="text-primary" id="name"></h5>
                                </div>
                            </div>
                            <div class="mx-auto mt-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                    <i class="mdi mdi-grease-pencil"></i> Edit
                                </button>
                                <button id="delete-category-btn" class="btn btn-sm btn-outline-danger font-weight-medium mx-auto">
                                    <i class="mdi mdi-delete"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Edit Categories</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="settings-close ti-close text-danger"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="pt-3" id="update-category-form" action="../logic/update-category-logic.php" method="post" enctype="multipart/form-data">

                            <input type="hidden" value="" id="category_id" name="category_id">
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name">
                            </div>
                            <div class="form-group">
                                <label for="image-upload">Select Image:</label>
                                <input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
                            </div>

                            <div id="image-preview-container">
                                <img id="image-preview" src="" alt="Image Preview" width="100%" height="auto">
                            </div>

                            <div class="mt-3">
                                <button id="save-category-update-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">SAVE</button>
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
    <?php include_once('includes/footer.php'); ?>