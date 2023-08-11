<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
    $message = "Error: [$errno] $errstr - $errfile:$errline - [Date/time] - $eventDate";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");

require_once '../controllers/storeController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Perform server-side validation and data sanitization
    $errors = array();

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        // Data is valid and sanitized, attempt to login
        $controller = new storeController();
        $result = $controller->login($email, $password);

        if ($result === 'not_found') {
            $response = array(
                'status' => 'error',
                'message' => 'A user not found with the provided email.'
            );
        } elseif ($result === 'incorrect_password') {
            $response = array(
                'status' => 'error',
                'message' => 'Incorrect password.'
            );
        } elseif ($result === 'verified') {
            // Redirect based on user role
            $userRole = $_SESSION['role'];
            switch ($userRole) {
                case 'Transport':
                    $response = array(
                        'status' => 'success',
                        'message' => 'Login successful as transport user!',
                        'redirect' => './Transport/index.php'
                    );
                    break;
                case 'Spare parts':
                    $response = array(
                        'status' => 'success',
                        'message' => 'Login successful as spare parts user!',
                        'redirect' => './Spare-parts/index.php'
                    );
                    break;
                case 'Mechanic':
                    $response = array(
                        'status' => 'success',
                        'message' => 'Login successful as mechanic!',
                        'redirect' => './Mechanic/index.php'
                    );
                    break;
                case 'Car rentals':
                    $response = array(
                        'status' => 'success',
                        'message' => 'Login successful as car rentals user!',
                        'redirect' => './Car-rentals/index.php'
                    );
                    break;
                case 'Admin':
                    $response = array(
                        'status' => 'success',
                        'message' => 'Login successful as an admin!',
                        'redirect' => './Admin/index.php'
                    );
                    break;
                case 'Customer':
                    $response = array(
                        'status' => 'success',
                        'message' => 'Login successful as a customer!',
                        'redirect' => './Customer/index.php'
                    );
                    break;
                default:
                    $response = array(
                        'status' => 'error',
                        'message' => 'Unknown user role.'
                    );
            }
        } elseif ($result === 'not_verified') {
            $response = array(
                'status' => 'success',
                'message' => 'User is not verified!',
                'redirect' => './verification.php'
            );
        } elseif ($result === 'Admin') {
            $response = array(
                'status' => 'success',
                'message' => 'Login successfull as admin!',
                'redirect' => './Admin/index.php'
            );
        } elseif ($result === 'Customer') {
            $response = array(
                'status' => 'success',
                'message' => 'Login successfull as customer!',
                'redirect' => './Customer/index.php'
            );
        } elseif ($result === 'no_details') {
            $response = array(
                'status' => 'success',
                'message' => 'User has no details!',
                'redirect' => './add-details.php'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to login. ' . $result
            );
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
