<?php
session_start();
$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$password = $_POST['password'];

$sql = "SELECT * FROM donor WHERE full_name='$name' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $_SESSION['user'] = $name;
    header("Location: search.php");
} else {
    header("Location: login.php?error=1");
}
?>
