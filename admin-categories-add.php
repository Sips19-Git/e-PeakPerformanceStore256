
<?php
require_once('files/functions.php');
protected_area();

// Load existing categories from the database
$rows = db_select('categories', '1 ORDER BY name ASC');

$categories = [];
$categories[0] = 'No parent (Main Category)';

foreach ($rows as $val) {
    $categories[$val['id']] = $val['name'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = [];

    $data['name'] = trim($_POST['name'] ?? '');
    $data['description'] = trim($_POST['description'] ?? '');
    $data['parent_id'] = (int)($_POST['parent_id'] ?? 0);

    // Save the category name in case validation fails
    $_SESSION['form']['value']['name'] = $data['name'];

    // Check that the category name is provided
    if ($data['name'] === '') {
        alert('danger', 'Please enter a category name.');
        header('Location: admin-categories-add.php');
        exit();
    }

    // Upload category image
    $imgs = upload_images($_FILES);

    $data['photo'] = json_encode($imgs);

    // Save category in database
    if (db_insert('categories', $data)) {

        unset($_SESSION['form']);

        alert('success', 'Category created successfully.');

        header('Location: admin-categories.php');
        exit();

    } else {

        alert('danger', 'Failed to create category. Please try again.');

        header('Location: admin-categories-add.php');
        exit();
    }
}

require_once('files/header.php');
?>

<!-- Page Title -->
<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">

        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">

                    <li class="breadcrumb-item">
                        <a class="text-nowrap" href="index.php">
                            <i class="ci-home"></i> Home
                        </a>
                    </li>

                    <li class="breadcrumb-item text-nowrap">
                        <a href="#">Account</a>
                    </li>

                    <li class="breadcrumb-item text-nowrap active"
                        aria-current="page">
                        Categories
                    </li>

                </ol>
            </nav>
        </div>

        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Product Categories</h1>
        </div>

    </div>
</div>

<!-- Main Content -->
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">

        <?php require_once('files/account-sidebar.php'); ?>

        <section class="col-lg-8 pt-lg-4 pb-4 mb-3">

            <div class="pt-2 px-4 ps-lg-0 pe-xl-5">

                <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
                    <h2 class="h3 py-2 me-2 text-center text-sm-start">
                        Add New Category
                    </h2>
                </div>

                <form action="admin-categories-add.php"
                      method="post"
                      enctype="multipart/form-data">

                    <!-- Category Name -->
                    <div class="mb-3">
                        <?= text_input([
                            'name' => 'name',
                            'label' => 'Category Name',
                            'attributes' => 'required'
                        ]) ?>
                    </div>

                    <div class="row mt-3">

                        <!-- Parent Category -->
                        <div class="col-md-6 mb-3">
                            <?= select_input([
                                'name' => 'parent_id',
                                'label' => 'Parent Category'
                            ], $categories) ?>
                        </div>

                        <!-- Category Image -->
                        <div class="col-md-6 mb-3">
                            <label for="photo" class="form-label">
                                Category Image
                            </label>

                            <input
                                class="form-control"
                                id="photo"
                                name="photo"
                                type="file"
                                accept=".jpg,.jpeg,.png">
                        </div>

                    </div>

                    <!-- Description -->
                    <div class="row mt-3">
                        <div class="col-12">

                            <label for="description" class="form-label">
                                Description
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                class="form-control"
                                rows="4"></textarea>

                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn-primary d-block w-100 mt-3"
                            type="submit">
                        <i class="ci-cloud-upload fs-lg me-2"></i>
                        Create Category
                    </button>

                </form>

            </div>

        </section>

    </div>
</div>

<?php require_once('files/footer.php'); ?>
