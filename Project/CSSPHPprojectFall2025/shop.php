<?php
$pageTitle = "Shop";
include 'includes/header.php';
require_once 'db.php';
$db = new db();

$stmt = $db->conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <section>
        <h2>Our Tools</h2>
        <div class="product-grid">
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="product.php?id=<?php echo $product['id']; ?>">
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="uploads/images/<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="product-thumb">
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        </a>
                        <p>$<?php echo htmlspecialchars($product['price']); ?></p>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products available at the moment.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
