<?php
require_once('files/functions.php');

// Must be logged in
if (!is_logged_in()) {
    alert('danger', 'Please sign in to use your wishlist.');
    header('Location: login.php');
    exit;
}

$user_id    = (int) $_SESSION['user']['user_id'];
$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
$action     = $_POST['action'] ?? 'add';   // 'add' or 'remove'

if ($product_id < 1) {
    alert('danger', 'Invalid product.');
    header('Location: shop.php');
    exit;
}

// Confirm the product actually exists before touching the wishlist
$product = get_product($product_id);

if (!$product['pro']) {
    alert('danger', 'That product could not be found.');
    header('Location: shop.php');
    exit;
}

if ($action === 'remove') {
    wishlist_remove($user_id, $product_id);
    alert('success', 'Removed from wishlist.');
} else {
    wishlist_add($user_id, $product_id);
    alert('success', 'Added to wishlist.');
}

// Redirect back to wherever the user came from
$redirect = $_POST['redirect'] ?? 'shop.php';
header('Location: ' . $redirect);
exit;