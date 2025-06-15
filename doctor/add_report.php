<?php
session_start();
include('../db.php');

if(!isset($_SESSION['doc_id']) && !isset($_SESSION['patient_id'])){
    header('Location:doc_login.php');
}
$doc_id=$_SESSION['doc_id'];
$patient_id=$_SESSION['patient_id'];
$test_name=$_SESSION['test_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Test</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .message-box {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            text-align: center;
        }

        .success {
            color: #2ecc71;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .error {
            color: #e74c3c;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .redirect-note {
            color: #555;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="message-box">
<?php
try {
    $conn->begin_transaction();
    $sql = "INSERT INTO testreport (patient_id,test_name,doctor_id)
            VALUES ('$patient_id','$test_name','$doc_id')";
    $conn->query($sql);
    $conn->commit();

    echo "<div class='success'>".htmlspecialchars($test_name). "booked successfully ✅</div>";
    echo "<div class='redirect-note'>Redirecting to patient list in 2 seconds...</div>";
    echo '<meta http-equiv="refresh" content="2;url=display_patients.php">';
} catch (mysqli_sql_exception $e) {
    $conn->rollback();
    echo "<div class='error'>Transaction failed: ".$e->getMessage()."</div>";
}
?>
</div>

</body>
</html>