<?php
 include('../db.php');
?>
<?php
if(isset($_POST['depentrytype'])){
    $entry=$_POST['depentrytype'];
    if ($entry==0){
        header("Location:dependent_signup.php");
        exit();
    }
    else if($entry==1){
        header("Location:dependent_login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dependent Portal Entry</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #dff9fb, #f6f9fc);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2c3e50;
        }

        header {
            background: linear-gradient(135deg, #0fb9b1, #22a6b3);
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        section {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }

        section h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            text-align: center;
            color: #130f40;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        label {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 12px 24px;
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            font-size: 1rem;
        }

        input[type="submit"]:hover {
            background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
            transform: translateY(-2px);
        }

    </style>
</head>
<body>

<header>
    <h1>
        IITG ONLINE HOSPITAL PORTAL<br>
        <small style="font-size: 0.9rem;">Empowering Healthcare, One Click at a Time</small>
    </h1>
</header>

<main>
    <section>
        <form action="dependent.php" method="post">
            <h3><b>If you are a new user, please select Signup; else, Login</b></h3>
            <label><input type="radio" value="0" name="depentrytype"> Signup</label>
            <label><input type="radio" value="1" name="depentrytype"> Login</label>
            <input type="submit" value="Continue">
        </form>
    </section>
</main>

</body>
</html>
