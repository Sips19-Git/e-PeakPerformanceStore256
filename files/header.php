<?php
require_once('files/functions.php');

// Build cart summary fresh on every request
$cart          = cart_summary();
$cart_count    = $cart['count'];
$cart_subtotal = $cart['subtotal'];
$cart_items    = $cart['items'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Peak Performance Store</title>
    <meta name="description" content="Peak Performance Store">
    <meta name="keywords" content="bootstrap, shop, e-commerce, fitness, supplements, bicycles">
    <meta name="author" content="Createx Studio">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" color="#fe6a6a" href="safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" media="screen" href="vendor/simplebar/dist/simplebar.min.css"/>
    <link rel="stylesheet" media="screen" href="vendor/tiny-slider/dist/tiny-slider.css"/>
    <link rel="stylesheet" media="screen" href="css/theme.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      '../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-WKV3GT5');
    </script>
</head>
<body class="handheld-toolbar-enabled">

    <noscript>
      <iframe src="http://www.googletagmanager.com/ns.html?id=GTM-WKV3GT5" height="0" width="0" style="display: none; visibility: hidden;"></iframe>
    </noscript>

    <!-- Sign in / sign up modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-secondary">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link fw-medium active" href="#signin-tab" data-bs-toggle="tab" role="tab" aria-selected="true">
                  <i class="ci-unlocked me-2 mt-n1"></i>Sign in
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-medium" href="#signup-tab" data-bs-toggle="tab" role="tab" aria-selected="false">
                  <i class="ci-user me-2 mt-n1"></i>Sign up
                </a>
              </li>
            </ul>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body tab-content py-4">
            <form class="needs-validation tab-pane fade show active" autocomplete="off" novalidate id="signin-tab" method="POST" action="login.php">
              <div class="mb-3">
                <label class="form-label" for="si-email">Email address</label>
                <input class="form-control" type="email" name="email" id="si-email" placeholder="johndoe@example.com" required>
                <div class="invalid-feedback">Please provide a valid email address.</div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="si-password">Password</label>
                <div class="password-toggle">
                  <input class="form-control" type="password" name="password" id="si-password" required>
                  <label class="password-toggle-btn" aria-label="Show/hide password">
                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                  </label>
                </div>
              </div>
              <div class="mb-3 d-flex flex-wrap justify-content-between">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="si-remember">
                  <label class="form-check-label" for="si-remember">Remember me</label>
                </div>
                <a class="fs-sm" href="#">Forgot password?</a>
              </div>
              <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Sign in</button>
            </form>

            <form class="needs-validation tab-pane fade" autocomplete="off" novalidate id="signup-tab" method="POST" action="register.php">
              <div class="mb-3">
                <label class="form-label" for="su-name">Full name</label>
                <input class="form-control" type="text" name="name" id="su-name" placeholder="John Doe" required>
                <div class="invalid-feedback">Please fill in your name.</div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="su-email">Email address</label>
                <input class="form-control" type="email" name="email" id="su-email" placeholder="johndoe@example.com" required>
                <div class="invalid-feedback">Please provide a valid email address.</div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="su-password">Password</label>
                <div class="password-toggle">
                  <input class="form-control" type="password" name="password" id="su-password" required>
                  <label class="password-toggle-btn" aria-label="Show/hide password">
                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                  </label>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="su-password-confirm">Confirm password</label>
                <div class="password-toggle">
                  <input class="form-control" type="password" name="password_confirm" id="su-password-confirm" required>
                  <label class="password-toggle-btn" aria-label="Show/hide password">
                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                  </label>
                </div>
              </div>
              <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Sign up</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <main class="page-wrapper">
      <header class="shadow-sm">
        <div class="navbar-sticky bg-light">
          <div class="navbar navbar-expand-lg bg-light">
            <div class="container">
              <a class="navbar-brand d-none d-sm-block flex-shrink-0" >

                <img src="img/petal.img.png" width="250" alt="Peak Performance Store"></a>
                <a class="navbar-brand d-sm-none flex-shrink-0 me-2" >
                <img src="img/petal.img.png" width="150" alt="Peak Performance Store"></a>

              <div class="input-group d-none d-lg-flex mx-4">
                <input class="form-control rounded-end pe-5" type="text" placeholder="Search for products">
                <i class="ci-search position-absolute top-50 end-0 translate-middle-y text-muted fs-base me-3"></i>
              </div>

              <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-tool navbar-stuck-toggler" href="#">
                  <span class="navbar-tool-tooltip">Expand menu</span>
                  <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-menu"></i></div>
                </a>

                <a class="navbar-tool d-none d-lg-flex" href="account-wishlist.php">
                  <span class="navbar-tool-tooltip">Wishlist</span>
                  <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-heart"></i></div>
                </a>

                <?php if (is_logged_in()): ?>
                  <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2" href="account-orders.php">
                <?php else: ?>
                  <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2" href="#signin-modal" data-bs-toggle="modal">
                <?php endif; ?>
                  <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-user"></i></div>
                  <div class="navbar-tool-text ms-n3">
                    <?php if (is_logged_in()): ?>
                      <small>Hello, <?= htmlspecialchars($_SESSION['user']['first_name']) ?></small>
                    <?php else: ?>
                      <small>Hello, Sign in</small>
                    <?php endif; ?>
                    My Account
                  </div>
                </a>

                <!-- DYNAMIC CART DROPDOWN -->
                <div class="navbar-tool dropdown ms-3">
                 <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="cart.php">
                        <span class="navbar-tool-label" id="cart-count">
                            <?= (int) $cart_count ?>
                        </span>
                        <i class="navbar-tool-icon ci-cart"></i>
                    </a>
                  <a class="navbar-tool-text" href="cart.php">
                    <small>My Cart</small>R<?= number_format($cart_subtotal, 2) ?>
                  </a>

                  <div class="dropdown-menu dropdown-menu-end">
                    <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;">
                      <?php if (empty($cart_items)): ?>
                        <div class="py-4 text-center text-muted">
                          <i class="ci-cart fs-2 mb-2 d-block"></i>
                          Your cart is empty.
                        </div>
                      <?php else: ?>
                        <div style="height: 15rem; overflow-y: auto;">
                          <?php foreach ($cart_items as $item): ?>
                            <div class="widget-cart-item py-2 border-bottom position-relative">
                              <form method="POST" action="cart-remove.php" class="position-absolute top-0 end-0 m-1">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                <button class="btn-close text-danger" type="submit" aria-label="Remove">&times;</button>
                              </form>
                              <div class="d-flex align-items-center pe-3">
                                <a class="flex-shrink-0" href="product.php?id=<?= $item['id'] ?>">
                                  <img src="<?= $item['thumb'] ?>" width="64" alt="<?= htmlspecialchars($item['name']) ?>">
                                </a>
                                <div class="ps-2">
                                  <h6 class="widget-product-title">
                                    <a href="product.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></a>
                                  </h6>
                                  <div class="widget-product-meta">
                                    <span class="text-accent me-2">R<?= number_format($item['price'], 2) ?></span>
                                    <span class="text-muted">x <?= $item['qty'] ?></span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php endif; ?>

                      <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                        <div class="fs-sm me-2 py-2">
                          <span class="text-muted">Subtotal:</span>
                          <span class="text-accent fs-base ms-1">R<?= number_format($cart_subtotal, 2) ?></span>
                        </div>
                        <a class="btn btn-outline-secondary btn-sm" href="cart.php">
                          Expand cart<i class="ci-arrow-right ms-1 me-n1"></i>
                        </a>
                      </div>
                      <a class="btn btn-primary btn-sm d-block w-100" href="checkout.php">
                        <i class="ci-card me-2 fs-base align-middle"></i>Checkout
                      </a>
                    </div>
                  </div>
                </div>
               
              </div>
            </div>
          </div>

          <div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu mt-n2 pt-0 pb-2">
            <div class="container">
              <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="input-group d-lg-none my-3">
                  <i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                  <input class="form-control rounded-start" type="text" placeholder="Search for products">
                </div>

                <ul class="navbar-nav navbar-mega-nav pe-lg-2 me-lg-2">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-lg-0" href="#" data-bs-toggle="dropdown">
                      <i class="ci-view-grid me-2"></i>Departments
                    </a>
                    <div class="dropdown-menu px-2 pb-4">
                      <div class="d-flex flex-wrap flex-sm-nowrap">
                        <div class="mega-dropdown-column pt-3 pt-sm-4 px-2 px-lg-3">
                          <div class="widget widget-links">
                            <a class="d-block overflow-hidden rounded-3 mb-3" href="shop.php"><img src="img/shop/departments/06.png" alt="Running Shoes"></a>
                            <h6 class="fs-base mb-2">Running Shoes</h6>
                          </div>
                        </div>
                        <div class="mega-dropdown-column pt-4 px-2 px-lg-3">
                          <div class="widget widget-links">
                            <a class="d-block overflow-hidden rounded-3 mb-3" href="shop.php"><img src="img/shop/departments/04.png" alt="Nutritional Supplements"></a>
                            <h6 class="fs-base mb-2">Nutritional Supplements</h6>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex flex-wrap flex-sm-nowrap">
                        <div class="mega-dropdown-column pt-4 px-2 px-lg-3">
                          <div class="widget widget-links">
                            <a class="d-block overflow-hidden rounded-3 mb-3" href="shop.php"><img src="img/shop/departments/03.png" alt="Bicycles"></a>
                            <h6 class="fs-base mb-2">Bicycles</h6>
                          </div>
                        </div>
                        <div class="mega-dropdown-column pt-4 px-2 px-lg-3">
                          <div class="widget widget-links">
                            <a class="d-block overflow-hidden rounded-3 mb-3" href="shop.php"><img src="img/shop/departments/05.png" alt="Accessories"></a>
                            <h6 class="fs-base mb-2">Accessories</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>

                <ul class="navbar-nav">
                  <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Account</a>
                    <ul class="dropdown-menu">
                      <li class="dropdown">
                        <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Shop User Account</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="account-orders.php">Orders History</a></li>
                          <li><a class="dropdown-item" href="account-profile.php">Profile Settings</a></li>
                          <li><a class="dropdown-item" href="account-wishlist.php">Wishlist</a></li>
                        </ul>
                      </li>
                      <li><a class="dropdown-item" href="login.php">Sign In / Sign Up</a></li>
                    </ul>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Pages</a>
                    <ul class="dropdown-menu">
                      <li class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="about.php">About Us</a></li>
                      <li><a class="dropdown-item" href="contacts.php">Contacts</a></li>
                      <li class="dropdown-divider"></li>
                    </ul>
                  </li>
                     <li class="nav-item">
                        <a class="nav-link" href="repair-booking.php">Repair Booking</a>
                      </li>
                                      
                </ul>
              </div>
            </div>
          </div>
        </div>
      </header>

      <script src="js/cart.js"></script>
      <script src="js/search.js"></script>

<?php if (isset($_SESSION['alert'])): ?>
  <div class="container pt-5">
    <div class="alert alert-<?= $_SESSION['alert']['type'] === 'success' ? 'success' : 'danger' ?>">
      <?= htmlspecialchars($_SESSION['alert']['message']) ?>
    </div>
  </div>
<?php unset($_SESSION['alert']); endif; ?>