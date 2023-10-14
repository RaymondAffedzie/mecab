<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once 'controllers/storeController.php';
$controller = new storeController();
include_once('includes/head.php');
include_once('includes/navbar.php');
?>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <i class="ti-user text-primary fs-1"></i>
            <p class="text-primary fs-2" id="user-full-name"></p>
        </div>
        <div class="col-md-6">
            <i class="mdi mdi-phone-classic text-primary fs-2"></i>
            <p class="text-primary fs-2" id="user-contact"></p>
            <i class="mdi mdi-email-outline text-primary fs-2"></i>
            <p class="text-primary fs-2" id="user-email"></p>
        </div>
        <button id="edit-profile-btn" class="btn btn-outline-primary mt-5 mx-auto">
            <i class="mdi mdi-grease-pencil"></i> Edit
        </button>
    </div>
</div>

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
        <button id="save-profile-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">SAVE</button>
    </div>
</form>
<?php include_once('includes/footer.php'); ?>