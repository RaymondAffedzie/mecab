<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:m:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/storeController.php';
$controller = new storeController();

if (isset($_GET['sparepart_id'])) {
    $sparepart_id = $_GET['sparepart_id'];

    // Fetch spare part details from the controller
    $query = "SELECT sp.*, ct.*, cb.*, cm.* 
                FROM spare_parts sp
                LEFT JOIN car_brand cb ON sp.car_brand_id = cb.car_brand_id
                LEFT JOIN car_model cm ON sp.car_model_id = cm.car_model_id
                INNER JOIN categories ct ON sp.category_id = ct.category_id
                WHERE sp.sparepart_id = :sparepart_id LIMIT 1";
    $params = array(":sparepart_id" => $sparepart_id);
    $sparePartDetails = $controller->getSingleRecordsByValue($query, $params);

    switch ($sparePartDetails) {
        case false:
            $response = array(
                'status' => 'error',
                'message' => 'An error occured while fetching spare parts.',
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
