<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must login to connect with donors.'); window.location.href='login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #d32f2f;
            text-align: center;
        }

        .donor-list {
            list-style: none;
            padding: 0;
            max-width: 800px;
            margin: 20px auto;
        }

        .donor-list li {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .donor-info p {
            margin: 6px 0;
            font-size: 16px;
        }

        .connect-btn {
            background-color: #d32f2f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .connect-btn:hover {
            background-color: #b71c1c;
        }

        .no-results {
            text-align: center;
            color: #444;
            margin-top: 50px;
            font-size: 18px;
        }
    </style>
</head>
<body>

<?php
if (isset($_GET['area']) && isset($_GET['age']) && isset($_GET['blood_group'])) {
    $area = $_GET['area'];
    $age = $_GET['age'];
    $blood_group = $_GET['blood_group'];

    $sql = "SELECT id, name, blood_group, phone, DATEDIFF(CURDATE(), dob) / 365 AS age 
            FROM donor 
            WHERE city LIKE '%$area%' 
            AND DATEDIFF(CURDATE(), dob) / 365 >= $age 
            AND blood_group = '$blood_group'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Donors Found</h2>";
        echo "<ul class='donor-list'>";

        while ($row = $result->fetch_assoc()) {
            echo "<li>
                    <div class='donor-info'>
                        <p><strong>Name:</strong> " . $row['name'] . "</p>
                        <p><strong>Age:</strong> " . intval($row['age']) . "</p>
                        <p><strong>Blood Group:</strong> " . $row['blood_group'] . "</p>
                    </div>
                    <form action='connect_request.php' method='POST'>
                        <input type='hidden' name='donor_id' value='" . $row['id'] . "'>
                        <button type='submit' class='connect-btn'>Connect</button>
                    </form>
                  </li>";
        }
        echo "</ul>";
    } else {
        echo "<div class='no-results'>No donors found with the given criteria.</div>";
    }
} else {
    echo "<div class='no-results'>Please enter all search criteria.</div>";
}

$conn->close();
?>

</body>
</html>
