<?php
include("db.php");
session_start();
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["tech_id"]) && !empty($_POST["password"])){
        $tech_id = $_POST["tech_id"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM technician WHERE technician_id = '$tech_id' ";
        $sql3 = "SELECT * FROM technician WHERE technician_id = '$tech_id'AND password = '$password'";
        $result = $conn->query($sql);
        $result3 = $conn->query($sql3);
        if ($result3->num_rows == 1) {
            $_SESSION['tech_id']=$tech_id;
            echo "✅ Login successful! Welcome, " . $tech_id;
            echo '<meta http-equiv="refresh" content="3;url=technician_dashboard.php">';
        } else if ($result->num_rows == 0) {
            echo "no account";
            echo '<meta http-equiv="refresh" content="3;url=technician_signup.html">';
        } 
        else {
            echo "❌ Invalid password. Redirecting to login...";
            echo '<meta http-equiv="refresh" content="3;url=technician_login.html">';
        }
    }
    else {
        echo "⚠️ Please enter both tech_id and Password.";
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: url('https://www.iitg.ac.in/gk/images/img-iitg4.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }

        /* Light overlay for bright image */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3); /* Keeps image bright */
            z-index: 1;
        }

        form {
            background: rgba(255, 255, 255, 0.9); /* Near-white form */
            padding: 30px; /* Reduced side padding */
            width: 100%;
            max-width: 450px; /* Slightly narrower */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            border-radius: 20px; /* Curved edges */
            z-index: 2;
            position: relative;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 18px;
            margin: 12px 0;
            background: #ffffff; /* Pure white inputs */
            border: none; /* No borders */
            border-radius: 12px; /* Curved edges */
            font-size: 18px;
            font-weight: 600;
            color: #1a3c34; /* Dark green text to match image */
            transition: box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(104, 142, 35, 0.5); /* Olive green shadow */
        }

        input[type="submit"] {
            width: 100%;
            padding: 18px;
            background: #688e23; /* Olive green from image */
            border: none; /* No borders */
            border-radius: 12px; /* Curved edges */
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            margin-top: 12px;
        }

        input[type="submit"]:hover {
            background: #7ea136; /* Lighter green */
            transform: translateY(-2px);
        }

        input::placeholder {
            color: #5a7a5e; /* Muted green for placeholders */
            font-size: 16px;
            font-weight: 500;
        }

        br {
            display: none; /* Hide <br> for clean spacing */
        }

        /* Roll number specific styling */
        input[name="tech_id"] {
            background: #f0f5e8; /* Light green tint for emphasis */
            font-size: 20px;
            font-weight: 700;
            color: #1a3c34;
            box-shadow: 0 0 8px rgba(104, 142, 35, 0.3); /* Subtle green shadow */
        }

        input[name="tech_id"]::placeholder {
            color: #5a7a5e;
            font-weight: 600;
        }

        @media (max-width: 400px) {
            form {
                padding: 20px;
                max-width: 100%;
            }

            input[type="text"],
            input[type="password"] {
                padding: 14px;
                font-size: 16px;
                margin: 8px 0;
                border-radius: 10px;
            }

            input[type="submit"] {
                padding: 14px;
                font-size: 18px;
                border-radius: 10px;
            }

            input[name="tech_id"] {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <form action="technician_login.php" method="post">
        <input type="text" id="tech_id" name="tech_id" placeholder="tech_id">
        <br>
        <input type="password" id="password" name="password" placeholder="password">
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>