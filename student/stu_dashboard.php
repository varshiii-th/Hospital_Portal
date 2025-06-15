<?php
include("../db.php");
session_start();
if (!isset($_SESSION['patient_id']) && !isset($_SESSION['roll_no'])) {
    header('Location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITG Hospital Portal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f6f9fc, #dff9fb);
            margin: 0;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #2c3e50;
        }

        h1 {
            color: #130f40;
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .container p {
            font-size: 1.2rem;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .container form {
            margin: 15px 0;
        }

        .container input[type='submit'] {
            width: 100%;
            padding: 14px;
            font-size: 1.1rem;
            border: none;
            border-radius: 8px;
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .container input[type='submit']:hover {
            background: linear-gradient(180deg,rgb(45, 72, 115) 0%,rgb(34, 59, 84) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
        }

        .container input[type='submit']:active {
            transform: scale(0.98);
        }

        .logout-btn {
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-align: center;
            padding: 12px 24px;
            background: linear-gradient(135deg, #ff6b6b, #ff8e53);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 1rem;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #ff8e53, #ff6b6b);
            transform: translateY(-2px);
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 2rem;
            }

            .container {
                padding: 20px;
            }

            .container input[type='submit'] {
                font-size: 1rem;
                padding: 12px;
            }

            .logout-btn {
                font-size: 0.9rem;
                padding: 10px 20px;
            }
        }
    </style>
</head>

<body>
    <a href="login.php" class="logout-btn">Logout</a>
    <div class="container">
        <h1>WELCOME TO IITG HOSPITAL PORTAL</h1>
        <p>
            <?php
            $sql = "SELECT student_name FROM student WHERE roll_no = '{$_SESSION['roll_no']}'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo htmlspecialchars($row['student_name']);
            ?>
        </p>

        <form action="consult_docter.php" method="post">
            <input type="submit" name="book_slot" value="Book Doctor Slot">
        </form>

        <form action="avilable_medicines.php" method="post">
            <input type="submit" name="view_available_medicines" value="Available Medicines">
        </form>

        <form action="prescription_history.php" method="get">
            <input type="submit" name="view_prescription_history" value="Prescription History">
        </form>

        <form action="test_reports.php" method="post">
            <input type="submit" name="view_test_reports" value="Test Reports">
            </form>
        <form action="your_slots.php" method="post">
            <input type="submit" name="view_booked_slots" value="View Booked Slots">
        
    </div>
</body>

</html>