<?php
// Fix session_start warning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user data from session
$customer_name = $_SESSION['session_customer_name'] ?? 'User';
$customer_email = $_SESSION['session_customer_email'] ?? '';
$mobile_number = $_SESSION['session_mobile_number'] ?? '';
$verification_time = date('d M Y, H:i:s');

// Mask mobile number for privacy
$masked_mobile = 'XXXXXX' . substr($mobile_number, -4);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ Verification Complete</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            padding: 0;
            overflow-x: hidden;
        }

        /* MODERN DASHBOARD CONTAINER */
        .dashboard-container {
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        /* TOP HEADER BAR */
        .header-bar {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            padding: 20px 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .header-title {
            color: white;
            font-size: 24px;
            font-weight: 700;
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 500;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(39, 174, 96, 0.2);
            color: #2ecc71;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid rgba(39, 174, 96, 0.3);
        }

        /* MAIN CONTENT AREA */
        .main-content {
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            align-items: start;
        }

        /* LEFT PANEL - Success Summary */
        .success-panel {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .success-icon-large {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 50px;
            color: white;
            animation: successPulse 2s ease-in-out infinite;
            box-shadow: 0 20px 40px rgba(39, 174, 96, 0.3);
        }

        @keyframes successPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .success-title {
            font-size: 28px;
            font-weight: 800;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .success-message {
            font-size: 16px;
            color: #7f8c8d;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .verified-badge {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(39, 174, 96, 0.3);
        }

        /* RIGHT PANEL - Details Dashboard */
        .details-dashboard {
            display: grid;
            grid-template-rows: auto auto auto auto;
            gap: 20px;
        }

        /* User Info Cards */
        .info-cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .info-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .info-card-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .info-card-label {
            color: #7f8c8d;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-card-value {
            color: #2c3e50;
            font-size: 18px;
            font-weight: 700;
            word-break: break-word;
        }

        /* Project Completion Card */
        .project-card {
            background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
            border-radius: 20px;
            padding: 30px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .project-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: projectGlow 4s ease-in-out infinite;
        }

        @keyframes projectGlow {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }

        .project-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .project-icon {
            font-size: 30px;
        }

        .project-title {
            font-size: 24px;
            font-weight: 800;
        }

        .project-description {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.95;
            position: relative;
            z-index: 2;
        }

        /* Security Features Grid */
        .security-features {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .security-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .security-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .security-title {
            color: #2c3e50;
            font-size: 20px;
            font-weight: 700;
        }

        .security-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .security-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: rgba(52, 152, 219, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(52, 152, 219, 0.1);
            transition: all 0.3s ease;
        }

        .security-item:hover {
            background: rgba(52, 152, 219, 0.1);
            transform: scale(1.02);
        }

        .security-item-icon {
            color: #27ae60;
            font-size: 18px;
        }

        .security-item-text {
            color: #2c3e50;
            font-size: 14px;
            font-weight: 600;
        }

        /* Action Buttons */
        .actions-panel {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .action-button {
            padding: 18px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #7f8c8d;
            border: 2px solid rgba(127, 140, 141, 0.2);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        /* Floating Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: floatParticle 12s ease-in-out infinite;
        }

        @keyframes floatParticle {
            0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg); opacity: 0.3; }
            25% { transform: translateY(-50px) translateX(30px) rotate(90deg); opacity: 1; }
            50% { transform: translateY(-100px) translateX(-30px) rotate(180deg); opacity: 0.7; }
            75% { transform: translateY(-50px) translateX(-60px) rotate(270deg); opacity: 1; }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header-bar {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .main-content {
                grid-template-columns: 1fr;
                padding: 20px;
                gap: 20px;
            }

            .info-cards-grid, .security-grid, .actions-panel {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .success-icon-large {
                width: 100px;
                height: 100px;
                font-size: 40px;
            }
        }

        @media (max-width: 480px) {
            .success-panel, .project-card, .security-features {
                padding: 20px;
            }

            .success-title {
                font-size: 24px;
            }

            .project-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Particles -->
    <div class="particles">
        <div class="particle" style="left: 10%; top: 20%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; top: 60%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 70%; top: 30%; animation-delay: 4s;"></div>
        <div class="particle" style="left: 80%; top: 70%; animation-delay: 6s;"></div>
        <div class="particle" style="left: 30%; top: 80%; animation-delay: 1s;"></div>
        <div class="particle" style="left: 90%; top: 40%; animation-delay: 3s;"></div>
    </div>

    <!-- MODERN DASHBOARD CONTAINER -->
    <div class="dashboard-container">
        <!-- TOP HEADER BAR -->
        <div class="header-bar">
            <div class="header-left">
                <div class="header-icon">2FA</div>
                <div>
                    <div class="header-title">Authentication System</div>
                    <div class="header-subtitle">Secure Mobile Verification</div>
                </div>
            </div>
            <div class="header-right">
                <div class="status-indicator">
                    <i class="fas fa-check-circle"></i>
                    Verification Complete
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT AREA -->
        <div class="main-content">
            <!-- LEFT PANEL - Success Summary -->
            <div class="success-panel">
                <div class="success-icon-large">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="success-title">Verification Successful</h1>
                <p class="success-message">
                    Hello <strong><?php echo htmlspecialchars($customer_name); ?></strong>!<br>
                    Your mobile number has been successfully verified and your account is now secure.
                </p>
                <div class="verified-badge">
                    <i class="fas fa-shield-check"></i>
                    Mobile Verified
                </div>
            </div>

            <!-- RIGHT PANEL - Details Dashboard -->
            <div class="details-dashboard">
                <!-- User Info Cards -->
                <div class="info-cards-grid">
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="info-card-label">Verified User</div>
                        </div>
                        <div class="info-card-value"><?php echo htmlspecialchars($customer_name); ?></div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-card-label">Email Address</div>
                        </div>
                        <div class="info-card-value"><?php echo htmlspecialchars($customer_email); ?></div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="info-card-label">Mobile Number</div>
                        </div>
                        <div class="info-card-value"><?php echo $masked_mobile; ?> <i class="fas fa-check-circle" style="color: #27ae60; margin-left: 8px;"></i></div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-card-label">Verification Time</div>
                        </div>
                        <div class="info-card-value"><?php echo $verification_time; ?></div>
                    </div>
                </div>

                <!-- Project Completion Card -->
                <div class="project-card">
                    <div class="project-header">
                        <div class="project-icon">🚀</div>
                        <div class="project-title">2FA Project Successfully Completed!</div>
                    </div>
                    <div class="project-description">
                        Two-Factor Authentication (2FA) with OTP SMS verification has been implemented 
                        and tested successfully. This secure system can be integrated into any application 
                        requiring mobile verification.
                    </div>
                </div>

                <!-- Security Features -->
                <div class="security-features">
                    <div class="security-header">
                        <div class="security-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="security-title">Security Features Implemented</div>
                    </div>
                    <div class="security-grid">
                        <div class="security-item">
                            <div class="security-item-icon">
                                <i class="fas fa-sms"></i>
                            </div>
                            <div class="security-item-text">SMS-based OTP verification</div>
                        </div>
                        <div class="security-item">
                            <div class="security-item-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="security-item-text">Secure session management</div>
                        </div>
                        <div class="security-item">
                            <div class="security-item-icon">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div class="security-item-text">Input validation & sanitization</div>
                        </div>
                        <div class="security-item">
                            <div class="security-item-icon">
                                <i class="fas fa-eye-slash"></i>
                            </div>
                            <div class="security-item-text">Mobile number masking</div>
                        </div>
                        <div class="security-item">
                            <div class="security-item-icon">
                                <i class="fas fa-plug"></i>
                            </div>
                            <div class="security-item-text">Secure API integration</div>
                        </div>
                        <div class="security-item">
                            <div class="security-item-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="security-item-text">HTTPS encryption</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="actions-panel">
                    <a href="index.html" class="action-button btn-primary">
                        <i class="fas fa-redo"></i>
                        Try Another Verification
                    </a>
                    <button onclick="window.close()" class="action-button btn-secondary">
                        <i class="fas fa-times"></i>
                        Close Window
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 MODERN DASHBOARD THEME LOADED!');
            console.log('✅ No duplicate success boxes');
            console.log('📱 Phone: <?php echo $masked_mobile; ?>');
            console.log('👤 User: <?php echo htmlspecialchars($customer_name); ?>');
            console.log('🎨 Modern dashboard design');
        });
    </script>
</body>
</html>