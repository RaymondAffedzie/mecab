<?php
session_start();
require_once '../controllers/storeController.php';
$storeController = new storeController();

// Fetch the car brands from the database
$carBrands = $storeController->getCarBrands();

// Prepare the response
$response = array(
    'status' => 'success',
    'message' => 'Car brands fetched successfully.',
    'car_brands' => $carBrands
);

if (!headers_sent()) {
    echo json_encode($response);
}
