<?php
session_start();

// Prevent user from accessing this page after loggin in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    // User is already logged in, redirect to dashboard or desired page
    header("Location: index.php");
    exit;
}
include_once('includes/head.php');

?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-5 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="images/logo.svg" alt="logo">
                            </div>
                            <h4>New here?</h4>
                            <!-- <h6 class="font-weight-light">You have a mech shop, register your business with us</h6> -->

                            <form class="pt-3" id="register-form" action="logic/register-user-logic.php" method="post">
                                <!-- Form fields -->
                                <div class="form-group">
                                    <input type="text" id="first_name" class="form-control form-control-lg" name="first_name" placeholder="First name">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="other_names" class="form-control form-control-lg" name="other_names" placeholder="Other names">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="last_name" class="form-control form-control-lg" name="last_name" placeholder="Last name">
                                </div>
                                <div class="form-group">
                                    <select id="role" class="form-control form-control-lg" name="role">
                                        <option value="">Select your role</option>
                                        <option value="Customer">Customer</option>
                                        <option value="Mechanic">Mechanic</option>
                                        <option value="Spare parts">Spare parts</option>
                                        <option value="Car retals"> Car retals</option>
                                        <option value="Transport"> Transport</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="email" id="user_email" class="form-control form-control-lg" name="user_email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password" class="form-control form-control-lg" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" id="con_password" class="form-control form-control-lg" name="con_password" placeholder="Confirm Password">
                                </div>
                                <div class="mb-4">
                                    <div class="form-check-warning">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" id="tnc" class="check-input" name="tnc">
                                            I agree to all Terms & Conditions
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button id="register-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="register">REGISTER</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Already have a store and an account? <a href="login.php" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
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
        $(document).ready(function() {
            $("#register-btn").click(function(e) {
                e.preventDefault();

                var firstName = $("#first_name").val().trim();
                var otherNames = $("#other_names").val().trim();
                var lastNames = $("#last_name").val().trim();
                var role = $("#role").val();
                var userEmail = $("#user_email").val().trim();
                var password = $("#password").val().trim();
                var conPassword = $("#con_password").val().trim();
                var tncChecked = $("#tnc").is(":checked");

                if (firstName === "") {
                    swal("Error", "Please enter your first name.", "error");
                    return;
                }
                if (lastNames === "") {
                    swal("Error", "Please enter your last name.", "error");
                    return;
                }
                if (userEmail === "") {
                    swal("Error", "Please enter your email.", "error");
                    return;
                }
                if (!validateEmail(userEmail)) {
                    swal("Error", "Please enter a valid email address.", "error");
                    return;
                }
                if (password === "") {
                    swal("Error", "Please enter your password.", "error");
                    return;
                }
                if (conPassword === "") {
                    swal("Error", "Please confirm your password.", "error");
                    return;
                }
                if (password !== conPassword) {
                    swal("Error", "Passwords do not match.", "error");
                    return;
                }
                if (!tncChecked) {
                    swal("Error", "Please agree to the Terms & Conditions.", "error");
                    return;
                }

                $.ajax({
                    url: "logic/register-user-logic.php",
                    type: "POST",
                    data: $("#register-form").serialize() + "&action=register",
                    dataType: "json",
                    success: function(response) {
                        // Handle the response and redirect
                        if (response.status === "success") {
                            // swal("Success", response.message, "success");
                            $("#register-form")[0].reset();
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
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

        // Email validation helper function
        function validateEmail(email) {
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }
    </script>
</body>

</html>