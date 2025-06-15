<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['tech_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_report'])) {
    $search = $_POST['search'];
    $search = mysqli_real_escape_string($conn, $search);

    $sql2 = "SELECT * FROM testreport 
         WHERE report IS NOT NULL AND
        patient_id LIKE '%$search%' ORDER BY test_report_date";
} else {

    $sql2 = "SELECT * FROM testreport
    WHERE report IS NOT NULL
     ORDER BY test_report_date ";
}

$result2 = $conn->query($sql2);

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
h2 {
    color: #2c3e50;
    font-size: 2em;
    margin-bottom: 20px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Container for the search form */
.search-container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    margin-bottom: 20px;
}

/* Styling for the search form inputs */
input[type="number"],
input[type="text"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 1em;
}

/* Styling for the submit button */
input[type="submit"] {
    background-color: #3498db;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease, transform 0.2s ease;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
}

input[type="submit"]:active {
    transform: translateY(0);
}

/* Styling for the logout button */
.logout {
    position: absolute;
    top: 20px;
    right: 20px;
}

.logout input[type="submit"] {
    background-color: #e74c3c;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.logout input[type="submit"]:hover {
    background-color: #c0392b;
    transform: translateY(-2px);
}

.logout input[type="submit"]:active {
    transform: translateY(0);
}

/* Styling for the dashboard link */
.dashboard-link {
    display: inline-block;
    margin-top: 20px;
    color: #3498db;
    text-decoration: none;
    font-size: 1em;
}

.dashboard-link:hover {
    text-decoration: underline;
}

/* Table styling for search results */
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

/* Styling for table links (View, Delete) */
td a {
    color: #3498db;
    text-decoration: none;
    margin-right: 10px;
}

td a:hover {
    text-decoration: underline;
}

/* Styling for error and success messages */
.error {
    color: #e74c3c;
    font-size: 1.1em;
    font-weight: 500;
    margin: 10px 0;
    text-align: center;
}

.success {
    color: #2ecc71;
    font-size: 1.1em;
    font-weight: 500;
    margin: 10px 0;
    text-align: center;
}

/* Styling for no results message */
p.no-results {
    color: #e74c3c;
    font-size: 1.2em;
    font-weight: 500;
    margin-top: 20px;
    text-align: center;
}

/* Responsive design for smaller screens */
@media (max-width: 600px) {
    .search-container {
        width: 90%;
    }

    table {
        width: 100%;
    }

    th, td {
        padding: 10px;
        font-size: 0.9em;
    }

    h2 {
        font-size: 1.5em;
    }

    input[type="number"],
    input[type="text"],
    input[type="submit"] {
        font-size: 0.9em;
        padding: 8px;
    }

    .logout {
        top: 10px;
        right: 10px;
    }

    .logout input[type="submit"] {
        padding: 8px 16px;
        font-size: 0.9em;
    }

    .dashboard-link {
        font-size: 0.9em;
    }
}
    </style>
</head>

<body>
    <h1>SEARCH REPORT</h1>
    <form action="search_report.php" method="post">
        <input type="text" name="search" placeholder="search by patient_id">
        <input type="submit" name="search_report" value="search_report">
    </form>
    <?php if ($result2->num_rows > 0): ?>
        <table>
            <tr>
                <th>Report Id</th>
                <th>Patient Id</th>
                <th>Report Date</th>
                <th>Report</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result2->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['report_id']) ?></td>
                    <td><?= htmlspecialchars($row['patient_id']) ?></td>
                    <td><?= htmlspecialchars($row['test_report_date']) ?></td>
                    <td><a href="view_report.php?id=<?php echo $row['report_id']; ?>">View Report</a>
                    </td>
                    <td>
                        <a href="update_report.php?id=<?php echo $row['report_id']; ?>">Edit</a> |
                        <a href="delete_report.php?id=<?php echo $row['report_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No Test Reports Found For The Patient.</p>
    <?php endif; ?>
    <a href="technician_dashboard.php" class="back-to-index">Back to Index</a>
</body>

</html>