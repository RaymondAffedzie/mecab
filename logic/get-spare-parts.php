<?php
session_start();
require_once '../controllers/storeController.php';
// Create an instance of the StoreController class
$controller = new StoreController();

// Fetch user details from the database
$parts = $controller->getStoreSpareParts();

// Prepare the response
$response = array(
    'status' => 'success',
    'message' => 'Spare parts fetched successfully.',
    'parts' => $parts
);

if (!headers_sent()) {
    echo json_encode($response);
}
