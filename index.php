<?php
// Start the session
session_start();

// Include database configuration
include 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Prepare and execute the query to fetch the user by email
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the user is banned
        if ($user['banned'] == 1) {
            $error = "Your account has been banned.";
        } elseif (password_verify($password, $user['password'])) {
            // Password is correct, log the user in
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            header("Location: home.php"); // Redirect to the dashboard
            exit();
        } else {
            // Invalid password
            $error = "Invalid email or password!";
        }
    } else {
        // No account found for the provided email
        $error = "No account found with that email!";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varatiya.com</title>
    <link rel="stylesheet" href="./css/style2.css">
</head>
<body>
    <div class="container login-container" id="loginFormContainer">
        <h2>Login</h2>
        <!-- Display error message -->
        <?php if (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
        <!-- Login form -->
        <form id="loginForm" method="POST" action="">
            <div class="form-group">
                <label for="loginEmail">Email</label>
                <input type="email" id="loginEmail" name="email" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="password" required placeholder="Enter your password">
            </div>
            <div class="button-container">
                <button type="submit">Log in</button>
            </div>
        </form>
        <div class="link">
            <p>Don't have an account? <a href="./signup.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
