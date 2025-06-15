<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['tech_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

        $sql2 = "DELETE FROM testreport WHERE report_id = '$report_id' ";
        if ($conn->query($sql2) === TRUE) {
            echo "report deleted successfully!";
            header("Location:search_report.php");

        } else {
            echo "Error: " . $conn->error;
        }
    } 
?>