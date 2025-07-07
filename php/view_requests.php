<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

$conn = new mysqli($servername, $username, $password, $dbname);
session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must log in to see your requests.'); window.location.href='login.php';</script>";
    exit;
}

$donor_id = $_SESSION['user_id'];

// Secure SQL using prepared statement
$sql = "SELECT cr.id, d.name AS requester_name, d.blood_group 
        FROM connect_requests cr
        JOIN donor d ON cr.requester_id = d.id 
        WHERE cr.recipient_id = ? AND cr.status = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Requests</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }
        .request-box {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #c62828;
        }
        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin: 10px 5px 0 0;
            text-decoration: none;
            display: inline-block;
        }
        .accept-btn {
            background-color: #2e7d32;
            color: white;
        }
        .reject-btn {
            background-color: #c62828;
            color: white;
        }
        .back-btn {
            background-color: #1976d2;
            color: white;
            margin-top: 30px;
            display: inline-block;
            text-align: center;
        }
        .no-requests {
            text-align: center;
            font-size: 18px;
            color: #555;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<h2>Pending Connection Requests</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='request-box'>
                <p><strong>Request from:</strong> {$row['requester_name']} (Blood Group: {$row['blood_group']})</p>
                <a href='accept_request.php?id={$row['id']}&status=accepted' class='btn accept-btn'>Accept</a>
                <a href='accept_request.php?id={$row['id']}&status=rejected' class='btn reject-btn'>Reject</a>
              </div>";
    }
} else {
    echo "<div class='no-requests'>No pending requests at the moment.</div>";
}
$conn->close();
?>

<div style="text-align: center;">
    <a href="main.html" class="btn back-btn">Back to Dashboard</a>
</div>

</body>
</html>
