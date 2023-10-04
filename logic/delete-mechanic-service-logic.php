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
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
$controller = new storeController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["service_id"]) && !empty($_POST["service_id"])) {
        $service_id = filter_input(INPUT_POST, 'service_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $table = 'mechanic_services';
        $column = 'service_id';

        // Delete the mechanic service record
        $deletedStatus = $controller->deleteRecord($table, $column, $service_id);

        switch ($deletedStatus) {
            case true:
                $response = array(
                    'status' => 'success',
                    'message' => 'Service deleted successfully.',
                    'redirect' => '../Mechanic/add-service.php'
                );
                break;
            default:
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to delete service.'
                );
                break;
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid request.',
            'redirect' => '../Mechanic/add-service.php'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method.',
        'redirect' => '../Mechanic/add-service.php'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
?>
