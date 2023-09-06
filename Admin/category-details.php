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

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    $query = "SELECT * FROM categories WHERE category_id = :category_id";
    $params = array(":category_id" => $category_id);

    $categoryDetails = $controller->getSingleRecordsByValue($query, $params);
}
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
                                    <img src="../uploads/<?php echo $categoryDetails['image']; ?>" alt="" id="image" width="480px" height="auto">
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Category name</p>
                                    <h5 class="text-primary" id="category_name"><?php echo $categoryDetails['category_name']; ?></h5>
                                </div>
                            </div>
                            <div class="mx-auto mt-3">
                                <button id="edit-spare-part-btn" class="btn btn-sm btn-outline-primary font-weight-medium mx-auto">
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
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card text-left" id="edit-spare-part-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Edit spare part</h1>
                        <form class="pt-3" id="update-category-form" action="../logic/update-category-logic.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" value="<?= $categoryDetails['category_id']; ?>" id="category_id" name="category_id">
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="image-upload">Select Image:</label>
                                        <input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="image-preview-container">
                                        <img id="image-preview" src="" alt="Image Preview" width="480px" height="auto">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button id="save-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">SAVE</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
            Copyright © 2023 from MeCAB. All rights reserved.
        </span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
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
<script src="../vendors/sweetalert/sweetalert.min.js"></script>
<script src="../js/off-canvas.js"></script>
<script src="../js/hoverable-collapse.js"></script>
<script src="../js/template.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/todolist.js"></script>
<script src="../js/dashboard.js"></script>
<script>
    // Display card on button click
    document.addEventListener("DOMContentLoaded", function() {
        // Get the edit-spare-part-btn and edit-spare-part-card elements
        const editProfileBtn = document.getElementById("edit-spare-part-btn");
        const userProfileCard = document.getElementById("edit-spare-part-card");

        // Add click event listener to the edit-spare-part-btn
        editProfileBtn.addEventListener("click", function() {
            // Toggle the visibility of the edit-spare-part-card
            userProfileCard.style.display = userProfileCard.style.display === "none" ? "block" : "none";
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

    $("#save-btn").click(function(e) {
        e.preventDefault();

        var category_name = $("#name").val().trim();
        var category_id = $("#category_id").val().trim();

        var categoryImageElement = $("#image-upload");
        var categoryImage = null;

        if (categoryImageElement.length > 0 && categoryImageElement[0].files.length > 0) {
            categoryImage = categoryImageElement[0].files[0];

            // Validate the image only if it's uploaded
            var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;
            if (!allowedExtensions.exec(categoryImage.name)) {
                swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG, JPG and AVIF.", "error");
                return;
            }
        }

        var formData = new FormData();
        formData.append('category_id', category_id);
        formData.append('category_name', category_name);
        formData.append('image', categoryImage);

        $.ajax({
            url: "../logic/update-category-logic.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    $("#update-category-form")[0].reset();
                    swal("Success", response.message, "success").then(function() {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
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

    // Delete spare part item
    $("#delete-category-btn").click(function(e) {
        <?php
        if (isset($_GET['category_id'])) {
            $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        ?>
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this category!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: "../logic/delete-category.php",
                        type: "POST",
                        data: {
                            category_id: "<?php echo $category_id; ?>"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                swal("Success", response.message, "success").then(function() {
                                    window.location.href = "../Admin/view-categories.php";
                                });
                            } else {
                                swal("Error", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error", "An error occurred while deleting the category: " + error, "error");
                        },
                    });
                }

            });
        <?php
        }
        ?>
    });
</script>
</body>

</html>