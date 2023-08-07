<?php
session_start();
require_once '../controllers/storeController.php';
// Create an instance of the StoreController class
$controller = new StoreController();

// Fetch user details from the database
$user = $controller->getUserDetails();
$contact = $controller->getUserContact($_SESSION['userId'], null);

// Check if the contact exists
if ($contact) {
    $user['users_contact'] = $contact['users_contact'];
} else {
    $user['users_contact'] = ''; // Set to empty string if the contact is not available
}

// Prepare the response
$response = array(
    'status' => 'success',
    'message' => 'User details fetched successfully.',
    'user' => $user
);



if (!headers_sent()) {
    echo json_encode($response);
}
