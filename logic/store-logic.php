<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../controllers/storeController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storeName  = filter_input(INPUT_POST, 'store_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $storeType  = filter_input(INPUT_POST, 'store_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $storeEmail = filter_input(INPUT_POST, 'store_email', FILTER_SANITIZE_EMAIL);
    $storeContact = filter_input(INPUT_POST, 'store_contact', FILTER_SANITIZE_NUMBER_INT);
    $gpsAddress = filter_input(INPUT_POST, 'gps_address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $streetName = filter_input(INPUT_POST, 'street_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $storeTown = filter_input(INPUT_POST, 'store_town', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $storeLocation = filter_input(INPUT_POST, 'store_location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $storeName = ucwords($storeName);
    $streetName = ucwords($streetName);
    $storeEmail = strtolower($storeEmail);
    $gpsAddress = strtoupper($gpsAddress);
    $storeTown = ucfirst($storeTown);
    $storeLocation = ucfirst($storeLocation);

    // Validdate email address
    $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    if (!preg_match($emailPattern, $storeEmail)) {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid email format.'
        );
        echo json_encode($response);
        exit;
    }

    // Validate GPS address
    $gpsPattern = '/^[a-zA-Z]{2}-\d{3,4}-\d{3,4}$/';
    if (!preg_match($gpsPattern, $gpsAddress)) {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid GPS address format.'
        );
        echo json_encode($response);
        exit;
    }

    // Validate contact nubmer
    $contactPattern = '/^0\d{9}$/';
    if (!preg_match($contactPattern, $storeContact)) {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid contact number format,'
        );
        echo json_encode($response);
        exit;
    }

    $errors = array();

    if (empty($storeName)) {
        $errors[] = "Store name is required.";
    }
    if (empty($storeType)) {
        $errors[] = "Store type is required.";
    }
    if (empty($storeEmail)) {
        $errors[] = "Store email is required.";
    } elseif (!filter_var($storeEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid store email format.";
    }
    if (empty($storeContact)) {
        $errors[] = "Store contact numbers is required.";
    }
    if (empty($gpsAddress)) {
        $errors[] = "GPS address is required.";
    }
    if (empty($streetName)) {
        $errors[] = "Street name is required.";
    }
    if (empty($storeTown)) {
        $errors[] = "Store town is required.";
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        $controller = new storeController();
        $result = $controller->addStore($storeName, $storeType, $storeEmail, $storeContact, $gpsAddress, $streetName, $storeTown, $storeLocation);

        switch ($result) {
            case 'exists':
                $response = array(
                    'status' => 'error',
                    'message' => 'A store with the same name or email or contact number already exists.'
                );
                break;
            case 'success':
                $response = array(
                    'status' => 'success',
                    'message' => 'Store Registered successfully!',
                    'redirect' => './register-user.php'
                );
                break;
            default:
            $response = array(
                'status' => 'error',
                'message' => 'Failed to register store.'
            );
            break;
        }
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid action.'
    );
}


if (!headers_sent()) {
    echo json_encode($response);
}
