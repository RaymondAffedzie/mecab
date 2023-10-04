<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
$controller = new storeController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["admin"]) && !empty($_POST["admin"])) {
        $admin_id = filter_input(INPUT_POST, 'admin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = array(
            'status' => 'Inactive'
        );
        $table = 'users';
        $datakey = 'user_id';

        $success = $controller->updateRecord($table, $data, $datakey, $admin_id);

        switch ($success) {
            case true:
                $response = array(
                    'status' => 'success',
                    'message' => 'Status updated successfully!',
                    'redirect' => 'admin-details.php?admin='.$admin_id
                );
                break;
            case false:
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to unblock admin!'
                );
                break;
            default:
                $response = array(
                    'status' => 'error',
                    'message' => 'An error occurred while blocking admin!'
                );
                break;
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid request. Missing admin parameter.',
            'redirect' => '../Admin/add-admin.php'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
