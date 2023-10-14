<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && !$_SESSION['loggedIn']) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/payment.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $payment = new Payment();

    if (isset($_GET['plan'])) {
        $plan_id = filter_input(INPUT_GET, 'plan', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $plansDetails = $payment->fetchPlan($plan_id);

        if ($plansDetails['status'] == true) {
            $response = array(
                'status' => 'success',
                'message' => $plansDetails['message'],
                'data' => $plansDetails['data']['data']
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => $plansDetails['message']
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid request. Missing parameter!'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method.'
    );
}

if (!headers_sent()) {
    echo json_encode($response);
}
