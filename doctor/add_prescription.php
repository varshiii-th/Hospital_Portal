<?php
session_start();
include('../db.php');
if(!isset($_SESSION['doc_id'])){
    header('Location:doc_login.php');
}
$doc_id=$_SESSION['doc_id'];
$date=$_SESSION['slot_date'];
$patient_id=$_SESSION['patient_id'];
   try{
    $conn->begin_transaction();
    $sql2="SELECT prescription_id FROM prescription 
    WHERE doctor_id='$doc_id' AND patient_id='$patient_id' AND prescription_date='$date'";
    $result2=$conn->query($sql2);
    if($result2->num_rows==1){
        $row2=$result2->fetch_assoc();
        $pres_id=$row2['prescription_id'];

    }
    else{
    
        $sql1="INSERT INTO prescription (doctor_id,patient_id,prescription_date) 
        VALUES ('$doc_id','$patient_id','$date')";
        $result=$conn->query($sql1);

        $sql3="SELECT prescription_id FROM prescription 
        WHERE doctor_id='$doc_id' AND patient_id='$patient_id' AND prescription_date='$date'";
        $result3=$conn->query($sql3);
        if($result3->num_rows==1){
            $row3=$result3->fetch_assoc();
            $pres_id=$row3['prescription_id'];

        }

    }
    $conn->commit();
    

    }
    catch(mysqli_sql_exception $e){
        $conn->rollback();
        echo"Transaction failed: ".$e->getMessage();
        
       
    }

if(isset($_POST['Add'])){
    $quantity_req=(int)$_POST['quantity_req'];
    $med_id=$_POST['med_id'];
    $quantity_available=(int)$_POST['quantity'];
    $price=$quantity_req * (int)$_POST['price'];
    $store_id=$_POST['store_id'];
    
    try{
       $conn->begin_transaction();
       if($quantity_available>=$quantity_req){
        $mor=false;
        $an=false;
        $ni=false;

        if (isset($_POST['shifts'])) {
            $selectedShifts = $_POST['shifts'];
        
            foreach ($selectedShifts as $shift) {
                if( htmlspecialchars($shift) =='morning'){
                    $mor=true;
                }
                if( htmlspecialchars($shift) =='afternoon'){
                    $an=true;
                }
                if( htmlspecialchars($shift) =='night'){
                    $ni=true;
                }
            }
        }
            $sql="INSERT INTO prescription_details (prescription_id,medicine_id,quantity_req,store_id,price,morning,afternoon,night)
            VALUES ('$pres_id','$med_id','$quantity_req','$store_id','$price','$mor','$an','$ni')";
            $conn->query($sql);
            
            $updated_quantity=$quantity_available - $quantity_req;
            
            $sql2="UPDATE medicine SET medicine_quantity='$updated_quantity' 
            WHERE medicine_id='$med_id'";
            $conn->query($sql2);

            
            $sql5="SELECT * FROM bill
            WHERE store_id='$store_id' AND prescription_id='$pres_id' ";
            $result5=$conn->query($sql5);
            
            if($result5->num_rows ==1){
                $row=$result5->fetch_assoc();
                $old_price=(int)$row['total_price'];
                $updated_price=$old_price+$price;
              
                $sql6="UPDATE bill SET total_price='$updated_price'
                WHERE store_id='$store_id' AND prescription_id='$pres_id'";
                $conn->query($sql6);
                
            }
            else{
                
                $sql6="INSERT INTO bill (prescription_id,store_id,total_price)
                VALUES('$pres_id','$store_id','$price')";
                $conn->query($sql6);
            }
    
        }
        else{
            echo"Required quantity is not available.<br>";
        }
        $conn->commit();
    }
    catch(mysqli_sql_exception $e){
        $conn->rollback();
        echo"Transaction failed: ".$e->getMessage();
       
    }
    
}
?>
<?php


$searchQuery = "SELECT m.*,s.store_name FROM Medicine AS m
                JOIN store AS s ON m.store_id=s.store_id
                 WHERE medicine_quantity > 0";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_medicine'])) {
    $search = $_POST['search'];
    $search = mysqli_real_escape_string($conn, $search);
    $searchQuery = "SELECT s.store_name,m.* FROM Medicine AS m
                    JOIN store AS s ON m.store_id=s.store_id
                    WHERE (medicine_id LIKE '%$search%' OR medicine_name LIKE '%$search%') 
                    AND medicine_quantity > 0";
}

$result = $conn->query($searchQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Available</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="number"] {
            padding: 8px 12px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            margin: 5px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .shift-checkbox {
            display: inline-block;
            margin-right: 8px;
        }

        p {
            text-align: center;
            color: #888;
        }
    </style>
</head>

<body>

    <h1>Available Medicines</h1>

    <form method="post">
        <input type="text" name="search" placeholder="Enter medicine name...">
        <input type="submit" name="search_medicine" value="Search Medicine">
    </form>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Medicine Id</th>
                    <th>Medicine Name</th>
                    <th>Medicine Type</th>
                    <th>Store Name</th>
                    <th>Quantity In Store</th>
                    <th>Add to Prescription</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['medicine_id']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_name']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_type']) . "</td>
                    <td>" . htmlspecialchars($row['store_name']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_quantity']) . "</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='med_id' value='" . htmlspecialchars($row['medicine_id']) . "'>
                            <input type='hidden' name='quantity' value='" . htmlspecialchars($row['medicine_quantity']) . "'>
                            <input type='hidden' name='store_id' value='" . htmlspecialchars($row['store_id']) . "'>
                            <input type='hidden' name='price' value='" . htmlspecialchars($row['price']) . "'>

                            <div class='shift-checkbox'>
                                <input type='checkbox' name='shifts[]' value='morning'> Morning
                            </div>
                            <div class='shift-checkbox'>
                                <input type='checkbox' name='shifts[]' value='afternoon'> Afternoon
                            </div>
                            <div class='shift-checkbox'>
                                <input type='checkbox' name='shifts[]' value='night'> Night
                            </div><br>

                            <input type='number' name='quantity_req' placeholder='Quantity' min='1' required>
                            <input type='submit' name='Add' value='Add'>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No medicines found for this search.</p>";
    }
    ?>

</body>

</html>