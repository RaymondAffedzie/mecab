<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
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
            <div class="col-md-12 grid-margin">
                <div class="card rounded-3 p-5">
                    <h4 class="text-center">Add Category</h4>
                    </h4>
                    <form class="pt-3" id="add-categories-form" action="../logic/add-categories-logic.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset style="border: 1px solid #ccc; border-radius: 4px; padding: 5px;">
                                    <legend style="color: #fe6633; font-size: 12px;">Required</legend>
                                    <div class="form-group mb-3">
                                        <label for="category_name">Category Name</label>
                                        <input type="text" id="category_name" class="form-control form-control-lg" name="category_name" placeholder="Category name">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="image-upload">Select Image:</label>
                                                <input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-6 py-3">
                                    <div id="image-preview-container">
                                        <img id="image-preview" src="" alt="Image Preview" width="100%" height="auto">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button id="save-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">
                                <i class="mdi mdi-content-save-all"></i> Save
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                Copyright © 2023. MeCAB All rights reserved.
            </span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                <!-- Hand-crafted & made with -->
                <i class="ti-heart text-danger ml-1"></i>
            </span>
        </div>
    </footer>
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->


<script src="../vendors/js/vendor.bundle.base.js"></script>
<script src="../js/jquery.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="../vendors/sweetalert/sweetalert.min.js"></script>
<script src="../js/off-canvas.js"></script>
<script src="../js/hoverable-collapse.js"></script>
<script src="../js/template.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/todolist.js"></script>
<script src="../js/dashboard.js"></script>
<script>
    $(document).ready(function() {
        $("#save-btn").click(function(e) {
            e.preventDefault();

            var category_name = $("#category_name").val().trim();

            if (category_name === '') {
                swal("Error", "Please enter category name.", "error");
                return;
            }

            var imageInput = document.getElementById('image-upload');
            var selectedFile = imageInput.files[0]; // Get the selected file

            var allowedExtensions = /(\.png|\.jpeg|\.jpg|\.AVIF)$/i;

            // Check if an image is selected
            if (!selectedFile) {
                swal("Error", "Please select an image.", "error");
                return;
            }

            // Check the file extension
            if (!allowedExtensions.exec(selectedFile.name)) {
                swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG, JPG and AVIF.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('category_name', category_name);
            formData.append('image', selectedFile);

            $.ajax({
                url: '../logic/add-categories-logic.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $("#add-categories-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            window.location.href = response.redirect;
                        });
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });

        });
    });

    // Function to preview the selected image
    function previewImage(input) {
        var imagePreview = document.getElementById('image-preview');
        var imagePreviewContainer = document.getElementById('image-preview-container');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.setAttribute('src', e.target.result);
                imagePreviewContainer.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            imagePreview.setAttribute('src', '');
            imagePreviewContainer.style.display = 'none';
        }
    }

    // Listen for changes in the file input
    document.getElementById('image-upload').addEventListener('change', function() {
        previewImage(this);
    });
</script>
</body>

</html>