<?php
include("../db.php");
session_start();

if (!isset($_SESSION['prof_id'])) {
    echo "Session professor_id not set.";
    exit();
}

$sql = "SELECT tr.report_id, tr.test_report_date, tr.report
        FROM TestReport AS tr
        JOIN Patient AS pat ON pat.patient_id = tr.patient_id
        JOIN Professor AS prof ON prof.professor_id = pat.id
        WHERE prof.professor_id= '{$_SESSION['prof_id']}' AND pat.patient_id='{$_SESSION['patient_id']}'
        ORDER BY tr.test_report_date DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Report Records</title>
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
            width: 90%;
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
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<a href="prof_dashboard.php" class="center-btn">Back To Dashboard</a>
    <h1>Test Report Records</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Test Report ID</th>
                    <th>Date</th>
                    <th>Test Report Image</th>
                    <th>Download</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            $imageData = $row['report']; 
            $imageType = 'image/jpeg'; 
            $base64Image = base64_encode($imageData);
            $imageSrc = 'data:' . $imageType . ';base64,' . $base64Image; 
            $downloadLink = 'data:' . $imageType . ';base64,' . $base64Image;
            echo "<tr>
                    <td>" . htmlspecialchars($row['report_id']) . "</td>
                    <td>" . htmlspecialchars($row['test_report_date']) . "</td>
                    <td><img src='" . $imageSrc . "' alt='Test Report Image'></td>
                    <td><a href='" . $downloadLink . "' class='download-btn' download='test_report_" . $row['report_id'] . ".jpg'>Download</a></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-records'>No test report records found.</p>";
    }
    ?>

</body>

</html>
