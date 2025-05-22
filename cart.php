<?php
/**
 * Shopping Cart Management Page
 * 
 * This script handles the shopping cart functionality for the PC parts store.
 * It requires user authentication and manages cart operations including:
 * - Displaying cart items
 * - Updating item quantities
 * - Removing items from cart
 * - Calculating total price
 * 
 * Dependencies:
 * - config.php: Database connection and session management
 * - navbar.php: Site navigation component
 * 
 * Database Tables Used:
 * - carts: Stores cart information linked to users
 * - cart_items: Stores individual items in carts
 * - parts: Stores product information
 * 
 * Session Requirements:
 * - user_id: Must be set for authentication
 * 
 * POST Actions:
 * - remove_item: Removes specific item from cart
 * - update_qty: Updates quantities for multiple items
 * 
 * @package PCShop
 * @author Joseph Abou Antoun
 * @version 1.0
 * @access public
 */

// Include configuration file for database connection
require 'config.php';

// Check if user is logged in, redirect to login if not
if (empty($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Define product categories for navigation
$cats = ['CPU','GPU','RAM','Motherboard','Storage','Cooler'];

// Handle POST requests for cart modifications
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cart_id = null;
  
  // Retrieve existing cart ID for current user
  $c = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
  $c->execute([$_SESSION['user_id']]);
  $row = $c->fetch();
  if ($row) $cart_id = $row['id'];

  // Redirect if no cart exists
  if (! $cart_id) {
    header('Location: cart.php');
    exit;
  }

  // Handle item removal
  if (isset($_POST['remove_item'])) {
    $rm = $pdo->prepare("DELETE FROM cart_items WHERE id = ?");
    $rm->execute([ (int)$_POST['remove_item'] ]);
  }
  // Handle quantity updates
  else if (isset($_POST['update_qty'], $_POST['qty']) && is_array($_POST['qty'])) {
    foreach ($_POST['qty'] as $item_id => $q) {
      // Ensure quantity is at least 1
      $q = max(1, (int)$q);
      $up = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
      $up->execute([$q, (int)$item_id]);
    }
  }

  // Redirect back to cart page after modifications
  header('Location: cart.php');
  exit;
}

// Fetch current user's cart and items
$c = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
$c->execute([$_SESSION['user_id']]);
$cart = $c->fetch();
$items = [];

// If cart exists, fetch all items with their details
if ($cart) {
  $ci = $pdo->prepare("
    SELECT ci.id AS cart_item_id, p.id AS part_id, p.name, p.price, ci.quantity
    FROM cart_items ci
    JOIN parts p ON ci.part_id = p.id
    WHERE ci.cart_id = ?
  ");
  $ci->execute([ $cart['id'] ]);
  $items = $ci->fetchAll();
}

// Calculate total price of all items in cart
$total = array_reduce($items, function($sum, $it) {
  return $sum + $it['price'] * $it['quantity'];
}, 0);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Cart – MochiModz Mart</title>

  <!-- External CSS dependencies -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="d-flex flex-column min-vh-100">

  <?php include 'navbar.php'; // Include navigation component ?>

  <!-- Main content area -->
  <main class="container py-5 flex-grow-1">
    <h2 class="mb-4">Your Shopping Cart</h2>

    <?php if (empty($items)): ?>
      <!-- Display message for empty cart -->
      <div class="alert alert-info">Your cart is empty. <a href="index.php">Continue shopping.</a></div>
    <?php else: ?>
      <!-- Cart items form -->
      <form method="post">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Part</th>
              <th>Price</th>
              <th style="width:120px">Quantity</th>
              <th>Subtotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $it): ?>
              <tr>
                <td><?= htmlspecialchars($it['name']) ?></td>
                <td>$<?= number_format($it['price'],2) ?></td>
                <td>
                  <!-- Quantity input field -->
                  <input
                    type="number"
                    name="qty[<?= $it['cart_item_id'] ?>]"
                    value="<?= $it['quantity'] ?>"
                    min="1"
                    class="form-control form-control-sm"
                  >
                </td>
                <td>$<?= number_format($it['price'] * $it['quantity'], 2) ?></td>
                <td>
                  <!-- Remove item button -->
                  <button
                    type="submit"
                    name="remove_item"
                    value="<?= $it['cart_item_id'] ?>"
                    class="btn btn-sm btn-outline-danger"
                    title="Remove this item"
                  >&times;</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-end">Total</th>
              <th>$<?= number_format($total,2) ?></th>
              <th></th>
            </tr>
          </tfoot>
        </table>

        <!-- Cart action buttons -->
        <div class="d-flex justify-content-between">
          <a href="index.php" class="btn btn-outline-secondary">← Continue Shopping</a>
          <div>
            <button type="submit" name="update_qty" class="btn btn-primary me-2">Update Cart</button>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </main>

  <!-- Footer section -->
  <footer class="footer mt-auto py-4 w-100 text-center">
    <div class="container-fluid text-center">
      <p class="mb-1">&copy; <?= date('Y') ?> MochiModz Mart, Inc. All rights reserved. Joseph Abou Antoun 52330567</p>
      <small>
        <a href="privacy.php">Privacy Policy</a> |
        <a href="terms.php">Terms of Service</a> |
        <a href="contact.php">Contact</a>
      </small>
    </div>
  </footer>

  <!-- JavaScript dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
