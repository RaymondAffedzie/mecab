<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

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
            <div class="col-md-6 grid-margin stretch-card mx-auto">
                <div class="card" id="change-password-card">
                    <div class="card-body">
                        <h1 class="card-title">Change Password</h1>
                        <form class="pt-3" id="change-password-form" action="../logic/change-password-logic.php" method="post">
                            <div class="form-group">
                                <input type="text" id="old-password" class="form-control form-control-lg" name="old-password" placeholder="Old password">
                            </div>
                            <div class="form-group">
                                <input type="text" id="new-password" class="form-control form-control-lg" name="new-password" placeholder="New password">
                            </div>
                            <div class="form-group">
                                <input type="text" id="con-new-password" class="form-control form-control-lg" name="con-new-password" placeholder="Confirm new password">
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
        // Change password script
        $("#save-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var oldPassword = $("#old-password").val().trim();
            var newPassword = $("#new-password").val().trim();
            var conPassword = $("#con-new-password").val().trim();

            // Perform validation
            if (oldPassword === "") {
                swal("Error", "Please enter your password.", "error");
                return;
            }
            if (newPassword === "") {
                swal("Error", "Please enter your new password.", "error");
                return;
            }
            if (conPassword === "") {
                swal("Error", "Please confirm your new password.", "error");
                return;
            }
            if (oldPassword === newPassword) {
                swal("Error", "Cannot use old password as new password.", "error");
                return;
            }
            if (newPassword !== conPassword) {
                swal("Error", "New password and confirm password do not match", "error");
                return;
            }

            var formData = new FormData();
            formData.append('old_password', oldPassword);
            formData.append('new_password', newPassword);
            formData.append('con_password', conPassword);
            // console.log(formData);

            // All inputs are valid, proceed with AJAX request
            $.ajax({
                url: "../logic/change-password-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    // Handle the response and redirect
                    if (response.status === 'success') {
                        $("#change-password-form")[0].reset();
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