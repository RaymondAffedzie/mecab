<?php
session_start();

// Prevent user from accessing this page after loggin in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    // User is already logged in, redirect to dashboard
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
                            <h4>Login</h4>
                            <form class="pt-3" id="login-form" action="logic/login-logic.php" method="post">
                                <!-- Form fields -->
                                <div class="form-group">
                                    <input type="email" id="email" class="form-control form-control-lg" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password" class="form-control form-control-lg" name="password" placeholder="Password">
                                </div>

                                <div class="mt-3">
                                    <button id="login-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="login"><i class="mdi mdi-login"></i> Login</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    You do not have an account <a href="register-user.php" class="text-primary">Register</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
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
        $(document).ready(function() {

            $("#login-btn").click(function(e) {
                e.preventDefault();

                // Get form inputs
                var email = $("#email").val().trim();
                var password = $("#password").val().trim();

                // Perform validation
                if (email === "") {
                    swal("Error", "Please enter your email.", "error");
                    return;
                }
                if (!validateEmail(email)) {
                    swal("Error", "Please enter a valid email address.", "error");
                    return;
                }
                if (password === "") {
                    swal("Error", "Please enter your password.", "error");
                    return;
                }

                // All inputs are valid, proceed with AJAX request
                $.ajax({
                    url: "logic/login-logic.php",
                    type: "POST",
                    data: $("#login-form").serialize() + "&action=login",
                    dataType: "json",
                    success: function(response) {
                        // Handle the response and redirect
                        if (response.status === "success") {
                            $("#login-form")[0].reset();
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