<?php
 include('db.php');
 
?>
<?php
if(isset($_POST['storeentrytype'])){
    $entry=$_POST['storeentrytype'];
    if ($entry==0) {
        header("Location:store/store_signup.php");
        exit();
    }
    else if($entry==1){
        header("Location:store/store_login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITG Online Hospital Portal</title>
    <!-- Add the above CSS here or link to external stylesheet -->
</head>
<body>
    <style>
/* Global Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: url('https://www.iitg.ac.in/gk/images/img-iitg4.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    display: flex;
    min-height: 100vh;
    padding: 0;
    position: relative;
    color: #333;
    line-height: 1.6;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    z-index: 1;
}

/* Sidebar Styles */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 70px;
    height: 100vh;
    background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
    transition: width 0.3s ease;
    z-index: 1000;
    overflow-x: hidden;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.sidebar:hover {
    width: 260px;
}

.hamburger {
    padding: 20px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.hamburger-line {
    width: 30px;
    height: 3px;
    background: #ecf0f1;
    margin: 6px 0;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 30px 0;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.sidebar:hover .nav-menu {
    opacity: 1;
}

.nav-menu li a {
    color: #ecf0f1;
    text-decoration: none;
    padding: 15px 25px;
    display: block;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.nav-menu li a:hover {
    background:rgb(22, 58, 99);
    color: #ffffff;
    transform: translateX(10px);
}

/* Main Content Styles */
.main-content {
    margin-left: 70px;
    transition: margin-left 0.3s ease;
    padding: 30px;
    width: 100%;
    z-index: 2;
}

.sidebar:hover ~ .main-content {
    margin-left: 260px;
}

/* Header Styles */
header {
    text-align: center;
    padding: 3rem 2rem;
    
    color:rgb(17, 17, 17);
    border-radius: 12px;
    margin-bottom: 2.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

header h1 {
    font-size: rem;
    font-weight: 1000;
    line-height: 1.2;
}

header h1 i {
    display: block;
    font-size: 1.2rem;
    font-weight: 400;
    margin-top: 0.5rem;
    opacity: 0.9;
}

/* Main Form Section */
main {
    max-width: 700px;
    margin: 0 auto;
    padding: 30px;
    background:rgba(236, 230, 230,0);
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

form h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1a2a44;
    text-align: center;
}

label {
    display: flex;
    align-items: center;
    font-size: 1.1rem;
    color:rgb(15, 15, 15);
    cursor: pointer;
    padding: 10px;
    border-radius: 8px;
    transition: background 0.2s ease;
}

label:hover {
    background:rgba(221, 223, 226,0.8);
}

input[type="radio"] {
    margin-right: 12px;
    accent-color: #688e23;
    width: 20px;
    height: 20px;
}

input[type="submit"] {
    background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
    color: #ffffff;
    padding: 12px 30px;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    align-self: center;
    min-width: 150px;
}

input[type="submit"]:hover {
    background: linear-gradient(180deg, #1a2a44 0%, #2c3e50 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

input[type="submit"]:active {
    transform: translateY(0);
}
</style>
    <!-- Navigation Sidebar -->
    <nav class="sidebar">
        <div class="hamburger">
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
        </div>
        <ul class="nav-menu">
            <li><a href="doctor.php">Doctor</a></li>
            <li><a href="student.php">Student</a></li>
            <li><a href="professor.php">Professor</a></li>
            <li><a href="dependent.php">Dependent</a></li>
            <li><a href="technician.php">Technician</a></li>
            <li><a href="store.php">Store</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>
                IITG ONLINE HOSPITAL PORTAL<br>
                Empowering Healthcare, One Click at a Time<br>
             
            </h1>
        </header>

        <main>
            <section>
                <form action="store.php" method="post">
                    <h3><b>If you are a new Store Owner, please select Signup; else, Login</b></h3>
                    <label>
                        <input type="radio" value="0" name="storeentrytype" required> Signup
                    </label>
                    <label>
                        <input type="radio" value="1" name="storeentrytype"> Login
                    </label>
                    <input type="submit" value="Proceed">
                </form>
            </section>
        </main>
    </div>
</body>
</html>