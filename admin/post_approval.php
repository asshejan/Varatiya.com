<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php'); // Redirect to login page
    exit;
}

// Include the database configuration
include '../config.php';

// Handle admin actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $propertyId = $_POST['property_id'] ?? '';

    if ($action && $propertyId) {
        switch ($action) {
            case 'delete':
                // Delete property from the database
                $stmt = $conn->prepare("DELETE FROM Listing WHERE id = ?");
                $stmt->bind_param("i", $propertyId);
                $stmt->execute();
                $stmt->close();
                break;
        }
    }
    // Redirect to prevent form resubmission
    header("Location: dashboard.php");
    exit;
}

// Fetch all properties from the database
$result = $conn->query("SELECT id, title, price, address, city, sqft, bedrooms, bathrooms, type, status FROM Listing");
$properties = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .actions button {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .actions .approve {
            background-color: #28a745;
            color: white;
        }
        .actions .delete {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Address</th>
                <th>City</th>
                <th>Sqft</th>
                <th>Bedrooms</th>
                <th>Bathrooms</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($properties): ?>
                <?php foreach ($properties as $property): ?>
                    <tr>
                        <td><?= htmlspecialchars($property['id']) ?></td>
                        <td><?= htmlspecialchars($property['title']) ?></td>
                        <td><?= htmlspecialchars(number_format($property['price'], 2)) ?></td>
                        <td><?= htmlspecialchars($property['address']) ?></td>
                        <td><?= htmlspecialchars($property['city']) ?></td>
                        <td><?= htmlspecialchars($property['sqft']) ?></td>
                        <td><?= htmlspecialchars($property['bedrooms']) ?></td>
                        <td><?= htmlspecialchars($property['bathrooms']) ?></td>
                        <td><?= htmlspecialchars($property['type']) ?></td>
                        <td><?= htmlspecialchars($property['status']) ?></td>
                        <td class="actions">
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="property_id" value="<?= htmlspecialchars($property['id']) ?>">
                                <button class="delete" name="action" value="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">No properties found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
