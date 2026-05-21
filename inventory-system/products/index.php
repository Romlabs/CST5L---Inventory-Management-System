<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
requireLogin();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ? ORDER BY created_at DESC");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
}
$products = $stmt->fetchAll();
?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fas fa-box"></i> Products</h2>
        <a href="create.php" class="btn btn-success"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Search</button>
            <?php if($search): ?>
                <a href="index.php" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </div>
    </form>
    
    <?php displayMessage(); ?>
    
    <?php if(count($products) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?> </td>
                        <td><?= htmlspecialchars($product['name']) ?> </td>
                        <td><?= htmlspecialchars($product['description']) ?> </td>
                        <td class="<?= $product['quantity'] < 5 ? 'text-danger fw-bold' : '' ?>"><?= $product['quantity'] ?> </td>
                        <td>$<?= number_format($product['price'], 2) ?> </td>
                        <td>
                            <a href="edit.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</a>
                         </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No products found. <a href="create.php">Add your first product</a></div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>