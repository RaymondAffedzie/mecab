<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../controllers/storeController.php';
require_once '../controllers/uniqueCode.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'add_service') {
        $errors = array();

        $serviceName = filter_input(INPUT_POST, 'serviceName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($serviceName)) {
            $errors[] = "Service name is required.";
        }

        if (!empty($errors)) {
            $response = array(
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $errors
            );
        } else {
            $controller = new storeController();

            $tableName = "service";
            $columnName = "service_name";
            $value = $serviceName;
            $data = array(
                'service_id' => $unique_id,
                'service_name' => ucfirst($serviceName)
            );
        }

        $result = $controller->addRecordCheck($data, $tableName, $columnName, $value);
        if ($result == 'success') {
            $response = array(
                'status' => 'success',
                'message' => 'Mechanic service saved successfully!',
                'redirect' => './index.php'
            );
        } else if ($result == 'exists') {
            $response = array(
                'status' => 'error',
                'message' => 'Mechanic service already exists!'
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid action.'
        );
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
