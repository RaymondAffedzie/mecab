<?php
include_once dirname(__FILE__) . '/../model/DatabaseConnection.php';

class OTPGenerator
{
    private $pdo;

    public function __construct()
    {
        $databaseConfig = new DatabaseConnection('localhost', 'mecab', 'lollipop', 'afterworld@Ghana1');
        $this->pdo = $databaseConfig->connect();
    }

    // Generate a random OTP
    public function generateOTP()
    {
        $otpLength = 6; // Change the length as per your requirement
        $otp = '';
        $characters = '0123456789'; // Possible characters for the OTP

        for ($i = 0; $i < $otpLength; $i++) {
            $otp .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $otp;
    }

    // Store the OTP in the database
    public function storeOTP($storeId, $userId, $otp)
    {
        try {
            // Set the OTP expiration time (e.g., 30 minutes from now)
            $otpExpiration = date('Y-m-d H:i:s', strtotime('+30 minutes'));

            // Prepare and execute the SQL query to insert OTP into the table
            $query = "INSERT INTO user_store_otp (store_id, users_id, otp_code, otp_expiration) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$storeId, $userId, $otp, $otpExpiration]);

            return 'success';
        } catch (PDOException $e) {
            echo "Error storing OTP: " . $e->getMessage();
            return 'error'; // Return 'error' in case of an exception
        }
    }

    // Send OTP 
    public function sendOTP($storeContact, $otp, $msg)
    {
        $endPoint = 'https://api.mnotify.com/api/sms/quick';
        $msg = $msg;
        $apiKey = 'xdizoHkuAdlMuuD93yghJnP7O';
        $url = $endPoint . '?key=' . $apiKey;
        $data = [
            'recipient' => [$storeContact],
            'sender' => 'MeCAB',
            'message' => $msg.' : '.$otp,
            'is_schedule' => 'false',
            'schedule_date' => ''
        ];

        $ch = curl_init();
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        $result = json_decode($result, TRUE);
        curl_close($ch);

        // Check if the SMS was sent successfully
        // if ($result['status'] === 'success') {
        //     return 'OTP success';
        // } else {
        //     return $result['status'].' : '.$result['message'];
        // }
    }

    // Send Default password
    public function sendDefaultPassword($storeContact, $msg)
    {
        $endPoint = 'https://api.mnotify.com/api/sms/quick';
        $msg = $msg;
        $apiKey = 'xdizoHkuAdlMuuD93yghJnP7O';
        $url = $endPoint . '?key=' . $apiKey;
        $data = [
            'recipient' => [$storeContact],
            'sender' => 'MeCAB',
            'message' => $msg,
            'is_schedule' => 'false',
            'schedule_date' => ''
        ];

        $ch = curl_init();
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        $result = json_decode($result, TRUE);
        curl_close($ch);

        // Check if the SMS was sent successfully
        // if ($result['status'] === 'success') {
        //     return 'OTP success';
        // } else {
        //     return $result['status'].' : '.$result['message'];
        // }
    }
}