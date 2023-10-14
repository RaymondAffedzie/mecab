<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:i:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

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
                                <button id="save-profile-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('includes/footer.php'); ?>