<?php

session_start();
require_once '../vendor/autoload.php';

$servername = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';
$dbname = 'u510162695_judging';

define('INFOBIP_API_KEY', '3877508f2b1527cde7f31af0c90b76f9-5c737222-a3dd-4830-9839-39f1abad18a9');
define('INFOBIP_SENDER', 'AdminPanel');
define('INFOBIP_BASE_URL', 'https://api.infobip.com');

// Set headers for JSON response
header('Content-Type: application/json');

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

function sendInfobipSMS($to, $message) {
    $curl = curl_init();
    $headers = [
        'Authorization: App ' . INFOBIP_API_KEY,
        'Content-Type: application/json',
        'Accept: application/json'
    ];

    $postData = [
        'messages' => [[
            'from' => INFOBIP_SENDER,
            'destinations' => [
                ['to' => $to]
            ],
            'text' => $message
        ]]
    ];

    curl_setopt_array($curl, [
        CURLOPT_URL => INFOBIP_BASE_URL . '/sms/2/text/advanced',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => $headers
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    return $err ? false : true;
}

function generateCode() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phoneNumber = $_POST['phone'] ?? '';

    if (empty($phoneNumber)) {
        echo json_encode(['success' => false, 'message' => 'Please enter your phone number']);
        exit;
    }

    // Format phone number (add country code if needed)
    if (!preg_match('/^\+/', $phoneNumber)) {
        $phoneNumber = '+63' . ltrim($phoneNumber, '0'); // Adding Philippines country code
    }

    // Generate new verification code
    $code = generateCode();

    // Update the code field in the admin table
    $stmt = $conn->prepare("UPDATE admin SET code = ? WHERE id = 1");
    $stmt->bind_param("s", $code);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to generate verification code']);
        exit;
    }

    // Send SMS with the stored code
    $message = "Your Admin Panel verification code is: {$code}";
    if (sendInfobipSMS($phoneNumber, $message)) {
        echo json_encode(['success' => true, 'message' => 'Verification code sent']);
    } else {
        // If SMS fails, clear the code
        $stmt = $conn->prepare("UPDATE admin SET code = '' WHERE id = 1");
        $stmt->execute();
        echo json_encode(['success' => false, 'message' => 'Failed to send SMS']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();