<?php
session_start();
$pageTitle = "Home";
include 'includes/header.php';
require_once 'db.php';
$db = new db();
?>

<main>
    <!-- Hero Banner Section -->
    <section class="hero-banner">
        <img src="bannerimage/banner1.jpg" alt="Store Banner" class="banner-image">
        <div class="hero-content">
            <h1>Welcome to Our Store</h1>
            <p>Discover our latest products and deals. Quality items at great prices.</p>
            <a href="shop.php" class="cta-button">Shop Now</a>
        </div>
    </section>

    <!-- Shop Preview Section -->
    <section class="shop-preview">
        <h2>Featured Products</h2>
        <div class="product-grid">
            <?php
            $stmt = $db->conn->query("SELECT * FROM products LIMIT 3");
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="uploads/images/<?php echo htmlspecialchars($product['image_url']); ?>"
                         alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-thumb">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>$<?php echo htmlspecialchars($product['price']); ?></p>
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="cta-button">View</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
