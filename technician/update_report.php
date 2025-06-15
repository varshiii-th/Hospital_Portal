<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['tech_id'])) {
    header("Location: login.php");
    exit();
}

$tech_id = $_SESSION["tech_id"];
$report_id = isset($_GET['id']) ? $_GET['id'] : null;
$patient_id = '';
$error = '';
$success = '';

if ($report_id) {
    $sql = "SELECT patient_id, test_report_date, file_type FROM TestReport WHERE report_id = '$report_id' ";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $report = $result->fetch_assoc();
        $patient_id = $report['patient_id'];
    } else {
        $error = "❌ Invalid report ID.";
    }
} else {
    $error = "❌ No report ID provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $new_patient_id = $_POST["patient_id"];

    $sql1 = "SELECT patient_id FROM Patient WHERE patient_id = '$patient_id' ";
    $result = $conn->query($sql1);;
    
    if ($result->num_rows == 0) {
        $error = "❌ Invalid patient ID.";
    } else {
        $file_content = null;
        $file_type = null;

        if (isset($_FILES["report"]) && $_FILES["report"]["error"] == 0) {
            $max_size = 5 * 1024 * 1024; // 5MB
            $file_size = $_FILES["report"]["size"];
            $file_tmp = $_FILES["report"]["tmp_name"];
            $file_type = $_FILES["report"]["type"] ?: 'application/octet-stream';

            if ($file_size > $max_size) {
                $error = "❌ File size exceeds 5MB limit.";
            } else {
                $file_content = file_get_contents($file_tmp);
                if ($file_content === false) {
                    $error = "❌ Failed to read file.";
                }
            }
        }

        if (!$error) {
            if ($file_content === null) {
                $sql = "UPDATE TestReport SET patient_id = '$new_patient_id' WHERE report_id = '$report_id' ";
                $result2 = $conn->query($sql);
            } else {
                $sql = "UPDATE TestReport SET patient_id = '$new_patient_id', report = '$file_content', file_type = '$file_type' WHERE report_id = '$report_id' ";
                $result2 = $conn->query($sql);
            }

            if ($result2==TRUE) {
                $success = "✅ Report updated successfully!";
                header("Location: technician_dashboard.php");
                exit();
            } else {
                $error = "❌ Database error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Test Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .error {
            color: #e74c3c;
            margin: 10px 0;
        }
        .success {
            color: #2ecc71;
            margin: 10px 0;
        }
        .logout, .dashboard-link {
            display: inline-block;
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
        }
        .logout:hover, .dashboard-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Test Report</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if ($report_id && !$error): ?>
            <form action="update_report.php?id=<?php echo htmlspecialchars($report_id); ?>" method="post" enctype="multipart/form-data">
                <input type="number" name="patient_id" placeholder="Patient ID" value="<?php echo htmlspecialchars($patient_id); ?>" required>
                <input type="file" name="report">
                <input type="submit" name="update" value="Update Report">
            </form>
        <?php endif; ?>
        <a href="technician_dashboard.php" class="dashboard-link">To Dashboard</a>
    </div>
</body>
</html>