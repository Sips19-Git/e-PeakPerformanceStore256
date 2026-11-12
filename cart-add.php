<?php
require_once('files/functions.php');

if (!is_logged_in()) {
    alert('danger', 'Please sign in to add items to your cart.');
    header('Location: login.php');
    exit;
}

$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
$qty        = isset($_POST['qty']) ? max(1, (int) $_POST['qty']) : 1;
$redirect   = $_POST['redirect'] ?? 'shop.php';

if ($product_id < 1) {
    alert('danger', 'Invalid product.');
    header('Location: ' . $redirect);
    exit;
}

// Confirm product exists
$data = get_product($product_id);
if (!$data['pro']) {
    alert('danger', 'Product not found.');
    header('Location: ' . $redirect);
    exit;
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add or increment
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $qty;
} else {
    $_SESSION['cart'][$product_id] = $qty;
}

alert('success', 'Added to cart.');
header('Location: ' . $redirect);
exit;