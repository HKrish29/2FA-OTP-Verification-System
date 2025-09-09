<?php
session_start();

// Fix undefined array key warnings by using null coalescing operator
$utm_medium = $_GET['utm_medium'] ?? '';
$utm_source = $_GET['utm_source'] ?? '';  
$utm_campaign = $_GET['utm_campaign'] ?? '';

$action = $_POST['action'] ?? '';

switch ($action) {
    case "send_otp":
        try {
            // Get and validate form data
            $customer_name = trim($_POST['customer_name'] ?? '');
            $customer_email = trim($_POST['customer_email'] ?? '');
            $mobile_number = trim($_POST['mobile_number'] ?? '');

            // Validation
            if (empty($customer_name) || empty($customer_email) || empty($mobile_number)) {
                echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">❌ All fields are required</div>';
                break;
            }

            if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
                echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">❌ Invalid email format</div>';
                break;
            }

            if (!preg_match('/^[0-9]{10}$/', $mobile_number)) {
                echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">❌ Mobile number must be 10 digits</div>';
                break;
            }

            // Store in session
            $_SESSION['session_customer_name'] = $customer_name;
            $_SESSION['session_customer_email'] = $customer_email; 
            $_SESSION['session_mobile_number'] = $mobile_number;
            $_SESSION['session_utm_medium'] = $utm_medium;
            $_SESSION['session_utm_source'] = $utm_source;
            $_SESSION['session_utm_campaign'] = $utm_campaign;

            // Generate OTP
            $otp = rand(100000, 999999);
            $_SESSION['session_otp'] = $otp;

            // Your 2Factor API key
            $apiKey = "c61f2623-8ce1-11f0-a562-0200cd936042";
            $url = "https://2factor.in/API/V1/$apiKey/SMS/$mobile_number/$otp";

            // Send OTP using cURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">❌ cURL Error: ' . $err . '</div>';
                break;
            }

            $obj = json_decode($response, true);
            $status = $obj['Status'] ?? 'Failed';

            if ($status == "Success") {
                // Load the beautiful verification form
                require_once("verification-form.php");
            } else {
                $details = $obj['Details'] ?? 'Unknown error';
                echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">';
                echo '❌ SMS sending failed<br>';
                echo 'Status: ' . htmlspecialchars($status) . '<br>';
                echo 'Details: ' . htmlspecialchars($details);
                echo '</div>';
            }

        } catch (Exception $e) {
            echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">❌ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        break;

    case "verify_otp":
        try {
            $otp = trim($_POST['otp'] ?? '');
            $session_otp = $_SESSION['session_otp'] ?? '';

            if (empty($otp)) {
                echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">❌ Please enter OTP</div>';
                break;
            }

            if ($otp == $session_otp) {
                // OTP verified successfully
                unset($_SESSION['session_otp']);

                // Get user data
                $mobile_number = $_SESSION['session_mobile_number'] ?? '';
                $customer_name = $_SESSION['session_customer_name'] ?? '';
                $customer_email = $_SESSION['session_customer_email'] ?? '';
                $utm_medium = $_SESSION['session_utm_medium'] ?? '';
                $utm_source = $_SESSION['session_utm_source'] ?? '';
                $utm_campaign = $_SESSION['session_utm_campaign'] ?? '';

                // Show success and redirect or show order form
                echo '<div style="color: green; padding: 20px; background: #e8f5e8; border-radius: 10px; margin: 20px 0; text-align: center;">';
                echo '<h2>✅ OTP Verified Successfully!</h2>';
                echo '<p>Welcome, ' . htmlspecialchars($customer_name) . '!</p>';
                echo '<p>Your mobile number ' . htmlspecialchars($mobile_number) . ' has been verified.</p>';
                echo '</div>';

                // Load order form or redirect
                if (file_exists("order-form.php")) {
                    require_once("order-form.php");
                } else {
                    echo '<div style="text-align: center; margin: 20px 0;">';
                    echo '<a href="index.php" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600;">Continue</a>';
                    echo '</div>';
                }

            } else {
                echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">❌ Invalid OTP. Please try again.</div>';
                // Show verification form again
                require_once("verification-form.php");
            }

        } catch (Exception $e) {
            echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">❌ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        break;

    default:
        echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px; margin: 10px 0;">❌ Invalid action</div>';
        break;
}
?>