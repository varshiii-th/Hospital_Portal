<?php
session_start();
require_once "../db.php";

$searchQuery = "SELECT * FROM Medicine WHERE medicine_quantity > 0";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_medicine'])) {
    $search = $_POST['search'];
    $search = mysqli_real_escape_string($conn, $search);
    $searchQuery = "SELECT * FROM Medicine 
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
    <title>Medicine Store</title>
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

        form {
            text-align: center;
            margin-bottom: 30px;
        }

        input[type="text"] {
            padding: 12px 18px;
            font-size: 1rem;
            border: 2px solid #22a6b3;
            border-radius: 8px;
            outline: none;
            width: 260px;
            transition: 0.3s;
        }

        input[type="text"]:focus {
            border-color: #0fb9b1;
            box-shadow: 0 0 5px rgba(15, 185, 177, 0.5);
        }

        input[type="submit"] {
            padding: 12px 20px;
            font-size: 1rem;
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            margin-left: 10px;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
        }

        table {
            width: 80%;
            margin: 0 auto;
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
            background: linear-gradient(90deg,rgb(204, 36, 36) 0%,rgb(236, 27, 27) 100%);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 1rem;
            transition: 0.3s;
 }

.center-btn:hover {
    background: linear-gradient(90deg,rgb(204, 36, 36) 0%,rgb(236, 27, 27) 100%);
    transform: translateY(-2px);
}

    </style>
</head>

<body>
    <h1>Available Medicines</h1>
    <a href="stu_dashboard.php" class="center-btn">Back To Dashboard</a>

    <form method="post">
        <input type="text" name="search" placeholder="Enter medicine name...">
        <input type="submit" name="search_medicine" value="Search Medicine">
    </form>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Medicine ID</th>
                    <th>Medicine Name</th>
                    <th>Medicine Type</th>
                    <th>Quantity</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['medicine_id']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_name']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_type']) . "</td>
                    <td>" . htmlspecialchars($row['medicine_quantity']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No medicines found for this search.</p>";
    }
    ?>

</body>

</html>
