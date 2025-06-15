<?php
session_start();
include('../db.php');

if(!isset($_SESSION['doc_id'])){
    header('Location:doc_login.php');
}

if(isset($_POST['prescribes'])){
    $_SESSION['slot_date']=$_POST['slot_date_s'];
    $_SESSION['patient_id']=$_POST['patient_id_s'];
    header('Location:add_prescription.php');
}
if(isset($_POST['prescribep'])){
    $_SESSION['slot_date']=$_POST['slot_date_p'];
    $_SESSION['patient_id']=$_POST['patient_id_p'];
    header('Location:add_prescription.php');
}
if(isset($_POST['prescribed'])){
    $_SESSION['slot_date']=$_POST['slot_date_d'];
    $_SESSION['patient_id']=$_POST['patient_id_d'];
    header('Location:add_prescription.php');
}
if(isset($_POST['reports'])){
    $_SESSION['patient_id']=$_POST['patient_id_s'];
    $_SESSION['test_name']=$_POST['test_names'];
    header('Location:add_report.php');
}
if(isset($_POST['reportp'])){
    $_SESSION['patient_id']=$_POST['patient_id_p'];
    $_SESSION['test_name']=$_POST['test_namep'];
    header('Location:add_report.php');
}
if(isset($_POST['reportd'])){
    $_SESSION['patient_id']=$_POST['patient_id_d'];
    $_SESSION['test_name']=$_POST['test_named'];
    header('Location:add_report.php');
}

