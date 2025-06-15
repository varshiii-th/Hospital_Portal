<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['tech_id'])) {
    header("Location: login.php");
    exit();
}

$tech_id = $_SESSION["tech_id"];
$report_id = isset($_GET['report_id']) ? $_GET['report_id'] : null;

if ($report_id) {
    $sql = "SELECT patient_id, test_name, doctor_id FROM testreport WHERE report_id = '$report_id' AND report IS NULL";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $report = $result->fetch_assoc();
        $patient_id = $report['patient_id'];
    } else {
        echo "❌ Invalid or already completed test request.";
    }
} else {
    echo "❌ No test request selected.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {

    if (isset($_FILES["report"]) && $_FILES["report"]["error"] == 0) {
        $max_size = 5 * 1024 * 1024;
        $file_size = $_FILES["report"]["size"];
        $file_tmp = $_FILES["report"]["tmp_name"];
        $file_type = $_FILES["report"]["type"] ?: 'application/octet-stream';

        $allowed_types = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($file_type, $allowed_types)) {
            echo "❌ Only PDF, JPEG, and PNG files are allowed.";
        } elseif ($file_size > $max_size) {
            echo "❌ File size exceeds 5MB limit.";
        } else {
            $file_content = file_get_contents($file_tmp);
            if ($file_content === false) {
                echo "❌ Failed to read file.";
            } else {
                $today = date('Y-m-d');
                $sql = "UPDATE testreport SET test_report_date = ?, report = ?, file_type = ? WHERE report_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $today, $file_content, $file_type, $report_id);
                if ($stmt->execute()) {
                    echo "✅ Report uploaded successfully!";
                    header("Location: technician_dashboard.php");
                    exit();
                } else {
                    echo "❌ Database error: " . $conn->error;
                }
                $stmt->close();
            }
        }
    } else {
        echo "<p class='error'>❌ No file uploaded or upload error.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Test Report</title>
    <style>
        /* Paste the CSS code from the artifact here */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            font-size: 1.8em;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        input[type="submit"]:active {
            transform: translateY(0);
        }

        .dashboard-link {
            display: inline-block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
            font-size: 1em;
        }

        .dashboard-link:hover {
            text-decoration: underline;
        }

        .error {
            color: #e74c3c;
            font-size: 1.1em;
            font-weight: 500;
            margin: 10px 0;
        }

        .success {
            color: #2ecc71;
            font-size: 1.1em;
            font-weight: 500;
            margin: 10px 0;
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            h2 {
                font-size: 1.5em;
            }

            input[type="number"],
            input[type="file"],
            input[type="submit"] {
                font-size: 0.9em;
                padding: 8px;
            }

            .dashboard-link {
                font-size: 0.9em;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Test Report</h2>
        <?php if ($report_id ): ?>
            <form action="add_report.php?report_id=<?php echo htmlspecialchars($report_id); ?>" method="post" enctype="multipart/form-data">
                <input type="number" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>" readonly>
                <input type="file" name="report" accept=".pdf,.jpg,.jpeg,.png" required>
                <input type="submit" name="add" value="Add Report">
            </form>
        <?php endif; ?>
        <a href="technician_dashboard.php" class="dashboard-link">To Dashboard</a>
    </div>
</body>

</html>