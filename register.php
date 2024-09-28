<?php
$servername = "localhost"; // Database host
$username = "root";        // Database username
$password = "";            // Database password
$dbname = "user_auth";     // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // SQL to insert user data
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful! You can now log in.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
