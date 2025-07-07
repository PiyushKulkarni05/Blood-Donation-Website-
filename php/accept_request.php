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
    echo "<script>alert('You must be logged in to perform this action.'); window.location.href='login.php';</script>";
    exit;
}

$request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$status = $_GET['status'];
$donor_id = $_SESSION['user_id'];

if ($request_id <= 0 || !in_array($status, ['accepted', 'rejected'])) {
    echo "<script>alert('Invalid request.'); window.location.href='main.html';</script>";
    exit;
}

$sql = "UPDATE connect_requests 
        SET status = ? 
        WHERE id = ? AND recipient_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $status, $request_id, $donor_id);

if ($stmt->execute()) {
    if ($status === 'accepted') {
        echo "<script>alert('Request Accepted!'); window.location.href='accepted.html';</script>";
    } else {
        echo "<script>alert('Request Rejected.'); window.location.href='main.html';</script>";
    }
} else {
    echo "<script>alert('Failed to update request status.'); window.location.href='view_request.php';</script>";
}

$conn->close();
?>
