<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../controllers/storeController.php';

if (isset($_POST['action']) && $_POST['action'] == "add_details") {

    $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $specialisation = filter_input(INPUT_POST, 'specialisation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $storeId = filter_input(INPUT_POST, 'store', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userId = $_SESSION['userId'];

    $controller = new storeController();

    // Validate contact number
    $contactPattern = '/^0\d{9}$/';
    if (!preg_match($contactPattern, $contact)) {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid contact number format.'
        );
    } else {
        if ($role == 'Admin') {
            $result = $controller->addUserDetails($userId, $contact, null, null);
            if ($result == 'exists') {
                $response = array(
                    'status' => 'error',
                    'message' => 'This contact has been used by another user!'
                );
            } elseif ($result == 'success') {
                $response = array(
                    'status' => 'success',
                    'message' => 'Details saved successfully.',
                    'redirect' => './Admin/index.php'
                );
                $_SESSION['regIsComplete'] = true;
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to save details.'
                );
            }
        } elseif ($role == 'Customer') {
            $result = $controller->addUserDetails($userId, $contact, null, null);
            if ($result == 'exists') {
                $response = array(
                    'status' => 'error',
                    'message' => 'This contact has been used by another user!'
                );
            } elseif ($result == 'success') {
                $response = array(
                    'status' => 'success',
                    'message' => 'Details saved successfully.',
                    'redirect' => './Customer/index.php'
                );

                $_SESSION['regIsComplete'] = true;
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to save details.'
                );
            }
        } elseif ($role == 'Mechanic') {
            if (empty($specialisation)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Select your field of work.'
                );
            }
            if (empty($storeId)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Select your store.'
                );
            }
            $result = $controller->addUserDetails($userId, $contact, $specialisation, $storeId);
            if ($result == 'exists') {
                $response = array(
                    'status' => 'error',
                    'message' => 'This contact has been used by another user!'
                );
            } elseif ($result == 'success') {
                $response = array(
                    'status' => 'success',
                    'message' => 'Details saved successfully.',
                    'redirect' => './verification.php'
                );
                $_SESSION['regIsComplete'] = true;
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to save details.'
                );
            }
        } else {
            if (empty($storeId)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Select your store.'
                );
            }
            $result = $controller->addUserDetails($userId, $contact, null, $storeId);
            if ($result == 'exists') {
                $response = array(
                    'status' => 'error',
                    'message' => 'This contact has been used by another user!'
                );
            } elseif ($result == 'success') {
                $response = array(
                    'status' => 'success',
                    'message' => 'Details saved successfully.',
                    'redirect' => './verification.php'
                );
                $_SESSION['regIsComplete'] = true;
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to save details.'
                );
            }
        }
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
