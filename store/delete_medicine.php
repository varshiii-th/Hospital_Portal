<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];

if (isset($_GET['id'])) {
    $medicine_id = $_GET['id'];
    $sql = "SELECT store_id FROM store WHERE email = '$email' ";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $store_id = $row["store_id"];

        $sql2 = "DELETE FROM medicine WHERE store_id = '$store_id' AND medicine_id = '$medicine_id' ";
        if ($conn->query($sql2) === TRUE) {
            echo "Medicine deleted successfully!";
            header("Location:search_medicine.php");

        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "❌ Error: Store not found for email $email.";
    }
}
?>