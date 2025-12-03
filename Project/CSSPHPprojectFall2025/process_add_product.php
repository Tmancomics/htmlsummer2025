<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';
$db = new db();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];

    if (empty($name) || empty($description) || empty($price)) {
        die("All fields are required.");
    }

    $imageName = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "uploads/images/";
        if (!is_dir($targetDir)) {
            die("Upload directory does not exist: " . $targetDir);
        }

        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            die("Image upload failed. Debug info: " . print_r($_FILES['image'], true));
        }
    } else {
        die("Image upload error. Code: " . $_FILES['image']['error']);
    }

    try {
        $stmt = $db->conn->prepare("INSERT INTO products (name, description, price, image_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $imageName]);
    } catch (PDOException $e) {
        die("Database insert failed: " . $e->getMessage());
    }

    header("Location: admin-dashboard.php");
    exit;
}
?>
