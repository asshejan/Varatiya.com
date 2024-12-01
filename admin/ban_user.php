<?php
// Start session and check admin login
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Include the database configuration
include '../config.php';

// Check if the request is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = $conn->real_escape_string($_POST['username']);

    // Update the banned status of the user
    $sql = "UPDATE accounts SET banned = 1 WHERE username = '$username'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User banned successfully!'); window.location.href = 'account.php';</script>";
    } else {
        echo "<script>alert('Error banning user: " . $conn->error . "'); window.location.href = 'account.php';</script>";
    }
} else {
    header('Location: account.php');
    exit;
}
?>
