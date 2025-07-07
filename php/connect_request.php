<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";  // Correct database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must log in to send a connection request.";
    exit;
}

$requester_id = $_SESSION['user_id'];  // The logged-in user's ID
$recipient_id = $_POST['donor_id'];  // The donor the user wants to connect with

// Insert the connection request into the table
$sql = "INSERT INTO connect_requests (requester_id, recipient_id, status) 
        VALUES ($requester_id, $recipient_id, 'pending')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Request sent successfully!'); window.location.href='main.html';</script>";
exit();

} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
