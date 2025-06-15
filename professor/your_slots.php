<?php
include("../db.php");
session_start();




$sql = "SELECT b.*
        FROM booking AS b 
        JOIN slots  AS sl ON b.slot_id=sl.slot_id
        WHERE b.patient_id = '{$_SESSION['patient_id']}' AND
        sl.slot_date>=CURDATE() 
        ";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Reports</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f2f6;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 2.5rem;
            color: #2d3436;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background: linear-gradient(135deg, #22a6b3, #0fb9b1);            color: #fff;
            font-size: 1.2rem;
        }

        td {
            background-color: #f7f7f7;
            font-size: 1rem;
        }

        img {
            max-width: 150px;
            height: auto;
            border-radius: 5px;
        }

        .no-records {
            text-align: center;
            font-size: 1.5rem;
            color: #e74c3c;
        }

        .download-btn {
            padding: 8px 16px;
            background-color: #0984e3;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 5px;
            text-decoration: none;
        }

        .download-btn:hover {
            background-color: #74b9ff;
        }
        .center-btn {
            display: block;
            width: fit-content;
            margin: 30px auto;
            text-align: center;
            padding: 12px 24px;
            background: linear-gradient(135deg, #22a6b3, #0fb9b1);            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 1rem;
            transition: 0.3s;
 }

.center-btn:hover {
    background: linear-gradient(135deg, #22a6b3,rgb(9, 219, 208));    transform: translateY(-2px);
}
    </style>
</head>
<body>
<a href="prof_dashboard.php" class="center-btn">Back To Dashboard</a>

    <h1>Your Slots</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Booking ID</th>
                    <th>Doctor_ID</th>
                    <th>Slot_Start_Time</th>
                    <th>Slot_End_Time</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
           echo"<tr>
                    <td>" . htmlspecialchars($row['booking_id']) . "</td>
                    <td>" . htmlspecialchars($row['doctor_id']) . "</td>
                    <td>" . htmlspecialchars($row['slot_start_time']) . "</td>
                    <td>" . htmlspecialchars($row['slot_end_time']) . "</td>

                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-records'>No slots booked.</p>";
    }
    ?>

</body>

</html>
