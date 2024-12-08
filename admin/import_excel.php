<?php
require '../vendor/autoload.php'; // Include PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

$response = ['status' => 'error', 'message' => 'An error occurred.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];

// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        $response['message'] = "Connection failed: " . $conn->connect_error;
        echo json_encode($response);
        exit();
    }

    try {
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        // Assuming the first row is the header
        $header = $sheetData[0];
        unset($sheetData[0]); // Remove header row

        // Map Excel columns to database fields
        $columnMapping = [
            'Student ID' => 'student_id',
            'First Name' => 'fname',
            'Middle Name' => 'mname',
            'Last Name' => 'lname',
            'Course' => 'course'
        ];

        $validEntries = 0;
        $invalidEntries = 0;
        $duplicateEntries = 0;

        foreach ($sheetData as $row) {
            $data = [];
            foreach ($header as $index => $columnName) {
                if (isset($columnMapping[$columnName])) {
                    $dbField = $columnMapping[$columnName];
                    $data[$dbField] = $row[$index];
                }
            }

            // Validate student ID format
            if (preg_match('/^\d{4}-\d{4}$/', $data['student_id'])) {
                // Check for duplicate
                $checkStmt = $conn->prepare("SELECT COUNT(*) FROM student WHERE student_id = ?");
                $checkStmt->bind_param("s", $data['student_id']);
                $checkStmt->execute();
                $checkStmt->bind_result($count);
                $checkStmt->fetch();
                $checkStmt->close();

                if ($count == 0) {
                    // Insert into database
                    $stmt = $conn->prepare("INSERT INTO student (student_id, fname, mname, lname, course, request_status) VALUES (?, ?, ?, ?, ?, 'Pending')");
                    $stmt->bind_param("sssss", $data['student_id'], $data['fname'], $data['mname'], $data['lname'], $data['course']);
                    $stmt->execute();
                    $validEntries++;
                } else {
                    $duplicateEntries++;
                }
            } else {
                $invalidEntries++;
            }
        }

        // Determine the status based on the results
        if ($duplicateEntries > 0) {
            $response['status'] = 'warning';
            $response['message'] = "Import completed with duplicates. Valid entries: $validEntries. Invalid entries: $invalidEntries. Duplicate entries: $duplicateEntries.";
        } else {
            $response['status'] = 'success';
            $response['message'] = "Import completed successfully. Valid entries: $validEntries. Invalid entries: $invalidEntries.";
        }
    } catch (Exception $e) {
        $response['message'] = "Error loading file: " . $e->getMessage();
    }

    $conn->close();
}

echo json_encode($response);
?>