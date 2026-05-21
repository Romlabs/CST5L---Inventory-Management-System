<?php
session_start();
require_once 'config/database.php';
require_once 'includes/auth.php';
requireLogin();

// Get statistics
$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_value = $pdo->query("SELECT SUM(quantity * price) FROM products")->fetchColumn();
$low_stock = $pdo->query("SELECT COUNT(*) FROM products WHERE quantity < 5")->fetchColumn();
$recent_products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<?php include 'includes/header.php'; ?>
<div class="container">
    <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
    
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card card-stats border-left-primary shadow h-100 py-2" style="border-left-color: #4e73df;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_products ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card card-stats border-left-success shadow h-100 py-2" style="border-left-color: #1cc88a;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Inventory Value</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?= number_format($total_value ?? 0, 2) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card card-stats border-left-warning shadow h-100 py-2" style="border-left-color: #f6c23e;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Low Stock Items (<5)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $low_stock ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recently Added Products</h6>
        </div>
        <div class="card-body">
            <?php if(count($recent_products) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr><th>Name</th><th>Quantity</th><th>Price</th><th>Added On</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($recent_products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= $product['quantity'] ?></td>
                                <td>$<?= number_format($product['price'], 2) ?></td>
                                <td><?= date('M d, Y', strtotime($product['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a href="products/index.php" class="btn btn-primary">View All Products</a>
            <?php else: ?>
                <p>No products yet. <a href="products/create.php">Add your first product</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>