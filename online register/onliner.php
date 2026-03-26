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
                <div class="process-item" id="process-step-5">
                    <span class="process-number">5</span>
                    <div>
                        <h3>Select College and Department</h3>
                        <p>Choose your college and department, then proceed with payment.</p>
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
                <label for="user-name">User name</label>
                <input type="text" id="user-name" name="username" placeholder="Enter user name" required>

                <label for="user-password">Password</label>
                <input type="password" id="user-password" name="password" placeholder="Enter password" required>

                <label for="confirm-password">Confirm password</label>
                <input type="password" id="confirm-password" name="confirmPassword" placeholder="Confirm password" required>
                <p class="field-hint pending" id="password-hint">Password and confirm password must be the same.</p>

                <label for="phone-number">Phone number</label>
                <input type="tel" id="phone-number" name="phone" placeholder="+2519XXXXXXXX or 09XXXXXXXX" required>
                <p class="field-hint pending" id="phone-hint">Enter your own phone number. Local Ethiopian formats such as <code>09...</code>, <code>9...</code>, or <code>251...</code> are converted automatically.</p>
                <?php if ($isDebugOtpMode): ?>
                <p class="field-hint pending">OTP sender is in local log mode. The generated code will be returned for testing until you configure a real SMS gateway in <code>otp_config.php</code>.</p>
                <?php endif; ?>
                <input type="hidden" id="phone-verified" name="phoneVerified" value="0">
                <input type="hidden" id="verified-phone-number" name="verifiedPhoneNumber" value="">

                <button type="button" class="primary-btn" id="send-otp-btn">Send OTP</button>

                <div class="otp-block">
                    <label for="otp-code">OTP code</label>
                    <div class="otp-row">
                        <input type="text" id="otp-code" name="otp" inputmode="numeric" placeholder="Enter OTP" disabled>
                        <button type="button" class="secondary-btn" id="verify-otp-btn" disabled>Verify OTP</button>
                    </div>
                </div>
            </form>

            <div class="status-box pending" id="form-status" aria-live="polite">
                Complete the form, make sure the passwords match, then send the OTP.
            </div>

            <div class="progress-box">
                <div class="check-item pending" id="details-summary-item">Form details are not valid yet.</div>
                <div class="check-item pending" id="otp-sent-summary-item">OTP has not been sent yet.</div>
                <div class="check-item pending" id="phone-summary-item">Phone number is not verified yet.</div>
                <div class="check-item pending" id="selection-summary-item">College and department not selected yet.</div>
            </div>
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
