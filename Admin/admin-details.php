<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    header("Location: ../login.php");
    exit;
}

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController()
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card" id="admin-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Admin Details</h1>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="col-md-12 text-left">
                                <div class="mt-3">
                                    <p class="text-muted">Admin Name</p>
                                    <h5 class="text-primary" id="name"></h5>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Admin Email</p>
                                    <h5 class="text-primary" id="email"></h5>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Admin Phone Number</p>
                                    <h5 class="text-primary" id="contact"></h5>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Admin Status</p>
                                    <?php
                                    $query = "SELECT status FROM users WHERE user_id = :user LIMIT 1";
                                    $user = $_SESSION['userId'];
                                    $params = array(':user' => $user);
                                    $record = $controller->getSingleRecordsByValue($query, $params);

                                    if ($record['status'] == 'Inactive') {
                                    ?>
                                        <h5 class="text-danger"><?= $record['status']; ?></h5>
                                    <?php
                                    } elseif ($record['status'] == 'Active') {
                                    ?>
                                        <h5 class="text-success"><?= $record['status']; ?></h5>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="mx-auto mt-3">
                                <?php
                                if ($record['status'] == 'Inactive') {
                                ?>
                                    <button id="status-unblock-btn" class="btn btn-sm btn-outline-warning font-weight-medium mx-auto">
                                        <i class="mdi mdi-"></i> Unblock
                                    </button>
                                <?php
                                } elseif ($record['status'] == 'Active') {
                                ?>
                                    <button id="status-block-btn" class="btn btn-sm btn-outline-danger font-weight-medium mx-auto">
                                        <i class="mdi mdi-correct"></i> Block
                                    </button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <?php include_once('includes/footer.php'); ?>