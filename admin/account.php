<?php
// Start session and check admin login
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Include the database configuration
include '../config.php';

// Fetch user accounts from the database
$sql = "SELECT username, email, banned FROM accounts";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Accounts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .ban-button {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .ban-button:hover {
            background-color: darkred;
        }
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-banned {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Admin - Manage User Accounts</h1>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="<?php echo $row['banned'] ? 'status-banned' : 'status-active'; ?>">
                            <?php echo $row['banned'] ? 'Banned' : 'Active'; ?>
                        </td>
                        <td>
                            <?php if (!$row['banned']): ?>
                                <form method="POST" action="ban_user.php" style="display: inline;">
                                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($row['username']); ?>">
                                    <button type="submit" class="ban-button">Ban</button>
                                </form>
                            <?php else: ?>
                                <span>Account Banned</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No accounts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
