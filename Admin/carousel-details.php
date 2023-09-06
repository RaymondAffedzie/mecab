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

if (isset($_GET['carousel_ID'])) {
    $carousel_ID = $_GET['carousel_ID'];

    $query = "SELECT * FROM carousel WHERE carousel_ID = :carousel_ID";
    $params = array(":carousel_ID" => $carousel_ID);

    $carouselDetails = $controller->getSingleRecordsByValue($query, $params);
}
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card" id="spare-part-card">
                    <div class="card-body">
                        <h1 class="card-title">Carousel Details</h1>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="col-md-6 text-left">
                                <div class="my-3">
                                    <img src="../uploads/<?php echo $carouselDetails['image']; ?>" alt="" id="image" width="480px" height="auto">
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Category name</p>
                                    <h5 class="text-primary"><?php echo $carouselDetails['carousel_caption']; ?></h5>
                                </div>
                            </div>
                            <div class="mx-auto mt-3">
                                <button id="edit-spare-part-btn" class="btn btn-sm btn-outline-primary font-weight-medium mx-auto">
                                    <i class="mdi mdi-grease-pencil"></i> Edit
                                </button>
                                <button id="delete-carousel-btn" class="btn btn-sm btn-outline-danger font-weight-medium mx-auto">
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
                        <h1 class="card-title">Edit Carousel</h1>
                        <form class="pt-3" id="update-carousel-form" action="../logic/update-carousel-logic.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" value="<?= $carouselDetails['carousel_ID']; ?>" id="carousel_ID" name="carousel_ID">
                                    <div class="form-group">
                                        <label for="name">Carousel Caption</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter carousel caption">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="image-upload">Select Image:</label>
                                                <input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="image-preview-container">
                                                <img id="image-preview" src="" alt="Image Preview" width="134px" height="186px">
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
    $(document).ready(function() {
        $("#save-btn").click(function(e) {
            e.preventDefault();

            var carouselCaption = $("#name").val().trim();
            var carousel_ID = $("#carousel_ID").val().trim();

            if (carouselCaption === '') {
                swal("Error", "Please enter carousel caption.", "error");
                return;
            }

            var imageInput = document.getElementById('image-upload');
            var selectedFile = imageInput.files[0]; // Get the selected file

            var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;

            // Check if an image is selected
            if (!selectedFile) {
                swal("Error", "Please select an image.", "error");
                return;
            }

            // Check the file extension
            if (!allowedExtensions.exec(selectedFile.name)) {
                swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG, and JPG.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('carousel_ID', carousel_ID);
            formData.append('carousel_caption', carouselCaption);
            formData.append('image', selectedFile);

            $.ajax({
                url: '../logic/update-carousel-logic.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-carousel-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            window.location.href = response.redirect; // redirect to desired page
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

    // Delete spare part item
    $("#delete-carousel-btn").click(function(e) {
        <?php
        if (isset($_GET['carousel_ID'])) {
            $carousel_ID = filter_input(INPUT_GET, 'carousel_ID', FILTER_SANITIZE_NUMBER_INT);
        ?>
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this carousel!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: "../logic/delete-carousel.php",
                        type: "POST",
                        data: {
                            carousel_ID: "<?php echo $carousel_ID; ?>"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                swal("Success", response.message, "success").then(function() {
                                    window.location.href = "../Admin/view-carousel.php";
                                });
                            } else {
                                swal("Error", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error", "An error occurred while deleting the carousel: " + error, "error");
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