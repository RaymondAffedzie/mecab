<?php
session_start();
require_once '../controllers/storeController.php';
$storeController = new storeController();

// Fetch the categories from the database
$categories = $storeController->getCategories();

// Prepare the response
$response = array(
    'status' => 'success',
    'message' => 'Categories fetched successfully.',
    'categories' => $categories
);

if (!headers_sent()) {
    header('Content-Type: application/json');
    echo json_encode($response);
}