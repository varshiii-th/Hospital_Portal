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

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_medicine'])) {
        $search= $_POST['search'];
        $search = mysqli_real_escape_string($conn, $search);

        $sql2 = "SELECT * FROM medicine WHERE store_id ='$store_id' AND  medicine_type LIKE '%$search%' OR medicine_name LIKE '%$search%'";
    } else {

        $sql2 = "SELECT * FROM medicine WHERE store_id ='$store_id' ";
    }

    $result2 = $conn->query($sql2);
    
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

        /* Styling for the logout form at top-right */
        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        /* Form styling for a clean, modern look */
        form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
            width: 100%;
            max-width: 600px;
        }

        /* Input field styling */
        input[type="text"] {
            width: 70%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        input[type="text"]:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        /* Button styling for a modern, interactive look */
        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        input[type="submit"]:active {
            transform: translateY(0);
        }

        /* Logout button styling */
        .logout input[type="submit"] {
            background-color: #e74c3c;
        }

        .logout input[type="submit"]:hover {
            background-color: #c0392b;
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

        /* Link styling for Edit/Delete actions */
        a {
            color: #3498db;
            text-decoration: none;
            margin: 0 5px;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        .back-to-index {
            margin-top: 20px;
            font-size: 1em;
            display: inline-block;
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

            form {
                flex-direction: column;
                align-items: center;
            }

            input[type="text"],
            input[type="submit"] {
                width: 100%;
                padding: 8px;
                font-size: 0.9em;
            }

            h1 {
                font-size: 2em;
            }

            .logout {
                top: 10px;
                right: 10px;
            }

            .back-to-index {
                font-size: 0.9em;
            }
        }
    </style>
</head>

<body>
    <h1>welcome to medicine store</h1>
    <form action="search_medicine.php" method="post">
        <input type="text" name="search" placeholder="search" >
        <input type="submit" name="search_medicine" value="search_medicine">
    </form>
    <?php if ($result2->num_rows > 0): ?>
        <table>
            <tr>
                <th>Medicine Name</th>
                <th>Medicine Type</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result2->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['medicine_name']) ?></td>
                    <td><?= htmlspecialchars($row['medicine_type']) ?></td>
                    <td><?= htmlspecialchars($row['medicine_quantity']) ?></td>
                    <td>
                    <a href="update_medicine.php?id=<?php echo $row['medicine_id']; ?>">Edit</a> |
                    <a href="delete_medicine.php?id=<?php echo $row['medicine_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No medicines found for this store.</p>
    <?php endif; ?>
    <a href="store_index.php" class="back-to-index">Back to Index</a>

</body>

</html>