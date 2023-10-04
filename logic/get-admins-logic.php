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

if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';

$controller = new StoreController();
$query = "SELECT u.user_id, u.first_name, u.last_name, u.users_email, c.users_contact
            FROM users u 
            LEFT JOIN users_contact c ON u.user_id = c.users_id WHERE u.users_role = 'Admin'";
$admins = $controller->getRecords($query);
$response = array(
    'status' => 'success',
    'message' => 'Admin fetched successfully.',
    'data' => $admins
);

if (!headers_sent()) {
    echo json_encode($response);
}
