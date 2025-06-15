<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];

$sql = "SELECT store_id FROM store WHERE email = '$email' ";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $store_id = $row["store_id"];

    $result2 = $conn->query("SELECT * FROM medicine WHERE store_id ='$store_id' ");
    
} else {
    echo "❌ Error: Store not found for email $email.";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* General body styling for a clean, centered layout */
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
<form action="../logout.php" class="logout" method="post">
        <input type="submit" name="Logout" value="Logout">
</form>
    <h1>welcome to medicine store</h1>
    <div class="button-container">
        <form action="add_medicine.php" method="post">
            <input type="submit" name="add_medicine" value="Add Medicine">
        </form>
        <form action="search_medicine.php" method="post">
            <input type="submit" name="search" value="Search">
        </form>
    </div>
    <?php if ($result2->num_rows > 0): ?>
        <table>
            <tr>
                <th>Medicine Name</th>
                <th>Medicine Type</th>
                <th>Quantity</th>
            </tr>
            <?php while ($row = $result2->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['medicine_name']) ?></td>
                    <td><?= htmlspecialchars($row['medicine_type']) ?></td>
                    <td><?= htmlspecialchars($row['medicine_quantity']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No medicines found for this store.</p>
    <?php endif; ?>

</body>

</html>