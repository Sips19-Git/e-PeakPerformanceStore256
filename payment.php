
<?php
require_once('files/functions.php');
require_once('files/payfast-code.php');

protected_area();

// Check that checkout details exist
if (empty($_SESSION['checkout_details'])) {
    header('Location: checkout.php');
    exit;
}

// Get the logged-in user's correct primary key
$user_id = $_SESSION['user']['new_user_id'] ?? null;

if (!$user_id) {
    die('User ID could not be found. Please log in again.');
}

// Get cart information
$summary = cart_summary();

if (empty($summary['items'])) {
    header('Location: cart.php');
    exit;
}

// Get customer details
$details = $_SESSION['checkout_details'];

// Create an order only once for this payment attempt
if (empty($_SESSION['payment_order_id'])) {

    $order_id = create_order($user_id, $summary['subtotal']);

    if (!$order_id) {
        die('Could not create your order. Please try again.');
    }

    // Save the order ID in the session
    $_SESSION['payment_order_id'] = $order_id;

    // Save order items
    if (!create_order_items($order_id, $summary['items'])) {
        die('Could not save your order items.');
    }

} else {
    $order_id = $_SESSION['payment_order_id'];
}

// PayFast payment details
$payment_data = [
    'merchant_id'  => PAYFAST_MERCHANT_ID,
    'merchant_key' => PAYFAST_MERCHANT_KEY,

    'return_url' => PAYFAST_BASE_URL . 'payment-success.php',
    'cancel_url' => PAYFAST_BASE_URL . 'payment-cancel.php',
    'notify_url' => PAYFAST_NOTIFY_URL,

    'name_first'   => $details['first_name'],
    'name_last'    => $details['last_name'],
    'email_address' => $details['email'],

    'm_payment_id' => 'PPS-' . $order_id,
    'amount'       => number_format($summary['subtotal'], 2, '.', ''),
    'item_name'    => 'Peak Performance Store Order #' . $order_id
];

// Generate PayFast signature
function generate_payfast_signature($data, $passphrase = '') {

    $signature_string = '';

    foreach ($data as $key => $value) {
        if ($value !== '' && $value !== null) {
            $signature_string .= $key . '=' . urlencode(trim((string)$value)) . '&';
        }
    }

    $signature_string = rtrim($signature_string, '&');

    if ($passphrase !== '') {
        $signature_string .= '&passphrase=' . urlencode(trim($passphrase));
    }

    return md5($signature_string);
}

$payment_data['signature'] = generate_payfast_signature(
    $payment_data,
    PAYFAST_PASSPHRASE
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting to PayFast</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/theme.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container text-center py-5">
    <h2>Redirecting to PayFast...</h2>
    <p>Please wait while we connect you to the secure payment page.</p>

    <form id="payfast-form"
          action="<?php echo htmlspecialchars(PAYFAST_PROCESS_URL); ?>"
          method="POST">

        <?php foreach ($payment_data as $key => $value): ?>
            <input
                type="hidden"
                name="<?php echo htmlspecialchars($key); ?>"
                value="<?php echo htmlspecialchars((string)$value); ?>">
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">
            Continue to PayFast
        </button>
    </form>
</div>

<script>
    document.getElementById('payfast-form').submit();
</script>

</body>
</html>
