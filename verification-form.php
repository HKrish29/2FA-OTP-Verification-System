<?php
// Make sure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user details from session
$mobile_number = $_SESSION['session_mobile_number'] ?? 'XXXXXXXXXX';
$customer_name = $_SESSION['session_customer_name'] ?? 'User';
$otp = $_SESSION['session_otp'] ?? '000000';

// Mask mobile number for privacy (show only last 4 digits)
$masked_mobile = 'XXXXXX' . substr($mobile_number, -4);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - Secure Login</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Additional styles for verification page */
        .otp-display {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); }
            50% { box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5); }
            100% { box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); }
        }

        .otp-code {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 8px;
            margin: 10px 0;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .mobile-info {
            background: rgba(39, 174, 96, 0.1);
            border: 2px solid rgba(39, 174, 96, 0.2);
            border-radius: 12px;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
            color: #27ae60;
            font-weight: 500;
        }

        .otp-input-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 25px 0;
        }

        .otp-digit {
            width: 50px;
            height: 50px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            outline: none;
        }

        .otp-digit:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: scale(1.05);
        }

        .timer {
            text-align: center;
            color: #e74c3c;
            font-weight: 600;
            margin: 15px 0;
            font-size: 14px;
        }

        .resend-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .resend-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .verification-tips {
            background: rgba(52, 152, 219, 0.1);
            border: 2px solid rgba(52, 152, 219, 0.2);
            border-radius: 12px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #2980b9;
        }

        .tips-list {
            margin: 10px 0 0 0;
            padding-left: 20px;
        }

        .tips-list li {
            margin: 5px 0;
        }

        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #27ae60;
            font-size: 12px;
            margin-top: 15px;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .step.completed {
            background: #27ae60;
            color: white;
        }

        .step.active {
            background: #667eea;
            color: white;
        }

        .step.pending {
            background: #bdc3c7;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <!-- Particle background -->
    <div class="particles">
        <div class="particle" style="left: 15%; animation-delay: 0s; width: 4px; height: 4px;"></div>
        <div class="particle" style="left: 25%; animation-delay: 1s; width: 6px; height: 6px;"></div>
        <div class="particle" style="left: 35%; animation-delay: 2s; width: 3px; height: 3px;"></div>
        <div class="particle" style="left: 45%; animation-delay: 3s; width: 5px; height: 5px;"></div>
        <div class="particle" style="left: 55%; animation-delay: 4s; width: 4px; height: 4px;"></div>
        <div class="particle" style="left: 65%; animation-delay: 5s; width: 7px; height: 7px;"></div>
        <div class="particle" style="left: 75%; animation-delay: 0.5s; width: 3px; height: 3px;"></div>
        <div class="particle" style="left: 85%; animation-delay: 1.5s; width: 5px; height: 5px;"></div>
    </div>

    <!-- Main container -->
    <div class="container">
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step completed">
                <i class="fas fa-check"></i>
            </div>
            <div class="step active">2</div>
            <div class="step pending">3</div>
        </div>

        <h1 class="form-title">🔐 Verify OTP</h1>
        <p class="form-subtitle">Enter the 6-digit code sent to your mobile</p>

        <!-- Mobile Info -->
        <div class="mobile-info">
            <i class="fas fa-mobile-alt"></i>
            <strong>OTP sent to:</strong> <?php echo $masked_mobile; ?>
        </div>

        <!-- Development OTP Display (Remove in production) -->
        <div class="otp-display">
            <div style="font-size: 14px; opacity: 0.9;">🚨 Development Mode - OTP Code:</div>
            <div class="otp-code"><?php echo $otp; ?></div>
            <div style="font-size: 12px; opacity: 0.8;">⚠️ Remove this in production!</div>
        </div>

        <!-- Error message -->
        <div class="error" id="errorMessage"></div>

        <!-- Success message -->
        <div class="success" id="successMessage"></div>

        <!-- OTP Verification Form -->
        <form id="verifyForm" method="POST" action="controller.php">
            <input type="hidden" name="action" value="verify_otp">

            <!-- OTP Input Fields -->
            <div class="input-group">
                <label for="otp" style="margin-bottom: 10px; display: block; font-weight: 600; color: #2c3e50;">
                    <i class="fas fa-shield-alt"></i> Enter OTP Code
                </label>
                <div class="otp-input-group">
                    <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" autocomplete="off">
                    <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" autocomplete="off">
                    <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" autocomplete="off">
                    <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" autocomplete="off">
                    <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" autocomplete="off">
                    <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" autocomplete="off">
                </div>
                <input type="hidden" name="otp" id="fullOtp">
            </div>

            <!-- Timer -->
            <div class="timer" id="timer">
                ⏰ OTP expires in: <span id="countdown">05:00</span>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btnSubmit" id="verifyOtpBtn">
                <i class="fas fa-check-circle"></i>
                <span>Verify OTP</span>
            </button>

            <!-- Resend OTP -->
            <div style="text-align: center; margin-top: 20px;">
                <span style="color: #7f8c8d;">Didn't receive the code?</span>
                <a href="#" class="resend-link" onclick="resendOtp(); return false;">
                    <i class="fas fa-redo"></i> Resend OTP
                </a>
            </div>
        </form>

        <!-- Verification Tips -->
        <div class="verification-tips">
            <strong><i class="fas fa-lightbulb"></i> Verification Tips:</strong>
            <ul class="tips-list">
                <li>Check your SMS inbox for the 6-digit code</li>
                <li>The OTP is valid for 5 minutes only</li>
                <li>Enter the code without spaces or dashes</li>
                <li>Contact support if you don't receive the code</li>
            </ul>
        </div>

        <!-- Security Badge -->
        <div class="security-badge">
            <i class="fas fa-lock"></i>
            <span>Secured with 256-bit encryption</span>
        </div>

        <div class="form-footer">
            <p>Secure OTP verification system</p>
            <p><a href="#" onclick="return false;">Privacy Policy</a> | <a href="#" onclick="return false;">Terms of Service</a></p>
        </div>
    </div>

    <script>
        // OTP Input Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-digit');
            const fullOtpInput = document.getElementById('fullOtp');
            const verifyBtn = document.getElementById('verifyOtpBtn');
            const form = document.getElementById('verifyForm');

            // Handle OTP input
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;

                    // Only allow numbers
                    if (!/[0-9]/.test(value)) {
                        e.target.value = '';
                        return;
                    }

                    // Move to next input
                    if (value && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }

                    // Update full OTP
                    updateFullOtp();
                });

                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').slice(0, 6);

                    if (/^[0-9]+$/.test(pastedData)) {
                        [...pastedData].forEach((digit, i) => {
                            if (otpInputs[i]) {
                                otpInputs[i].value = digit;
                            }
                        });
                        updateFullOtp();

                        // Focus last filled input
                        const lastIndex = Math.min(pastedData.length - 1, otpInputs.length - 1);
                        otpInputs[lastIndex].focus();
                    }
                });
            });

            function updateFullOtp() {
                const otp = Array.from(otpInputs).map(input => input.value).join('');
                fullOtpInput.value = otp;

                // Enable/disable verify button
                if (otp.length === 6) {
                    verifyBtn.disabled = false;
                    verifyBtn.style.opacity = '1';
                } else {
                    verifyBtn.disabled = true;
                    verifyBtn.style.opacity = '0.6';
                }
            }

            // Form submission with loading effect
            form.addEventListener('submit', function(e) {
                if (fullOtpInput.value.length !== 6) {
                    e.preventDefault();
                    showError('Please enter complete 6-digit OTP');
                    return;
                }

                verifyBtn.classList.add('loading');
                verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Verifying...</span>';
            });

            // Countdown timer
            let timeLeft = 300; // 5 minutes
            const countdown = document.getElementById('countdown');

            const timer = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                countdown.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    countdown.textContent = '00:00';
                    showError('OTP has expired. Please request a new one.');
                }
            }, 1000);

            // Focus first input
            otpInputs[0].focus();
        });

        // Resend OTP function
        function resendOtp() {
            showSuccess('New OTP has been sent to your mobile number');
            // You can add actual resend logic here
        }

        // Error/Success message functions
        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }

        function showSuccess(message) {
            const successDiv = document.getElementById('successMessage');
            successDiv.textContent = message;
            successDiv.style.display = 'block';
            setTimeout(() => {
                successDiv.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>