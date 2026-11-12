<?php
require_once('files/functions.php');
require_once('files/header.php');

$id = 0;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

if ($id < 1) {
    die("ID not found.");
}

$data = get_product($id);

$pro = $data['pro'];
$cat = $data['cat'];

if ($pro == null) {
    die("Product not found");
}

if ($cat == null) {
    die("Category not found");
}

// Get product images from the database
$photos = json_decode($pro['photos'], true);

if (!is_array($photos)) {
    $photos = [];
}

// Get the main product image
$thumb = get_product_thumb($pro['photos']);

// Prepare the product price
$price = isset($pro['price']) ? $pro['price'] : 0;
?>

<!-- Page Title -->
<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light">
                    <li class="breadcrumb-item">
                        <a href="index.php">
                            <i class="ci-home"></i> Home
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="shop.php">Shop</a>
                    </li>

                    <li class="breadcrumb-item active">
                        <?= htmlspecialchars($pro['name']) ?>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">
                <?= htmlspecialchars($pro['name']) ?>
            </h1>
        </div>
    </div>
</div>

<!-- Product Details -->
<div class="container pb-5 mb-2 mb-md-4">

    <div class="bg-light shadow-lg rounded-3 px-4 py-4 mb-5">
        <div class="row">

            <!-- Product Image -->
            <div class="col-lg-6">

                <div class="product-gallery">

                    <!-- Large Main Image -->
                    <div class="product-gallery-preview mb-3">

                        <img
                            id="mainProductImage"
                            src="<?= htmlspecialchars($thumb) ?>"
                            alt="<?= htmlspecialchars($pro['name']) ?>"
                            class="img-fluid rounded-3 d-block mx-auto"
                            style="width: 100%; max-height: 550px; object-fit: contain;"
                        >

                    </div>

                    <!-- Product Image Thumbnails -->
                    <?php if (!empty($photos)) { ?>

                        <div class="d-flex flex-wrap gap-2 justify-content-center">

                            <?php foreach ($photos as $photo) {

                                // Support image paths saved as strings
                                if (is_string($photo)) {
                                    $photoPath = $photo;
                                } else {
                                    continue;
                                }

                                if (empty($photoPath)) {
                                    continue;
                                }
                            ?>

                                <img
                                    src="<?= htmlspecialchars($photoPath) ?>"
                                    alt="Product thumbnail"
                                    class="img-thumbnail"
                                    style="width: 85px; height: 85px; object-fit: contain; cursor: pointer;"
                                    onclick="document.getElementById('mainProductImage').src = this.src;"
                                >

                            <?php } ?>

                        </div>

                    <?php } ?>

                </div>

                <!-- Add to Cart Under the Image -->
                <div class="mt-4">

                    <form action="cart.php" method="post">

                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= (int) $pro['id'] ?>"
                        >

                        <input
                            type="hidden"
                            name="price"
                            value="<?= htmlspecialchars((string) $price) ?>"
                        >

                        <div class="mb-3">
                            <label class="form-label" for="quantity">
                                Quantity
                            </label>

                            <select
                                class="form-select"
                                name="quantity"
                                id="quantity"
                                style="max-width: 150px;"
                            >
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <button
                            class="btn btn-primary btn-shadow w-100"
                            type="submit"
                        >
                            <i class="ci-cart fs-lg me-2"></i>
                            Add to Cart
                        </button>

                    </form>

                </div>

            </div>

            <!-- Product Information -->
            <div class="col-lg-6 pt-4 pt-lg-0">

                <div class="product-details ms-lg-4">

                    <h2 class="h3 mb-3">
                        <?= htmlspecialchars($pro['name']) ?>
                    </h2>

                    <!-- Product Price -->
                    <div class="mb-4">
                        <span class="h2 fw-normal text-accent">
                            R<?= number_format((float) $price, 2) ?>
                        </span>
                    </div>

                    <!-- Product Category -->
                    <div class="mb-3">
                        <span class="fw-medium">Category:</span>

                        <?= htmlspecialchars($cat['name']) ?>
                    </div>


                    <hr>


                    <!-- Additional Product Information -->
                    <div class="bg-white rounded-3 p-3 mt-4">

                        <h5 class="mb-3">Product Information</h5>

                        <p class="mb-2">
                            <strong>Product ID:</strong>
                            <?= (int) $pro['id'] ?>
                        </p>

                        <p class="mb-2">
                            <strong>Product Name:</strong>
                            <?= htmlspecialchars($pro['name']) ?>
                        </p>

                        <p class="mb-2">
                            <strong>Category:</strong>
                            <?= htmlspecialchars($cat['name']) ?>
                        </p>

                        <p class="mb-0">
                            <strong>Price:</strong>
                            R<?= number_format((float) $price, 2) ?>
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Back to Shop -->
    <div class="text-center">
        <a href="shop.php" class="btn btn-outline-primary">
            <i class="ci-arrow-left me-2"></i>
            Back to Shop
        </a>
    </div>

</div>

<?php
require_once('files/footer.php');
?>
```