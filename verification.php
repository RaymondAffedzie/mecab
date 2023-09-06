<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

// Prevent user from accessing this page when user's store is verified
if (isset($_SESSION['isVerified'])) {
    header("Location: index.php");
}

require_once 'controllers/storeController.php';
include_once('includes/head.php');
// include_once('includes/navbar.php');

$controller = new storeController();
$record = $controller->getUserDetails();

?>
    <!--Top Header-->
    <div class="top-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 col-sm-8 col-md-5 col-lg-4">
                    <p class="phone-no"><i class="anm anm-phone-s"></i> +233 (0)24 769 2388 / +233 (0)24 816 5601</p>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 d-none d-lg-none d-md-block d-lg-block">
                    <div class="text-center"><p class="top-header_middle-text">iRBbA Devs & iQuco Tech</p></div>
                </div>
                <div class="col-2 col-sm-4 col-md-3 col-lg-4 text-right">
                    <span class="user-menu d-block d-lg-none"><i class="anm anm-user-al" aria-hidden="true"></i></span>
                    <?php
                        if (isset($_SESSION['loggedIn'])) {
                        ?>
                        <ul class="customer-links list-inline">
                            <li>
                                <form id="logoutForm" action="./logic/logout.php" method="post">
                                    <button type="submit" name="logout" class="border-0 text-light" style="cursor: pointer;">
                                        <i class="ti-power-off text-primary"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                        <?php
                        } else {
                        ?>
                            <ul class="customer-links list-inline">
                                <li><a href="./login.php">Login</a></li>
                                <li><a href="./register-user.php">Create Account</a></li>
                                <li><a href="./register-store.php">Purchase Store</a></li>
                            </ul>
                        <?php
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
    <!--End Top Header-->

    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">STORE VERIFICATION</h1>
            </div>
        </div>
    </div>
    <!--End Page Title-->

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 main-col offset-md-3">
                <div class="mb-4">
                <p>
                    A verification code has been sent to your store manager.
                    <br>
                    Contact the store manager for the code!
                </p>
                <form class="pt-3" id="CustomerLoginForm" action="logic/verification-logic.php" method="post" class="contact-form">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="input-group mb-3">
                                <input type="number" id="code" name="code" placeholder="Verification Code" required>
                            </div>
                            <div class="mt-3">
                                <button id="save-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">
                                     Verify
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                            <!-- Work in progress -->
                            <p><strong>Didn't recieve code</strong></p>
                            <label class="text-danger">Not available now!</label>
                            <button id="save-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="generate-code" disabled>
                                Regenerate code
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
            
    <!-- Including Jquery -->
    <script src="assets/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery.cookie.js"></script>
    <script src="assets/js/vendor/wow.min.js"></script>
    <!-- Including Javascript -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/lazysizes.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="vendors/sweetalert/sweetalert.min.js"></script>
    <script>
        // Ajax script for submitting form
        $(document).ready(function() {
            $("#save-btn").click(function(e) {
                e.preventDefault();

                // Get form inputs
                var code = $("#code").val().trim();

                // Perform validation
                if (code === "") {
                    swal("Error", "Verification code is required.", "error");
                    return;
                }
                if (!validateCode(code)) {
                    swal("Error", "Please enter a valid verification code.", "error");
                    return;
                }

                // All inputs are valid, proceed with AJAX request
                $.ajax({
                    url: "logic/verification-logic.php",
                    type: "POST",
                    data: $("#CustomerLoginForm").serialize() + "&action=verify",
                    dataType: "json",
                    success: function(response) {
                        // Handle the response and redirect
                        if (response.status === "success") {
                            $("#CustomerLoginForm")[0].reset();
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

        // Contact validation helper function
        function validateCode(code) {
            var codePattern = /^\d{6}$/;
            return codePattern.test(code);
        }

        // Ajax script for logout
        $(document).ready(function() {
            // When the form is submitted
            $('#logoutForm').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Perform the Ajax request
                $.ajax({
                    url: "logic/logout.php",
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