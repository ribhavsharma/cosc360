<?php
// Database connection
include __DIR__ . "/../core/init.php";

// Start session if not already started
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = DBHOST;
$db   = DBNAME;
$user = DBUSER;
$pass = DBPASS;

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the visitor's IP address
$ip_address = $_SERVER['REMOTE_ADDR'];

// Get the current page URL
$page = $_SERVER['REQUEST_URI'];

// Insert a new row into the tracking table
$sql = "INSERT INTO tracking (page, ip_address, visit_time) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $page, $ip_address);
$stmt->execute();

$stmt->close();
$conn->close();
?>