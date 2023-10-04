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
    $model_name = filter_input(INPUT_POST, 'model_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $model_id = filter_input(INPUT_POST, 'model_id', FILTER_SANITIZE_NUMBER_INT);

    $model_name = ucwords($model_name);

    $errors = array();
    if (empty($model_name)) {
        $errors[] = "Car model name is required.";
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
                'model_name' => $model_name
            );

            // Database values
            $table = 'car_model';
            $dataKey = 'car_model_id';

            $success = $controller->updateRecord($table, $data, $dataKey, $model_id);

            switch ($success) {
                case true:
                    $response = array(
                        'status' => 'success',
                        'message' => 'Car model updated successfully!'
                    );
                    break;
                case false:
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to update car model!'
                    );
                default:
                    $response = array(
                        'status' => 'error',
                        'message' => 'An error occurred while updating the car model!'
                    );
                    break;
            }
        } catch (PDOException $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Error updating car model: ' . $e->getMessage(),
                'redirect' => '../Admin/car-model-details.php?model=' . $model_id    
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
