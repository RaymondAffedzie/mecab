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
    $spcialisation = filter_input(INPUT_POST, 'spcialisation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $imageData      = $_FILES['image'] ?? null;

    $spcialisation = ucwords($spcialisation);
    $description = ucfirst($description);

    $errors = array();
    if (empty($spcialisation)) {
        $errors[] = "specialisation name is required.";
    }

    if (empty($imageData)) {
        $errors[] = "specialisation image is required.";
    }

    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => $errors[0]
        );
    } else {
        include_once "../controllers/uniqueCode.php";

        $specialisation_id = $v4uuid;

        $controller = new StoreController();

        $table = "specialisation";
        $data = array(
            'specialisation_id' => $specialisation_id,
            'specialisation' => $spcialisation,
            'description' => $description
        );

        $result = $controller->addRecordWithImage($data, $imageData, $table);

        if ($result['status'] === 'success') {
            $response = array(
                'status' => 'success',
                'message' => $result['message'],
                'redirect' => '../Admin/view-specialisations.php'
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
