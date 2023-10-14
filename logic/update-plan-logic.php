<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");
require_once '../controllers/payment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'plan_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'plan_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $amount = filter_input(INPUT_POST, 'plan_amount', FILTER_SANITIZE_NUMBER_INT);
    $interval = filter_input(INPUT_POST, 'plan_interval', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'plan_id', FILTER_SANITIZE_NUMBER_INT);

    if (isset($id)) {
        $textRegex = "/^[a-zA-Z ]+$/";
        $intervalRegex = "/^(weekly|monthly|quarterly|biannually|annually)$/";
        $amountRegex = "/^[1-9]\d*$/";

        $errors = array();
        if (empty($name) || !preg_match($textRegex, $name)) {
            $errors[] = "Please enter a valid name. Only alphabets and spaces are allowed.";
        }

        if (empty($interval) || !preg_match($intervalRegex, $interval)) {
            $errors[] = "Please select a valid interval (weekly, monthly, quarterly, biannually, or annually).";
        }

        if (!empty($description) && !preg_match($textRegex, $description)) {
            $errors[] = "Please enter a valid description. Only alphabets and spaces are allowed.";
        }

        if (empty($amount) || !preg_match($amountRegex, $amount)) {
            $errors[] = "Please enter a valid integer value! {$amount}";
        }

        if (!empty($errors)) {
            $response = array(
                'status' => 'error',
                'message' => $errors[0]
            );
        } else {

            $payment = new Payment();
            $planResult = $payment->updatePlan($name, $interval, $amount, $description, $id);

            if ($planResult['status'] === 'success') {
                $response = array(
                    'status' => 'success',
                    'message' => $planResult['message'],
                    'redirect' => '../Admin/create-plan.php'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => $planResult['message']
                );
            }
        }
    }else {
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
