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
                            <h6 class="font-weight-light">You own a shop or a store. Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3" id="register-form" action="logic/store-logic.php" method="post">
                                <!-- Form fields -->
                                <div class="form-group">
                                    <input type="text" id="store_name" class="form-control form-control-lg" name="store_name" placeholder="Shop/Store Name">
                                </div>
                                <div class="form-group">
                                    <select id="store_type" class="form-control form-control-lg" name="store_type">
                                        <option value="">Shop type</option>
                                        <option value="Mechanic">Mechanic Shop</option>
                                        <option value="Spare Parts">Spare parts Shop</option>
                                        <option value="Car Rentals">Car Rental</option>
                                        <option value="Transport">Transport</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="tel" id="store_contact" class="form-control form-control-lg" name="store_contact" placeholder="Contact">
                                </div>
                                <div class="form-group">
                                    <input type="email" id="store_email" class="form-control form-control-lg" name="store_email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="gps_address" class="form-control form-control-lg" name="gps_address" placeholder="GPS Address">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="street_name" class="form-control form-control-lg" name="street_name" placeholder="Street Name">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="store_town" class="form-control form-control-lg" name="store_town" placeholder="Store Town">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="store_location" class="form-control form-control-lg" name="store_location" placeholder="Store Location">
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
                                    Already have an store and account? <a href="login.php" class="text-primary">Login</a>
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
            $("#register-btn").click(function(e) {
                e.preventDefault();

                // Get form inputs
                var storeName = $("#store_name").val().trim();
                var storeType = $("#store_type").val();
                var storeEmail = $("#store_email").val().trim();
                var storeContact = $("#store_contact").val().trim();
                var gpsAddress = $("#gps_address").val().trim();
                var streetName = $("#street_name").val().trim();
                var storeTown = $("#store_town").val().trim();
                var storeLocation = $("#store_location").val().trim();
                var tncChecked = $("#tnc").is(":checked");

                // Perform validation
                if (storeName === "") {
                    swal("Error", "Please enter the store name.", "error");
                    return;
                }
                if (storeType === "") {
                    swal("Error", "Please select the store type.", "error");
                    return;
                }
                if (storeEmail === "") {
                    swal("Error", "Please enter the store email.", "error");
                    return;
                }
                if (!validateEmail(storeEmail)) {
                    swal("Error", "Please enter a valid email address.", "error");
                    return;
                }
                if (!validateContact(storeContact)) {
                    swal("Error", "Please enter a valid contact number starting with 0 and containing 10 digits.", "error");
                    return;
                }
                if (gpsAddress === "") {
                    swal("Error", "Please enter the GPS address.", "error");
                    return;
                }
                if (!validateGPSAddress(gpsAddress)) {
                    swal("Error", "Invalid GPS address format.", "error");
                    return;
                }
                if (streetName === "") {
                    swal("Error", "Please enter the street name.", "error");
                    return;
                }
                if (storeTown === "") {
                    swal("Error", "Please enter the town of your store.", "error");
                    return;
                }

                if (!tncChecked) {
                    swal("Error", "Please agree to the Terms & Conditions.", "error");
                    return;
                }

                var formData = new FormData();
                formData.append('store_name', storeName);
                formData.append('store_type', storeType);
                formData.append('store_email', storeEmail);
                formData.append('store_contact', storeContact);
                formData.append('store_town', storeTown);
                formData.append('store_location', storeLocation);
                formData.append('gps_address', gpsAddress);
                formData.append('street_name', streetName);
                
                $.ajax({
                    url: "logic/store-logic.php",
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === "success") {
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

        // GPS address validation helper function
        function validateGPSAddress(gpsAddress) {
            var gpsPattern = /^[a-zA-Z]{2}-\d{3,4}-\d{3,4}$/;
            return gpsPattern.test(gpsAddress);
        }

        // Contact validation helper function
        function validateContact(contact) {
            var contactPattern = /^0\d{9}$/;
            return contactPattern.test(contact);
        }
    </script>

</body>

</html>