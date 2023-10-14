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
    // User is already logged in, redirect to dashboard or desired page
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
            <h1 class="page-width">Purchase a store</h1>
        </div>
    </div>
</div>
<!--End Page Title-->

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-10 col-lg-9 mx-auto">
            <form class="pt-3" id="CustomerLoginForm" action="logic/store-logic.php" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="store_name">Store Name</label>
                            <input type="text" id="store_name" name="store_name" class="fonm-control" placeholder="Mecab car rentals">
                        </div>
                        <div class="form-group mb-2">
                            <label for="store_type">Store Type</label>
                            <select id="store_type" class="form-control" name="store_type">
                                <option value="">Shop type</option>
                                <option value="Mechanic">Mechanic Shop</option>
                                <option value="Spare Parts">Spare parts Shop</option>
                                <option value="Car Rentals">Car Rental</option>
                                <option value="Transport">Transport</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="store_contact">Store Contact</label>
                            <input type="tel" id="store_contact" name="store_contact" class="fonm-control" placeholder="0208203381">
                        </div>
                        <div class="form-group mb-2">
                            <label for="store_email">Store email</label>
                            <input type="email" id="store_email" name="store_email" class="fonm-control" placeholder="email@mecab.org">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="store_gps_address">Store GPS Address</label>
                            <input type="text" id="store_gps_address" name="store_gps_address" class="fonm-control" placeholder="CE-5687-7891">
                        </div>
                        <div class="form-group mb-2">
                            <label for="street_name">Street Name</label>
                            <input type="text" id="street_name" name="street_name" class="fonm-control" placeholder="Commercial Road">
                        </div>
                        <div class="form-group mb-2">
                            <label for="store_town">Store Town/city</label>
                            <input type="text" id="store_town" name="store_town" class="fonm-control" placeholder="Winneba">
                        </div>
                        <div class="form-group mb-2">
                            <label for="store_location">Store Location</label>
                            <input type="text" id="store_location" name="store_location" class="fonm-control" placeholder="Taxi rank">
                        </div>
                    </div>
                    <div class="my-3">
                        <div class="form-check-warning">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" id="tnc" class="check-input" name="tnc">
                                I agree to all Terms & Conditions
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <button id="register-store-btn" class="btn btn-block btn-primary btn-lg" name="register-store-btn">Purchase store</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>

<?php include_once('includes/footer.php') ?>