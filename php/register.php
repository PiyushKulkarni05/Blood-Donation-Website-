<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $blood_group = $_POST['blood_group'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $dob = $_POST['dob'];
    $last_donation_date = $_POST['last_donation_date'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO donor (name, email, password, blood_group, phone, city, dob, last_donation_date)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $hashed_password, $blood_group, $phone, $city, $dob, $last_donation_date);

    // Execute the query
    if ($stmt->execute()) {
        // HTML response with alert and meta refresh (redirect)
        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv='refresh' content='1;url=main.html'>
            <script>
                alert('Registration successful!');
            </script>
        </head>
        <body></body>
        </html>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
