<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['tech_id'])) {
    header("Location: login.php");
    exit();
}

$tech_id = $_SESSION["tech_id"];

$result_pending = $conn->query("SELECT report_id, patient_id, test_report_date, test_name, doctor_id FROM testreport WHERE report IS NULL ORDER BY test_report_date");

$result_completed = $conn->query("SELECT report_id, patient_id, test_report_date, test_name, doctor_id FROM testreport WHERE report IS NOT NULL ORDER BY test_report_date");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            position: relative; /* For positioning logout button */
        }

        /* Styling for the main heading */
        h1 {
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 30px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Container for Add Medicine and Search buttons to align side by side */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px; /* Space between buttons */
            margin: 20px 0;
        }

        /* Styling for the logout form at top-right */
        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        /* General button styling for a modern, interactive look */
        input[type="submit"] {
            border: none;
            padding: 12px 24px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        /* Specific styling for Add Medicine and Search buttons */
        .button-container input[type="submit"] {
            background-color: #3498db;
            color: white;
        }

        .button-container input[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .button-container input[type="submit"]:active {
            transform: translateY(0);
        }

        /* Specific styling for Logout button */
        .logout input[type="submit"] {
            background-color: #e74c3c;
            color: white;
        }

        .logout input[type="submit"]:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }

        .logout input[type="submit"]:active {
            transform: translateY(0);
        }

        /* Table styling for a clean and professional appearance */
        table {
            width: 80%;
            max-width: 800px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling for the "No medicines found" message */
        p {
            color: #e74c3c;
            font-size: 1.2em;
            font-weight: 500;
            margin-top: 20px;
            text-align: center;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 600px) {
            table {
                width: 100%;
            }

            th, td {
                padding: 10px;
                font-size: 0.9em;
            }

            h1 {
                font-size: 2em;
            }

            .button-container {
                flex-direction: column; /* Stack buttons vertically on small screens */
                align-items: center;
                gap: 10px;
            }

            input[type="submit"] {
                padding: 10px 20px;
                font-size: 0.9em;
            }

            .logout {
                top: 10px;
                right: 10px;
            }
        }
    </style>

</head>
<body>
    <form action="logout.php" class="logout" method="post">
        <input type="submit" name="Logout" value="Logout">
    </form>
    <h1>Technician Dashboard</h1>
    <div class="button-container">
        <form action="search_report.php" method="post">
            <input type="submit" name="search" value="Search Reports">
        </form>
    </div>

    <h2>Pending Test Requests</h2>
    <?php if ($result_pending->num_rows > 0): ?>
        <table>
            <tr>
                <th>Report ID</th>
                <th>Patient ID</th>
                <th>Test Name</th>
                <th>Doctor ID</th>
                <th>Report Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result_pending->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['report_id']) ?></td>
                    <td><?= htmlspecialchars($row['patient_id']) ?></td>
                    <td><?= htmlspecialchars($row['test_name']) ?></td>
                    <td><?= htmlspecialchars($row['doctor_id']) ?></td>
                    <td><?= htmlspecialchars($row['test_report_date']) ?></td>
                    <td><a href="add_report.php?report_id=<?= $row['report_id'] ?>">Add Report</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No pending test requests.</p>
    <?php endif; ?>

    <h2>Completed Reports</h2>
    <?php if ($result_completed->num_rows > 0): ?>
        <table>
            <tr>
                <th>Report ID</th>
                <th>Patient ID</th>
                <th>Test Name</th>
                <th>Doctor ID</th>
                <th>Report Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result_completed->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['report_id']) ?></td>
                    <td><?= htmlspecialchars($row['patient_id']) ?></td>
                    <td><?= htmlspecialchars($row['test_name']) ?></td>
                    <td><?= htmlspecialchars($row['doctor_id']) ?></td>
                    <td><?= htmlspecialchars($row['test_report_date']) ?></td>
                    <td><a href="view_report.php?id=<?= $row['report_id'] ?>">View Report</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No completed reports found.</p>
    <?php endif; ?>
</body>
</html>