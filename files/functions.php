<?php

require_once 'Zebra_Image.php';



if(session_status() == PHP_SESSION_NONE){
    session_start();
}

define ('BASE_URL', 'http://localhost/e-PeakPerformanceStore/');


$conn = new mysqli('localhost', 'root', '','e-peakperformance');



function db_select($table, $condition = null) {

    $sql = "SELECT * FROM $table";

    if ($condition != null) {
        $sql .= " WHERE $condition";
    }

    global $conn;

    $res = $conn->query($sql);

    $rows = [];

    while ($row = $res->fetch_assoc()) {
        $rows[] = $row;
    }

    return $rows;
}

function db_insert($table_name, $data) {
    global $conn;

    $columns = [];
    $values = [];

    foreach ($data as $key => $value) {
        $columns[] = "`" . $key . "`";

        if ($value === null || $value === '') {
            $values[] = "NULL";
        } elseif (is_numeric($value)) {
            $values[] = "'" . $conn->real_escape_string($value) . "'";
        } else {
            $values[] = "'" . $conn->real_escape_string($value) . "'";
        }
    }

    $sql = "INSERT INTO `$table_name` (" .
           implode(", ", $columns) .
           ") VALUES (" .
           implode(", ", $values) .
           ")";

    if ($conn->query($sql)) {
        return true;
    } else {
        echo "Database error: " . $conn->error;
        echo "<br>SQL query: " . $sql;
        exit();
    }
}

function create_thumb($source,  $target) {

   $image = new Zebra_Image();

    $image->auto_handle_exif_orientation = true;
    $image->source_path = $source;
    $image->target_path = $target;

    $image->preserve_aspect_ratio = true;
    $image->enlarge_smaller_images = true;
    $image->preserve_time = true;

    ini_set('memory_limit', '-1');

  $image->jpeg_quality = get_jpeg_quality(filesize($source));
;
    
    
    $width = 500;
    $height = 500;

    
if (!$image->resize($width, $height, ZEBRA_IMAGE_CROP_CENTER)) {

      return false;

} else {

    return $image->target_path;

}


}
 
function get_jpeg_quality($size) {

    $size = $size / 1000000; // Convert bytes to MB

    if ($size > 5) {
        $qt = 10;
    } elseif ($size > 4) {
        $qt = 13;
    } elseif ($size > 2) {
        $qt = 15;
    } elseif ($size > 1) {
        $qt = 17;
    } elseif ($size > 0.8) {
        $qt = 50;
    } elseif ($size > 0.5) {
        $qt = 80;
    } else {
        $qt = 90;
    }

    return $qt;
}

function upload_images($files)
{
    $uploaded_images = [];

    $upload_folder = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

    if (!is_dir($upload_folder)) {
        mkdir($upload_folder, 0775, true);
    }

    foreach ($files as $file) {

        // Skip image fields that were left empty
        if (
            !isset($file['error']) ||
            $file['error'] === UPLOAD_ERR_NO_FILE
        ) {
            continue;
        }

        // Show the actual PHP upload error
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die("Image upload error code: " . $file['error']);
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            die("Only JPG, JPEG and PNG images are allowed.");
        }

        $file_name = time() . '-' . bin2hex(random_bytes(4)) . '.' . $ext;

        $destination = $upload_folder . $file_name;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            die("Could not save image to: " . $destination);
        }

        $uploaded_images[] = [
            'src' => 'uploads/' . $file_name,
            'thumb' => 'uploads/' . $file_name
        ];
    }

    return $uploaded_images;
}


function urls($path = " / ")
{
    return BASE_URL . $path;
}
// this function checks if you're logged in and if not it'll kick you out
 function protected_area(){

 if (!isset($_SESSION['user'])){
    alert('user', 'Unauthorized access, login beofre you proceed.');
    header('Location: login.php');
    die();
 }


}

 function logout()
{
    if(isset($_SESSION['user'])){
        unset($_SESSION['user']);
    }
    alert('success', 'logged out successfully.');
    header('Location: login.php');
    die();
 
}

