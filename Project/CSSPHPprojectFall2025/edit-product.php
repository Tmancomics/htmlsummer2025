<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';
$db = new db();

if (!isset($_GET['id'])) {
    header("Location: admin-dashboard.php");
    exit;
}

$id = $_GET['id'];
$stmt = $db->conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

$pageTitle = "Edit Product";
include 'includes/header.php';
?>

<main>
    <section class="form-section">
        <h2>Edit Product</h2>
        <form action="process_edit_product.php" method="post" enctype="multipart/form-data" class="product-form">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>" />

            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required />

            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required />

            <label for="image">Replace Image (optional)</label>
            <input type="file" id="image" name="image" accept="image/*" />

            <button type="submit" class="cta-button">Update Product</button>
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

