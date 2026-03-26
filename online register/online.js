const otpConfig = window.onlineRegisterOtpConfig || {};
const sendOtpUrl = otpConfig.sendOtpUrl || "send_otp.php";
const verifyOtpUrl = otpConfig.verifyOtpUrl || "verify_otp.php";
const defaultCountryCode = "+251";

const registerForm = document.getElementById("register-form");
const usernameInput = document.getElementById("user-name");
const passwordInput = document.getElementById("user-password");
const confirmPasswordInput = document.getElementById("confirm-password");
const phoneInput = document.getElementById("phone-number");
const phoneHint = document.getElementById("phone-hint");
const otpInput = document.getElementById("otp-code");
const sendOtpButton = document.getElementById("send-otp-btn");
const verifyOtpButton = document.getElementById("verify-otp-btn");
const passwordHint = document.getElementById("password-hint");
const formStatus = document.getElementById("form-status");
const detailsSummaryItem = document.getElementById("details-summary-item");
const otpSentSummaryItem = document.getElementById("otp-sent-summary-item");
const phoneSummaryItem = document.getElementById("phone-summary-item");
const selectionSummaryItem = document.getElementById("selection-summary-item");
const processStep1 = document.getElementById("process-step-1");
const processStep2 = document.getElementById("process-step-2");
const processStep3 = document.getElementById("process-step-3");
const processStep4 = document.getElementById("process-step-4");
const processStep5 = document.getElementById("process-step-5");
const phoneVerifiedInput = document.getElementById("phone-verified");
const verifiedPhoneNumberInput = document.getElementById("verified-phone-number");

let otpSent = false;
let phoneVerified = false;
let isSendingOtp = false;
let isVerifyingOtp = false;

function setStatus(message, state) {
    formStatus.textContent = message;
    formStatus.className = `status-box ${state}`;
}

function setChecklistItem(element, message, completed) {
    element.textContent = message;
    element.className = completed ? "check-item success" : "check-item pending";
}

function setVerificationState(verified, phoneNumber = "") {
    phoneVerified = verified;
    phoneVerifiedInput.value = verified ? "1" : "0";
    verifiedPhoneNumberInput.value = phoneNumber;
}

function sanitizePhoneNumber(value) {
    return value.replace(/[^\d+]/g, "").replace(/(?!^)\+/g, "");
}

function normalizePhoneNumber(value) {
    const sanitized = sanitizePhoneNumber(value.trim());

    if (!sanitized) {
        return "";
    }

    if (sanitized.startsWith("+")) {
        return sanitized;
    }

    if (sanitized.startsWith("00")) {
        return `+${sanitized.slice(2)}`;
    }

    if (sanitized.startsWith("251")) {
        return `+${sanitized}`;
    }

    if (sanitized.startsWith("0")) {
        return `${defaultCountryCode}${sanitized.slice(1)}`;
    }

    if (/^9\d{8}$/.test(sanitized)) {
        return `${defaultCountryCode}${sanitized}`;
    }

    return sanitized;
}

function isValidPhoneNumber(phoneNumber) {
    return /^\+\d{9,15}$/.test(phoneNumber);
}

function updatePhoneHint(message, state) {
    phoneHint.textContent = message;
    phoneHint.className = `field-hint ${state}`;
}

function validatePasswordMatch() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    if (!password && !confirmPassword) {
        passwordHint.textContent = "Password and confirm password must be the same.";
        passwordHint.className = "field-hint pending";
        return false;
    }

    if (password.length < 6) {
        passwordHint.textContent = "Password must be at least 6 characters long.";
        passwordHint.className = "field-hint error";
        return false;
    }

    if (password !== confirmPassword) {
        passwordHint.textContent = "Password and confirm password do not match.";
        passwordHint.className = "field-hint error";
        return false;
    }

    passwordHint.textContent = "Password confirmation matched successfully.";
    passwordHint.className = "field-hint success";
    return true;
}

