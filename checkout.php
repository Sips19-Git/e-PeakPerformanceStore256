
<?php
require_once('files/functions.php');
protected_area();

$summary = cart_summary();

if (empty($summary['items'])) {
    alert('danger', 'Your cart is empty. Please add products before checking out.');
    header('Location: cart.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $address    = trim($_POST['address'] ?? '');

    if ($first_name === '') {
        $errors[] = 'Please enter your first name.';
    }

    if ($last_name === '') {
        $errors[] = 'Please enter your last name.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($phone === '') {
        $errors[] = 'Please enter your phone number.';
    }

    if ($address === '') {
        $errors[] = 'Please enter your delivery address.';
    }

    if (empty($errors)) {

        $_SESSION['checkout_details'] = [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'phone'      => $phone,
            'address'    => $address
        ];

        $_SESSION['checkout_reference'] =
            'PPS-' . strtoupper(bin2hex(random_bytes(4)));

        header('Location: checkout.php?payment=1');
        exit;
    }
}

$checkout_details = $_SESSION['checkout_details'] ?? null;
$reference = $_SESSION['checkout_reference'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Checkout - Peak Performance Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/theme.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="handheld-toolbar-enabled">

<?php require_once('files/header.php'); ?>

<div class="page-title-overlap bg-dark pt-4">
    <div class="container py-3">
        <h1 class="h3 text-light">Checkout</h1>
    </div>
</div>

<main class="container py-5">

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <?php if (!$checkout_details || !isset($_GET['payment'])): ?>

        <!-- DELIVERY INFORMATION -->

        <div class="row">

            <div class="col-lg-7">

                <div class="card">

                    <div class="card-header">
                        <h5 class="mb-0">Delivery Information</h5>
                    </div>

                    <div class="card-body">

                        <form method="POST" action="checkout.php">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>

                                    <input
                                        type="text"
                                        name="first_name"
                                        class="form-control"
                                        required
                                        value="<?= htmlspecialchars($_POST['first_name'] ?? $_SESSION['user']['first_name'] ?? '') ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>

                                    <input
                                        type="text"
                                        name="last_name"
                                        class="form-control"
                                        required
                                        value="<?= htmlspecialchars($_POST['last_name'] ?? $_SESSION['user']['last_name'] ?? '') ?>">
                                </div>

                            </div>


                            <div class="mb-3">
                                <label class="form-label">Email Address</label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    required
                                    value="<?= htmlspecialchars($_POST['email'] ?? $_SESSION['user']['email'] ?? '') ?>">
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>

                                <input
                                    type="tel"
                                    name="phone"
                                    class="form-control"
                                    required
                                    value="<?= htmlspecialchars($_POST['phone'] ?? $_SESSION['user']['phone_number'] ?? '') ?>">
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Delivery Address</label>

                                <textarea
                                    name="address"
                                    class="form-control"
                                    rows="3"
                                    required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                            </div>


                            <button type="submit" class="btn btn-primary w-100">
                                Continue to Payment
                            </button>

                        </form>

                    </div>
                </div>

            </div>


            <!-- ORDER SUMMARY -->

            <div class="col-lg-5 mt-4 mt-lg-0">

                <div class="card">

                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>

                    <div class="card-body">

                        <?php foreach ($summary['items'] as $item): ?>

                            <div class="d-flex justify-content-between mb-3">

                                <span>
                                    <?= htmlspecialchars($item['name']) ?>
                                    × <?= (int)$item['qty'] ?>
                                </span>

                                <strong>
                                    R<?= number_format($item['price'] * $item['qty'], 2) ?>
                                </strong>

                            </div>

                        <?php endforeach; ?>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <strong>Subtotal</strong>

                            <strong>
                                R<?= number_format($summary['subtotal'], 2) ?>
                            </strong>
                        </div>

                    </div>
                </div>

            </div>

        </div>


    <?php else: ?>

        <!-- PAYMENT SECTION -->

        <div class="row justify-content-center">

            <div class="col-lg-7">

                <div class="card">

                    <div class="card-header">
                        <h5 class="mb-0">Payment Information</h5>
                    </div>

                    <div class="card-body">

                        <p>
                            Your delivery information has been saved.
                        </p>

                        <hr>

                        <p>
                            <strong>Checkout Reference:</strong>
                            <?= htmlspecialchars($reference) ?>
                        </p>

                        <p>
                            <strong>Order Subtotal:</strong>
                            R<?= number_format($summary['subtotal'], 2) ?>
                        </p>

                        <p class="text-muted">
                            You will be redirected to PayFast's secure payment page.
                        </p>

                        <!-- SEND CUSTOMER TO PAYMENT.PHP -->

                        <form action="payment.php" method="POST">

                            <button type="submit" class="btn btn-primary w-100">
                                Pay with PayFast
                            </button>

                        </form>


                        <a href="cart.php"
                           class="btn btn-outline-secondary w-100 mt-3">
                            Return to Cart
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
