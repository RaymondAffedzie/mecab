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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carouselCaption = filter_input(INPUT_POST, 'carouselName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $imageData      = $_FILES['carouselImage'] ?? null;

    $carouselCaption = ucfirst($carouselCaption);

    $errors = array();
    if (empty($carouselCaption)) {
        $errors[] = "Carousel caption is required.";
    }

    if (empty($imageData)) {
        $errors[] = "Carousel image is required.";
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        include_once "../controllers/uniqueCode.php";

        $storeController = new StoreController();

        // Prepare data for database insertion
        $data = array(
            'carousel_caption' => $carouselCaption
        );

        // Database values
        $table = 'carousel';

        // Call the method to add the spare part with image
        $result = $storeController->addRecordWithImage($data, $imageData, $table);

        if ($result['status'] === 'success') {
            $response = array(
                'status' => 'success',
                'message' => $result['message'],
                'redirect' => '../Admin/view-carousel.php'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' =>  $result['message'],
                'redirect' => '../Admin/add-carousel.php'
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
