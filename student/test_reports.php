<?php
include("../db.php");
session_start();


if (!isset($_SESSION['roll_no'])) {
    echo "Session roll number not set.";
    exit();
}


$sql = "SELECT tr.report_id, tr.test_report_date, tr.report
        FROM TestReport AS tr
        JOIN Patient AS pat ON pat.patient_id = tr.patient_id
        JOIN Student AS s ON s.roll_no = pat.id
        WHERE s.roll_no = '{$_SESSION['roll_no']}'
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
            background: linear-gradient(135deg, #22a6b3, #0fb9b1);  
                      color: #fff;
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
<a href="stu_dashboard.php" class="center-btn">Back To Dashboard</a>

    <h1>Test Reports</h1>
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
