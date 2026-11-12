
<?php

require_once 'files/functions.php';

protected_area();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Cancelled</title>
    <link rel="stylesheet" href="css/theme.min.css">
</head>

<body>

<?php require_once 'files/header.php'; ?>

<div class="container text-center py-5">

    <h2 class="text-danger">Payment Cancelled</h2>

    <p>Your payment was cancelled.</p>

    <p>Your order has not been marked as paid.</p>

    <a href="cart.php" class="btn btn-primary">
        Return to Cart
    </a>

</div>

<?php require_once 'files/footer.php'; ?>

</body>
</html>
