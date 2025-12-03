<?php
session_start();
require_once 'db.php';
$db = new db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    $stmt = $db->conn->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        die("Email already registered.");
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->conn->prepare("INSERT INTO admins (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $passwordHash]);

    $_SESSION['success'] = "Registration successful. Please log in.";
    header("Location: login.php");
    exit;
}
?>
