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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceName = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $imageData      = $_FILES['image'] ?? null;

    $errors = array();
    if (empty($serviceName)) {
        $errors[] = "Service name is required.";
    }

    if (empty($imageData)) {
        $errors[] = "Service image is required.";
    }

    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => $errors[0]
        );
    } else {
        include_once "../controllers/uniqueCode.php";

        $service_id = $v4uuid;

        $controller = new StoreController();

        $table = "service";
        $data = array(
            'service_id' => $service_id,
            'service_name' => $serviceName
        );

        $result = $controller->addRecordWithImage($data, $imageData, $table);

        if ($result['status'] === 'success') {
            $response = array(
                'status' => 'success',
                'message' => $result['message'],
                'redirect' => '../Admin/view-services.php'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' =>  $result['message'],
                'redirect' => '../Admin/add-service.php'
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
