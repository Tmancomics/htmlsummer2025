<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$pageTitle = "Add Product";
include 'includes/header.php';
?>

<main>
    <section class="form-section">
        <h2>Add New Product</h2>
        <form action="process_add_product.php" method="post" enctype="multipart/form-data" class="product-form">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" required />

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" required />

            <label for="image">Product Image</label>
            <input type="file" id="image" name="image" accept="image/*" required />

            <button type="submit" class="cta-button">Add Product</button>
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
