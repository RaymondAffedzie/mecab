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

if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    $query = "SELECT * FROM `service` WHERE service_id = :service_id";
    $params = array(":service_id" => $service_id);

    $serviceDetails = $controller->getSingleRecordsByValue($query, $params);
}
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card" id="spare-part-card">
                    <div class="card-body">
                        <h1 class="card-title">Service Details</h1>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="col-md-6 text-left">
                                <!--  -->
                                <div class="mt-3">
                                    <p class="text-muted">Service name</p>
                                    <h5 class="text-primary" id="service_name"><?php echo $serviceDetails['service_name']; ?></h5>
                                </div>
                            </div>
                            <div class="mx-auto mt-3">
                                <button id="edit-spare-part-btn" class="btn btn-sm btn-outline-primary font-weight-medium mx-auto">
                                    <i class="mdi mdi-grease-pencil"></i> Edit
                                </button>
                                <button id="delete-service-btn" class="btn btn-sm btn-outline-danger font-weight-medium mx-auto">
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
                        <h1 class="card-title">Edit Service</h1>
                        <form class="pt-3" id="update-service-form" action="../logic/update-service-logic.php" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" value="<?= $serviceDetails['service_id']; ?>" id="service_id" name="service_id">
                                    <div class="form-group">
                                        <label for="service_name">Service Name</label>
                                        <input type="text" class="form-control" id="name" name="service_name" placeholder="Enter Service Name">
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

            var serviceName = $("#name").val().trim();
            var service_id = $("#service_id").val().trim();

            if (serviceName === '') {
                swal("Error", "Please enter service name.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('service_id', service_id);
            formData.append('service_name', serviceName);

            $.ajax({
                url: '../logic/update-service-logic.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-service-form")[0].reset();
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

    // Delete spare part item
    $("#delete-service-btn").click(function(e) {
        <?php
        if (isset($_GET['service_id'])) {
            $service_id = filter_input(INPUT_GET, 'service_id', FILTER_SANITIZE_SPECIAL_CHARS);
        ?>
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this service!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: "../logic/delete-service.php",
                        type: "POST",
                        data: {
                            service_id: "<?php echo $service_id; ?>"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                swal("Success", response.message, "success").then(function() {
                                    window.location.href = "../Admin/view-services.php";
                                });
                            } else {
                                swal("Error", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error", "An error occurred while deleting the service: " + error, "error");
                        },
                    });
                }

            });
        <?php
        }
        ?>
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

    // Listen for changes in the file input
    document.getElementById('image-upload').addEventListener('change', function() {
        previewImage(this);
    });
</script>
</body>

</html>