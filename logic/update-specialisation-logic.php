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
    $specialisation_id = filter_input(INPUT_POST, 'specialisation_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $specialisation_name = filter_input(INPUT_POST, 'specialisation_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $specialisation_description = filter_input(INPUT_POST, 'specialisation_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image = $_FILES['image'] ?? null;

    $specialisation_name = ucfirst($specialisation_name);
    $specialisation_description = ucfirst($specialisation_description);

    $errors = array();
    if (empty($specialisation_name)) {
        $errors[] = "specialisation name is required.";
    }
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
                'specialisation' => $specialisation_name,
                'description' => $specialisation_description
            );
            $table = 'specialisation';
            $dataKey = 'specialisation_id';
            $success = $controller->updateRecordWithImage($table, $dataKey, $specialisation_id, $data, $image);
            switch ($success) {
                case true:
                    $response = array(
                        'status' => 'success',
                        'message' => 'Specialisation updated successfully!',
                        'redirect' => '../Admin/specialisation-details.php?specialisation=' . $specialisation_id
                    );
                    break;
                case 'failed':
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to update specialisation!'
                    );
                default:
                    $response = array(
                        'status' => 'error',
                        'message' => 'An error occurred while updating specialisation!'
                    );
                    break;
            }
        } catch (PDOException $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Error updating specialisation: ' . $e->getMessage(),
                'redirect' => '../Admin/specialisation-details.php?specialisation=' . $specialisation_id
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
