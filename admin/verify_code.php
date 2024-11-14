<?php
// admin/verify_code.php

require 'dbcon.php';

function generateToken($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $token;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = implode('', $_POST['code']);
    try {
        $stmt = $conn->prepare("SELECT email, code FROM admin WHERE code = :code");
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $newToken = generateToken();
            $updateStmt = $conn->prepare("UPDATE admin SET token = :token WHERE email = :email");
            $updateStmt->bindParam(':token', $newToken);
            $updateStmt->bindParam(':email', $result['email']);
            $updateStmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Verification successful. Redirecting...', 'token' => $newToken]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid verification code.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>