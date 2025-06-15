<?php
include '../db.php';
session_start();

if(!isset($_SESSION['doctor_email']) && !isset($_SESSION['doc_id'])){
    header("Location:doc_signup.php");
}
$doctor_email = $_SESSION['doctor_email'];
$doc_id = $_SESSION['doc_id'];

if(isset($_POST['available'])){
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $available_date = $_POST['available_date'];

    try {
        $conn->begin_transaction();

        $sql = "INSERT INTO slots (doctor_id, start_time, end_time, slot_date, available_from) 
                VALUES ('$doc_id','$start_time','$end_time','$available_date','$start_time')";
        $sql2 = "DELETE FROM slots WHERE doctor_id='$doc_id' AND slot_date < DATE_SUB(NOW(), INTERVAL 1 DAY)";

        if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
            echo "✅ Slot availability updated successfully";
            echo '<meta http-equiv="refresh" content="2;url=doc_dashboard.php">';
        }
        $conn->commit();
    }
    catch(mysqli_sql_exception $e){
        $conn->rollback();
        echo "Transaction failed: " . $e->getMessage();
        echo '<meta http-equiv="refresh" content="2;url=slot_available.php">';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Timings</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 20px;
        }

        h2, p {
            color: #2c3e50;
        }

        form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 320px;
        }

        label {
            font-size: 16px;
            color: #34495e;
        }

        input[type="time"],
        input[type="date"],
        input[type="submit"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        input[type="time"],
        input[type="date"] {
            background-color: #ecf0f1;
        }

        input[type="submit"] {
            background-color: #27ae60;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #219150;
            transform: translateY(-2px);
        }

        a {
            text-decoration: none;
            color: #fff;
            background-color: #34495e;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #2c3e50;
        }

        .message {
            color: #27ae60;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h2>Book Your Available Timings</h2>

<form action='slot_available.php' method='post'>
    <div>
        <label for="start_time">Start Time:</label>
        <input type='time' name='start_time' placeholder="start time" required>
    </div>

    <div>
        <label for="end_time">End Time:</label>
        <input type='time' name='end_time' required>
    </div>

    <div>
        <label for="available_date">Select Date:</label>
        <input type='date' name='available_date' required>
    </div>

    <input type='submit' name='available' value='I Am Available'>
</form>

<a href="doc_dashboard.php">Back to Dashboard</a>

</body>
</html>