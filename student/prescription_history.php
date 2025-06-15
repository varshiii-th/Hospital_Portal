<?php
include("../db.php");
session_start();

// Debug: check session
if (!isset($_SESSION['roll_no'])) {
    echo "Session roll number not set.";
    exit();
}


$sql = "SELECT p.prescription_id, p.prescription_date, d.doctor_id, d.name AS doctor_name, pd.morning,pd.afternoon,pd.night,
        pd.medicine_id, m.medicine_name, pd.quantity_req 
        FROM Prescription_Details AS pd
        JOIN Prescription AS p ON p.prescription_id = pd.prescription_id
        JOIN Medicine AS m ON m.medicine_id = pd.medicine_id
        JOIN Doctor AS d ON d.doctor_id = p.doctor_id
        JOIN Patient AS pat ON pat.patient_id = p.patient_id
        JOIN Student AS s ON s.roll_no = pat.id
        WHERE s.roll_no = '{$_SESSION['roll_no']}'
        ORDER BY p.prescription_date DESC";

$result = $conn->query($sql);

// Debug: check query error
if (!$result) {
    die("Query failed: " . $conn->error);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Prescription Details</title>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f1f2f6;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #2d3436;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }
    th, td {
        padding: 12px 20px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);

        color: white;
    }
    td {
        color: #2d3436;
    }
    tr:nth-child(even) {
        background-color: #f5f6fa;
    }
    tr:hover {
        background-color: #dfe6e9;
    }
    .no-records {
        text-align: center;
        font-size: 18px;
        color: #e74c3c;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .center-btn {
            display: block;
            width: fit-content;
            margin: 30px auto;
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
    background: linear-gradient(180deg,rgb(50, 82, 133) 0%,rgb(56, 84, 111) 100%);
    transform: translateY(-2px);
}
</style>
</head>
<body>
<a href="stu_dashboard.php" class="center-btn">Back To Dashboard</a>
<div class="container">
    <h1>Your Prescription Records</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Prescription ID</th>
                        <th>Date</th>
                        <th>Doctor Name</th>
                        <th>Medicine ID</th>
                        <th>Medicine Name</th>
                        <th>Quantity Required</th>
                        <th>Morning</th>
                        <th>Afternoon</th>
                        <th>Night</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $result->fetch_assoc()) {
            if($row['morning']){
                $mor='yes';
            }
            else{
                $mor='no';
            }
            if($row['afternoon']){
                $af='yes';
            }
            else{
                $af='no';
            }
        
            if($row['night']){
                $ni='yes';
            }
            else{
                $ni='no';
            }
            echo "<tr>
                    <td>" . htmlspecialchars($row['prescription_id']) . "</td>
                    <td>" . htmlspecialchars($row['prescription_date']) . "</td>
                    <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_id']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_name']) . "</td>
                    <td>" . htmlspecialchars($row['quantity_req']) . "</td>
                    <td>" . htmlspecialchars($mor) . "</td>
                <td>" . htmlspecialchars($af) . "</td>
                <td>" . htmlspecialchars($ni) . "</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p class='no-records'>No prescription records found.</p>";
    }
    ?>

</div>

</body>
</html>
