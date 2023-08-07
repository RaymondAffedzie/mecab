<?php
session_start();
require_once '../controllers/storeController.php';
$storeController = new storeController();

// Fetch the car models based on the selected car brand
if (isset($_GET['car_brand_id'])) {
    $carBrandId = $_GET['car_brand_id'];
    $carModels = $storeController->getCarModelsByBrand($carBrandId);

    $response = array(
        'status' => 'success',
        'message' => 'Car models fetched successfully.',
        'car_models' => $carModels
    );
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
