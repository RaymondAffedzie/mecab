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

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = filter_input(INPUT_POST, 'service_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $service_name = ucfirst($service_name);

    $errors = array();
    if (empty($service_name)) {
        $errors[] = "Service name is required.";
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
            // Create an instance of the StoreController
            $controller = new StoreController();

            // Prepare the update data array for the updateRecordWithImage function
            $data = array(
                'service_id' => $service_id,
                'service_name' => $service_name,
            );

            // Database values
            $table = 'service';
            $dataKey = 'service_id';

            // Update car brand in the database
            $success = $controller->updateRecord($table, $data, $dataKey, $service_id);

            switch ($success) {
                case true:
                    $response = array(
                        'status' => 'success',
                        'message' => 'Service updated successfully!',
                        'redirect' => '../Admin/service-details.php?service_id=' . $service_id
                    );
                    break;
                case false:
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to update service!',
                        'redirect' => '../Admin/../Admin/service-details.php?service_id=' . $service_id
                    );
                default:
                    $response = array(
                        'status' => 'error',
                        'message' => 'An error occurred while updating service!',
                        'redirect' => '../Admin/service-details.php?service_id=' . $service_id
                    );
                    break;
            }
        } catch (PDOException $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Error updating service: ' . $e->getMessage(),
                'redirect' => '../Admin/service-details.php?service_id=' . $service_id
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
