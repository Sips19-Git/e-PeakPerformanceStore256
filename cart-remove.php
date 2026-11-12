<?php
require_once('files/functions.php');

$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
$redirect   = $_POST['redirect'] ?? 'cart.php';

if ($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
    unset($_SESSION['cart'][$product_id]);
    alert('success', 'Item removed from cart.');
}

header('Location: ' . $redirect);
exit;