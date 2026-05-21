<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
requireLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "Product deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete product.";
    }
} else {
    $_SESSION['error'] = "Invalid product ID.";
}

header("Location: index.php");
exit();
?>