function readAndValidateForm() {
    const username = usernameInput.value.trim();
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    const phoneNumber = normalizePhoneNumber(phoneInput.value);

    if (!username) {
        setStatus("Enter the user name.", "error");
        return null;
    }

    if (!validatePasswordMatch()) {
        setStatus("Password and confirm password must match before sending OTP.", "error");
        return null;
    }

    if (!phoneNumber) {
        updatePhoneHint("Enter the phone number you want to receive the OTP on.", "error");
        setStatus("Enter the phone number.", "error");
        return null;
    }

    if (!isValidPhoneNumber(phoneNumber)) {
        updatePhoneHint("Use a valid phone number. Example: +2519XXXXXXXX, 09XXXXXXXX, or 9XXXXXXXX.", "error");
        setStatus("Enter a valid phone number before sending OTP.", "error");
        return null;
    }

    phoneInput.value = phoneNumber;
    updatePhoneHint(`OTP will be sent to ${phoneNumber}.`, "success");

    return { username, password, confirmPassword, phoneNumber };
}

function updateSummary() {
    const detailsValid = Boolean(
        usernameInput.value.trim() &&
        isValidPhoneNumber(normalizePhoneNumber(phoneInput.value)) &&
        validatePasswordMatch()
    );

    setChecklistItem(
        detailsSummaryItem,
        detailsValid ? "User name, matching password, and phone number are valid." : "Form details are not valid yet.",
        detailsValid
    );
    setChecklistItem(
        otpSentSummaryItem,
        otpSent ? "OTP has been sent to the phone number." : "OTP has not been sent yet.",
        otpSent
    );
    setChecklistItem(
        phoneSummaryItem,
        phoneVerified ? `Phone number ${verifiedPhoneNumberInput.value} verified successfully with OTP.` : "Phone number is not verified yet.",
        phoneVerified
    );
    setChecklistItem(
        selectionSummaryItem,
        phoneVerified ? "Ready to select college and department." : "College and department not selected yet.",
        phoneVerified
    );

    updateProcessSteps();
}

function updateProcessSteps() {
    const hasAccountInfo = usernameInput.value.trim().length > 0 && validatePasswordMatch();
    const hasOtpSent = otpSent;
    const hasPhoneVerified = phoneVerified;

    processStep1.className = hasAccountInfo ? "process-item success" : "process-item pending";
    processStep2.className = hasOtpSent || hasPhoneVerified ? "process-item success" : "process-item pending";
    processStep3.className = hasPhoneVerified ? "process-item success" : "process-item pending";

    updateFooterProgress(hasAccountInfo, hasPhoneVerified);
}

function updateFooterProgress(step1Complete, step2Complete) {
    const step1 = document.getElementById('footer-step-1');
    const step2 = document.getElementById('footer-step-2');
    const step3 = document.getElementById('footer-step-3');
    const connector1 = document.getElementById('connector-1');
    const connector2 = document.getElementById('connector-2');

    if (!step1 || !step2 || !step3 || !connector1 || !connector2) {
        return;
    }

    step1.className = step1Complete ? 'step-item completed' : 'step-item current';
    step2.className = step2Complete ? 'step-item completed' : 'step-item';
    step3.className = 'step-item';

    connector1.className = step1Complete ? 'connector active' : 'connector';
    connector2.className = step2Complete ? 'connector active' : 'connector';

    if (step2Complete) {
        step2.className = 'step-item current';
        step1.className = 'step-item completed';
    }

    // Step 3 will become current if step2 is complete and user remains on this page after verification.
    step3.className = step2Complete ? 'step-item current' : 'step-item';
}


function updateProgressBar(step1, step2, step3, step4, step5) {
    const steps = [step1, step2, step3, step4, step5];
    const progressFill = document.getElementById('progress-fill');
    const stepElements = [
        document.getElementById('step-1'),
        document.getElementById('step-2'),
        document.getElementById('step-3'),
        document.getElementById('step-4'),
        document.getElementById('step-5')
    ];
    const labelElements = [
        document.getElementById('label-1'),
        document.getElementById('label-2'),
        document.getElementById('label-3'),
        document.getElementById('label-4'),
        document.getElementById('label-5')
    ];

    let completedSteps = 0;
    steps.forEach((completed, index) => {
        if (completed) {
            completedSteps++;
            stepElements[index].className = 'step completed';
            labelElements[index].className = 'step-label completed';
        } else if (index === completedSteps) {
            stepElements[index].className = 'step current';
            labelElements[index].className = 'step-label current';
        } else {
            stepElements[index].className = 'step';
            labelElements[index].className = 'step-label';
        }
    });

    const progressPercent = (completedSteps / 5) * 100;
    progressFill.style.width = progressPercent + '%';
}

