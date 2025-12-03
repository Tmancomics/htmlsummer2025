<?php
$pageTitle = "Product Details";
include 'includes/header.php';
require_once 'db.php';
$db = new db();

if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit;
}

$id = $_GET['id'];
$stmt = $db->conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}
?>

<main>
    <section class="product-detail">
        <?php if (!empty($product['image_url'])): ?>
            <img src="uploads/images/<?php echo htmlspecialchars($product['image_url']); ?>"
                 alt="Product Image" class="product-thumb-large">
        <?php endif; ?>

        <div class="product-info">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p class="price">$<?php echo htmlspecialchars($product['price']); ?></p>
            <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>

            <form action="cart.php" method="post">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" required>
                <button type="submit" class="cta-button">Add to Cart</button>
            </form>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
