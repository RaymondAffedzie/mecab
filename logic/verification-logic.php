<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../controllers/storeController.php';
require_once '../controllers/otpGenerator.php';

// Check if the form was submitted
if (isset($_POST['action']) && $_POST['action'] == "verify") {
    // Retrieve the entered OTP from the form submission and validate
    $enteredOTP = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_NUMBER_INT);

    // Retrieve the stored OTP details from the database based on the user's ID
    $userId = $_SESSION['userId'];
    $storeController = new StoreController();
    $verification = $storeController->getStoreVerification($userId);
    $otpGenerator = new OTPGenerator();

    if ($verification) {
        // Compare the entered OTP with the stored OTP to validate the user
        if ($enteredOTP == $verification['otp_code']) {
            // Check if the OTP is within the expiration time
            $currentDateTime = new DateTime();
            $otpExpiration = new DateTime($verification['otp_expiration']);

            if ($currentDateTime <= $otpExpiration) {
                // Approve user and store verification
                $approved = $storeController->verifyUserStore($userId, $verification['store_id']);

                if ($approved) {
                    // Fetch the user's role
                    $userRole = $_SESSION['role'];

                    // Redirect based on user role
                    switch ($userRole) {
                        case 'Transport':
                            $redirectUrl = './Transport/index.php';
                            break;
                        case 'Spare parts':
                            $redirectUrl = './Spare-parts/index.php';
                            break;
                        case 'Mechanic':
                            $redirectUrl = './Mechanic/index.php';
                            break;
                        case 'Car rentals':
                            $redirectUrl = './Car-rentals/index.php';
                            break;
                        default:
                            $redirectUrl = './index.php';
                    }

                    $response = array(
                        'status' => 'success',
                        'message' => 'Verification successful',
                        'redirect' => $redirectUrl
                    );
                    $_SESSION['isVerified'] = true;
                }
            } else {
                // OTP has expired, generate a new verification code
                $newOTP = $otpGenerator->generateOTP();
                $otpGenerator->storeOTP($verification['store_id'], $userId, $newOTP);

                // Send the new verification code to the user
                $msg = 'Do not share your code with anyone. Ignore this message if you did not request for this code. Your verification code is: ';
                $storeContact = $storeController->getStoreById($verification['store_id']);
                $sendOTP = $otpGenerator->sendOTP($storeContact['store_contact'], $newOTP, $msg);

                $response = array(
                    'status' => 'expired',
                    'message' => 'Verification code expired. New code generated and sent to your contact.'
                );
            }
        } else {
            // Invalid OTP
            $response = array(
                'status' => 'error',
                'message' => 'Invalid code. Please try again.'
            );
        }
    } else {
        // OTP not found or error occurred while fetching OTP
        $response = array(
            'status' => 'error',
            'message' => 'Enter the code sent to you. Please try again.'
        );
    }
}

if (!headers_sent()) {
    echo json_encode($response);
}
