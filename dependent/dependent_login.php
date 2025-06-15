<?php
session_start();
include("../db.php");
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["dep_id"]) && !empty($_POST["password"])){
        $dep_id = $_POST["dep_id"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM professor_dependent WHERE  dependent_id= '$dep_id' ";
        $sql3 = "SELECT * FROM professor_dependent WHERE dependent_id= '$dep_id'AND password = '$password'";
        $result = $conn->query($sql);
        $result3 = $conn->query($sql3);
        if ($result3->num_rows == 1) {
            $_SESSION['dep_id']=$dep_id;
            $sql5 = "SELECT patient_id FROM patient 
            WHERE  id = '$dep_id' AND patient_role='dependent'";

            $result5= $conn->query($sql5);
            
            if ($result5->num_rows ==1) {
                $row1 = $result5->fetch_assoc();
                $_SESSION['patient_id'] = $row1['patient_id'];
            }
            echo "✅ Login successful! Welcome, " . $dep_id;
            echo '<meta http-equiv="refresh" content="3;url=de_dashboard.php">';
        } else if ($result->num_rows == 0) {
            echo "no account";
            echo '<meta http-equiv="refresh" content="3;url=dependent_signup.php">';
        } 
        else {
            echo "❌ Invalid password. Redirecting to login...";
            echo '<meta http-equiv="refresh" content="3;url=dependent_login.php">';
        }
    }
    else {
        echo "⚠️ Please enter both Dependent_id and Password.";
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
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
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
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
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
        input[name="dep_id"] {
            background: #f0f5e8; /* Light green tint for emphasis */
            font-size: 20px;
            font-weight: 700;
            color: #1a3c34;
            box-shadow: 0 0 8px rgba(104, 142, 35, 0.3); /* Subtle green shadow */
        }

        input[name="dep_id"]::placeholder {
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

            input[name="dep_id"] {
                font-size: 18px;
            }
        }
        .back-link {
            display: block;
            text-align: center;
            margin: 15px 0;
            text-decoration: none;
            color: #1a3c34;
            font-size: 16px;
            font-weight: 600;
            padding: 10px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #688e23;
        }
        .back-link {
                font-size: 14px;
                margin: 10px 0;
            } 
    </style>
</head>
<body>
    <form action="dependent_login.php" method="post">
        <input type="text" id="dep_id" name="dep_id" placeholder="dependent_id">
        <br>
        <input type="password" id="password" name="password" placeholder="password">
        <br>
        <input type="submit" value="Submit">
        <a href='../dependent.php' class='back-link'>Back_To_Index</a>

    </form>
</body>
</html>