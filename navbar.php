<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$fullNavPages = ['index.php','product.php','cart.php','checkout.php'];
$cats = ['CPU','GPU','RAM','Motherboard','Storage','Cooler'];
?>
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      <img src="images/logo.png" width="30" class="d-inline-block align-text-top me-2" alt="">
      MochiModz Mart
    </a>

    <?php if (in_array($currentPage, $fullNavPages) && !empty($_SESSION['user_id'])): ?>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link<?= $currentPage==='index.php' && empty($_GET['cat']) ? ' active' : '' ?>"
               href="index.php">All Categories</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle<?= !empty($_GET['cat']) ? ' active' : '' ?>"
               href="#" role="button" data-bs-toggle="dropdown">Categories</a>
            <ul class="dropdown-menu">
              <?php foreach ($cats as $c): ?>
                <li>
                  <a class="dropdown-item<?= ($_GET['cat'] ?? '')===$c ? ' active' : '' ?>"
                     href="index.php?cat=<?= urlencode($c) ?>">
                    <?= htmlspecialchars($c) ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </li>
        </ul>
        <div class="d-flex" style="padding: 10px;">
          <a href="cart.php" class="btn btn-outline-secondary me-2">🛒 Cart</a>
          <a href="logout.php" class="btn btn-outline-danger">Logout</a>
        </div>
      </div>
    <?php else: ?>
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
