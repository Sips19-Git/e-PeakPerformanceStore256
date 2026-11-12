<?php
require_once('files/functions.php');
protected_area();

$user_id = (int) $_SESSION['user']['user_id'];
$items   = wishlist_get_items($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Wishlist - Peak Performance Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/theme.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="handheld-toolbar-enabled">

<?php require_once('files/header.php'); ?>

<main class="page-wrapper">

    <?php if (isset($_SESSION['alert'])): ?>
        <div class="container pt-4">
            <div class="alert alert-<?= $_SESSION['alert']['type'] === 'success' ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
            </div>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <div class="container py-5">
        <div class="row">

            <!-- Sidebar (same as profile page) -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action" href="account-profile.php">
                        <i class="ci-user me-2"></i>Profile Settings
                    </a>
                    <a class="list-group-item list-group-item-action" href="account-orders.php">
                        <i class="ci-bag me-2"></i>Orders History
                    </a>
                    <a class="list-group-item list-group-item-action active" href="account-wishlist.php">
                        <i class="ci-heart me-2"></i>Wishlist
                    </a>
                    <a class="list-group-item list-group-item-action text-danger" href="logout.php">
                        <i class="ci-close-circle me-2"></i>Log Out
                    </a>
                </div>
            </div>

            <!-- Main -->
            <div class="col-lg-9 col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">My Wishlist</h5>
                        <span class="badge bg-secondary"><?= count($items) ?> item<?= count($items) === 1 ? '' : 's' ?></span>
                    </div>
                    <div class="card-body">

                        <?php if (empty($items)): ?>
                            <div class="py-5 text-center text-muted">
                                <i class="ci-heart fs-1 mb-3 d-block"></i>
                                <p class="mb-3">Your wishlist is empty.</p>
                                <a class="btn btn-primary btn-sm" href="shop.php">Browse Products</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table align-middle">
                     <thead>
                     <tr>
                  <th>Product</th>
      <th class="text-center">Price</th>
       <th class="text-end">Actions</th>
                                      
    </tr>
     </thead>
             <tbody>
             <?php foreach ($items as $item): ?>
                      <tr>
                  <td>
                  <div class="d-flex align-items-center">
                      <a href="product.php?id=<?= $item['id'] ?>" class="flex-shrink-0">
                 <img src="<?= get_product_thumb($item['photos']) ?>"
               width="64" alt="<?= htmlspecialchars($item['name']) ?>">
                 </a>
                <div class="ps-3">
              <a class="product-title" href="product.php?id=<?= $item['id'] ?>">
          <?= htmlspecialchars($item['name']) ?>
         </a>
                     </div>
         </div>
                 </td>
 <td class="text-center text-accent">R<?= number_format($item['price'], 2) ?></td>
                              <td class="text-end">
                   <a class="btn btn-outline-primary btn-sm"
                href="product.php?id=<?= $item['id'] ?>">
                           View
          </a>
      <form method="POST" action="wishlist-toggle.php" class="d-inline">
                <input type="hidden" name="action" value="remove">
                       <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                       <input type="hidden" name="redirect" value="account-wishlist.php">
           <button class="btn btn-outline-danger btn-sm" type="submit">
              <i class="ci-trash"></i> Remove
               </button>
                     </form>
      </td>
            </tr>
    <?php endforeach; ?>
</tbody>
 </table>
        </div>
        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>


<?php require_once('files/footer.php'); ?>
</body>
</html>