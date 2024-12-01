<?php
// Include the database configuration
include 'config.php';

// Initialize variables for form handling
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $price = $_POST['price'];
    $sqft = $_POST['sqft'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $status = $_POST['status'];
    $type = $_POST['type'];
    $image_url = $_POST['image_url'] ?? null;
    $buyerContact = $_POST['buyerContact'] ?? null;
    $description = $_POST['description'] ?? null;

    // Insert into the database
    $sql = "INSERT INTO Listing (title, address, city, country, price, sqft, bedrooms, bathrooms, status, type, image_url, buyerContact, Description, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssdiissssss", $title, $address, $city, $country, $price, $sqft, $bedrooms, $bathrooms, $status, $type, $image_url, $buyerContact, $description);

        // Attempt to execute the statement
        if ($stmt->execute()) {
            $message = "Property added successfully!";
        } else {
            // Detailed error message
            $message = "Execution error: " . $stmt->error;
        }
    } else {
        // Detailed error message for prepare() failure
        $message = "Prepare error: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #00B98E;
            border: none;
        }
        .btn-primary:hover {
            background-color: #009773;
        }
        .header {
            color: #00B98E;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-label {
            color: #00B98E;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h1 class="header">Add Property</h1>

                    <?php if ($message): ?>
                        <div class="alert alert-info">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="form-group">
                            <label for="city" class="form-label">City:</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>

                        <div class="form-group">
                            <label for="country" class="form-label">Country:</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>

                        <div class="form-group">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        </div>

                        <div class="form-group">
                            <label for="sqft" class="form-label">Square Feet:</label>
                            <input type="number" class="form-control" id="sqft" name="sqft" required>
                        </div>

                        <div class="form-group">
                            <label for="bedrooms" class="form-label">Bedrooms:</label>
                            <input type="number" class="form-control" id="bedrooms" name="bedrooms">
                        </div>

                        <div class="form-group">
                            <label for="bathrooms" class="form-label">Bathrooms:</label>
                            <input type="number" class="form-control" id="bathrooms" name="bathrooms">
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="For Sell">For Sell</option>
                                <option value="For Rent">For Rent</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type" class="form-label">Type:</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="apartment">Apartment</option>
                                <option value="Villa">Villa</option>
                                <option value="Home">Home</option>
                                <option value="sublet">Sublet</option>
                                <option value="Building">Building</option>
                                <option value="Townhouse">Townhouse</option>
                                <option value="Hostel">Hostel</option>
                                <option value="Garage">Garage</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image_url" class="form-label">Image URL:</label>
                            <input type="url" class="form-control" id="image_url" name="image_url">
                        </div>
                        <div class="form-group">
    <label for="buyerContact" class="form-label">Buyer Contact:</label>
    <input type="text" class="form-control" id="buyerContact" name="buyerContact" maxlength="15" required>
</div>

<div class="form-group">
    <label for="description" class="form-label">Description:</label>
    <textarea class="form-control" id="description" name="description" rows="4" maxlength="500" required></textarea>
</div>


                        <button type="submit" class="btn btn-primary btn-block">Add Property</button>

                        <a href="home.php" class="btn btn-secondary btn-block">Back to Home</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