function resetOtpState(showMessage) {
    otpSent = false;
    setVerificationState(false, "");
    otpInput.value = "";
    otpInput.disabled = true;
    verifyOtpButton.disabled = true;
    sendOtpButton.disabled = false;
    isSendingOtp = false;
    isVerifyingOtp = false;

    if (showMessage) {
        setStatus("Form data changed. Send a new OTP for the updated phone number and details.", "pending");
    }

    updateSummary();
}

async function postJson(url, payload) {
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: new URLSearchParams(payload)
    });

    let data = null;
    try {
        const text = await response.text();
        data = JSON.parse(text);
    } catch (error) {
        data = null;
    }

    if (!response.ok || !data || data.success !== true) {
        const error = new Error((data && data.message) || `Request failed with status ${response.status}.`);
        error.payload = data;
        throw error;
    }

    return data;
}

function getDebugMessage(data) {
    if (!data || !data.debugOtp) {
        return "";
    }

    return ` Debug OTP: ${data.debugOtp}`;
}

[usernameInput, passwordInput, confirmPasswordInput, phoneInput].forEach((input) => {
    input.addEventListener("input", () => {
        validatePasswordMatch();

        if (input === phoneInput) {
            const normalizedPhone = normalizePhoneNumber(phoneInput.value);
            if (normalizedPhone && isValidPhoneNumber(normalizedPhone)) {
                updatePhoneHint(`OTP will be sent to ${normalizedPhone}.`, "success");
            } else {
                updatePhoneHint("Enter your own phone number. Local Ethiopian formats such as 09..., 9..., or 251... are converted automatically.", "pending");
            }
        }

        if (otpSent || phoneVerified) {
            resetOtpState(true);
        } else {
            updateSummary();
        }
    });
});

phoneInput.addEventListener("blur", () => {
    const normalizedPhone = normalizePhoneNumber(phoneInput.value);

    if (normalizedPhone) {
        phoneInput.value = normalizedPhone;
    }

    updateSummary();
});

sendOtpButton.addEventListener("click", async () => {
    if (isSendingOtp) {
        return;
    }

    const formData = readAndValidateForm();
    if (!formData) {
        updateSummary();
        return;
    }

    isSendingOtp = true;
    sendOtpButton.disabled = true;
    setStatus(`Sending OTP to ${formData.phoneNumber}...`, "pending");

    try {
        const response = await postJson(sendOtpUrl, formData);
        otpSent = true;
        setVerificationState(false, "");
        phoneInput.value = response.phoneNumber || formData.phoneNumber;
        otpInput.disabled = false;
        verifyOtpButton.disabled = false;
        setStatus(`${response.message}${getDebugMessage(response)}`, "success");
        updateSummary();
    } catch (error) {
        otpSent = false;
        setVerificationState(false, "");
        setStatus(error.message || "Unable to send OTP.", "error");
        updateSummary();
    } finally {
        isSendingOtp = false;
        sendOtpButton.disabled = false;
    }
});

verifyOtpButton.addEventListener("click", async () => {
    if (isVerifyingOtp) {
        return;
    }

    if (!otpSent) {
        setStatus("Send the OTP first before verifying the code.", "error");
        return;
    }

    const otpCode = otpInput.value.trim();
    if (!otpCode) {
        setStatus("Enter the OTP code from the phone.", "error");
        return;
    }

    const phoneNumber = normalizePhoneNumber(phoneInput.value);
    if (!isValidPhoneNumber(phoneNumber)) {
        setStatus("Enter a valid phone number before verifying OTP.", "error");
        return;
    }

    isVerifyingOtp = true;
    verifyOtpButton.disabled = true;
    setStatus("Verifying OTP code...", "pending");

    try {
        const response = await postJson(verifyOtpUrl, {
            phoneNumber,
            otpCode
        });
        setVerificationState(true, response.phoneNumber || phoneNumber);
        setStatus(response.message || "Phone number verified successfully.", "success");
        updateSummary();
        // Store session data
        const formData = readAndValidateForm();
        await postJson("store_session.php", {
            username: formData.username,
            password: formData.password,
            phone_number: formData.phoneNumber
        });
        // Redirect to college selection page
        window.location.href = "collage/departmentlist.php";
    } catch (error) {
        setVerificationState(false, "");
        setStatus(error.message || "OTP verification failed.", "error");
        updateSummary();
    } finally {
        isVerifyingOtp = false;
        verifyOtpButton.disabled = false;
    }
});

validatePasswordMatch();
updateSummary();
