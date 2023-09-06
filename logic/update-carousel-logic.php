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
    $carousel_ID = filter_input(INPUT_POST, 'carousel_ID', FILTER_SANITIZE_NUMBER_INT);
    $carousel_caption = filter_input(INPUT_POST, 'carousel_caption', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image = $_FILES['image'] ?? null;

    $carousel_caption = ucfirst($carousel_caption);

    $errors = array();
    if (empty($carousel_caption)) {
        $errors[] = "Carousel caption is required.";
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
                'carousel_caption' => $carousel_caption
            );

            // Database values
            $table = 'carousel';
            $dataKey = 'carousel_ID';


            // Update spare part in the database
            $success = $controller->updateRecordWithImage($table, $dataKey, $carousel_ID, $data, $image);

            switch ($success) {
                case true:
                    $response = array(
                        'status' => 'success',
                        'message' => 'Carousel updated successfully!',
                        'redirect' => '../Admin/carousel-details.php?carousel_ID=' . $carousel_ID
                    );
                    break;
                case 'failed':
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to update carousel!',
                        'redirect' => '../Admin/carousel-details.php?carousel_ID=' . $carousel_ID
                    );
                    break;
                default:
                    $response = array(
                        'status' => 'error',
                        'message' => 'An error occurred while carousel',
                        'redirect' => '../Admin/carousel-details.php?carousel_ID=' . $carousel_ID
                    );
                    break;
            }
        } catch (PDOException $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Error updating carousel: ' . $e->getMessage(),
                'redirect' => '.../Admin/carousel-details.php?carousel_ID=' . $carousel_ID
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