function is_logged_in()
{
    if(isset($_SESSION['user'])){
        return true;
    }else{
    return false;
    }

}
  function alert($type,$message){
    
$_SESSION['alert']['type'] = $type;
$_SESSION['alert']['message'] = $message;
}

function login_user($email, $password)

{   
    global $conn;
    $sql = "SELECT * FROM users WHERE email = '{$email}'";
    $res = $conn->query($sql);

    if($res->num_rows < 1){
        return false;
        
    }

    $row = $res->fetch_assoc();

    if(!password_verify($password, $row['password'])){
        return false;
    }

    $_SESSION['user'] = $row;
    
    return true;

}  


function select_input($data, $options) {

    $name = isset($data['name']) ? $data['name'] : "";
    $attributes = isset($data['attributes']) ? $data['attributes'] : "";
    $label = isset($data['label']) ? $data['label'] : $name;

    $value = "";
    $error = "";
    $error_text = "";

    if (isset($_SESSION['form']['value'][$name])) {
        $value = $_SESSION['form']['value'][$name];
    }

    if (isset($_SESSION['form']['error'][$name])) {
        $error = $_SESSION['form']['error'][$name];
    }

    if (isset($data['value'])) {
        $value = $data['value'];
    }

    if (isset($data['error'])) {
        $error = $data['error'];
    }

    if ($error != "") {
        $error_text = '<div class="form-text text-danger">'
                    . $error . '</div>';
    }

    $select_options = "";

    foreach ($options as $key => $option) {

        $selected = "";

        if ((string)$key === (string)$value) {
            $selected = ' selected';
        }

        $select_options .= '<option value="' . $key . '"'
                         . $selected . '>'
                         . $option
                         . '</option>';
    }

    $select_tag = '<select name="' . $name
                . '" id="' . $name
                . '" class="form-select" '
                . $attributes . '>
                    <option value="">Select '
                . $label . '</option>'
                . $select_options
                . '</select>';

    return '<label class="form-label text-capitalize" for="'
         . $name . '">' . $label . '</label>'
         . $select_tag
         . $error_text;
}



function text_input($data) {

    $name = $data['name'] ?? '';
    $attributes = $data['attributes'] ?? '';
    $type = $data['type'] ?? 'text';

    $value = '';

    if (isset($_SESSION['form']['value'][$name])) {
        $value = $_SESSION['form']['value'][$name];
    }

    if (isset($data['value'])) {
        $value = $data['value'];
    }

    $error_text = '';

    if (isset($_SESSION['form']['error'][$name])) {
        $error = $_SESSION['form']['error'][$name];

        $error_text = '<div class="form-text text-danger">'
                    . htmlspecialchars($error)
                    . '</div>';
    }

    $label = $data['label'] ?? $name;

    return
        '<label class="form-label text-capitalize" for="' . htmlspecialchars($name) . '">'
        . htmlspecialchars($label) . '</label>
        <input
            name="' . htmlspecialchars($name) . '"
            id="' . htmlspecialchars($name) . '"
            value="' . htmlspecialchars((string)$value) . '"
            class="form-control"
            type="' . htmlspecialchars($type) . '"
            ' . $attributes . '>'
        . $error_text;
}



function get_product_thumb($json) {

    $img = "assets/no_img.jpg";

    if (empty($json)) {
        return $img;
    }

    $objects = json_decode($json);

    if (empty($objects)) {
        return $img;
    }

    if (isset($objects[0]->thumb) && !empty($objects[0]->thumb)) {
        return $objects[0]->thumb;
    }

    return $img;
}


function get_product($id) {
    global $conn;

    $sql = "SELECT * FROM products WHERE products.id = $id";

    $data['pro'] = $conn->query($sql)->fetch_assoc();
    $data['cat'] = null;

    if ($data['pro'] != null) {
        $cat_id = $data['pro']['category_id'];
        $sql = "SELECT * FROM categories  WHERE id = $cat_id";
        $data['cat'] = $conn->query($sql)->fetch_assoc();
    }

    return $data;
}



