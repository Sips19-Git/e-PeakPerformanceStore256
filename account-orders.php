
<?php
require_once('files/functions.php');
protected_area();

$user_id = (int) $_SESSION['user']['user_id'];

// Get orders belonging to the logged-in user
global $conn;

$orders = [];

$result = $conn->query(
    "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC"
);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Set up page-specific variables for the shared layout
$page_title    = 'My Orders';
$page_subtitle = 'Orders History';
$breadcrumb    = 'Orders History';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Orders - Peak Performance Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/theme.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="handheld-toolbar-enabled">

<?php require_once('files/header.php'); ?>

<!-- Page Title -->
<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item">
                        <a class="text-nowrap" href="index.php">
                            <i class="ci-home"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item text-nowrap">
                        <a href="#">Account</a>
                    </li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">
                        Orders History
                    </li>
                </ol>
            </nav>
        </div>

        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">My Orders</h1>
        </div>
    </div>
</div>

<!-- Orders Content -->
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">

        <?php require_once('files/account-sidebar.php'); ?>

        <!-- Main Content -->
        <section class="col-lg-8">

            <!-- Alerts -->
            <?php if (isset($_SESSION['alert'])): ?>
                <div class="alert alert-<?= $_SESSION['alert']['type'] === 'success' ? 'success' : 'danger' ?> mt-3">
                    <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                </div>
                <?php unset($_SESSION['alert']); ?>
            <?php endif; ?>

            <!-- Toolbar -->
            <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4">
                <h5 class="mb-0">Orders History</h5>

                <span class="text-muted">
                    <?= count($orders) ?>
                    order<?= count($orders) === 1 ? '' : 's' ?>
                </span>
            </div>

            <!-- Orders List -->
            <?php if (empty($orders)): ?>

                <div class="card">
                    <div class="card-body py-5 text-center">
                        <i class="ci-bag fs-1 mb-3 d-block text-muted"></i>

                        <h5 class="mb-3">No orders yet</h5>

                        <p class="text-muted mb-4">
                            You have not placed any orders yet.
                            Start shopping and your orders will appear here.
                        </p>

                        <a class="btn btn-primary btn-sm" href="shop.php">
                            Browse Products
                        </a>
                    </div>
                </div>

            <?php else: ?>

                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($orders as $order): ?>

                                        <?php
                                        $order_id = $order['id'] ?? 0;

                                        $order_date = $order['created_at']
                                            ?? $order['order_date']
                                            ?? null;

                                        $order_status = $order['status'] ?? 'Pending';

                                        $order_total = $order['total_amount']
                                            ?? $order['total']
                                            ?? $order['amount']
                                            ?? 0;

                                        $status_class = 'bg-secondary';

                                        if (strtolower($order_status) === 'completed') {
                                            $status_class = 'bg-success';
                                        } elseif (strtolower($order_status) === 'pending') {
                                            $status_class = 'bg-warning text-dark';
                                        } elseif (strtolower($order_status) === 'cancelled') {
                                            $status_class = 'bg-danger';
                                        } elseif (strtolower($order_status) === 'processing') {
                                            $status_class = 'bg-info text-dark';
                                        }
                                        ?>

                                        <tr>
                                            <td>
                                                <strong>
                                                    #<?= htmlspecialchars((string) $order_id) ?>
                                                </strong>
                                            </td>

                                            <td>
                                                <?php if ($order_date): ?>
                                                    <?= htmlspecialchars(date('d M Y', strtotime($order_date))) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Not available</span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge <?= $status_class ?>">
                                                    <?= htmlspecialchars(ucfirst($order_status)) ?>
                                                </span>
                                            </td>

                                            <td class="text-end text-accent">
                                                R<?= number_format((float) $order_total, 2) ?>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            <?php endif; ?>

        </section>
    </div>
</div>

<?php require_once('files/footer.php'); ?>
</body>
</html>
