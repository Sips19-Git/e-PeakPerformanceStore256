
<?php

require_once 'files/functions.php';

protected_area();

global $conn;

$order_id = (int)($_GET['order'] ?? 0);
$user_id = (int)($_SESSION['user']['user_id']
    ?? $_SESSION['user']['id']
    ?? 0);

$stmt = $conn->prepare(
    "SELECT * FROM orders
     WHERE order_id = ? AND user_id = ?"
);

$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();

$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    die('Order not found.');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Result</title>
    <link rel="stylesheet" href="css/theme.min.css">
</head>

<body>

<?php require_once 'files/header.php'; ?>

<div class="container py-5 text-center">

    <?php if ($order['payment_status'] === 'paid'): ?>

        <h2 class="text-success">Payment Successful!</h2>

        <p>Thank you for shopping with Peak Performance Store.</p>

        <p>Order: PPS-<?php echo $order_id; ?></p>

        <?php
        if (isset($_SESSION['payment_order_id']) &&
            (int)$_SESSION['payment_order_id'] === $order_id) {

            unset($_SESSION['cart']);
            unset($_SESSION['checkout_details']);
            unset($_SESSION['checkout_reference']);
            unset($_SESSION['payment_order_id']);
        }
        ?>

    <?php else: ?>

        <h2>Payment Processing</h2>

        <p>Your payment has not yet been confirmed.</p>

        <p>Please check your order again shortly.</p>

    <?php endif; ?>

    <a href="account-orders.php" class="btn btn-primary">
        View My Orders
    </a>

</div>

<?php require_once 'files/footer.php'; ?>

</body>
</html>
