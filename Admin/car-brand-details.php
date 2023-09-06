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
                <div class="card" id="car-brand-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Car Brand Details</h1>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="col-md-12 text-left">
                                <div class="mt-3">
                                    <p class="text-muted">Car Brand Name</p>
                                    <h5 class="text-primary" id="brand_name"></h5>
                                </div>
                            </div>
                            <div class="mx-auto mt-3">
                                <button id="edit-car-brand-btn" class="btn btn-sm btn-outline-primary font-weight-medium mx-auto">
                                    <i class="mdi mdi-grease-pencil"></i> Edit
                                </button>
                                <button id="delete-car-brand-btn" class="btn btn-sm btn-outline-danger font-weight-medium mx-auto">
                                    <i class="mdi mdi-delete"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card text-left" id="edit-car-brand-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Edit Car Brand</h1>
                        <form class="pt-3" id="update-car-brand-form" action="../logic/update-car-brand-logic.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" id="car-brand-id">
                                    <div class="form-group">
                                        <label for="car-brand-name">Car Brand Name</label>
                                        <input type="text" class="form-control" id="car-brand-name" name="brand_name" placeholder="Enter Car Brand Name" required>
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
        // Get the edit-car-brand-btn and edit-car-brand-card elements
        const editProfileBtn = document.getElementById("edit-car-brand-btn");
        const userProfileCard = document.getElementById("edit-car-brand-card");

        // Add click event listener to the edit-car-brand-btn
        editProfileBtn.addEventListener("click", function() {
            // Toggle the visibility of the edit-car-brand-card
            userProfileCard.style.display = userProfileCard.style.display === "none" ? "block" : "none";
        });
    });

    $(document).ready(function() {

        // Fetch car brand details
        <?php
            if (isset($_GET['car_brand_id'])) {
                $car_brand_id = filter_input(INPUT_GET, 'car_brand_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
            $.ajax({
                url: "../logic/get-car-brand-details.php",
                type: "GET",
                data: {
                    car_brand_id: "<?= $car_brand_id ?>"
                },
                dataType: "json",
                success: function(response){
                    if(response.status === "success") {

                        $("#brand_name").text(response.data.brand_name);
                        $("#car-brand-name").val(response.data.brand_name);
                        $("#car-brand-id").val(response.data.car_brand_id);
                        $("#car-brand-card").show();
                    }
                }
            });
        <?php
            }
        ?>

        // Update spare part item
        $("#save-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var carBrandId = $("#car-brand-id").val().trim();
            var carBrandName = $("#car-brand-name").val().trim();

            if (carBrandName === "") {
                swal("Error", "Please enter car brand name.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('car_brand_id', carBrandId);
            formData.append('brand_name', carBrand);

            $.ajax({
                url: "../logic/update-car-brand-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-car-brand-form")[0].reset();
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

        // Delete car brand
        $("#delete-car-brand-btn").click(function(e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this car brand!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: "../logic/delete-car-brand.php",
                        type: "POST",
                        data: {
                            car_brand_id: "<?php echo $sparepart_id; ?>"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                swal("Success", response.message, "success").then(function() {
                                    window.location.href = "../Admin/add-car-brand.php";
                                });
                            } else {
                                swal("Error", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error", "An error occurred while deleting the Car Brand: " + error, "error");
                        },
                    });
                }
            });
        });

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