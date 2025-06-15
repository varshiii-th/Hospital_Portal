<?php
include '../db.php';
session_start();
if(!isset($_SESSION['doctor_email']) && !isset($_SESSION['doc_id'])){
    header("Location:doc_signup.php");
}
$doctor_email = $_SESSION['doctor_email'];
$doc_id = $_SESSION['doc_id'];

if(isset($_POST['slot_available'])){
    header("Location:slot_available.php");
}

if(isset($_POST['display_patients'])){
    header("Location:display_patients.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 20px;
        }

        a {
            text-decoration: none;
            color: #fff;
            background-color: #34495e;
            padding: 10px 20px;
            border-radius: 6px;
            margin-bottom: 30px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #2c3e50;
        }

        form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 300px;
        }

        input[type="submit"] {
            padding: 14px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<a href='../index.php'>Back to Index Page</a>

<h2>Welcome Doctor</h2>

<form action='doc_dashboard.php' method='post'>
    <input type='submit' name='slot_available' value='Slot Available'>
    <input type='submit' name='display_patients' value='Display Patients'>
</form>

</body>
</html>