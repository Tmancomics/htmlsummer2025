<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';
$db = new db();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Optional: delete image file
    $stmt = $db->conn->prepare("SELECT image_url FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && !empty($product['image_url'])) {
        $imagePath = "uploads/images/" . $product['image_url'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // delete image file
        }
    }

    // Delete product from DB
    $stmt = $db->conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: admin-dashboard.php");
exit;
