<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
    $message = "Error: [$errno] $errstr - $errfile:$errline - [Date/time] - $eventDate";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page when not verified
if (!$_SESSION['isVerified']) {
    // User's store is not verified
    header("location: ../verification.php");
    exit;
}

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
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card" id="user-profile-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">User Profile</h1>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="col-md-6 text-center">
                                <div class="my-3">
                                    <i class="ti-user text-primary" style="font-size: 70px;"></i>
                                </div>
                                <div class="mt-3">
                                    <h3 class="text-primary fs-30" id="user-full-name"></h3>
                                </div>
                            </div>
                            <div class="col-md-6 text-left">
                                <div class="mt-3">
                                    <p class="text-muted">Role</p>
                                    <h3 class="text-primary text-primary fs-20" id="user-role">
                                        <i class="mdi mdi-store"></i>
                                    </h3>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Contact</p>
                                    <h3 class="text-primary text-primary fs-20" id="user-contact">
                                        <i class="mdi mdi-phone-classic"></i>
                                    </h3>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Email</p>
                                    <h3 class="text-primary text-primary fs-20" id="user-email">
                                        <i class="mdi mdi-email-outline"></i>
                                    </h3>
                                </div>
                            </div>
                            <button id="edit-profile-btn" class="btn btn-sm btn-outline-primary font-weight-medium mx-auto">
                                <i class="mdi mdi-grease-pencil"></i>
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card text-left" id="edit-profile-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Edit Profile</h1>
                        <form class="pt-3" id="update-profile-form" action="../logic/update-user-logic.php" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="first_name" class="form-control form-control-lg" name="first_name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="other_names" class="form-control form-control-lg" name="other_names">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="last_name" class="form-control form-control-lg" name="last_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" id="user_email" class="form-control form-control-lg" name="user_email">
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" id="user_contact" class="form-control form-control-lg" name="user_contact">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="user_role" class="form-control form-control-lg" name="user_role" disabled>
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

<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/jquery.js"></script>
<script src="vendors/sweetalert/sweetalert.min.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>
<script src="js/dashboard.js"></script>
<script>
    // Display card on button click
    document.addEventListener("DOMContentLoaded", function() {
        // Get the edit-profile-btn and edit-profile-card elements
        const editProfileBtn = document.getElementById("edit-profile-btn");
        const userProfileCard = document.getElementById("edit-profile-card");

        // Add click event listener to the edit-profile-btn
        editProfileBtn.addEventListener("click", function() {
            // Toggle the visibility of the edit-profile-card
            userProfileCard.style.display = userProfileCard.style.display === "none" ? "block" : "none";
        });
    });

    $(document).ready(function() {
        // get user details
        $.ajax({
            url: "../logic/get-user-details.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {

                    var userDetails = response.user;

                    // populate profile card
                    var fullName = userDetails.first_name + " " + userDetails.last_name;
                    fullName += userDetails.other_names ? " " + userDetails.other_names : " ";
                    $("#user-full-name").text(fullName);
                    $("#user-role").text(userDetails.users_role);
                    $("#user-contact").text(userDetails.users_contact);
                    $("#user-email").text(userDetails.users_email);

                    // populate update form
                    $("#first_name").val(userDetails.first_name);
                    $("#other_names").val(userDetails.other_names);
                    $("#last_name").val(userDetails.last_name);
                    $("#user_email").val(userDetails.users_email);
                    $("#user_contact").val(userDetails.users_contact);
                    $("#user_role").val(userDetails.users_role);

                    // Show the user profile card
                    $("#user-profile-card").show();
                } else {
                    // Handle error case
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching user details: " + error, "error");
            }
        });

        // Update script
        $("#save-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var firstName = $("#first_name").val().trim();
            var otherNames = $("#other_names").val().trim();
            var lastName = $("#last_name").val().trim();
            var userEmail = $("#user_email").val().trim();
            var userContact = $("#user_contact").val().trim();

            // Perform validation
            if (firstName === "") {
                swal("Error", "Please enter your first name.", "error");
                return;
            }
            if (lastName === "") {
                swal("Error", "Please enter your last name.", "error");
                return;
            }
            if (userEmail === "") {
                swal("Error", "Please enter your email.", "error");
                return;
            }
            if (userContact === "") {
                swal("Error", "Please enter your contact.", "error");
                return;
            }
            if (!validateEmail(userEmail)) {
                swal("Error", "Please enter a valid email address.", "error");
                return;
            }
            if (!validateContact(userContact)) {
                swal("Error", "Please enter a valid contact number starting with 0 and containing 10 digits.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('first_name', firstName);
            formData.append('last_name', lastName);
            formData.append('other_names', otherNames);
            formData.append('user_email', userEmail);
            formData.append('user_contact', userContact);

            // All inputs are valid, proceed with AJAX request
            $.ajax({
                url: "../logic/update-user-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    // Handle the response and redirect
                    if (response.status === 'success') {
                        $("#update-profile-form")[0].reset();
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

            // Email validation helper function
            function validateEmail(email) {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailPattern.test(email);
            }

            // Contact validation helper function
            function validateContact(contact) {
                var contactPattern = /^0\d{9}$/;
                return contactPattern.test(contact);
            }
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