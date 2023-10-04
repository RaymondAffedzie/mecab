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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carouselCaption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $imageData      = $_FILES['image'] ?? null;

    $carouselCaption = ucfirst($carouselCaption);

    $errors = array();
    if (empty($carouselCaption)) {
        $errors[] = "Caption is required.";
    }

    if (empty($imageData)) {
        $errors[] = "Image is required.";
    }

    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        include_once "../controllers/uniqueCode.php";

        $storeController = new StoreController();

        $data = array(
            'carousel_caption' => $carouselCaption
        );

        // Database values
        $table = 'carousel';

        $result = $storeController->addRecordWithImage($data, $imageData, $table);

        if ($result['status'] === 'success') {
            $response = array(
                'status' => 'success',
                'message' => $result['message'],
                'redirect' => '../Admin/view-carousels.php'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' =>  $result['message']
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