function product_item_ui_1($pro) {

    $thumb      = get_product_thumb($pro['photos']);
    $product_id = $pro['id'];

    // Check wishlist state only if a user is logged in
    $in_wishlist = false;
    if (is_logged_in()) {
        $in_wishlist = wishlist_has($_SESSION['user']['user_id'], $product_id);
    }

    $wishlist_action = $in_wishlist ? 'remove' : 'add';
    $heart_class     = $in_wishlist ? 'ci-heart text-danger' : 'ci-heart';
    $heart_title     = $in_wishlist ? 'Remove from wishlist' : 'Add to wishlist';

    $str = <<<EOF

<div class="col-md-4 col-sm-6 px-2 mb-4">
    <div class="card product-card">

        <form method="POST" action="wishlist-toggle.php" class="position-absolute top-0 end-0 m-2" style="z-index:2;">
            <input type="hidden" name="action" value="{$wishlist_action}">
            <input type="hidden" name="product_id" value="{$product_id}">
            <input type="hidden" name="redirect" value="shop.php">
            <button class="btn-wishlist btn-sm" type="submit"
                data-bs-toggle="tooltip" data-bs-placement="left"
                title="{$heart_title}">
                <i class="{$heart_class}"></i>
            </button>
        </form>

        <a class="card-img-top d-block overflow-hidden"
           href="product.php?id={$product_id}">
            <img src="{$thumb}" alt="{$pro['name']}">
        </a>

        <div class="card-body py-2">

            <h3 class="product-title fs-sm">
                <a href="product.php?id={$product_id}">{$pro['name']}</a>
            </h3>

            <div class="product-price">
                <span class="text-accent">R{$pro['price']}</span>
            </div>

        </div>

        <div class="card-body card-body-hidden">

            <form method="POST" action="cart-add.php">
                <input type="hidden" name="product_id" value="{$product_id}">
                <input type="hidden" name="qty" value="1">
                <input type="hidden" name="redirect" value="shop.php">
                <button class="btn btn-primary btn-sm d-block w-100 mb-2" type="submit">
                    <i class="ci-cart fs-sm me-1"></i>Add to Cart
                </button>
            </form>

        </div>

    </div>

    <hr class="d-sm-none">
</div>

EOF;

    return $str;
}


function db_update($table, $data, $condition) {
    global $conn;

    $set_parts = [];
    foreach ($data as $key => $value) {
        if ($value === null || $value === '') {
            $set_parts[] = "`$key` = NULL";
        } else {
            $set_parts[] = "`$key` = '" . $conn->real_escape_string($value) . "'";
        }
    }

    $sql = "UPDATE `$table` SET " . implode(", ", $set_parts) . " WHERE $condition";

    if ($conn->query($sql)) {
        return true;
    } else {
        die("Database error: " . $conn->error . "<br>SQL: " . $sql);
    }
}

