<?php
include 'config.php';

// Initialize variables from POST
$searchKeyword = isset($_POST['type']) ? $_POST['type'] : '';
$propertyStatus = isset($_POST['status']) ? $_POST['status'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
$items_per_page = 9;

// Build SQL query to fetch listings
$sql = "SELECT * FROM Listing WHERE 1=1";

// Add filters to the query
if (!empty($searchKeyword)) {
    // Filter based on the 'type' column (e.g., Apartment, Villa, etc.)
    $sql .= " AND type LIKE '$searchKeyword'";
}

if (!empty($propertyStatus)) {
    // Filter based on the 'status' column (For Rent or For Sell)
    $sql .= " AND status = '$propertyStatus'";
}

if (!empty($city)) {
    // Filter based on the 'city' column
    $sql .= " AND city LIKE '%$city%'";
}

// Default behavior when no filter is applied
if (empty($searchKeyword) && empty($propertyStatus) && empty($city)) {
    $sql .= " ORDER BY created_at DESC"; // Order by latest added listings
}

// Add pagination
$sql .= " LIMIT $offset, $items_per_page";

// Execute query to get listings
$result = $conn->query($sql);

// Fetch listings
$current_listings = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $current_listings[] = $row;
    }
}

// Count total items for pagination
$total_query = "SELECT COUNT(*) as total FROM Listing WHERE 1=1";
if (!empty($searchKeyword)) {
    $total_query .= " AND type LIKE '%$searchKeyword%'";
}
if (!empty($propertyStatus)) {
    $total_query .= " AND status = '$propertyStatus'";
}
if (!empty($city)) {
    $total_query .= " AND city LIKE '%$city%'";
}

$total_result = $conn->query($total_query);
$total_items = $total_result ? $total_result->fetch_assoc()['total'] : 0;
$next_offset = $offset + $items_per_page;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Varatiya.com</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="home.php" class="navbar-brand d-flex align-items-center text-center">
                    <div class="icon p-2 me-2">
                        <img class="img-fluid" src="img/icon-deal.png" alt="Icon" style="width: 30px; height: 30px;">
                    </div>
                    <h1 class="m-0 text-primary">Varatiya <h6>.com</h6></h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="home.php" class="nav-item nav-link">Home</a>
                        <a href="about.html" class="nav-item nav-link">About</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Property</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="property-list.php" class="dropdown-item">Property List</a>
                                <a href="property-type.php" class="dropdown-item">Property Type</a>
                                <a href="property-agent.html" class="dropdown-item">Property Agent</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                <a href="404.html" class="dropdown-item active">404 Error</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="logout.php" class="btn btn-primary px-3 d-none d-lg-flex">log Out</a>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->




        <!-- Header Start -->
        <div class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 animated fadeIn mb-4">Property List</h1> 
                        <nav aria-label="breadcrumb animated fadeIn">
                        <ol class="breadcrumb text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item text-body active" aria-current="page">Property List</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 animated fadeIn">
                    <img class="img-fluid" src="img/header.jpg" alt="">
                </div>
            </div>
        </div>
        <!-- Header End -->


        <!-- Search Section -->
<div class="container-fluid bg-primary mb-5" style="padding: 35px;">
    <div class="container">
        <form method="POST" action="">
            <div class="row g-3">
                <!-- Property Type -->
                <div class="col-md-4">
                    <select name="type" class="form-select border-0 py-3">
                        <option value="">Property Type</option>
                        <option value="Apartment" <?= $searchKeyword == 'Apartment' ? 'selected' : '' ?>>Apartment</option>
                        <option value="Villa" <?= $searchKeyword == 'Villa' ? 'selected' : '' ?>>Villa</option>
                        <option value="Home" <?= $searchKeyword == 'Home' ? 'selected' : '' ?>>Home</option>
                        <option value="Sublet" <?= $searchKeyword == 'Sublet' ? 'selected' : '' ?>>Sublet</option>
                        <option value="Building" <?= $searchKeyword == 'Building' ? 'selected' : '' ?>>Building</option>
                        <option value="Townhouse" <?= $searchKeyword == 'Townhouse' ? 'selected' : '' ?>>Townhouse</option>
                        <option value="Hostel" <?= $searchKeyword == 'Hostel' ? 'selected' : '' ?>>Hostel</option>
                        <option value="Garage" <?= $searchKeyword == 'Garage' ? 'selected' : '' ?>>Garage</option>
                    </select>
                </div>
                
                <!-- Property Status -->
                <div class="col-md-4">
                    <select name="status" class="form-select border-0 py-3">
                        <option value="">Property Status</option>
                        <option value="For Rent" <?= $propertyStatus == 'For Rent' ? 'selected' : '' ?>>For Rent</option>
                        <option value="For Sell" <?= $propertyStatus == 'For Sell' ? 'selected' : '' ?>>For Sell</option>
                    </select>
                </div>

                <!-- City Search -->
                <div class="col-md-4">
                    <input type="text" name="city" class="form-control border-0 py-3" placeholder="Search By City" value="<?= htmlspecialchars($city) ?>">
                </div>
            </div>

            <!-- Search Button -->
            <div class="row mt-3">
                <div class="col-md-2 offset-md-10">
                    <button type="submit" class="btn btn-dark border-0 w-100 py-3">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Property Listings Section -->
