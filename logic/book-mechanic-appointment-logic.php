<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: ../login.php");
    exit;
}

require_once '../controllers/storeController.php';
require_once '../controllers/uniqueCode.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = ucwords(filter_input(INPUT_POST, 'make', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $model = ucwords(filter_input(INPUT_POST, 'model', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $plate = ucwords(filter_input(INPUT_POST, 'plate', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $note = ucwords(filter_input(INPUT_POST, 'note', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $appointment_date = ucwords(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $year = ucwords(filter_input(INPUT_POST, 'year', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $service_id = ucwords(filter_input(INPUT_POST, 'service', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $mechanic_id = ucwords(filter_input(INPUT_POST, 'mechanic', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $user = $_SESSION['userId'];
    $appointment_id = generate_uuid_v4();
    $make = ucwords($make);
    $model = ucwords($model);
    $plate = strtoupper($plate);
    $note = ucfirst($note);
    $date_created = date('Y-m-d');

    $platePatternOne = '/^[A-Za-z]{2}-[1-9]\d*-\d{2}$/';
    $platePatternTwo = '/^[A-Za-z]{2}-[1-9]\d*-[A-Za-z]$/';
    $platePatternThree = '/^[A-Za-z]+-\d+-\d{2}$/';

    $appointmentTimestamp = strtotime($appointment_date);
    $todayTimestamp = strtotime(date('Y-m-d'));

    $errors = array();
    if (empty($make)) {
        $errors[] = "Car make is required.";
    }
    if (empty($model)) {
        $errors[] = "Car model is required.";
    }
    if (!preg_match($platePatternOne, $plate) && !preg_match($platePatternTwo, $plate) && !preg_match($platePatternThree, $plate)) {
        $errors[] = "Car license plate number is required.";
    }
    if (empty($appointment_date)) {
        $errors[] = "Date of appointment is required.";
    }
    if ($appointmentTimestamp < $todayTimestamp) {
        $errors[] = "Appointment date cannot be in the past.";
    }
    if ($year !== null) {
        if ($year === false || $year < 1900 || $year > date('Y')) {
            $errors[] = "Invalid year. Please enter a valid year between 1900 and " . date('Y');
        }
    }

    if (!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => $errors[0]
        );
    } else {
        $controller = new storeController();
        $tableName = "mechanic_appointment";
        $data = array(
            'appointment_id' => $appointment_id,
            'mechanic_id' => $mechanic_id,
            'users_id' => $user,
            'service_id' => $service_id,
            'appointment_date' => $appointment_date,
            'make' => $make,
            'model' => $model,
            'year' => $year,
            'plate' => $plate,
            'note' => $note,
            'date_added' => $date_created
        );

        $result = $controller->addRecord($data, $tableName);
        if ($result == true) {
            $response = array(
                'status' => 'success',
                'message' => 'Appointment booked successfully!'
            );
        } else if ($result == 'failed') {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to book appointment. Please try again later!'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'An error occured while booking appointment. Please try again!'
            );
        }
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid Request.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