function validate($rules) {
    // $rules = ['field_name' => ['required', 'email', 'min:6', 'match:password']]
    $errors = [];

    foreach ($rules as $field => $field_rules) {
        $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';

        foreach ($field_rules as $rule) {
            $rule_name = explode(':', $rule)[0];
            $rule_param = explode(':', $rule)[1] ?? null;

            if ($rule_name === 'required' && $value === '') {
                $errors[$field] = ucfirst($field) . " is required.";
            }
            if ($rule_name === 'email' && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "Invalid email address.";
            }
            if ($rule_name === 'min' && strlen($value) < (int)$rule_param && $value !== '') {
                $errors[$field] = ucfirst($field) . " must be at least {$rule_param} characters.";
            }
            if ($rule_name === 'match' && $value !== $_POST[$rule_param]) {
                $errors[$field] = "Passwords do not match.";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['form']['error'] = $errors;
        foreach ($_POST as $k => $v) {
            $_SESSION['form']['value'][$k] = $v;
        }
        return false;
    }
    return true;
}


function wishlist_add($user_id, $product_id) {
    global $conn;

    $user_id    = (int) $user_id;
    $product_id = (int) $product_id;

    // INSERT IGNORE relies on the UNIQUE KEY to silently skip duplicates
    $sql = "INSERT IGNORE INTO wishlist (user_id, product_id, created)
            VALUES ($user_id, $product_id, " . time() . ")";

    return $conn->query($sql);
}

function wishlist_remove($user_id, $product_id) {
    global $conn;

    $user_id    = (int) $user_id;
    $product_id = (int) $product_id;

    $sql = "DELETE FROM wishlist WHERE user_id = $user_id AND product_id = $product_id";

    return $conn->query($sql);
}

function wishlist_has($user_id, $product_id) {
    global $conn;

    $user_id    = (int) $user_id;
    $product_id = (int) $product_id;

    $res = $conn->query(
        "SELECT wishlist_id FROM wishlist WHERE user_id = $user_id AND product_id = $product_id LIMIT 1"
    );

    return $res->num_rows > 0;
}

function wishlist_get_items($user_id) {
    global $conn;

    $user_id = (int) $user_id;

    $sql = "SELECT p.*
            FROM wishlist w
            JOIN products p ON p.id = w.product_id
            WHERE w.user_id = $user_id
            ORDER BY w.wishlist_id DESC";

    $res  = $conn->query($sql);
    $rows = [];

    while ($row = $res->fetch_assoc()) {
        $rows[] = $row;
    }

    return $rows;
}

function wishlist_count($user_id) {
    global $conn;

    $user_id = (int) $user_id;

    $res = $conn->query("SELECT COUNT(*) AS c FROM wishlist WHERE user_id = $user_id");

    return (int) $res->fetch_assoc()['c'];
}

function cart_summary() {
    $summary = [
        'count' => 0,
        'subtotal' => 0,
        'items' => []
    ];

    if (empty($_SESSION['cart'])) {
        return $summary;
    }

    foreach ($_SESSION['cart'] as $product_id => $qty) {
        $data = get_product($product_id);
        $product = $data['pro'] ?? null;

        if ($product) {
            $summary['count'] += (int) $qty;
            $summary['subtotal'] += $product['price'] * (int) $qty;

            $summary['items'][] = [
                'id' => $product_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'qty' => (int) $qty,
                'thumb' => get_product_thumb($product['photos'])
            ];
        }
    }

    return $summary;
}
// Create an order
function create_order($user_id, $total_amount) {
    global $conn;

    $user_id = (int) $user_id;
    $total_amount = (float) $total_amount;

    $stmt = $conn->prepare(
        "INSERT INTO orders (user_id, total_amount, payment_status, payment_reference, created)
         VALUES (?, ?, 'pending', '', NOW())"
    );

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("id", $user_id, $total_amount);

    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }

    $order_id = $conn->insert_id;
    $stmt->close();

    // Set a reference using the database order ID
    $reference = 'PPS-' . $order_id;

    $stmt = $conn->prepare(
        "UPDATE orders SET payment_reference = ? WHERE order_id = ?"
    );

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("si", $reference, $order_id);
    $success = $stmt->execute();
    $stmt->close();

    return $success ? $order_id : false;
}



function create_order_items($order_id, $items) {
    global $conn;

    $order_id = (int) $order_id;

    $stmt = $conn->prepare(
        "INSERT INTO order_items
         (order_id, product_id, product_name, price, qty)
         VALUES (?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        return false;
    }

    foreach ($items as $item) {
        $product_id = (int) $item['id'];
        $product_name = $item['name'];
        $price = (float) $item['price'];
        $qty = (int) $item['qty'];

        $stmt->bind_param(
            "iisdi",
            $order_id,
            $product_id,
            $product_name,
            $price,
            $qty
        );

        if (!$stmt->execute()) {
            $stmt->close();
            return false;
        }
    }

    $stmt->close();
    return true;
}


