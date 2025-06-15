<?php
session_start();
require_once "db.php";

// Check if technician is logged in
if (!isset($_SESSION['tech_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid report ID.");
}

$report_id = $_GET['id'];

$sql = "SELECT report, file_type FROM TestReport WHERE report_id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $file_type = $row['file_type'];
    $is_image = strpos($file_type, 'image/') === 0;

    header("Content-Type: $file_type");
    header("Content-Disposition: " . ($is_image ? "inline" : "attachment") . "; filename=report_$report_id");
    header("Content-Length: " . strlen($row['report']));
    echo $row['report'];
} else {
    die("Report not found or unauthorized access.");
}

$stmt->close();
$conn->close();
?>