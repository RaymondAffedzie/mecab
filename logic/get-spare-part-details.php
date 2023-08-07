<?php

require_once '../controllers/storeController.php';
$controller = new storeController();

if (isset($_GET['sparepart_id'])) {
    $sparepart_id = $_GET['sparepart_id'];

    // Fetch spare part details from the controller
    $sparePartDetails = $controller->getSparePartDetails($sparepart_id);

    switch ($sparePartDetails) {
        case false:
            $response = array(
                'status' => 'error',
                'message' => 'An error occured while fetchin spare parts.',
                'redirect' => '../Spare-parts/view-spare-parts.php'
            );
            break;
        case null:
            $response = array(
                'status' => 'error',
                'message' => 'Spare part not found.',
                'redirect' => '../Spare-parts/view-spare-parts.php'
            );
            break;
        default:
            $response = array(
                'status' => 'success',
                'data' => $sparePartDetails
            );
            break;
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request. Missing sparepart_id parameter.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
