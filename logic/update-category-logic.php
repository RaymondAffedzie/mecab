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
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    $category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image = $_FILES['image'] ?? null;

    $category_name = ucwords($category_name);

    $errors = array();

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
                'category_name' => $category_name
            );

            // Database values
            $table = 'categories';
            $dataKey = 'category_id';


            // Update spare part in the database
            $success = $controller->updateRecordWithImage($table, $dataKey, $category_id, $data, $image);

            switch ($success) {
                case true:
                    $response = array(
                        'status' => 'success',
                        'message' => 'Category updated successfully!',
                        'redirect' => '../Admin/category-details.php?category_id=' . $category_id
                    );
                    break;
                case 'failed':
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to update category!',
                        'redirect' => '../Admin/category-details.php?category_id=' . $category_id
                    );
                    break;
                default:
                    $response = array(
                        'status' => 'error',
                        'message' => 'An error occurred while category',
                        'redirect' => '../Admin/category-details.php?category_id=' . $category_id
                    );
                    break;
            }
        } catch (PDOException $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Error updating category: ' . $e->getMessage(),
                'redirect' => '.../Admin/category-details.php?category_id=' . $category_id
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
