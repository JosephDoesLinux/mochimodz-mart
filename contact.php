<?php
require 'config.php';

// redirect to login if not authenticated
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$err = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (! $name || ! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $message) {
        $err = 'Please fill in all fields with valid information.';
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO contacts (user_id, name, email, message, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        try {
            $stmt->execute([
                $_SESSION['user_id'],
                $name,
                $email,
                $message,
            ]);
            $success = true;
        } catch (Exception $e) {
            $err = 'Unable to send message. Please try again later.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us – MochiModz Mart</title>

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
    <h2 class="mb-4">Contact Support</h2>

    <?php if ($err): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
    <?php elseif ($success): ?>
      <div class="alert alert-success">
        Thanks, <?= htmlspecialchars($name) ?>! Your message has been sent. We’ll get back to you shortly.
      </div>
    <?php endif; ?>

    <form action="contact.php" method="post" class="mt-3">
      <div class="row g-3">
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
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-success">Send Message</button>
        </div>
      </div>
    </form>
  </main>

  <!-- Footer -->
  <footer class="footer mt-auto py-4 w-100 text-center">
    <div class="container">
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
