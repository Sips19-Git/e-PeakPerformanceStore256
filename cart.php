
<?php
require_once('files/functions.php');
protected_area();

$summary = cart_summary();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Cart - Peak Performance Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/theme.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="handheld-toolbar-enabled">

<?php require_once('files/header.php'); ?>

<div class="page-title-overlap bg-dark pt-4">
    <div class="container py-3">
        <h1 class="h3 text-light">My Shopping Cart</h1>
    </div>
</div>

<main class="container py-5">

    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?= $_SESSION['alert']['type'] === 'success' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($_SESSION['alert']['message']) ?>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <?php if (empty($summary['items'])): ?>

        <div class="card">
            <div class="card-body text-center py-5">
                <i class="ci-cart fs-1 d-block mb-3"></i>
                <h4>Your cart is empty</h4>
                <p class="text-muted">Browse our products and add something you like.</p>
                <a href="shop.php" class="btn btn-primary">Browse Products</a>
            </div>
        </div>

    <?php else: ?>

        <div class="row">

            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Cart Items (<?= $summary['count'] ?>)</h5>
                    </div>

                    <div class="card-body">
                        <?php foreach ($summary['items'] as $item): ?>
                            <div class="d-flex align-items-center mb-4 pb-4 border-bottom">

                                <img
                                    src="<?= htmlspecialchars($item['thumb']) ?>"
                                    alt="<?= htmlspecialchars($item['name']) ?>"
                                    width="80"
                                    class="me-3"
                                >

                                <div class="flex-grow-1">
                                    <h6>
                                        <a href="product.php?id=<?= (int) $item['id'] ?>">
                                            <?= htmlspecialchars($item['name']) ?>
                                        </a>
                                    </h6>

                                    <p class="mb-1">
                                        Price: R<?= number_format($item['price'], 2) ?>
                                    </p>

                                    <p class="mb-0">
                                        Quantity: <?= (int) $item['qty'] ?>
                                    </p>
                                </div>

                                <div class="text-end">
                                    <strong>
                                        R<?= number_format($item['price'] * $item['qty'], 2) ?>
                                    </strong>

                                    <form method="POST" action="cart-remove.php" class="mt-2">
                                        <input type="hidden" name="product_id"
                                               value="<?= (int) $item['id'] ?>">

                                        <button type="submit"
                                                class="btn btn-outline-danger btn-sm">
                                            Remove
                                        </button>
                                    </form>
                                </div>

                            </div>
                        <?php endforeach; ?>

                        <a href="shop.php" class="btn btn-outline-primary btn-sm">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cart Summary</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <strong>R<?= number_format($summary['subtotal'], 2) ?></strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Delivery</span>
                            <span>To be confirmed</span>
                        </div>

                        <hr>

                        <p class="text-muted small">
                            Your final payable amount may include delivery charges.
                        </p>

                        <a href="checkout.php" class="btn btn-primary w-100">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>

        </div>

    <?php endif; ?>

</main>

<?php require_once('files/footer.php'); ?>
</body>
</html>
