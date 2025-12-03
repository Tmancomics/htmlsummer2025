<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';
$db = new db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];

    if (empty($name) || empty($description) || empty($price)) {
        die("All fields are required.");
    }

    // Handle optional image replacement
    $imageName = null;
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
        $targetDir = "uploads/images/";
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            die("Image upload failed.");
        }

        // Optional: delete old image
        $stmt = $db->conn->prepare("SELECT image_url FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $old = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($old && !empty($old['image_url'])) {
            $oldPath = $targetDir . $old['image_url'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Update with new image
        $stmt = $db->conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $imageName, $id]);
    } else {
        // Update without changing image
        $stmt = $db->conn->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $id]);
    }

    header("Location: admin-dashboard.php");
    exit;
}

