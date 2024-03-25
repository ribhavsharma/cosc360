<?php
include __DIR__ . "/../core/functions.php";

session_start(); // Start the session if it's not already started

if (isset($_SESSION['USER'])) {
    unset($_SESSION['USER']);
}

if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
}

// Destroy the session
session_destroy();

redirect('./login.php');
?>