<?php
include("../db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['slot_id']) && !empty($_POST['doctor_id'])) {
    $slot = $_POST['slot_id'];
    $doctor = $_POST['doctor_id'];
    $patient = $_SESSION['patient_id'];
    $time2 = strtotime($_POST['start_time']);
    $time1 = strtotime($_POST['end_time']);
    $time3 = strtotime($_POST['available_from']);
    $now = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
    $curr_time = strtotime($now->format("H:i:s"));
    $time2s = $_POST['start_time'];
    $time1s = $_POST['end_time'];
    $time3s = $_POST['available_from'];
    $curr_times = $now->format("H:i:s");

    if ($curr_time < $time3) {
        $diffInSeconds = $time1 - $time3;
        $total = floor($diffInSeconds / 60);
        if ($total >= 10) {
            $sql3 = "INSERT INTO Booking (doctor_id, patient_id, slot_id,slot_start_time,slot_end_time)
                     VALUES ('$doctor', '$patient', '$slot','$time3s',ADDTIME('$time3s', '00:10:00'))";
            $sql4 = "UPDATE slots SET available_from = ADDTIME('$time3s', '00:10:00') WHERE slot_id = '$slot'";
            if ($conn->query($sql3) === TRUE && $conn->query($sql4) === TRUE) {
                echo "<p class='success-msg'>Slot booked successfully!</p>";
            } else {
                echo "<p class='error-msg'>Error booking slot: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='error-msg'>Not enough time to book the slot. Minimum 10 minutes required.</p>";
        }
    } elseif ($curr_time >= $time3 && $curr_time <= $time1) {
        $diffInSeconds = $time1 - $curr_time;
        $total = floor($diffInSeconds / 60);
        if ($total >= 10) {
            $sql3 = "INSERT INTO Booking (doctor_id, patient_id, slot_id,slot_start_time,slot_end_time)
                     VALUES ('$doctor', '$patient', '$slot','$curr_times',ADDTIME('$curr_times', '00:10:00'))";
            $sql4 = "UPDATE slots SET available_from = ADDTIME('$curr_times', '00:10:00') WHERE slot_id = '$slot'";
            if ($conn->query($sql3) === TRUE && $conn->query($sql4) === TRUE) {
                echo "<p class='success-msg'>Slot booked successfully!</p>";
            } else {
                echo "<p class='error-msg'>Error booking slot: " . $conn->error . "</p>";
            }
        }
    }
}

$sql = "SELECT  
            d.doctor_id, 
            d.name AS doctor_name, 
            d.doctor_type, 
            d.doctor_photo, 
            s.slot_id, 
            s.start_time, 
            s.end_time,
            s.available_from,
            s.slot_date
        FROM 
            Slots AS s
        JOIN 
            Doctor AS d ON d.doctor_id = s.doctor_id
        WHERE  
            s.slot_date = CURDATE() 
            AND s.end_time > NOW()
        ORDER BY 
            s.slot_date, s.start_time";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Slot Booking</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f7;
            padding: 30px;
            color: #34495e;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.3rem;
            color: #2c3e50;
        }

        table {
            width: 95%;
            margin: 0 auto 40px;
            border-collapse: collapse;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 20px;
            text-align: center;
            border-bottom: 1px solid #ecf0f1;
        }

        th {
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            color: #fff;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        img {
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        input[type="submit"] {
            padding: 10px 18px;
            font-size: 0.95rem;
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            border: none;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            transform: translateY(-2px);
        }

        .success-msg {
            text-align: center;
            color: #27ae60;
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .error-msg {
            text-align: center;
            color: #c0392b;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 20px;
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
<a href="prof_dashboard.php" class="center-btn">Back to Dashboard</a>
    <h1>Available Doctor Slots - Book Yours</h1>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Slot ID</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Available From</th>
                    <th>Doctor ID</th>
                    <th>Doctor Name</th>
                    <th>Doctor Type</th>
                    <th>Photo</th>
                    <th>Book</th>
                </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['slot_id']) . "</td>
                            <td>" . htmlspecialchars($row['slot_date']) . "</td>
                            <td>" . htmlspecialchars($row['start_time']) . "</td>
                            <td>" . htmlspecialchars($row['end_time']) . "</td>
                            <td>" . htmlspecialchars($row['available_from']) . "</td>
                            <td>" . htmlspecialchars($row['doctor_id']) . "</td>
                            <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                            <td>" . htmlspecialchars($row['doctor_type']) . "</td>
                            <td>";   
                    if (!empty($row['doctor_photo'])) {
                        $imageData = $row['doctor_photo'];
                        $imageType = 'image/jpeg';  // or 'image/png' if that's what you're storing
                        $base64Image = base64_encode($imageData);
                        $imageSrc = 'data:' . $imageType . ';base64,' . $base64Image;
                        echo "<img src='" . $imageSrc . "' width='70' height='70' alt='Doctor Photo'>";
                    } else {
                        echo "<span>No Photo</span>";
                    }
                    echo "</td>
                          <td>
                              <form method='post'>
                                  <input type='hidden' name='slot_id' value='" . htmlspecialchars($row['slot_id']) . "'>
                                  <input type='hidden' name='doctor_id' value='" . htmlspecialchars($row['doctor_id']) . "'>
                                  <input type='hidden' name='start_time' value='" . htmlspecialchars($row['start_time']) . "'>
                                  <input type='hidden' name='end_time' value='" . htmlspecialchars($row['end_time']) . "'>
                                  <input type='hidden' name='available_from' value='" . htmlspecialchars($row['available_from']) . "'>
                                  <input type='submit' value='Book Slot'>
                              </form>
                          </td>
                        </tr>";
                }                
        echo "</table>";
    } else {
        echo "<p class='error-msg'>No slots found.</p>";
    }
    ?>

</body>
</html>
