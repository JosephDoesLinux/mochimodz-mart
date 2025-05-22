<!-- /**
 * Navigation Bar Component
 * 
 * This component creates a responsive navigation bar for the PC shop website.
 * It includes different navigation options based on user authentication status.
 * 
 * Features:
 * - Displays logo and brand name
 * - Shows full navigation menu for authenticated users on specific pages
 * - Provides category dropdown menu for product filtering
 * - Includes Cart and Logout buttons for authenticated users
 * - Shows Login, Sign Up and About Us buttons for non-authenticated users
 * 
 * Variables:
 * @var string $currentPage      Current page filename
 * @var array  $fullNavPages     Array of pages that should display full navigation
 * @var array  $cats            Array of product categories
 * 
 * Dependencies:
 * - Requires Bootstrap 5.x for styling and components
 * - Requires session to be started for user authentication
 * - Requires images/logo.png file
 * 
 * Usage:
 * Include this file in pages where navigation is needed:
 * require_once 'navbar.php';
 * @author     Joseph Abou Antoun 52330567
 */ -->
<?php
// Get the current page filename for active state handling
$currentPage = basename($_SERVER['PHP_SELF']);
// Define pages that should show the full navigation menu
$fullNavPages = ['index.php','product.php','cart.php','checkout.php'];
// Define product categories for the dropdown menu
$cats = ['CPU','GPU','RAM','Motherboard','Storage','Cooler'];
?>
<!-- Main navigation element with Bootstrap classes:
  navbar-expand-lg: Expands to full menu on large screens
  fixed-top: Keeps navbar at top of viewport while scrolling
  shadow-sm: Adds subtle shadow effect -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
  <!-- Container class provides responsive padding and centering -->
  <div class="container">
    <!-- Brand section with logo and text -->
    <a class="navbar-brand fw-bold" href="index.php">
   <!-- Logo image with Bootstrap spacing and alignment classes:
     d-inline-block: Makes image inline with text
     align-text-top: Aligns image with top of text
     me-2: Adds margin to right of image -->
   <img src="images/logo.png" width="30" class="d-inline-block align-text-top me-2" alt="">
   MochiModz Mart
    </a>

    <?php if (in_array($currentPage, $fullNavPages) && !empty($_SESSION['user_id'])): ?>
   <!-- Hamburger menu button for mobile views:
     data-bs-toggle/target: Bootstrap's JavaScript functionality -->
   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
     <span class="navbar-toggler-icon"></span>
   </button>
   <!-- Collapsible navigation content -->
   <div class="collapse navbar-collapse" id="mainNavbar">
     <!-- Main navigation list:
       me-auto: Pushes following content to the right
       mb-2 mb-lg-0: Adds bottom margin on mobile, removes on large screens -->
     <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <!-- All Categories link with dynamic active state -->
    <li class="nav-item">
      <a class="nav-link<?= $currentPage==='index.php' && empty($_GET['cat']) ? ' active' : '' ?>"
      href="index.php">All Categories</a>
    </li>
    <!-- Categories dropdown menu -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle<?= !empty($_GET['cat']) ? ' active' : '' ?>"
      href="#" role="button" data-bs-toggle="dropdown">Categories</a>
      <!-- Dropdown menu items -->
      <ul class="dropdown-menu">
        <?php foreach ($cats as $c): ?>
       <li>
         <!-- Individual category items with dynamic active state -->
         <a class="dropdown-item<?= ($_GET['cat'] ?? '')===$c ? ' active' : '' ?>"
         href="index.php?cat=<?= urlencode($c) ?>">
        <?= htmlspecialchars($c) ?>
         </a>
       </li>
        <?php endforeach; ?>
      </ul>
    </li>
     </ul>
     <!-- Right-aligned button group for authenticated users:
       d-flex: Creates flexbox container
       padding: 10px: Adds spacing around buttons -->
     <div class="d-flex" style="padding: 10px;">
    <!-- Cart and Logout buttons with Bootstrap button styles:
      btn-outline-secondary/danger: Creates outlined button style
      me-2: Adds right margin -->
    <a href="cart.php" class="btn btn-outline-secondary me-2">🛒 Cart</a>
    <a href="logout.php" class="btn btn-outline-danger">Logout</a>
     </div>
   </div>
    <?php else: ?>
   <!-- Button group for non-authenticated users:
     ms-auto: Pushes buttons to right side -->
   <div class="d-flex ms-auto" style="padding: 10px;">
     <?php if ($currentPage!=='login.php'): ?>
    <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
     <?php endif; ?>
     <?php if ($currentPage!=='register.php'): ?>
    <a href="register.php" class="btn btn-outline-secondary me-2">Sign Up</a>
     <?php endif; ?>
     <a href="index.php#AboutUs" class="btn btn-outline-success">About Us</a>
   </div>
    <?php endif; ?>
  </div>
</nav>
