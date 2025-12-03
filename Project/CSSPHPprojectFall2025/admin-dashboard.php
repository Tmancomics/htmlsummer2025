<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$pageTitle = "Admin Dashboard";
include 'includes/header.php';
require_once 'db.php';
$db = new db();

// Fetch products
$stmt = $db->conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <section>
        <h2>Manage Products</h2>
        <a href="add-product.php" class="cta-button">Add New Product</a>
        <div class="product-grid">
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="uploads/images/<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="product-thumb">
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p>$<?php echo htmlspecialchars($product['price']); ?></p>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="admin-actions">
                            <a href="edit-product.php?id=<?php echo $product['id']; ?>" class="action-link">Edit</a>
                            <a href="delete-product.php?id=<?php echo $product['id']; ?>" class="action-link delete-link" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
