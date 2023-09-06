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

$controller = new storeController()
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card" id="car-model-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Car Model Details</h1>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="col-md-12 text-left">
                                <div class="mt-3">
                                    <p class="text-muted">Car Model Name</p>
                                    <h5 class="text-primary" id="model_name"></h5>
                                </div>
                            </div>
                            <div class="mx-auto mt-3">
                                <button id="edit-car-model-btn" class="btn btn-sm btn-outline-primary font-weight-medium mx-auto">
                                    <i class="mdi mdi-grease-pencil"></i> Edit
                                </button>
                                <button id="delete-car-model-btn" class="btn btn-sm btn-outline-danger font-weight-medium mx-auto">
                                    <i class="mdi mdi-delete"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card text-left" id="edit-car-model-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Edit Car Model</h1>
                        <form class="pt-3" id="update-car-model-form" action="../logic/update-car-model-logic.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" id="car-model-id">
                                    <div class="form-group">
                                        <label for="car-model-name">Car Model Name</label>
                                        <input type="text" class="form-control" id="car-model-name" name="model_name" placeholder="Car Brand" required>
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
        // Get the edit-car-model-btn and edit-car-model-card elements
        const editProfileBtn = document.getElementById("edit-car-model-btn");
        const userProfileCard = document.getElementById("edit-car-model-card");

        // Add click event listener to the edit-car-model-btn
        editProfileBtn.addEventListener("click", function() {
            // Toggle the visibility of the edit-car-model-card
            userProfileCard.style.display = userProfileCard.style.display === "none" ? "block" : "none";
        });
    });

    $(document).ready(function() {

        // Fetch car model details
        <?php
            if (isset($_GET['model'])) {
                $car_model = filter_input(INPUT_GET, 'model', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
            $.ajax({
                url: "../logic/get-car-model-details.php",
                type: "GET",
                data: {
                    model_id: "<?= $car_model; ?>"
                },
                dataType: "json",
                success: function(response){
                    if(response.status === "success") {

                        $("#model_name").text(response.data.model_name);
                        $("#car-model-name").val(response.data.model_name);
                        $("#car-model-id").val(response.data.car_model_id);
                        $("#car-model-card").show();
                    }
                }
            });
        <?php
            }
        ?>

        // Update Car Model
        $("#save-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var carModelId = $("#car-model-id").val().trim();
            var carModelName = $("#car-model-name").val().trim();

            if (carModelName === "") {
                swal("Error", "Please enter car model name.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('model_id', carModelId);
            formData.append('model_name', carModelName);

            $.ajax({
                url: "../logic/update-car-model-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-car-model-form")[0].reset();
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

        // Delete car model
        <?php
            if (isset($_GET['model'])) {
                $car_model = filter_input(INPUT_GET, 'model', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
        $("#delete-car-model-btn").click(function(e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this car model!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: "../logic/delete-car-model.php",
                        type: "POST",
                        data: {
                            model_id: "<?= $car_model; ?>"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                swal("Success", response.message, "success").then(function() {
                                    window.location.href = "../Admin/add-car-model.php";
                                });
                            } else {
                                swal("Error", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error", "An error occurred while deleting the Car Model: " + error, "error");
                        },
                    });
                }
            });
        });
        <?php
            }
        ?>

        // Logout script
        $('#logoutForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Perform the Ajax request
            $.ajax({
                url: "./../logic/logout.php",
                type: "POST",
                data: $("#logoutForm").serialize() + "&action=logout",
                dataType: "json",
                success: function(response) {
                    // Handle the response from the server
                    if (response.status === 'success') {
                        // If logout was successful, redirect to the login page
                        window.location.href = response.redirect;
                    } else {
                        // If there was an error, display the error message
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    // If there was an error with the Ajax request, display an error message
                    swal("Error", response.message, "error");
                }
            });
        });
    });
</script>
</body>

</html>