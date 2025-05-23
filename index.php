<!-- /**
 * Main Shop Page - MochiModz Mart
 * 
 * This is the primary landing page for the PC components e-commerce website.
 * It handles product listing and category filtering functionality.
 * 
 * Features:
 * - User authentication check
 * - Category-based product filtering
 * - Product listing with images and basic details
 * - Responsive layout using Bootstrap 5
 * 
 * Page Sections:
 * - Hero section with main call-to-action
 * - Featured categories grid with icons
 * - Product listing with filtering capability
 * - About Us section
 * - Footer with links
 * 
 * Security Features:
 * - Session-based authentication
 * - SQL injection prevention using PDO prepared statements
 * - XSS prevention using htmlspecialchars()
 * 
 * Dependencies:
 * - config.php: Database configuration and connection
 * - navbar.php: Navigation bar component
 * - Bootstrap 5.3.0
 * - Google Fonts (Poppins)
 * - Custom CSS (styles.css)
 * 
 * @requires PHP >= 7.0
 * @requires PDO
 * @category E-commerce
 * @package  MochiModz
 * @author   [Your Name]
 * @license  [License Information]
  * @author     Joseph Abou Antoun 52330567

 */ -->
<?php
// Include database configuration and establish connection
require 'config.php';

// Check if user is logged in, redirect to login page if not
if (empty($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Define available product categories array
// Used in both navigation and featured categories section
$cats = ['CPU','GPU','RAM','Motherboard','Storage','Cooler'];

// Database query to fetch parts
// If category parameter exists and is valid, fetch parts from that category
// Otherwise fetch all parts
if (!empty($_GET['cat']) && in_array($_GET['cat'], $cats, true)) {
  // Prepare parameterized query for security against SQL injection
  $stmt = $pdo->prepare("SELECT * FROM parts WHERE category = ?");
  $stmt->execute([$_GET['cat']]);
} else {
  // No category filter - fetch all parts
  $stmt = $pdo->query("SELECT * FROM parts");
}
// Fetch all results into $parts array
$parts = $stmt->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MochiModz Mart Shop</title>

  <!-- Load Bootstrap CSS framework -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Setup Google Fonts - Poppins with different weights -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap"
    rel="stylesheet">

  <!-- Custom styles -->
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="d-flex flex-column min-vh-100">

  <?php include 'navbar.php'; ?>
<main class="container py-5 flex-grow-1">
  <!-- Hero -->
  <section class="text-center mb-5">
    <h1 class="display-4">Build Your Dream PC</h1>
    <p class="lead">Choose from the widest selection of top-tier CPUs, GPUs, motherboards, RAM &amp; more—all priced competitively.</p>
    <a href="#categories" class="btn btn-primary btn-lg">Shop Categories</a>
  </section>

  <!-- Featured Categories -->
  <section id="categories" class="mb-5">
    <h2 class="mb-4">Browse by Category</h2>
    <div class="row g-4">
      <?php foreach ($cats as $c): ?>
        <div class="col-md-4 col-lg-2 text-center">
          <a href="index.php?cat=<?= urlencode($c) ?>" class="text-decoration-none text-dark">
            <div class="card p-3 h-100">
              <img src="images/<?= strtolower($c) ?>.png" alt="<?= htmlspecialchars($c) ?>" class="mb-3" style="height:80px; object-fit:contain;">
              <h5><?= htmlspecialchars($c) ?></h5>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Parts Listing -->
  <section>
    <h2 class="mb-4"><?= empty($_GET['cat']) ? 'All Parts' : htmlspecialchars($_GET['cat']) . 's' ?></h2>
    <div class="row">
      <?php if (empty($parts)): ?>
        <p class="text-muted">No parts found in this category.</p>
      <?php else: ?>
        <?php foreach ($parts as $p): ?>
          <div class="col-md-4">
            <div class="card mb-4">
              <?php if ($p['image']): ?>
                <img src="images/<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>">
              <?php endif; ?>
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
                <p class="card-text text-muted"><?= htmlspecialchars($p['category']) ?></p>
                <p class="card-text">$<?= number_format($p['price'],2) ?></p>
                <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-primary">View Details</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- About Us -->
<section class="mt-5 p-4 bg-white rounded shadow-sm d-flex align-items-center">
 <img src="images/logo.png" alt="About Us Icon" style="height: 6rem; margin-right: 1rem;">
 <div>
    <h3>About MochiModz Mart</h3>
    <p>
      Founded in 2025 by PC enthusiasts, MochiModz Mart is dedicated to bringing you the
      best selection of cutting-edge components with unbeatable customer service.
      Whether you’re overclocking your first build or assembling a high-end workstation,
      our curated catalog and expert guides have got you covered.
    </p>
    <p>
      <strong>Free shipping</strong> on orders over $100. <strong>30-day price match guarantee.</strong>
      Questions? <a href="contact.php">Contact our support team</a>.
    </p>
    </div>
  </section>
              </main>

  <!-- Footer -->
  <footer class="footer mt-auto py-4 text-center">
    <div class="container">
      <p class="mb-1">&copy; <?= date('Y') ?> MochiModz Mart, Inc. All rights reserved. Joseph Abou Antoun 52330567</p>
      <small>
        <a href="privacy.php">Privacy Policy</a> |
        <a href="terms.php">Terms of Service</a> |
        <a href="contact.php">Contact</a>
      </small>
    </div>
  </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-...your-integrity-hash..." crossorigin="anonymous"></script>
</body>