<div class="container">
    <div class="row">
        <?php if (!empty($current_listings)): ?>
            <?php foreach ($current_listings as $listing): ?>
                <div class="col-lg-4 col-md-6 property-item mb-4">
                    <div class="property-item rounded overflow-hidden shadow">
                        <!-- Image with Status and Type Badges -->
                        <div class="position-relative overflow-hidden">
                            <a href="property-details.php?id=<?= htmlspecialchars($listing['id']) ?>">
                                <img class="img-fluid w-100" src="<?= htmlspecialchars($listing['image_url']) ?>" alt="<?= htmlspecialchars($listing['title']) ?>">
                            </a>
                            <!-- For Sell/For Rent badge at top-center -->
                            <div class="bg-success rounded text-white position-absolute top-0 start-50 translate-middle-x mt-3 py-1 px-3">
                                <?= htmlspecialchars($listing['status']) ?>
                            </div>
                            <!-- Property Type at bottom-left with white background -->
                            <div class="bg-white text-primary rounded position-absolute start-0 bottom-0 m-3 py-1 px-3 shadow-sm">
                                <?= htmlspecialchars($listing['type']) ?>
                            </div>
                        </div>
                        <!-- Property Details -->
                        <div class="p-4 pb-0">
                            <h5 class="text-primary mb-3"><?= number_format($listing['price'], 2) ?> BDT</h5>
                            <a class="d-block h5 mb-2" href="property-details.php?id=<?= htmlspecialchars($listing['id']) ?>">
                                <?= htmlspecialchars($listing['title']) ?>
                            </a>
                            <p>
                                <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                <?= htmlspecialchars($listing['address']) ?>, <?= htmlspecialchars($listing['city']) ?>
                            </p>
                        </div>
                        <!-- Additional Info -->
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2">
                                <i class="fa fa-ruler-combined text-primary me-2"></i>
                                <?= htmlspecialchars($listing['sqft']) ?> Sqft
                            </small>
                            <small class="flex-fill text-center border-end py-2">
                                <i class="fa fa-bed text-primary me-2"></i>
                                <?= htmlspecialchars($listing['bedrooms']) ?> Bed
                            </small>
                            <small class="flex-fill text-center py-2">
                                <i class="fa fa-bath text-primary me-2"></i>
                                <?= htmlspecialchars($listing['bathrooms'] ?? 'N/A') ?> Bath
                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No properties found. Please try a different search.</p>
        <?php endif; ?>
    </div>

    <!-- Load More Button -->
    <?php if ($next_offset < $total_items): ?>
        <form method="POST" action="" class="text-center mt-4">
            <input type="hidden" name="offset" value="<?= $next_offset ?>">
            <input type="hidden" name="type" value="<?= htmlspecialchars($searchKeyword) ?>"> <!-- Preserve search term -->
            <input type="hidden" name="status" value="<?= htmlspecialchars($propertyStatus) ?>">
            <input type="hidden" name="city" value="<?= htmlspecialchars($city) ?>">
            <button type="submit" class="btn btn-primary">Load More</button>
        </form>
    <?php endif; ?>
</div>
<!-- Property Listings Section -->

        <!-- Call to Action Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="bg-light rounded p-3">
                    <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
                        <div class="row g-5 align-items-center">
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                                <img class="img-fluid rounded w-100" src="img/call-to-action.jpg" alt="">
                            </div>
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="mb-4">
                                    <h1 class="mb-3">Contact With Our Certified Agent</h1>
                                    <p>Eirmod sed ipsum dolor sit rebum magna erat. Tempor lorem kasd vero ipsum sit sit diam justo sed vero dolor duo.</p>
                                </div>
                                <a href="" class="btn btn-primary py-3 px-4 me-2"><i class="fa fa-phone-alt me-2"></i>Make A Call</a>
                                <a href="" class="btn btn-dark py-3 px-4"><i class="fa fa-calendar-alt me-2"></i>Get Appoinment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Call to Action End -->
        

       
        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Get In Touch</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Road - 14, Block - J, Bashundhara R/A</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+880 1701909276</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>as.shejan@gmail.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href="https://x.com/as_shejan"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/as.shejan/"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href="https://x.com/as_shejan"><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href="https://www.linkedin.com/in/asshejan/?originalSubdomain=bd"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                       
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <!-- <h5 class="text-white mb-4">Photo Gallery</h5> -->
                        <div class="row g-2 pt-2">
                            <!-- <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-1.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-2.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-3.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-4.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-5.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-6.jpg" alt="">
                            </div> -->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <!-- <h5 class="text-white mb-4">Newsletter</h5>
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div> -->
                         <h5 class="text-white mb-4">Quick Links</h5>
                        <a class="btn btn-link text-white-50" href="about.html">About Us</a>
                        <a class="btn btn-link text-white-50" href="contact.html">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="https://support.google.com/">Our Services</a>
                        <a class="btn btn-link text-white-50" href="https://support.google.com/">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="https://support.google.com/">Terms & Condition</a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">www.varatiya.com</a>, All Right Reserved. 
							
							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							Designed By <a class="border-bottom" href="#">As Shejan</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="home.php">Home</a>
                                <a href="https://support.google.com/">Cookies</a>
                                <a href="https://support.google.com/">Help</a>
                                <a href="https://support.google.com/">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

<?php $conn->close(); ?>