$doc_id=$_SESSION['doc_id'];
try{
    $conn->begin_transaction();
    $sqls="SELECT b.booking_id,b.patient_id,sl.slot_date,b.slot_start_time,b.slot_end_time,s.roll_no,s.student_name,s.photo,s.age,s.sex,s.blood_group
            FROM booking AS b 
            JOIN patient AS p ON b.patient_id=p.patient_id  
            JOIN student AS s ON  p.patient_role='student' AND p.id=s.roll_no
            JOIN slots AS sl ON b.slot_id=sl.slot_id
            WHERE b.doctor_id='$doc_id' AND b.slot_end_time>=CURTIME() AND sl.slot_date>=CURDATE()";
    $results=$conn->query($sqls);

    $sqlp="SELECT b.booking_id,b.patient_id,sl.slot_date,b.slot_start_time,b.slot_end_time,pr.professor_id,pr.professor_name,pr.photo,pr.age,pr.sex,pr.blood_group 
            FROM booking AS b 
            JOIN patient AS p ON b.patient_id=p.patient_id  
            JOIN professor AS pr ON  p.patient_role='professor' AND p.id=pr.professor_id
            JOIN slots AS sl ON b.slot_id=sl.slot_id
            WHERE b.doctor_id='$doc_id' AND b.slot_end_time>=CURTIME() AND sl.slot_date>=CURDATE()";
    $resultp=$conn->query($sqlp);

    $sqld="SELECT b.booking_id,b.patient_id,sl.slot_date,b.slot_start_time,b.slot_end_time,d.dependent_id,d.dependent_name,d.photo,d.age,d.sex,d.blood_group
            FROM booking AS b 
            JOIN patient AS p ON b.patient_id=p.patient_id  
            JOIN professor_dependent AS d ON  p.patient_role='dependent' AND p.id=d.dependent_id
            JOIN slots AS sl ON b.slot_id=sl.slot_id
            WHERE b.doctor_id='$doc_id' AND b.slot_end_time>=CURTIME() AND sl.slot_date>=CURDATE()";
    $resultd=$conn->query($sqld);

    $conn->commit();
}
catch(mysqli_sql_exception $e){
    $conn->rollback();
    echo"Transaction failed: ".$e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor's Patient Slots</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        a {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        p {
            font-size: 22px;
            font-weight: 600;
            margin-top: 30px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #2c3e50;
            color: #fff;
        }

        td {
            background-color: #ffffff;
        }

        img {
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        input[type="submit"] {
            padding: 8px 12px;
            background-color: #27ae60;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #219150;
        }

        input[type="text"] {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .no-slots {
            text-align: center;
            font-size: 18px;
            color: #7f8c8d;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<a href='doc_dashboard.php'>Back to Dashboard</a>

<?php
if ($results && $results->num_rows > 0) {
    echo "<p>Student Slots:</p>";
    echo "<table>
            <tr>
                <th>Booking ID</th>
                <th>Date</th>
                <th>Photo</th>

                <th>Start Time</th>
                <th>End Time</th>
                <th>Roll No</th>
                <th>Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Blood Group</th>
                <th>Prescribe</th>
                <th>Book Test</th>
            </tr>";
    while ($row = $results->fetch_assoc()) {
        echo "<tr>
                <td>{$row['booking_id']}</td>
                <td>{$row['slot_date']}</td>
                <td><img src='{$row['photo']}' width='80' height='80'></td>
                <td>{$row['slot_start_time']}</td>
                <td>{$row['slot_end_time']}</td>
                <td>{$row['roll_no']}</td>
                <td>{$row['student_name']}</td>

                <td>{$row['age']}</td>
                <td>{$row['sex']}</td>
                <td>{$row['blood_group']}</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='patient_id_s' value='{$row['patient_id']}'>
                        <input type='hidden' name='slot_date_s' value='{$row['slot_date']}'>
                        <input type='submit' name='prescribes' value='Prescribe'>
                    </form>
                </td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='patient_id_s' value='{$row['patient_id']}'>
                        <input type='text' name='test_names' placeholder='test_name'>
                        <input type='submit' name='reports' value='Book Test'>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<div class='no-slots'>No student slots found.</div>";
}

if ($resultp && $resultp->num_rows > 0) {
    echo "<p>Professor Slots:</p><table>
            <tr>
                <th>Booking ID</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Professor ID</th>
                <th>Name</th>
                <th>Photo</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Blood Group</th>
                <th>Prescribe</th>
                <th>Book Test</th>
            </tr>";
    while ($row1 = $resultp->fetch_assoc()) {
        echo "<tr>
                <td>{$row1['booking_id']}</td>
                <td>{$row1['slot_date']}</td>
                <td>{$row1['slot_start_time']}</td>
                <td>{$row1['slot_end_time']}</td>
                <td>{$row1['professor_id']}</td>
                <td>{$row1['professor_name']}</td>
                <td><img src='{$row1['photo']}' width='80' height='80'></td>
                <td>{$row1['age']}</td>
                <td>{$row1['sex']}</td>
                <td>{$row1['blood_group']}</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='patient_id_p' value='{$row1['patient_id']}'>
                        <input type='hidden' name='slot_date_p' value='{$row1['slot_date']}'>
                        <input type='submit' name='prescribep' value='Prescribe'>
                    </form>
                </td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='patient_id_p' value='{$row1['patient_id']}'>
                        <input type='text' name='test_namep' placeholder='test_name'>
                        <input type='submit' name='reportp' value='Book Test'>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<div class='no-slots'>No professor slots found.</div>";
}


if ($resultd && $resultd->num_rows > 0) {
    echo "<p>Professor Dependent Slots:</p><table>
            <tr>
                <th>Booking ID</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Dependent ID</th>
                <th>Name</th>
                <th>Photo</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Blood Group</th>
                <th>Prescribe</th>
                <th>Book Test</th>
            </tr>";
    while ($row2= $resultd->fetch_assoc()) {
        echo "<tr>
                <td>{$row2['booking_id']}</td>
                <td>{$row2['slot_date']}</td>
                <td>{$row2['slot_start_time']}</td>
                <td>{$row2['slot_end_time']}</td>
                <td>{$row2['dependent_id']}</td>
                <td>{$row2['dependent_name']}</td>
                <td><img src='{$row2['photo']}' width='80' height='80'></td>
                <td>{$row2['age']}</td>
                <td>{$row2['sex']}</td>
                <td>{$row2['blood_group']}</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='patient_id_d' value='{$row2['patient_id']}'>
                        <input type='hidden' name='slot_date_d' value='{$row2['slot_date']}'>
                        <input type='submit' name='prescribed' value='Prescribe'>
                    </form>
                </td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='patient_id_d' value='{$row2['patient_id']}'>
                        <input type='text' name='test_named' placeholder='test_name'>
                        <input type='submit' name='reportd' value='Book Test'>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<div class='no-slots'>No professor dependent slots found.</div>";
}
?>

</body>
</html>