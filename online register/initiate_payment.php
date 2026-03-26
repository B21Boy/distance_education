<?php
session_start();
include '../connection.php';
$config = include 'otp_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get form data
$department_code = trim($_POST['department_code'] ?? '');
$department_name = trim($_POST['department_name'] ?? '');
$semester_fee = floatval($_POST['semester_fee'] ?? 0);

// Validate
if (empty($department_code) || empty($department_name) || $semester_fee <= 0) {
    echo json_encode(['error' => 'Invalid department data']);
    exit;
}

// Use session data
$username = $_SESSION['username'] ?? '';
$password = $_SESSION['password'] ?? '';
$phone_number = $_SESSION['phone_number'] ?? '';

if (empty($username) || empty($phone_number)) {
    echo json_encode(['error' => 'Session expired']);
    exit;
}

// Generate unique tx_ref
$tx_ref = 'reg_' . time() . '_' . rand(1000, 9999);

// Prepare Chapa payload
$payload = [
    'amount' => $semester_fee,
    'currency' => $config['chapa']['currency'],
    'email' => $username . '@temp.com', // Dummy email
    'first_name' => $username,
    'last_name' => 'User',
    'phone_number' => $phone_number,
    'tx_ref' => $tx_ref,
    'callback_url' => $config['chapa']['callback_url'] . '?tx_ref=' . $tx_ref,
    'return_url' => $config['chapa']['return_url'] . '?tx_ref=' . $tx_ref,
    'customization' => [
        'title' => 'Dept Reg',
        'description' => 'Payment for ' . $department_name . ' semester fee'
    ]
];

// Insert into database
$stmt = $conn->prepare("INSERT INTO applicant_payments (tx_ref, amount, currency, phone_number, email, first_name, last_name, department_code, department_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sdsssssss", $tx_ref, $payload['amount'], $payload['currency'], $phone_number, $payload['email'], $payload['first_name'], $payload['last_name'], $department_code, $department_name);
if (!$stmt->execute()) {
    echo json_encode(['error' => 'Database error']);
    exit;
}
$stmt->close();

// Make API call to Chapa
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $config['chapa']['api_base_url'] . '/transaction/initialize');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $config['chapa']['secret_key'],
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    // Update status to failed
    $conn->query("UPDATE applicant_payments SET status='failed' WHERE tx_ref='$tx_ref'");
    echo json_encode(['error' => 'Payment initialization failed']);
    exit;
}

$data = json_decode($response, true);
if (!$data || !isset($data['data']['checkout_url'])) {
    $conn->query("UPDATE applicant_payments SET status='failed' WHERE tx_ref='$tx_ref'");
    echo json_encode(['error' => 'Invalid response from payment gateway']);
    exit;
}

// Store form data in session
$_SESSION['department_code'] = $department_code;
$_SESSION['department_name'] = $department_name;
$_SESSION['semester_fee'] = $semester_fee;
$_SESSION['tx_ref'] = $tx_ref;

echo json_encode(['checkout_url' => $data['data']['checkout_url']]);

$conn->close();
?>