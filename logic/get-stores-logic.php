<?php
session_start();
require_once '../controllers/storeController.php';
// Create an instance of the StoreController class
$storeController = new StoreController();

// Fetch the stores from the database
$stores = $storeController->getStores();

// Prepare the response
$response = array(
    'status' => 'success',
    'message' => 'Stores fetched successfully.',
    'stores' => $stores
);


if (!headers_sent()) {
    echo json_encode($response);
}