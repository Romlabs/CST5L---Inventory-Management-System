<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
requireLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    $_SESSION['error'] = "Product not found.";
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    
    $errors = [];
    if (empty($name)) $errors[] = "Product name is required.";
    if ($quantity < 0) $errors[] = "Quantity cannot be negative.";
    if ($price < 0) $errors[] = "Price cannot be negative.";
    
    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, quantity=?, price=? WHERE id=?");
        if ($stmt->execute([$name, $description, $quantity, $price, $id])) {
            $_SESSION['success'] = "Product updated successfully!";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to update product.";
        }
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
}
?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4><i class="fas fa-edit"></i> Edit Product</h4>
                </div>
                <div class="card-body">
                    <?php displayMessage(); ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Product Name *</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="<?= $product['quantity'] ?>" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" min="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>