<?php
include 'config.php'; // Include database configuration

// Initialize error and success messages
$error_message = '';
$success_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validate form inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error_message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email format.';
    } elseif ($password !== $confirmPassword) {
        $error_message = 'Passwords do not match.';
    } else {
        // Check if the username or email already exists
        $check_sql = "SELECT * FROM accounts WHERE username = ? OR email = ?";
        $check_stmt = $conn->prepare($check_sql);
        if ($check_stmt) {
            $check_stmt->bind_param('ss', $username, $email);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $existing_user = $check_result->fetch_assoc();
                if ($existing_user['username'] === $username) {
                    $error_message = 'Username already exists. Please choose another.';
                } elseif ($existing_user['email'] === $email) {
                    $error_message = 'Email is already registered. Please use a different email.';
                }
            } else {
                // Hash the password for security
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert user data into the database
                $insert_sql = "INSERT INTO accounts (username, email, password, banned) VALUES (?, ?, ?, 0)";
                $insert_stmt = $conn->prepare($insert_sql);
                if ($insert_stmt) {
                    $insert_stmt->bind_param('sss', $username, $email, $hashed_password);
                    if ($insert_stmt->execute()) {
                        $success_message = 'Sign-up successful. You can now <a href="index.php">log in</a>.';
                    } else {
                        $error_message = 'Error: Could not save your data. Please try again.';
                    }
                    $insert_stmt->close();
                } else {
                    $error_message = 'Error: Could not prepare the statement.';
                }
            }

            $check_stmt->close();
        } else {
            $error_message = 'Error: Could not check for duplicate accounts.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="./css/style2.css">
</head>
<body>
    <div class="container signup-container" id="signupFormContainer">
        <h2>Sign Up</h2>
        <!-- Display error message -->
        <?php if (!empty($error_message)): ?>
            <p class="error-message" style="color: red;"><?= $error_message; ?></p>
        <?php endif; ?>
        <!-- Display success message -->
        <?php if (!empty($success_message)): ?>
            <p class="success-message" style="color: green;"><?= $success_message; ?></p>
        <?php endif; ?>
        <form id="signupForm" method="POST" action="signup.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="signupEmail">Email</label>
                <input type="email" id="signupEmail" name="email" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="signupPassword">Password</label>
                <input type="password" id="signupPassword" name="password" required placeholder="Enter your password">
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm your password">
            </div>
            <div class="button-container">
                <button type="submit">Sign Up</button>
            </div>
            <div class="link">
                <p>Already have an account? <a href="./index.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
