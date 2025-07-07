<?php
session_start();
include 'config.php'; // Assumes $conn is defined here

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    exit;
}

$requester_id = intval($_SESSION['user_id']); // Sanitize user_id

// Query to get requests sent by this user
$sql = "SELECT r.status, u.name, u.blood_group, u.city, u.phone
        FROM connect_requests r
        JOIN donor u ON r.recipient_id = u.id
        WHERE r.requester_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $requester_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #c62828;
        }
        .request-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin: 15px auto;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .info {
            font-size: 16px;
            margin: 5px 0;
        }
    </style>
</head>
<body>

<h2>Your Sent Requests</h2>

<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ensure we are using the correct variable names
        $name = htmlspecialchars($row['name']);
        $blood_group = htmlspecialchars($row['blood_group']);
        $status = htmlspecialchars($row['status']);
        $contact = htmlspecialchars($row['phone']);
        $city = htmlspecialchars($row['city']);

        echo "<div class='request-card'>
                <p class='info'><strong>Name:</strong> $name</p>
                <p class='info'><strong>Blood Group:</strong> $blood_group</p>
                <p class='info'><strong>Status:</strong> $status</p>";

        // Only display contact and city if the status is 'Accepted'
        if (strtolower($status) === 'accepted') {
            echo "<p class='info'><strong>Contact:</strong> $contact</p>
                  <p class='info'><strong>City:</strong> $city</p>";
        }

        echo "</div>";
    }
} else {
    echo "<p style='text-align:center;'>You haven't sent any requests yet.</p>";
}
$conn->close();
?>

</body>
</html>
