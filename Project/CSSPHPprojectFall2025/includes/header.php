<?php
session_start();

$count = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle ?? 'Torin Grasley CSS and PHP Project'; ?></title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<header>
    <nav class="main-nav">
        <ul class="nav-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['admin_id'])): ?>
                <li><a href="admin-dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
            <li class="cart-link">
                <a href="cart.php">
                    Cart
                    <span class="cart-count"><?php echo $count; ?></span>
                </a>
            </li>
        </ul>
    </nav>
</header>