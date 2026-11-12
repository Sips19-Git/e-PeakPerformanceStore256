
<?php
require_once('files/functions.php');
protected_area();

$rows = db_select('categories', 'parent_id = 0');
$categories = [];

foreach ($rows as $val) {
    $categories[$val['id']] = $val['name'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = [];

    $data['name'] = trim($_POST['name'] ?? '');
    $data['buying_price'] = $_POST['buying_price'] ?? 0;
    $data['price'] = $_POST['price'] ?? 0;
    $data['description'] = trim($_POST['description'] ?? '');
    $data['category_id'] = (int)($_POST['category_id'] ?? 0);

    if ($data['category_id'] <= 0) {
        die('Please select a product category.');
    }

   if (empty($_SESSION['user']['new_user_id'])) {
    die('User ID is missing. Please log out and log in again.');
}

$data['user_id'] = (int)$_SESSION['user']['new_user_id'];

    $imgs = upload_images($_FILES);
    $data['photos'] = json_encode($imgs);

    if (db_insert('products', $data)) {
        unset($_SESSION['form']);
        alert('success', 'Product added successfully!');
        header('Location: admin-products.php');
        exit();
    } else {
        alert('danger', 'Failed to add product. Please try again.');
        die('Failed to create product.');
    }
}

require_once('files/header.php');
?>

<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item">
                        <a class="text-nowrap" href="index.php">
                            <i class="ci-home"></i>Home
                        </a>
                    </li>
                    <li class="breadcrumb-item text-nowrap">
                        <a href="#">Account</a>
                    </li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">
                        Orders history
                    </li>
                </ol>
            </nav>
        </div>

        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Product Add</h1>
        </div>
    </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">

        <?php require_once('files/account-sidebar.php'); ?>

        <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
            <div class="pt-2 px-4 ps-lg-0 pe-xl-5">

                <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
                    <h2 class="h3 py-2 me-2 text-center text-sm-start">
                        Add New Product
                    </h2>

                </div>

                <form action="admin-products-add.php"
                            method="post"
                            enctype="multipart/form-data">

                    <div class="mb-3 pb-2">

                    <div class = "row">
                      <div class = "col-md-12">
                        <?= select_input([
                                'name' => 'category_id',
                                'label' => 'Product Category'
                            ], $categories) ?>
                      </div>

                    </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?= text_input([
                                    'name' => 'name',
                                    'label' => 'Product Name',
                                ]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mt-2">
                              <?= text_input([
                                'name' => 'buying_price',
                                'label' => 'Buying Price (R)',
                                'type' => 'number',
                                'attributes' => 'step="0.01" min="0" required'
                            ]) ?>
                            </div>

                            <div class="col-md-6 mt-2">
                          <?= text_input([
                                'name' => 'price',
                                'label' => 'Selling Price (R)',
                                'type' => 'number',
                                'attributes' => 'step="0.01" min="0" required'
                            ]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="row col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="photo_1">Product Photo 1</label>
                                    <input class="form-control"
                                           id="photo_1"
                                           name="photo_1"
                                           type="file"
                                           accept=".jpg,.jpeg,.png">
                                </div>
                            </div>

                            <div class="row col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="photo_2">Product Photo 2</label>
                                    <input class="form-control"
                                           id="photo_2"
                                           name="photo_2"
                                           type="file"
                                           accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="row col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="photo_3">Product Photo 3</label>
                                    <input class="form-control"
                                           id="photo_3"
                                           name="photo_3"
                                           type="file"
                                           accept=".jpg,.jpeg,.png">
                                </div>
                            </div>

                            <div class="row col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="photo_4">Product Photo 4</label>
                                    <input class="form-control"
                                           id="photo_4"
                                           name="photo_4"
                                           type="file"
                                           accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="row col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="photo_5">Product Photo 5</label>
                                    <input class="form-control"
                                           id="photo_5"
                                           name="photo_5"
                                           type="file"
                                           accept=".jpg,.jpeg,.png">
                                </div>
                            </div>

                            <div class="row col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="photo_6">Product Photo 6</label>
                                    <input class="form-control"
                                           id="photo_6"
                                           name="photo_6"
                                           type="file"
                                           accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description"
                                              id="description"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <button class="btn btn-primary d-block w-100 mt-3" type="submit">
                        <i class="ci-cloud-upload fs-lg me-2"></i>
                        Submit
                    </button>

                </form>

            </div>
        </section>
    </div>
</div>

<?php require_once('files/footer.php'); ?>
