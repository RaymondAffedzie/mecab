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

require_once '../controllers/storeController.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password  = filter_input(INPUT_POST, 'old_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $new_password  = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $con_password  = filter_input(INPUT_POST, 'con_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $errors = array();
    if (empty($old_password)) {
        $errors[] = "Password is required.";
    }
    if (empty($new_password)) {
        $errors[] = "New password is required.";
    }
    if (empty($con_password)) {
        $errors[] = "Confirm password is required.";
    }
    if (strcmp($old_password, $new_password) === 0) {
        $errors[] = "Old password and new password cannot be same.";
    }
    if (strcmp($new_password, $con_password) > 0 || strcmp($new_password, $con_password) < 0) {
        $errors[] = "New password and confirm password do not match.";
    }

    // Check if there is any valiation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation erorr',
            'errors' => $errors
        );
    } else {
        $controler = new storeController();

        $changePassword = $controler->updateUserPassword($old_password, $new_password);

        $userRole = $_SESSION['role'];
        switch ($userRole) {
            case 'Spare parts':
                switch ($changePassword) {
                    case 'success':
                        $response = array(
                            'status' => 'success',
                            'message' => 'Password changed successfully.',
                            'redirect' => '../Spare-parts/change-password.php'
                        );
                        break;
                    case 'wrong':
                        $response = array(
                            'status' => 'error',
                            'message' => 'Wrong password. Please try again',
                            'redirect' => '../Spare-parts/change-password.php'
                        );
                        break;
                    default:
                        $response = array(
                            'status' => 'error',
                            'message' => 'Failed to change your password',
                            'redirect' => '../Spare-parts/change-password.php'
                        );
                        break;
                }
                break;
            case 'Car rentals':
                switch ($changePassword) {
                    case 'success':
                        $response = array(
                            'status' => 'success',
                            'message' => 'Password changed successfully.',
                            'redirect' => '../Car-rentals/change-password.php'
                        );
                        break;
                    case 'wrong':
                        $response = array(
                            'status' => 'error',
                            'message' => 'Wrong passord. Please try again',
                            'redirect' => '../Car-rentals/change-password.php'
                        );
                        break;
                    default:
                        $response = array(
                            'status' => 'error',
                            'message' => 'Failed to change your password',
                            'redirect' => '../Car-rentals/change-password.php'
                        );
                        break;
                }
                break;
            case 'Admin':
            case 'Customer':
            case 'Mechanic':
            case 'Transport':
                switch ($changePassword) {
                    case 'success':
                        $response = array(
                            'status' => 'success',
                            'message' => 'Password changed successfully.',
                            'redirect' => '../' . $userRole . '/change-password.php'
                        );
                        break;
                    case 'wrong':
                        $response = array(
                            'status' => 'error',
                            'message' => 'Wrong password. Please try again.',
                            'redirect' => '../' . $userRole . '/change-password.php'
                        );
                        break;
                    default:
                        $response = array(
                            'status' => 'error',
                            'message' => 'Failed to change your password',
                            'redirect' => '../' . $userRole . '/change-password.php'
                        );
                        break;
                }
                break;
            default:
                $response = array(
                    'status' => 'error',
                    'message' => 'Invalid user role.',
                    'redirect' => '../' . $userRole . '/profile.php'
                );
                break;
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
