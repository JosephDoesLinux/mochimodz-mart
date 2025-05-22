<!-- /**
 * Product Details Page
 * @author     Joseph Abou Antoun 52330567
 * 
 * This script displays detailed information about a specific product/part and allows adding it to cart.
 * Requires user authentication and database connection.
 * 
 * Features:
 * - Displays product details including name, description, price and image
 * - Handles adding product to shopping cart
 * - Includes navigation, about section and footer
 * 
 * Database Tables Used:
 * - parts: stores product information
 * - carts: stores user shopping carts
 * - cart_items: stores items in shopping carts
 * **/ -->
 <?php
// Include configuration and database connection
require 'config.php';
// Include navigation bar component
include 'navbar.php';

// Check if user is logged in, redirect to login if not
if (empty($_SESSION['user_id'])) header('Location: login.php');

// Get product ID from URL and sanitize it
$id = (int)$_GET['id'];
// Prepare and execute query to fetch product details
$stmt = $pdo->prepare("SELECT * FROM parts WHERE id = ?");
$stmt->execute([$id]);
$part = $stmt->fetch();
// Exit if product not found
if (!$part) exit('Part not found.');

// Handle POST request when adding item to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get current user's ID
  $uid = $_SESSION['user_id'];
  // Check if user already has a cart
  $c = $pdo->prepare("SELECT * FROM carts WHERE user_id = ?");
  $c->execute([$uid]);
  $cart = $c->fetch();
  
  // Create new cart if user doesn't have one
  if (!$cart) {
    $pdo->prepare("INSERT INTO carts(user_id) VALUES (?)")->execute([$uid]);
    $cart_id = $pdo->lastInsertId();
  } else {
    $cart_id = $cart['id'];
  }
  
  // Add item to cart or increment quantity if already exists
  $i = $pdo->prepare("INSERT INTO cart_items(cart_id, part_id) VALUES (?,?) ON DUPLICATE KEY UPDATE quantity = quantity + 1");
  $i->execute([$cart_id, $id]);

  // Ensure all database operations are complete before redirect
  session_write_close();
  header('Location: cart.php');
  exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Font: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/styles.css">
  <!-- Dynamic page title based on product name -->
  <title><?= htmlspecialchars($part['name']) ?></title>
</head>
<body class="d-flex flex-column min-vh-100">
  <main class="container py-5 flex-grow-1">
  <!-- Back to shop navigation -->
  <a href="index.php" class="btn btn-link">&laquo; Back to Shop</a>
  
  <!-- Product details section -->
  <div class="row mt-4">
  <!-- Product image column -->
  <div class="col-md-5">
    <?php if($part['image']): ?><img src="images/<?= htmlspecialchars($part['image']) ?>" class="img-fluid"><?php endif; ?>
  </div>
  <!-- Product information column -->
  <div class="col-md-7">
    <h2><?= htmlspecialchars($part['name']) ?></h2>
    <p><?= nl2br(htmlspecialchars($part['description'])) ?></p>
    <h4>$<?= number_format($part['price'],2) ?></h4>
    <!-- Add to cart form -->
    <form method="post" onsubmit="return addToCart(event)">
      <button class="btn btn-success" type="submit">Add to Cart</button>
    </form>
  </div>
  </div>

  <!-- About Us section -->
  <section class="mt-5 p-4 bg-white rounded shadow-sm">
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
  <script>
    function addToCart(event) {
      event.preventDefault();
      
      if (confirm('Are you sure you want to add this item to cart?')) {
        fetch(window.location.href, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          }
        })
        .then(response => {
          if (response.ok) {
            alert('Item has been added to cart!');
          }
        });
      }
      return false;
    }
  </script>
</body>
</html>