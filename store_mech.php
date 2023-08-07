<?php
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
                            <h6 class="font-weight-light">You have a mech shop, register your business with us</h6>

                            <form class="pt-3" id="register-form" action="logic/mech-logic.php" method="post">
                                <div class="form-group">
                                    <select id="store" class="form-control form-control-lg" name="store">
                                        <option value="">Select Store</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
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
            // Retrieve all registered stores for the dropdown
            $.ajax({
                url: "logic/mech-logic.php",
                type: "POST",
                data: {
                    action: "getStores"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        var stores = response.stores;
                        // Populate the dropdown with store options
                        for (var i = 0; i < stores.length; i++) {
                            var storeOption = "<option value='" + stores[i].store_id + "'>" + stores[i].store_name + "</option>";
                            $("#store").append(storeOption);
                        }
                    } else {
                        swal("Error", "Failed to retrieve stores.", "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while retrieving stores: " + error, "error");
                }
            });
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
    </script>


</body>

</html>

<?php
 if (isset($_POST['action']) && $_POST['action'] == "getStores") {
    // Retrieve all registered stores from the database
    $controller = new storeController();
    $stores = $controller->getStores();

    if (!empty($stores)) {
        $response = array(
            'status' => 'success',
            'stores' => $stores
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Failed to retrieve stores.'
        );
    }

    // Send JSON response
    echo json_encode($response);
    exit;
}