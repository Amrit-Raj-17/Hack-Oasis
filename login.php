<?php
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "user_auth";     

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // SQL to fetch user data
    $sql = "SELECT * FROM users WHERE username = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Verify if user exists and password matches
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            echo "Login successful!";
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
