<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:m:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
$controller = new storeController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["service_id"]) && !empty($_POST["service_id"])) {
        $service_id = $_POST["service_id"];
        $table = 'service';
        $column = 'service_id';

        // Delete the spare part record along with its image
        $deletedStatus = $controller->deleteRecord($table, $column, $service_id);

        switch ($deletedStatus) {
            case true:
                $response = array(
                    'status' => 'success',
                    'message' => 'Service deleted successfully.',
                    'redirect' => '../Admin/view-services.php'
                );
                break;
            case 'not-existing':
                $response = array(
                    'status' => 'error',
                    'message' => 'Service not found.',
                    'redirect' => '../../Admin/view-services.php'
                );
                break;
            default:
                $response = array(
                    'status' => 'error',
                    'message' => 'An error occurred while deleting.',
                    'redirect' => '../Admin/service-details.php'
                );
                break;
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Missing service parameter.',
            'redirect' => '../Admin/view-services.php'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method.',
        'redirect' => '../Admin/view-services.php'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
