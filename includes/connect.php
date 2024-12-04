<?php
// Database configuration
$host = 'localhost'; // Host name
$username = 'root'; // MySQL username
$password = ''; // MySQL password (default is empty for XAMPP)
$dbname = 'candidates_db'; // Replace with your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
function logErrorToConsole($message) {
    // Use json_encode to safely format the message
    $jsonMessage = json_encode($message);
    echo "<script>console.error($jsonMessage);</script>";
}

if ($conn->connect_error) {
    die(logErrorToConsole("Connection failed: " . $conn->connect_error));
}
echo "<script>console.log(\"Connected successfully\");</script>";
?>