<?php
session_start();
ob_start();
$otpConfig = require __DIR__ . '/otp_config.php';
$smsDriver = $otpConfig['sms']['driver'] ?? 'log';
$isDebugOtpMode = $smsDriver === 'log' && !empty($otpConfig['sms']['debug_return_otp']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Register</title>
<link rel="stylesheet" href="online.css">
</head>
<body>
<main class="register-shell">
    <section class="intro-panel">
        <p class="eyebrow">Online Register</p>
        <h1>Complete the registration process with password check and phone OTP</h1>
        <p class="intro-copy">
            Fill in your account information carefully. Your password and confirm password must match before the system
            sends an OTP to your phone number. Registration is treated as verified only after the OTP code is confirmed.
        </p>

        <div class="process-card">
            <h2>How the process works</h2>
            <div class="process-list">
                <div class="process-item" id="process-step-1">
                    <span class="process-number">1</span>
                    <div>
                        <h3>Enter account details</h3>
                        <p>Add your user name, password, confirm password, and phone number.</p>
                    </div>
                </div>
                <div class="process-item" id="process-step-2">
                    <span class="process-number">2</span>
                    <div>
                        <h3>Validate your password</h3>
                        <p>The form checks that password and confirm password are the same before OTP can be sent.</p>
                    </div>
                </div>
                <div class="process-item" id="process-step-3">
                    <span class="process-number">3</span>
                    <div>
                        <h3>Send OTP to phone</h3>
                        <p>Use the phone number in international format, for example <code>+2519XXXXXXXX</code>.</p>
                    </div>
                </div>
                <div class="process-item" id="process-step-4">
                    <span class="process-number">4</span>
                    <div>
                        <h3>Verify the OTP code</h3>
                        <p>After the code is confirmed successfully, the phone number is marked as verified.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="form-panel">
        <div class="form-card">
            <p class="eyebrow">Applicant Form</p>
            <h2>Create your registration account</h2>

            <form id="register-form" class="register-form" novalidate>
                <div class="form-field">
                    <input type="text" id="user-name" name="username" placeholder=" " required>
                    <label for="user-name">User name</label>
                </div>

                <div class="form-field">
                    <input type="password" id="user-password" name="password" placeholder=" " required>
                    <label for="user-password">Password</label>
                </div>

                <div class="form-field">
                    <input type="password" id="confirm-password" name="confirmPassword" placeholder=" " required>
                    <label for="confirm-password">Confirm password</label>
                </div>
                <p class="field-hint pending" id="password-hint">Password and confirm password must be the same.</p>

                <div class="form-field">
                    <input type="tel" id="phone-number" name="phone" placeholder=" " required>
                    <label for="phone-number">Phone number</label>
                </div>
                <p class="field-hint pending" id="phone-hint">Enter your own phone number. Local Ethiopian formats such as <code>09...</code>, <code>9...</code>, or <code>251...</code> are converted automatically.</p>
                <input type="hidden" id="phone-verified" name="phoneVerified" value="0">
                <input type="hidden" id="verified-phone-number" name="verifiedPhoneNumber" value="">

                <button type="button" class="primary-btn" id="send-otp-btn">Send OTP</button>

                <div class="otp-block">
                    <div class="form-field otp-field">
                        <input type="text" id="otp-code" name="otp" inputmode="numeric" placeholder=" " disabled>
                        <label for="otp-code">OTP code</label>
                    </div>
                    <button type="button" class="secondary-btn" id="verify-otp-btn" disabled>Verify OTP</button>
                </div>
                <p class="field-hint otp-debug hidden" id="otp-debug"></p>
            </form>
        </div>
    </section>
</main>

<footer class="progress-footer">
    <div class="progress-container">
        <div class="step-item current" id="footer-step-1">1</div>
        <div class="connector" id="connector-1"></div>
        <div class="step-item" id="footer-step-2">2</div>
        <div class="connector" id="connector-2"></div>
        <div class="step-item" id="footer-step-3">3</div>
    </div>
</footer>

<script>
window.onlineRegisterOtpConfig = {
    sendOtpUrl: "send_otp.php",
    verifyOtpUrl: "verify_otp.php"
};
</script>
<script src="online.js?v=2"></script>
</body>
</html>
