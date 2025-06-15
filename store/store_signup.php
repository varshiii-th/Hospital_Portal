
<?php
include("../db.php");
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $password = $_POST["password"];
    $name = $_POST["store_name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $owner_name = $_POST["owner_name"];

    $sql = "INSERT INTO store 
        ( password, store_name, phone, email, owner_name) 
        VALUES 
        ( '$password', '$name', '$phone', '$email', '$owner_name')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Store registered successfully!";
        echo '<meta http-equiv="refresh" content="3;url=store_login.php">';

        
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Store Signup</title>
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
            background: rgba(255, 255, 255, 0.3); /* Bright image */
            z-index: 1;
        }

        h2 {
            font-size: 36px;
            font-weight: 700;
            color: #1a3c34; /* Dark green to match image */
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 2;
        }

        form {
            background: rgba(255, 255, 255, 0.9); /* Near-white form */
            padding: 30px; /* Reduced side padding */
            width: 100%;
            max-width: 550px; /* Broad but tighter */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            border-radius: 20px; /* Curved edges */
            z-index: 2;
            position: relative;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="date"],
        input[type="file"],
        select {
            width: 100%;
            padding: 18px;
            margin: 12px 0;
            background: #ffffff; /* Pure white inputs */
            border: none; /* No borders */
            border-radius: 12px; /* Curved edges */
            font-size: 18px;
            font-weight: 600;
            color: #1a3c34; /* Dark green text */
            transition: box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        select:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(104, 142, 35, 0.5); /* Olive green shadow */
        }

        input[type="file"] {
            padding: 14px;
            cursor: pointer;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='%231a3c34' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 18px center;
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

        input::placeholder,
        select option {
            color: #5a7a5e; /* Muted green */
            font-size: 16px;
            font-weight: 500;
        }

        label {
            font-size: 16px;
            font-weight: 600;
            color: #1a3c34; /* Dark green */
            margin: 10px 0 5px;
            display: block;
        }

        br {
            display: none; /* Hide <br> for clean spacing */
        }

        /* Roll number specific styling */
        input[name="store_id"] {
            background: #f0f5e8; /* Light green tint */
            font-size: 20px;
            font-weight: 700;
            color: #1a3c34;
            box-shadow: 0 0 8px rgba(104, 142, 35, 0.3); /* Subtle green shadow */
        }

        input[name="store_id"]::placeholder {
            color: #5a7a5e;
            font-weight: 600;
        }

        @media (max-width: 400px) {
            form {
                padding: 20px;
                max-width: 100%;
            }

            h2 {
                font-size: 28px;
                margin-bottom: 20px;
            }

            input[type="text"],
            input[type="password"],
            input[type="email"],
            input[type="date"],
            input[type="file"]{
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

            label {
                font-size: 14px;
            }

            input[name="store_id"] {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <h2>Store Signup Form</h2>
    <form action="store_signup.php" method="post" enctype="multipart/form-data">

        
        <input type="text" name="store_name" placeholder="Store Name" required><br>
        <input type="text" name="phone" placeholder="Phone Number" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="owner_name" placeholder="Owner_name" required><br>


  
        <input type="submit" value="Sign Up">
    </form>
</body>
</html>