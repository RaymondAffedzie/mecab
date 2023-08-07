<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../controllers/storeController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_brand      = filter_input(INPUT_POST, 'car_brand_id', FILTER_SANITIZE_NUMBER_INT);
    $car_model      = filter_input(INPUT_POST, 'car_model_id', FILTER_SANITIZE_NUMBER_INT);
    $spare_part_name = filter_input(INPUT_POST, 'spare_part_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category       = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
    $price          = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
    $description    = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $imageData      = $_FILES['image'] ?? null;

    $spare_part_name = ucwords($spare_part_name);
    $description = ucfirst($description);

    $errors = array();
    if (empty($spare_part_name)) {
        $errors[] = "Spare part name is required.";
    }
    if (empty($category)) {
        $errors[] = "Spare part category is required.";
    }
    if (empty($price)) {
        $errors[] = "Spare part price is required.";
    }
    if (empty($imageData)) {
        $errors[] = "Spare part image is required.";
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        include_once "../controllers/uniqueCode.php";

        $spare_part_id = $v4uuid;

        $storeController = new StoreController();

        // Call the method to get the user's store
        $store = $storeController->getUserStore($_SESSION['userId']);

        // Ensure $store is an integer
        $store = is_array($store) ? (int)$store['store_id'] : (int)$store;

        // Set car_brand_id and car_model_id to NULL if they are empty
        $car_brand = empty($car_brand) ? null : $car_brand;
        $car_model = empty($car_model) ? null : $car_model;

        // Prepare data for database insertion
        $data = array(
            'sparepart_id' => $spare_part_id,
            'name' => $spare_part_name,
            'description' => $description,
            'price' => $price,
            'category_id' => $category,
            'store_id' => $store,
            'car_brand_id' => $car_brand,
            'car_model_id' => $car_model
        );

        // Database values
        $table = 'spare_parts';

        // Call the method to add the spare part with image
        $result = $storeController->addRecordWithImage($data, $imageData, $table);

        if ($result['status'] === 'success') {
            $response = array(
                'status' => 'success',
                'message' => $result['message'],
                'redirect' => '../Spare-parts/view-spare-parts.php'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' =>  $result['message'],
                'redirect' => '../Spare-parts/add-spare-parts.php'
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
