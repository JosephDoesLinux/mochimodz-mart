<?php
/**
 * Checkout Page Handler
 * 
 * This script handles the checkout process for the MochiModz Mart e-commerce site.
 * It displays order summary and processes customer shipping/payment information.
 * 
 * Features:
 * - User authentication check
 * - Cart summary display with item details and total
 * - Shipping information collection
 * - Payment method selection
 * - Order confirmation
 * 
 * Security measures:
 * - Session validation
 * - SQL prepared statements
 * - HTML escaping for output
 * 
 * Database interactions:
 * - Queries carts table for user's cart
 * - Joins cart_items and parts tables for order details
 * 
 * Dependencies:
 * - config.php: Database and session configuration
 * - navbar.php: Site navigation
 * - Bootstrap 5.3.0
 * - Custom CSS (styles.css)
 * 
 * @requires PHP >= 7.0
 * @requires PDO
 * @requires Session
 * @author Joseph Abou Antoun 52330567
 */

// Include configuration and database connection
require 'config.php';

// Check if user is logged in, redirect to login if not
if (empty($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Fetch user's cart from database
$c = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
$c->execute([$_SESSION['user_id']]);
$cart = $c->fetch();

// Initialize cart items array and total
$items = [];
$total = 0.00;

// If cart exists, fetch all items with their details
if ($cart) {
  // Prepare and execute query to get cart items with product details
  $ci = $pdo->prepare("
    SELECT p.name, p.price, ci.quantity
    FROM cart_items ci
    JOIN parts p ON ci.part_id = p.id
    WHERE ci.cart_id = ?
  ");
  $ci->execute([$cart['id']]);
  $items = $ci->fetchAll();
  
  // Calculate total price
  foreach ($items as $it) {
    $total += $it['price'] * $it['quantity'];
  }
}

// Handle form submission
$showThankYou = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Form was submitted - in production, payment processing would go here
  $showThankYou = true;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout – MochiModz Mart</title>

  <!-- External CSS Dependencies -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <!-- Include navigation bar -->
  <?php include 'navbar.php'; ?>

  <main class="container py-5">
    <?php if ($showThankYou): ?>
      <!-- Order confirmation message -->
      <div class="text-center py-5">
        <h2>Thank You for Your Order!</h2>
        <p class="lead">We've received your order and will start processing it right away.</p>
        <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
      </div>
    <?php else: ?>
      <h2 class="mb-4">Checkout</h2>
      <div class="row">
        <!-- Order Summary Section -->
        <div class="col-md-5 mb-4">
          <div class="card">
            <div class="card-header">
              <strong>Order Summary</strong>
            </div>
            <ul class="list-group list-group-flush">
              <?php if (empty($items)): ?>
                <li class="list-group-item">Your cart is empty.</li>
              <?php else: ?>
                <?php foreach ($items as $it): ?>
                  <!-- Display each cart item with price -->
                  <li class="list-group-item d-flex justify-content-between">
                    <span><?= htmlspecialchars($it['name']) ?> × <?= $it['quantity'] ?></span>
                    <span>$<?= number_format($it['price'] * $it['quantity'], 2) ?></span>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
              <!-- Display total amount -->
              <li class="list-group-item d-flex justify-content-between">
                <strong>Total</strong>
                <strong>$<?= number_format($total, 2) ?></strong>
              </li>
            </ul>
          </div>
        </div>

        <!-- Shipping & Payment Form Section -->
        <div class="col-md-7">
          <form method="post">
            <!-- Customer Information Fields -->
            <div class="mb-3">
              <label for="fullname" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Shipping Address</label>
              <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email for Confirmation</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <hr>
            <!-- Payment Information Fields -->
            <h5 class="mb-3">Payment Method</h5>
            <div class="mb-3">
              <select class="form-select" name="payment_method" required>
                <option value="" disabled selected>-- Select --</option>
                <option>Credit Card</option>
                <option>PayPal</option>
                <option>Bank Transfer</option>
              </select>
            </div>
            <!-- Credit Card Information -->
            <div class="mb-3">
              <label for="ccnumber" class="form-label">Card Number</label>
              <input type="text" class="form-control" id="ccnumber" name="ccnumber">
            </div>
            <div class="row">
              <div class="col">
                <label for="exp" class="form-label">Expiry</label>
                <input type="text" class="form-control" id="exp" name="exp">
              </div>
              <div class="col">
                <label for="cvc" class="form-label">CVC</label>
                <input type="text" class="form-control" id="cvc" name="cvc">
              </div>
            </div>
            <button type="submit" class="btn btn-success btn-lg mt-4">Confirm Order</button>
          </form>
        </div>
      </div>
    <?php endif; ?>
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

  <!-- JavaScript Dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
