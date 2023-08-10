<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../controllers/storeController.php';

if (isset($_POST['action']) && $_POST['action'] == "register") {
    $firstName  = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName   = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $otherNames = filter_input(INPUT_POST, 'other_names', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userEmail  = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
    $role       = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password   = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $con_password = filter_input(INPUT_POST, 'con_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $firstName = ucwords($firstName);
    $lastName = ucwords($lastName);
    $otherNames = ucwords($otherNames);
    $userEmail = strtolower($userEmail);

    $errors = array();
    if (empty($firstName)) {
        $errors[] = "First name is required.";
    }
    if (empty($lastName)) {
        $errors[] = "Last name is required.";
    }
    if (empty($userEmail)) {
        $errors[] = "Mechanic email is required.";
    } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid mechanic email format.";
    }
    if (empty($role)) {
        $errors[] = "role is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if($password !== $con_password){
        $errors[] = "Password and confirm password do not match";
    }

    // Validdate email address using regular expression
    $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    if (!preg_match($emailPattern, $userEmail)) {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid email format.'
        );
        echo json_encode($response);
        exit;
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $controller = new storeController();
        $result = $controller->addUser($firstName, $lastName, $otherNames, $userEmail, $role, $password);

        if ($result === 'exists') {
            $response = array(
                'status' => 'error',
                'message' => 'A User with the same email already exists.'
            );
        } elseif ($result === 'success') {
            $response = array(
                'status' => 'success',
                'message' => 'User registered successfully!',
                'redirect' => './login.php'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to register user.'
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
