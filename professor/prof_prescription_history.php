<?php
include("../db.php");
session_start();

if (!isset($_SESSION['prof_id'])) {
    echo "Session professor_id not set.";
    exit();
}

$sql = "SELECT p.prescription_id, p.prescription_date, d.doctor_id, d.name AS doctor_name, pd.morning, pd.afternoon, pd.night,
        pd.medicine_id, m.medicine_name, pd.quantity_req 
        FROM Prescription_Details AS pd
        JOIN Prescription AS p ON p.prescription_id = pd.prescription_id
        JOIN Medicine AS m ON m.medicine_id = pd.medicine_id
        JOIN Doctor AS d ON d.doctor_id = p.doctor_id
        JOIN Patient AS pat ON pat.patient_id = p.patient_id
        JOIN Professor AS prof ON prof.professor_id = pat.id
        WHERE prof.professor_id = '{$_SESSION['prof_id']}' AND pat.patient_id='{$_SESSION['patient_id']}'
        ORDER BY p.prescription_date DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription Records</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f6f9fc, #dff9fb);
            padding: 30px;
            color: #2c3e50;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #130f40;
            font-size: 2.5rem;
        }

        table {
            width: 95%;
            margin: 30px auto;
            border-collapse: collapse;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 20px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        p {
            text-align: center;
            font-size: 1.1rem;
            color: #636e72;
        }

        .center-btn {
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
        }

        .center-btn:hover {
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            transform: translateY(-2px);
        }

    </style>
</head>
<body>
    <a href="prof_dashboard.php" class="center-btn">Back to Dashboard</a>
    <h1>Prescription Records</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Prescription ID</th>
                    <th>Date</th>
                    <th>Doctor Name</th>
                    <th>Medicine ID</th>
                    <th>Medicine Name</th>
                    <th>Morning</th>
                    <th>Afternoon</th>
                    <th>Night</th>
                    <th>Quantity Required</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['prescription_id']) . "</td>
                    <td>" . htmlspecialchars($row['prescription_date']) . "</td>
                    <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_id']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_name']) . "</td>
                    <td>" . htmlspecialchars($row['morning']) . "</td>
                    <td>" . htmlspecialchars($row['afternoon']) . "</td>
                    <td>" . htmlspecialchars($row['night']) . "</td>
                    <td>" . htmlspecialchars($row['quantity_req']) . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No prescription records found.</p>";
    }
    ?>

</body>
</html>
