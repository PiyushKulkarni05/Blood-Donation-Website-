
<?php
// Step 1: Connect to the database
$servername = "localhost";
$username = "root"; // default for XAMPP
$password = "";     // default for XAMPP
$dbname = "blood_bank"; // Make sure this database exists

$conn = new mysqli($servername, $username, $password, $dbname);

// Step 2: Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 3: Ensure the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input to avoid SQL injection
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $last_donation = mysqli_real_escape_string($conn, $_POST['last_donation']);

    // Step 4: Insert into database
    $sql = "INSERT INTO donors (full_name, email, password, blood_group, phone, city, last_donation)
            VALUES ('$full_name', '$email', '$password', '$blood_group', '$phone', '$city', '$last_donation')";

    if ($conn->query($sql) === TRUE) {
        echo "<h2 style='color: green; text-align:center;'>Registration successful!</h2>";
        echo "<p style='text-align:center;'><a href='index.html'>Go back to Home</a></p>";
    } else {
        echo "<h2 style='color: red; text-align:center;'>Error: " . $conn->error . "</h2>";
    }

    $conn->close();
} else {
    echo "<h2 style='color: red; text-align:center;'>Please submit the form properly!</h2>";
}
?>

