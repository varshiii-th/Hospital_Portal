<?php
session_start();
include "../db.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_medicine"])) {
    $medicine_name = trim($_POST["medicine_name"] ?? "");
    $medicine_type = trim($_POST["medicine_type"] ?? "");
    $medicine_quantity = (int)($_POST["medicine_quantity"] ?? 0);

    if (empty($medicine_name) || empty($medicine_type) || $medicine_quantity <= 0) {
        echo "❌ Please provide valid medicine name, type, and a positive quantity.";
    } else {
        $sql = "SELECT store_id FROM store WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $store_id = $row["store_id"];

            $stmt = $conn->prepare("INSERT INTO medicine (medicine_name, store_id, medicine_type, medicine_quantity) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sisi", $medicine_name, $store_id, $medicine_type, $medicine_quantity);

            if ($stmt->execute()) {
                echo "✅ Medicine added successfully!";
            } else {
                echo "❌ Error: " . $stmt->error;
            }
        } else {
            echo "❌ Error: Store not found for email $email.";
        }
    }
} else {
    echo "⚠️ Invalid request.";
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

        /* Styling for the logout form at top-right */
        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        /* Form styling for a clean, modern look */
        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 20px 0;
        }

        /* Input field styling */
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
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
            width: 100%;
            margin-top: 10px;
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

        /* Link styling for dashboard navigation */
        a {
            color: #3498db;
            text-decoration: none;
            font-size: 1em;
            margin-top: 10px;
            display: inline-block;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        /* Styling for error/success messages */
        body::before {
            content: '';
            display: block;
            margin-bottom: 20px;
            color: #e74c3c; /* Red for errors */
            font-size: 1.2em;
            font-weight: 500;
            text-align: center;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 600px) {
            form {
                padding: 15px;
            }

            input[type="text"],
            input[type="number"],
            input[type="submit"] {
                padding: 8px;
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
    <form action="add_medicine.php" method="post" enctype="multipart/form-data">
        <input type="text" name="medicine_name" placeholder="Medicine name" required><br>
        <input type="text" name="medicine_type" placeholder="Medicine type" required><br>
        <input type="number" name="medicine_quantity" placeholder="quantity" required><br>
        <input type="submit" name="add_medicine" value="add_medicine">
    </form>
    <a href="store_index.php">to dashboard</a>
</body>

</html>