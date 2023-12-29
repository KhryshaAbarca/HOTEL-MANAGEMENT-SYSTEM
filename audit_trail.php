<?php
session_start(); 

function logAction($action, $details) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotel";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user ID from the session (assuming you have user authentication)
    $user_id = $_SESSION['admin']; // Replace 'user_id' with your session variable name

    // Prepare and execute the SQL statement to insert into the audit trail
    $sql = "INSERT INTO audit_trail (action, details, user_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $action, $details, $user_id);
    $stmt->execute();

    // Close connection
    $conn->close();
}

?>