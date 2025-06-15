<?php
include("../db.php");
session_start();
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
            padding: 50px;
            margin: 0;
            color: #2c3e50;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            padding: 40px;
            background-color: #ffffff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        h1 {
            font-size: 2.5rem;
            color: #130f40;
            margin-bottom: 30px;
        }

        p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            color: #34495e;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="submit"] {
            padding: 14px 28px;
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            border: none;
            color: white;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: linear-gradient(135deg, #1a2a44 0%, #2c3e50 100%);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="dependent_login.php">Log out</a>
        <h1>WELCOME TO IITG HOSPITAL PORTAL</h1>
        <br>

        <?php
        $sql = "SELECT dependent_name FROM Professor_Dependent WHERE dependent_id = '{$_SESSION['dep_id']}'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo "<p>Welcome, <strong>" . htmlspecialchars($row['dependent_name']) . "</strong></p>";
        ?>
        <br>

        <form action='consult_docter.php' method='post'>
            <input type='submit' name='book_slot' value='Book Doctor Slot'>
        </form>

        <form action='avilable_medicines.php' method='post'>
            <input type='submit' name='view_available_medicines' value='Available Medicines'>
        </form>

        <form action='pd_prescription_history.php' method='get'>
            <input type='submit' name='view_prescription_history' value='Prescription History'>
        </form>

        <form action='pd_test_reports.php' method='post'>
            <input type='submit' name='view_test_reports' value='Test Reports'>
        </form>
        
        <form action="your_slots.php" method="post">
            <input type="submit" name="view_booked_slots" value="View Booked Slots">
        </form>
    </div>
</body>

</html>
