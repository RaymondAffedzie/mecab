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
    $first_name  = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $last_name   = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $other_names = filter_input(INPUT_POST, 'other_names', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email       = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $contact     = filter_input(INPUT_POST, 'user_contact', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $first_name = ucwords($first_name);
    $last_name  = ucwords($last_name);
    $other_names = !empty($other_names) ? ucwords($other_names) : null;
    $email       = strtolower($email);

    $errors = array();
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($contact)) {
        $errors[] = "Contact is required.";
    }


    // Validate email address 
    $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    if (!preg_match($emailPattern, $email)) {
        $errors[] = "Invalid email format.";
    }

    // Validate contact number
    $contactPattern = '/^0\d{9}$/';
    if (!preg_match($contactPattern, $contact)) {
        $errors[] = "Invalid contact number format.";
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        $controller = new StoreController();

        $updateUser = $controller->updateUserRecord($first_name, $last_name, $other_names, $email, $contact);

        $userRole = $_SESSION['role'];
        switch ($userRole) {
            case 'Spare parts':

                switch ($updateUser) {
                    case 'contact-exists':
                        // Check if the new contact is different from the old contact
                        $oldContact = $controller->getUserContact($_SESSION['userId'], null);
                        $oldContact = $oldContact['users_contact'];

                        if ($contact !== $oldContact && !empty($contact)) {
                            $response = array(
                                'status' => 'error',
                                'message' => 'The contact ' . $contact . ' has been used by another user.',
                                'redirect' => '../Spare-parts/profile.php'
                            );
                        } else {
                            $response = array(
                                'status' => 'success',
                                'message' => 'Profile updated successfully.',
                                'redirect' => '../Spare-parts/profile.php'
                            );
                        }
                        break;
                    case 'email-exists':
                        $response = array(
                            'status' => 'error',
                            'message' => 'The email ' . $email . ' has been used by another user.',
                            'redirect' => '../Spare-parts/profile.php'
                        );
                        break;
                    case true:
                        $response = array(
                            'status' => 'success',
                            'message' => 'Profile updated successfully.',
                            'redirect' => '../Spare-parts/profile.php'
                        );
                        break;
                    default:
                        $response = array(
                            'status' => 'error',
                            'message' => 'Profile update failed.',
                            'redirect' => '../Spare-parts/profile.php'
                        );
                        break;
                }
                break;
            case 'Car rentals':
                switch ($updateUser) {
                    case 'contact-exists':
                        // Check if the new contact is different from the old contact
                        $oldContact = $controller->getUserContact($_SESSION['userId'], null);
                        $oldContact = $oldContact['users_contact'];

                        if ($contact !== $oldContact && !empty($contact)) {
                            $response = array(
                                'status' => 'error',
                                'message' => 'The contact ' . $contact . ' has been used by another user.',
                                'redirect' => '../Car-rentals/profile.php'
                            );
                        } else {
                            $response = array(
                                'status' => 'success',
                                'message' => 'Profile updated successfully.',
                                'redirect' => '../Car-rentals/profile.php'
                            );
                        }
                        break;
                    case 'email-exists':
                        $response = array(
                            'status' => 'error',
                            'message' => 'The email ' . $email . ' has been used by another user.',
                            'redirect' => '../Car-rentals/profile.php'
                        );
                        break;
                    case true:
                        $response = array(
                            'status' => 'success',
                            'message' => 'Profile updated successfully.',
                            'redirect' => '../Car-rentals/profile.php'
                        );
                        break;
                    default:
                        $response = array(
                            'status' => 'error',
                            'message' => 'Profile update failed.',
                            'redirect' => '../Car-rentals/profile.php'
                        );
                        break;
                }
                break;
            case 'Admin':
            case 'Customer':
            case 'Mechanic':
            case 'Transport':
                switch ($updateUser) {
                    case 'contact-exists':
                        // Check if the new contact is different from the old contact
                        $oldContact = $controller->getUserContact($_SESSION['userId'], null);
                        $oldContact = $oldContact['users_contact'];

                        if ($contact !== $oldContact && !empty($contact)) {
                            $response = array(
                                'status' => 'error',
                                'message' => 'The contact ' . $contact . ' has been used by another user.',
                                'redirect' => '../' . $userRole . '/profile.php'
                            );
                        } else {
                            $response = array(
                                'status' => 'success',
                                'message' => 'Profile updated successfully.',
                                'redirect' => '../' . $userRole . '/profile.php'
                            );
                        }
                        break;
                    case 'email-exists':
                        $response = array(
                            'status' => 'error',
                            'message' => 'The email ' . $email . ' has been used by another user.',
                            $redirect = '../' . $userRole . '/profile.php'
                        );
                        break;
                    case true:
                        $response = array(
                            'status' => 'success',
                            'message' => 'Profile updated successfully.',
                            $redirect = '../' . $userRole . '/profile.php'
                        );
                        break;
                    default:
                        $response = array(
                            'status' => 'error',
                            'message' => 'Profile update failed.',
                            $redirect = '../' . $userRole . '/profile.php'
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
