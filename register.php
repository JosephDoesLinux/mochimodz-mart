<?php
require 'config.php';
include 'navbar.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username']);
    $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if ($u && $_POST['password']) {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?,?)");
        try {
            $stmt->execute([$u, $p]);
            header('Location: login.php');
            exit;
        } catch (Exception $e) {
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

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Font: Poppins -->
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
    <h2>Register</h2>

    <?php if ($err): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <input name="username" class="form-control" placeholder="Username" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button class="btn btn-primary">Register</button>
    </form>

    <p class="mt-3">
      Already have an account? <a href="login.php">Login</a>
    </p>

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
  <footer class="footer mt-auto py-4 w-100 text-center">
    <div class="container-fluid">
      <p class="mb-1">&copy; <?= date('Y') ?> MochiModz Mart, Inc. All rights reserved.</p>
      <small>
        <a href="privacy.php">Privacy Policy</a> |
        <a href="terms.php">Terms of Service</a> |
        <a href="contact.php">Contact</a>
      </small>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
