<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // Change this to 1 to display errors

session_start();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s"); // Fixed the time format
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) { // Corrected the condition
    header("Location: ../login.php");
    exit;
}

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded-3 p-5">
                    <h4 class="text-center">Create New Admin</h4>
                    <form class="pt-3" id="add-admin-form" action="../logic/add-admins-logic.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset style="border: 1px solid #ccc; border-radius: 4px; padding: 5px;">
                                    <legend style="color: #fe6633; font-size: 12px;">Required</legend>
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" id="first_name" class="form-control form-control-lg" name="first_name" placeholder="First Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="other_names">Other Name</label> <!-- Changed the field name -->
                                        <input type="text" id="other_names" class="form-control form-control-lg" name="other_names" placeholder="Other Name" required>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset style="border: 1px solid #ccc; border-radius: 4px; padding: 5px;">
                                    <legend style="color: #fe6633; font-size: 12px;">Required</legend>
                                    <div class="form-group">
                                        <label for="last_name">Last name</label>
                                        <input type="text" id="last_name" class="form-control form-control-lg" name="last_name" placeholder="Last name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Contact</label>
                                        <input type="text" id="contact" class="form-control form-control-lg" name="contact" placeholder="Contact" required>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset style="border: 1px solid #ccc; border-radius: 4px; padding: 5px;">
                                    <legend style="color: #fe6633; font-size: 12px;">Required</legend>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" class="form-control form-control-lg" name="email" placeholder="Email" required>
                                    </div>
                                </fieldset>
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

            var first_name = $("#first_name").val().trim();
            var other_names = $("#other_names").val().trim();
            var last_name = $("#last_name").val().trim();
            var email = $("#email").val().trim();
            var contact = $("#contact").val().trim();

            if (first_name === '') {
                swal("Error", "Please enter first name.", "error");
                return;
            }

            if (last_name === '') {
                swal("Error", "Please enter last name.", "error");
                return;
            }

            // Validate the email format with a regular expression
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Matches a basic email format
            if (!emailRegex.test(email)) {
                swal("Error", "Please enter a valid email address.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('first_name', first_name);
            formData.append('other_names', other_names);
            formData.append('last_name', last_name);
            formData.append('email', email);
            formData.append('contact', contact);

            $.ajax({
                url: '../logic/add-admins-logic.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $("#add-admin-form")[0].reset();
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
</script>

</body>

</html>