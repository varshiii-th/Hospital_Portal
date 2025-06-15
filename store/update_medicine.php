<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];

if (isset($_GET['id'])) {
    
    $medicine_id = $_GET['id'];
    $sql = "SELECT store_id FROM store WHERE email = '$email' ";
    $result = $conn->query($sql);
    
    $sql1 = "SELECT * FROM medicine WHERE medicine_id = '$medicine_id' ";
    $res = $conn->query($sql1);
    $result2 = $res->fetch_assoc();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $store_id = $row["store_id"];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_medicine'])) {
            $medicine_name = trim($_POST["medicine_name"]);
            $medicine_type = trim($_POST["medicine_type"]);
            $medicine_quantity = ($_POST["medicine_quantity"]);

            $sql2 = "UPDATE medicine SET medicine_name = '$medicine_name' , medicine_type = '$medicine_type' , medicine_quantity = '$medicine_quantity' WHERE store_id = '$store_id' AND medicine_id = '$medicine_id' ";
            if ($conn->query($sql2) === TRUE) {
                echo "Medicine updated successfully!";
                header("Location:search_medicine.php");
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "❌ Error: Store not found for email $email.";
    }
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

            h1 {
                font-size: 2em;
            }

            .logout {
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>

<body>
    <h1>update medicine</h1>
    <form method="post">
        <input type="text" name="medicine_name" value=<?php echo $result2["medicine_name"];?> required><br>
        <input type="text" name="medicine_type" value=<?php echo $result2["medicine_type"];?>  required><br>
        <input type="number" name="medicine_quantity" value=<?php echo $result2["medicine_quantity"];?>  required><br>
        <input type="submit" name="update_medicine" value="update_medicine">
    </form>
</body>

</html>