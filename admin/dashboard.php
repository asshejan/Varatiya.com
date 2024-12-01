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

// Fetch data for bar chart
$chartDataQuery = "
    SELECT type, status, COUNT(*) as count 
    FROM Listing 
    GROUP BY type, status
";
$result = $conn->query($chartDataQuery);

$chartData = [];
while ($row = $result->fetch_assoc()) {
    $chartData[] = $row;
}

// Fetch all properties for table
$propertiesResult = $conn->query("SELECT id, title, price, address, city, sqft, bedrooms, bathrooms, type, status FROM Listing");
$properties = $propertiesResult->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        canvas {
            display: block;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
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
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Bar Chart -->
    <canvas id="propertyChart" width="800" height="400"></canvas>

    <!-- Properties Table -->
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
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No properties found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        // Prepare data for Chart.js
        const chartData = <?= json_encode($chartData) ?>;

        // Process data for chart
        const types = [...new Set(chartData.map(data => data.type))]; // Unique property types
        const statuses = ['For Rent', 'For Sell']; // Predefined statuses
        const dataset = statuses.map(status => ({
            label: status,
            backgroundColor: status === 'For Rent' ? '#007bff' : '#28a745',
            data: types.map(type => {
                const entry = chartData.find(data => data.type === type && data.status === status);
                return entry ? entry.count : 0;
            }),
        }));

        // Create the chart
        const ctx = document.getElementById('propertyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: types,
                datasets: dataset,
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
