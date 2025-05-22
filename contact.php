<!-- /**
 * Contact Form Handler and Display Page
 * 
 * This page provides a contact form for authenticated users to submit messages to support.
 * It handles both the form display and submission processing.
 *
 * Features:
 * - Authentication check with redirect to login if not authenticated
 * - Form validation for name, email and message
 * - Database storage of contact messages
 * - Success/error message display
 * - XSS prevention through htmlspecialchars
 * - Form field persistence on validation errors
 *
 * Database table required:
 * contacts (
 *   id INT PRIMARY KEY AUTO_INCREMENT,
 *   user_id INT,
 *   name VARCHAR(255),
 *   email VARCHAR(255), 
 *   message TEXT,
 *   created_at DATETIME
 * )
 *
 * Dependencies:
 * - config.php: Database connection and session management
 * - navbar.php: Site navigation
 * - Bootstrap 5.3.0
 * - Google Fonts (Poppins)
 * - Custom CSS (css/styles.css)
 *
 * @see login.php For authentication
 * @see config.php For database connection
 * @author     Joseph Abou Antoun 52330567
 */ -->
<?php
// Include database connection and session management
require 'config.php';

// Security check: Ensure user is authenticated
if (empty($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Initialize error and success flags
$err = '';
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and validate input fields
  $name    = trim($_POST['name'] ?? '');
  $email   = trim($_POST['email'] ?? '');
  $message = trim($_POST['message'] ?? '');

  // Validate all required fields
  if (! $name || ! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $message) {
    $err = 'Please fill in all fields with valid information.';
  } else {
    // Prepare SQL statement to prevent SQL injection
    $stmt = $pdo->prepare("
      INSERT INTO contacts (user_id, name, email, message, created_at)
      VALUES (?, ?, ?, ?, NOW())
    ");
    try {
      // Execute the prepared statement with user data
      $stmt->execute([
        $_SESSION['user_id'],
        $name,
        $email,
        $message,
      ]);
      $success = true;
    } catch (Exception $e) {
      // Handle database errors gracefully
      $err = 'Unable to send message. Please try again later.';
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us – MochiModz Mart</title>

  <!-- External CSS Dependencies -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Font Integration -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap"
    rel="stylesheet">
  <!-- Site-specific styles -->
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- Include navigation bar -->
  <?php include 'navbar.php'; ?>

  <!-- Main content area -->
  <main class="container py-5 flex-grow-1">
    <h2 class="mb-4">Contact Support</h2>

    <!-- Display error or success messages -->
    <?php if ($err): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
    <?php elseif ($success): ?>
      <div class="alert alert-success">
        Thanks, <?= htmlspecialchars($name) ?>! Your message has been sent. We'll get back to you shortly.
      </div>
    <?php endif; ?>

    <!-- Contact form with Bootstrap styling -->
    <form action="contact.php" method="post" class="mt-3">
      <div class="row g-3">
        <!-- Name field -->
        <div class="col-md-6">
          <label for="contactName" class="form-label">Name</label>
          <input
            type="text"
            class="form-control"
            id="contactName"
            name="name"
            placeholder="Your Name"
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
            required
          >
        </div>
        <!-- Email field -->
        <div class="col-md-6">
          <label for="contactEmail" class="form-label">Email</label>
          <input
            type="email"
            class="form-control"
            id="contactEmail"
            name="email"
            placeholder="you@example.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            required
          >
        </div>
        <!-- Message field -->
        <div class="col-12">
          <label for="contactMessage" class="form-label">Message</label>
          <textarea
            class="form-control"
            id="contactMessage"
            name="message"
            rows="5"
            placeholder="How can we help you?"
            required
          ><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </div>
        <!-- Submit button -->
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-success">Send Message</button>
        </div>
      </div>
    </form>
  </main>

  <!-- Site footer -->
  <footer class="footer mt-auto py-4 w-100 text-center">
    <div class="container">
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
