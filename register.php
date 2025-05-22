<?php
/**
 * User Registration Page
 * 
 * This script handles new user registration for MochiModz Mart.
 * It processes POST requests to create new user accounts in the database.
 * 
 * Features:
 * - Username and password validation
 * - Password hashing using PASSWORD_DEFAULT
 * - Duplicate username checking
 * - Redirect to login page on successful registration
 * 
 * Database:
 * - Table: users
 * - Columns: username, password
 * 
 * Dependencies:
 * - config.php: Database configuration and connection
 * - navbar.php: Site navigation header
 * - Bootstrap 5.3.0
 * - Custom styles.css
 * 
 * @uses PDO For database operations
 * @uses password_hash() For secure password hashing
 * @throws Exception When username already exists
 * @author Joseph Abou Antoun 52330567
 */

// Include required configuration and navigation files
require 'config.php';
include 'navbar.php';

// Initialize error message variable
$err = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize username input and hash password
  $u = trim($_POST['username']);
  $p = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // Verify both username and password are provided
  if ($u && $_POST['password']) {
    // Prepare SQL statement to prevent SQL injection
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?,?)");
    try {
      // Attempt to insert new user
      $stmt->execute([$u, $p]);
      // Redirect to login page on success
      header('Location: login.php');
      exit;
    } catch (Exception $e) {
      // Handle duplicate username error
      $err = 'Username taken.';
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register – MochiModz Mart</title>

  <!-- External CSS Dependencies -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts Integration -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <!-- Custom Stylesheet -->
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="d-flex flex-column min-vh-100">

  <?php include 'navbar.php'; // Include navigation bar ?>

  <main class="container py-5 flex-grow-1">
    <h2>Register</h2>

    <!-- Display error message if any -->
    <?php if ($err): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form method="post">
      <div class="mb-3">
        <input name="username" class="form-control" placeholder="Username" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button class="btn btn-primary">Register</button>
    </form>

    <!-- Login Link -->
    <p class="mt-3">
      Already have an account? <a href="login.php">Login</a>
    </p>

    <!-- About Section -->
    <section class="mt-5 p-4 bg-white rounded shadow-sm d-flex align-items-center">
      <img src="images/logo.png" alt="About Us Icon" style="height: 6rem; margin-right: 1rem;">
      <div>
        <h3>About MochiModz Mart</h3>
        <p>
          Founded in 2025 by PC enthusiasts, MochiModz Mart is dedicated to bringing you the
          best selection of cutting-edge components with unbeatable customer service.
          Whether you're overclocking your first build or assembling a high-end workstation,
          our curated catalog and expert guides have got you covered.
        </p>
        <p>
          <strong>Free shipping</strong> on orders over $100. <strong>30-day price match guarantee.</strong>
          Questions? <a href="contact.php">Contact our support team</a>.
        </p>
      </div>
    </section>
  </main>

  <!-- Footer Section -->
  <footer class="footer mt-auto py-4 w-100 text-center">
    <div class="container-fluid">
      <p class="mb-1">&copy; <?= date('Y') ?> MochiModz Mart, Inc. All rights reserved. Joseph Abou Antoun 52330567</p>
      <small>
        <a href="privacy.php">Privacy Policy</a> |
        <a href="terms.php">Terms of Service</a> |
        <a href="contact.php">Contact</a>
      </small>
    </div>
  </footer>

  <!-- JavaScript Dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
