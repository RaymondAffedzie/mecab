<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page after loggin in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    // User is already logged in, redirect to dashboard
    header("Location: index.php");
    exit;
}
require_once 'controllers/storeController.php';
$controller = new storeController();
include_once('includes/head.php');
include_once('includes/navbar.php');
?>
<!--Page Title-->
<div class="page section-header text-center">
    <div class="page-title">
        <div class="wrapper">
            <h1 class="page-width">Login</h1>
        </div>
    </div>
</div>
<!--End Page Title-->

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 main-col offset-md-3">
            <div class="mb-4">
                <form method="POST" action="logic/login-logic.php" id="CustomerLoginForm" class="contact-form">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="CustomerEmail">Email</label>
                                <input type="email" name="email" placeholder="" id="CustomerEmail" class="" autocorrect="off" autocapitalize="off" autofocus="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="CustomerPassword">Password</label>
                                <input type="password" value="" name="password" placeholder="" id="CustomerPassword" class="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12">
                            <button type="submit" class="btn mb-3" id="login-btn">Sign in</button>
                            <p class="mb-4">
                                <a href="#" id="RecoverPassword">Forgot your password?</a> &nbsp; | &nbsp;
                                <a href="register-user.php" id="customer_register_link">Create account</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Footer-->
</div>
<footer id="footer">
    <div class="newsletter-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-7 w-100 d-flex justify-content-start align-items-center">
                    <div class="display-table">
                        <div class="display-table-cell footer-newsletter">
                            <div class="section-header text-center">
                                <label class="h2"><span>sign up for </span>newsletter</label>
                            </div>
                            <form action="#" method="post">
                                <div class="input-group">
                                    <input type="email" class="input-group__field newsletter__input" name="EMAIL" value="" placeholder="Email address" required="">
                                    <span class="input-group__btn">
                                        <button type="submit" class="btn newsletter__submit" name="commit" id="Subscribe"><span class="newsletter__submit-text--large">Subscribe</span></button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-5 d-flex justify-content-end align-items-center">
                    <div class="footer-social">
                        <ul class="list--inline site-footer__social-icons social-icons">
                            <li><a class="social-icons__link" href="#" target="_blank" title="Follow MeCAB on Facebook"><i class="icon icon-facebook"></i> <span class="icon__fallback-text">Facebook</span></a></li>
                            <li><a class="social-icons__link" href="#" target="_blank" title="Follow MeCAB on Twitter"><i class="icon icon-twitter"></i> <span class="icon__fallback-text">Twitter</span></a></li>
                            <li><a class="social-icons__link" href="#" target="_blank" title="Follow MeCAB on Instagram"><i class="icon icon-instagram"></i> <span class="icon__fallback-text">Instagram</span></a></li>
                            <li><a class="social-icons__link" href="#" target="_blank" title="Subscribe to our YouTube channel"><i class="icon icon-youtube"></i> <span class="icon__fallback-text">YouTube</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="site-footer">
        <div class="container">
            <!--Footer Links-->
            <div class="footer-top">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                        <h4 class="h4">Quick Shop</h4>
                        <ul>
                            <li><a href="#">Lights</a></li>
                            <li><a href="#">Mirrors</a></li>
                            <li><a href="#">Exhaust</a></li>
                            <li><a href="#">Body Parts</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                        <h4 class="h4">Informations</h4>
                        <ul>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Privacy policy</a></li>
                            <li><a href="#">Terms &amp; condition</a></li>
                            <li><a href="#">My Account</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                        <h4 class="h4">Customer Services</h4>
                        <ul>
                            <li><a href="#">Request Personal Data</a></li>
                            <li><a href="#">FAQ's</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Orders and Returns</a></li>
                            <li><a href="#">Support Center</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 contact-box">
                        <h4 class="h4">Contact Us</h4>
                        <ul class="addressFooter">
                            <li><i class="icon anm anm-map-marker-al"></i>
                                <p>Commercial Road, A003 <br> CE-001-2923, Winneba</p>
                            </li>
                            <li class="phone"><i class="icon anm anm-phone-s"></i>
                                <p>(+233) (0)24 769 2388</p>
                            </li>
                            <li class="email"><i class="icon anm anm-envelope-l"></i>
                                <p>admin@mecab.org</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--End Footer Links-->
            <hr>
            <div class="footer-bottom">
                <div class="row">
                    <!--Footer Copyright-->
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 order-1 order-md-0 order-lg-0 order-sm-1 copyright text-sm-center text-md-left text-lg-left">
                        <span></span>
                        <a href="#">Copyright © <?= date("Y") ?> MeCAB. All rights reserved.</a>
                    </div>
                    <!--End Footer Copyright-->
                    <!--Footer Payment Icon-->
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 order-0 order-md-1 order-lg-1 order-sm-0 payment-icons text-right text-md-center">
                        <ul class="payment-icons list--inline">
                            <li><i class="icon fa fa-cc-visa" aria-hidden="true"></i></li>
                            <li><i class="icon fa fa-cc-mastercard" aria-hidden="true"></i></li>
                            <li><i class="icon fa fa-cc-paypal" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                    <!--End Footer Payment Icon-->
                </div>
            </div>
        </div>
    </div>
</footer>
<!--End Footer-->

<!--Scoll Top-->
<span id="site-scroll"><i class="icon anm anm-angle-up-r"></i></span>
<!--End Scoll Top-->

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
    $(document).ready(function() {

        $("#login-btn").click(function(e) {
            e.preventDefault();

            $("#login-btn").prop("disabled", true);

            var email = $("#CustomerEmail").val().trim();
            var password = $("#CustomerPassword").val().trim();

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

            var formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);

            $.ajax({
                url: "logic/login-logic.php",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === "success") {
                        $("#login-btn").prop("disabled", false);
                        $("#CustomerLoginForm")[0].reset();
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    } else {
                        $("#CustomerLoginForm")[0].reset();
                        $("#login-btn").prop("disabled", false);
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    $("#CustomerLoginForm")[0].reset();
                    $("#login-btn").prop("disabled", false);
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
</div>
</body>

</html>