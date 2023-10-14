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

$controller = new storeController();
?>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
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
                                <button id="save-password-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <?php include_once('includes/footer.php'); ?>