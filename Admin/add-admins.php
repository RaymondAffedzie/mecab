<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s"); // Fixed the time format
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: ../login.php");
    exit;
}

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-4 pb-5">
                                        <h4 class="card-title">Add Admin</h4>
                                        <form class="pt-3" id="add-admin-form" action="../logic/add-admins-logic.php" method="post">
                                            <div class="form-group">
                                                <label for="admin_first_name">First Name</label>
                                                <input type="text" id="admin_first_name" class="form-control" name="admin_first_name" placeholder="First Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="admin_other_names">Other Names</label>
                                                <input type="text" id="admin_other_names" class="form-control" name="admin_other_names" placeholder="Other Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="admin_last_name">Last name</label>
                                                <input type="text" id="admin_last_name" class="form-control" name="admin_last_name" placeholder="Last name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="admin_email">Email</label>
                                                <input type="email" id="admin_email" class="form-control" name="admin_email" placeholder="Email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="admin_contact">Contact</label>
                                                <input type="text" id="admin_contact" class="form-control" name="admin_contact" placeholder="Contact" required>
                                            </div>

                                            <div class="mt-3">
                                                <button id="save-admin-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">
                                                    <i class="mdi mdi-content-save-all"></i> Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-8">
                                        <h4>Administrators</h4>
                                        <div class="table-responsive">
                                            <table id="admins-table" class="table order-column table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Firstname</th>
                                                        <th class="text-center">Surname</th>
                                                        <th class="text-center">Email</th>
                                                        <th class="text-center">Phone Number</th>
                                                        <th class="text-center">View Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once('includes/footer.php'); ?>