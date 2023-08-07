<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../controllers/storeController.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $spare_part_id = filter_input(INPUT_POST, 'spare_part_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $car_brand = filter_input(INPUT_POST, 'car_brand_id', FILTER_SANITIZE_NUMBER_INT);
    $car_model = filter_input(INPUT_POST, 'car_model_id', FILTER_SANITIZE_NUMBER_INT);
    $spare_part_name = filter_input(INPUT_POST, 'spare_part_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image = $_FILES['image'] ?? null;

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

    // Check if there are any validation errors
    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        );
    } else {
        try {
            // Create an instance of the StoreController
            $controller = new StoreController();

            // Prepare the update data array for the updateRecordWithImage function
            $data = array(
                'car_brand_id' => $car_brand,
                'car_model_id' => $car_model,
                'name' => $spare_part_name,
                'category_id' => $category,
                'price' => $price,
                'description' => $description
            );

            // Database values
            $table = 'spare_parts';
            $dataKey = 'sparepart_id';

            // Update spare part in the database
            $success = $controller->updateRecordWithImage($table, $dataKey, $spare_part_id, $data, $image);

            switch ($success) {
                case true:
                    $response = array(
                        'status' => 'success',
                        'message' => 'Spare part updated successfully!',
                        'redirect' => '../Spare-parts/spare-part-details.php?sparepart_id='. $spare_part_id
                    );
                    break;
                case 'failed':
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to update spare part!',
                        'redirect' => '../Spare-parts/spare-part-details.php?sparepart_id=' . $spare_part_id
                    );
                default:
                    $response = array(
                        'status' => 'error',
                        'message' => 'An error occurred while updating the spare part',
                        'redirect' => '../Spare-parts/spare-part-details.php?sparepart_id=' . $spare_part_id
                    );
                    break;
            }
        } catch (PDOException $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Error updating spare part: ' . $e->getMessage(),
                'redirect' => '../Spare-parts/spare-part-details.php?sparepart_id=' . $spare_part_id    
            );
        }
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
