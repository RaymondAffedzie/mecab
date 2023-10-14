<?php
session_start();
include_once dirname(__FILE__) . '/../model/DatabaseConnection.php';

class Payment
{
    private $sk;
    private $cartTotal;

    public function __construct()
    {
        $this->sk = 'sk_test_27e389526208142e8ca9c25f2fce4be9221c1476';
        $this->cartTotal = $_SESSION['cart_total'];
    }

    public function verifyPayment($ref)
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/{$ref}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$this->sk}",
                "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return array(
                'status' => 'error',
                'message' => "cURL Error: {$err}"
            );
        } else {
            $resData = json_decode($response, true);
            $amount = $this->cartTotal * 100;

            if ($resData['status'] === true && $resData['data']['status'] === 'success' && $resData['data']['amount'] === $amount) {
                return array(
                    'status' => 'success',
                    'message' => 'Payment verified and successful.',
                    'data' => $resData
                );
            } elseif ($resData['data']['amount'] !== $amount) {
                return array(
                    'status' => 'error',
                    'message' => 'Payment amount mismatch.'
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => 'Payment verification failed.'
                );
            }
        }
    }

    public function createPlan($name, $interval, $amount, $description)
    {
        $url = "https://api.paystack.co/plan";
        $amount *= 100;
        $fields = [
            'name' => $name,
            'interval' => $interval,
            'amount' => $amount,
            'description' => $description,
            'currency' => 'GHS'
        ];

        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $fields_string,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$this->sk}",
                "Cache-Control: no-cache",
            )
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return array(
                'status' => 'error',
                'message' => "cURL Error: {$err}"
            );
        } else {
            $resData = json_decode($response, true);

            if ($resData['status'] === true) {
                
                return array(
                    'status' => 'success',
                    'message' => $resData['message'],
                    'data' => $resData
                );
            }
        }
    }

    public function listPlans()
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.paystack.co/plan",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$this->sk}",
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return array(
                'status' => 'error',
                'message' => "cURL Error: {$err}"
            );
        } else {
            $resData = json_decode($response, true);

            if ($resData['status'] === true) {
                return array(
                    'status' => 'success',
                    'message' => $resData['message'],
                    'data' => $resData
                );
            }
        }
    }

    public function fetchPlan($planId)
    {
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.paystack.co/plan/{$planId}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$this->sk}",
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return array(
                'status' => 'error',
                'message' => "cURL Error: {$err}"
            );
        } else {
            $resData = json_decode($response, true);

            if ($resData['status'] === true) {
                return array(
                    'status' => 'success',
                    'message' => $resData['message'],
                    'data' => $resData
                );
            }
        }
    }

    public function updatePlan($name, $interval, $amount, $description, $planId)
    {
        $url = "https://api.paystack.co/plan/{$planId}";
        $amount *= 100;
        $fields = [
            'name' => $name,
            'interval' => $interval,
            'amount' => $amount,
            'description' => $description,
            'currency' => 'GHS'
        ];

        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $fields_string,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$this->sk}",
                "Cache-Control: no-cache",
            )
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return array(
                'status' => 'error',
                'message' => "cURL Error: {$err}"
            );
        } else {
            $resData = json_decode($response, true);

            if ($resData['status'] === true) {
                return array(
                    'status' => 'success',
                    'message' => $resData['message'],
                );
            }
        }
    }

    public function initialiseTransaction($email, $reference, $plan_code) {
        $url = "https://api.paystack.co/transaction/initialize";

        $fields = [
          'email' => "customer@email.com",
          'amount' => "10000",
          'plan' => $plan_code,
          'channels' => ['mobile_money'],
          'reference' => $reference,
          'currency' => 'GHS',
          'email' => $email,
          'callback_url' => 'mecab.org'
        ];
      
        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $fields_string,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$this->sk}",
                "Cache-Control: no-cache",
            )
        ));
        
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return array(
                'status' => 'error',
                'message' => "cURL Error: {$err}"
            );
        } else {
            $resData = json_decode($response, true);

            if ($resData['status'] === true) {
                return array(
                    'status' => 'success',
                    'message' => $resData['message'],
                );
            }
        }
    }
}
