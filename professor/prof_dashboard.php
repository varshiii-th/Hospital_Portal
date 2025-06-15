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
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f7;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 20px;
        }

        h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 40px;
            text-align: center;
        }

        .welcome-msg {
            font-size: 1.3rem;
            color: #34495e;
            margin-bottom: 30px;
            text-align: center;
        }

        form {
            margin: 12px 0;
            display: flex;
            justify-content: center;
        }

        input[type="submit"] {
            padding: 14px 26px;
            font-size: 1rem;
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            border: none;
            color: #fff;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            min-width: 220px;
        }

        input[type="submit"]:hover {
            
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-align: center;
            padding: 12px 24px;
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);

            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 1rem;
            transition: 0.3s;
        

            transform: translateY(-2px);
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
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
    </style>
</head>

<body>
    <a class='logout-btn'href="prof_login.php">Logout</a>
    <h1>WELCOME TO IITG HOSPITAL PORTAL</h1>

    <div class="welcome-msg">
        <?php
        $sql = "SELECT professor_name, sex FROM Professor WHERE professor_id = '{$_SESSION['prof_id']}'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "" . htmlspecialchars($row['professor_name']);
        } else {
            echo "Invalid user.";
        }
        ?>
    </div>

    <div class="button-group">
        <form action='consult_doctor.php' method='post'>
            <input type='submit' name='book_slot' value='Book Doctor Slot'>
        </form>

        <form action='available_medicines.php' method='post'>
            <input type='submit' name='view_available_medicines' value='Available Medicines'>
        </form>

        <form action='prof_prescription_history.php' method='get'>
            <input type='submit' name='view_prescription_history' value='Prescription History'>
        </form>

        <form action='prof_test_reports.php' method='post'>
            <input type='submit' name='view_test_reports' value='Test Reports'>
        </form>
        <form action="your_slots.php" method="post">
            <input type="submit" name="view_booked_slots" value="View Booked Slots">
        </form>
    </div>
</body>

</html>
