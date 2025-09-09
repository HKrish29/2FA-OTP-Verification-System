<?php
session_start();

// Get form data
$customer_name = $_POST['customer_name'] ?? $_SESSION['session_customer_name'] ?? 'Customer';
$customer_email = $_POST['customer_email'] ?? $_SESSION['session_customer_email'] ?? '';
$mobile_number = $_POST['mobile_number'] ?? $_SESSION['session_mobile_number'] ?? '';
$address = $_POST['address'] ?? '';
$pincode = $_POST['pincode'] ?? '';
$special_instructions = $_POST['special_instructions'] ?? '';
$utm_source = $_POST['utm_source'] ?? '';
$utm_medium = $_POST['utm_medium'] ?? '';
$utm_campaign = $_POST['utm_campaign'] ?? '';

// Generate order ID
$order_id = 'ORD' . date('Ymd') . rand(1000, 9999);

// Store order details (in real app, save to database)
$_SESSION['order_details'] = [
    'order_id' => $order_id,
    'customer_name' => $customer_name,
    'customer_email' => $customer_email,
    'mobile_number' => $mobile_number,
    'address' => $address,
    'pincode' => $pincode,
    'special_instructions' => $special_instructions,
    'order_date' => date('Y-m-d H:i:s'),
    'amount' => 999,
    'status' => 'confirmed'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed! - Thank You</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .success-container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .order-success {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 50px 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .success-animation {
            font-size: 80px;
            animation: successBounce 1.5s ease-out;
            margin-bottom: 20px;
        }

        @keyframes successBounce {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .order-details {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .detail-row:last-child {
            border-bottom: none;
            font-weight: bold;
            color: #27ae60;
            font-size: 18px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 30px;
        }

        @media (max-width: 480px) {
            .action-buttons {
                grid-template-columns: 1fr;
            }
        }

        .btn-primary, .btn-secondary {
            padding: 15px 25px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            color: white;
        }

        .btn-primary:hover, .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="particles">
        <div class="particle" style="left: 10%; animation-delay: 0s; width: 4px; height: 4px;"></div>
        <div class="particle" style="left: 30%; animation-delay: 1s; width: 6px; height: 6px;"></div>
        <div class="particle" style="left: 50%; animation-delay: 2s; width: 3px; height: 3px;"></div>
        <div class="particle" style="left: 70%; animation-delay: 3s; width: 5px; height: 5px;"></div>
        <div class="particle" style="left: 90%; animation-delay: 4s; width: 4px; height: 4px;"></div>
    </div>

    <div class="container success-container">
        <div class="order-success">
            <div class="success-animation">🎉</div>
            <h1 style="font-size: 36px; margin-bottom: 15px;">Order Confirmed!</h1>
            <p style="font-size: 18px; opacity: 0.9; margin-bottom: 20px;">
                Thank you, <strong><?php echo htmlspecialchars($customer_name); ?></strong>!<br>
                Your order has been placed successfully.
            </p>
            <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 10px; display: inline-block;">
                <strong>Order ID: <?php echo $order_id; ?></strong>
            </div>
        </div>

        <div class="order-details">
            <h3 style="color: #2c3e50; margin-bottom: 20px; text-align: center;">
                <i class="fas fa-receipt"></i> Order Details
            </h3>

            <div class="detail-row">
                <span><i class="fas fa-user"></i> Customer Name:</span>
                <span><?php echo htmlspecialchars($customer_name); ?></span>
            </div>

            <div class="detail-row">
                <span><i class="fas fa-envelope"></i> Email:</span>
                <span><?php echo htmlspecialchars($customer_email); ?></span>
            </div>

            <div class="detail-row">
                <span><i class="fas fa-phone"></i> Mobile:</span>
                <span><?php echo htmlspecialchars($mobile_number); ?></span>
            </div>

            <div class="detail-row">
                <span><i class="fas fa-map-marker-alt"></i> Delivery Address:</span>
                <span><?php echo htmlspecialchars($address); ?></span>
            </div>

            <div class="detail-row">
                <span><i class="fas fa-location-arrow"></i> Pin Code:</span>
                <span><?php echo htmlspecialchars($pincode); ?></span>
            </div>

            <?php if ($special_instructions): ?>
            <div class="detail-row">
                <span><i class="fas fa-comment"></i> Special Instructions:</span>
                <span><?php echo htmlspecialchars($special_instructions); ?></span>
            </div>
            <?php endif; ?>

            <div class="detail-row">
                <span><i class="fas fa-calendar"></i> Order Date:</span>
                <span><?php echo date('d M Y, H:i'); ?></span>
            </div>

            <div class="detail-row">
                <span><strong>Total Amount:</strong></span>
                <span><strong>₹999</strong></span>
            </div>
        </div>

        <div style="background: rgba(52, 152, 219, 0.1); padding: 20px; border-radius: 15px; margin: 20px 0;">
            <h4 style="color: #2980b9; margin-bottom: 10px;">
                <i class="fas fa-info-circle"></i> What's Next?
            </h4>
            <ul style="text-align: left; color: #2980b9;">
                <li>You'll receive a confirmation SMS shortly</li>
                <li>Our team will contact you within 24 hours</li>
                <li>Expected delivery: 3-5 business days</li>
                <li>Track your order using Order ID: <strong><?php echo $order_id; ?></strong></li>
            </ul>
        </div>

        <div class="action-buttons">
            <a href="track-order.php?id=<?php echo $order_id; ?>" class="btn-primary">
                <i class="fas fa-truck"></i> Track Order
            </a>
            <a href="index.php" class="btn-secondary">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>

        <div style="text-align: center; margin-top: 30px; color: #7f8c8d;">
            <p><i class="fas fa-heart" style="color: #e74c3c;"></i> Thank you for choosing us!</p>
            <p style="font-size: 12px;">
                Need help? Contact us at <strong>support@yourcompany.com</strong> or call <strong>+91-XXXXXXXXXX</strong>
            </p>
        </div>
    </div>
</body>
</html>