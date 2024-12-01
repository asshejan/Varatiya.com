<?php
// Include the database connection
include 'config.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the ID from the URL (sanitize the input to prevent SQL injection)

    // Query the database for the property details using mysqli
    $stmt = $conn->prepare("SELECT * FROM listing WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" denotes that $id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc(); // Fetch the property data

    // If the property is not found, show an error message
    if (!$property) {
        die("Property not found.");
    }
} else {
    die("Invalid property ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($property['title']) ?> - Property Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons for decoration -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom styling */
        body {
            background-color: #f8f9fa;
        }

        .property-title {
            color: #2C3E50;
            font-size: 2rem;
            font-weight: bold;
        }

        .price {
            color: #27AE60;
            font-size: 1.5rem;
        }

        .badge-custom {
            font-size: 1rem;
            padding: 0.5rem 1rem;
        }

        .property-description {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .property-details ul {
            padding-left: 0;
        }

        .property-details ul li {
            list-style-type: none;
            padding: 8px 0;
        }

        .property-details ul li strong {
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row">
        <!-- Image Section -->
        <div class="col-lg-6">
            <img class="img-fluid rounded shadow-sm" src="<?= htmlspecialchars($property['image_url']) ?>" alt="<?= htmlspecialchars($property['title']) ?>">
        </div>
        <!-- Details Section -->
        <div class="col-lg-6">
            <h1 class="property-title"><?= htmlspecialchars($property['title']) ?></h1>
            <p><i class="fa fa-map-marker-alt text-primary me-2"></i><?= htmlspecialchars($property['address']) ?>, <?= htmlspecialchars($property['city']) ?></p>
            <h3 class="price"><?= number_format($property['price'], 2) ?> BDT</h3>
            <div class="mb-3">
                <span class="badge bg-primary badge-custom"><?= htmlspecialchars($property['type']) ?></span>
                <span class="badge bg-success badge-custom"><?= htmlspecialchars($property['status']) ?></span>
            </div>
            <div class="property-details">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Square Footage:</strong> <?= htmlspecialchars($property['sqft']) ?> Sqft</li>
                    <li class="list-group-item"><strong>Bedrooms:</strong> <?= htmlspecialchars($property['bedrooms'] ?? 'N/A') ?></li>
                    <li class="list-group-item"><strong>Bathrooms:</strong> <?= htmlspecialchars($property['bathrooms'] ?? 'N/A') ?></li>
                    <li class="list-group-item"><strong>City:</strong> <?= htmlspecialchars($property['city']) ?></li>
                    <li class="list-group-item"><strong>Buyer Contact☎️</strong> <?= htmlspecialchars($property['buyerContact']) ?></li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Description Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h4>Description</h4>
            <div class="property-description">
                <p><?= htmlspecialchars($property['Description'] ?? 'No description available') ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
