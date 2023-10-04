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

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $service_id = filter_input(INPUT_POST, 'service_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $duration = filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_NUMBER_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);

    $service_name = ucwords($service_name);

    $errors = array();
    if (empty($service_name)) {
        $errors[] = "Service is required.";
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        try {
            $controller = new StoreController();

            $data = array(
                'service_name' => $service_name,
                'price' => $price,
                'duration' => $duration
            );

            // Database values
            $table = 'mechanic_services';
            $dataKey = 'service_id';

            $success = $controller->updateRecord($table, $data, $dataKey, $service_id);

            switch ($success) {
                case true:
                    $response = array(
                        'status' => 'success',
                        'message' => 'Service updated successfully!'
                    );
                    break;
                case false:
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to update service!'
                    );
                default:
                    $response = array(
                        'status' => 'error',
                        'message' => 'An error occurred while updating the service!'
                    );
                    break;
            }
        } catch (PDOException $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Error updating service: ' . $e->getMessage(),
                'redirect' => '../Mechanic/service-details.php?service=' . $service_id    
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
