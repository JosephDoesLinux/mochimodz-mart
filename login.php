<?php
/**
 * User Login Page
 * 
 * This script handles user authentication by validating credentials against the database.
 * 
 * Flow:
 * 1. Includes required configuration and navigation files
 * 2. Processes POST login request if submitted
 * 3. Validates username/password against database
 * 4. Creates session and redirects on success, shows error on failure
 * 
 * Dependencies:
 * - config.php: Database connection and configuration settings
 * - navbar.php: Navigation bar component
 * - styles.css: Custom styling
 * - Bootstrap 5.3.0
 * - Google Fonts (Poppins)
 * 
 * Database:
 * - Table: users
 * - Relevant columns: id, username, password (hashed)
 * 
 * Security Features:
 * - Password hashing verification
 * - Prepared statements for SQL queries
 * - Session-based authentication
 * 
 * @uses $_POST['username'] Username input from login form
 * @uses $_POST['password'] Password input from login form
 * @uses $_SESSION['user_id'] Stores user ID upon successful login
 * 
 * @return void
 * @author Joseph Abou Antoun 52330567
 */

// Include necessary configuration and navigation
require 'config.php';
include 'navbar.php';

// Initialize error message variable
$err = '';

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = $_POST['username'];
  // Prepare SQL statement to prevent SQL injection
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$u]);
  $user = $stmt->fetch();
  
  // Verify user credentials
  if ($user && password_verify($_POST['password'], $user['password'])) {
    // Set session and redirect to homepage on success
    $_SESSION['user_id'] = $user['id'];
    header('Location: index.php');
    exit;
  }
  // Set error message if authentication fails
  $err = 'Invalid credentials.';
}
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Google Fonts: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/styles.css">

  <title>Login</title>
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- Main Content -->
  <main class="container py-5 flex-grow-1">
    <h2>Login</h2>
    <!-- Error message display -->
    <?php if($err): ?>
      <div class="alert alert-danger"><?= $err ?></div>
    <?php endif; ?>
    
    <!-- Login Form -->
    <form method="post">
      <div class="mb-3">
        <input name="username" class="form-control" placeholder="Username">
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password">
      </div>
      <button class="btn btn-primary">Login</button>
    </form>
    <p class="mt-3">No account? <a href="register.php">Register</a></p>

    <!-- About Us Section -->
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
  <footer class="footer mt-5 py-4" style="background-color: #FFD6E8;">
    <div class="container-fluid text-center">
      <p class="mb-1">&copy; <?= date('Y') ?> MochiModz Mart, Inc. All rights reserved. Joseph Abou Antoun 52330567</p>
      <small>
        <a href="privacy.php">Privacy Policy</a> |
        <a href="terms.php">Terms of Service</a> |
        <a href="contact.php">Contact</a>
      </small>
    </div>
  </footer>
</body>
</html>
