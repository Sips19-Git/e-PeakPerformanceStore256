<?php
require_once('files/header.php');
require_once('files/functions.php');

$allProducts   = db_select('products');
$allCategories = db_select('categories');

// Map id => name, TRIMMED so trailing spaces don't break matching
$categoryNames = [];
foreach ($allCategories as $c) {
    $categoryNames[$c['id']] = trim($c['name']);
}

// Group products by TRIMMED category name
$productsByCategory = [];
foreach ($allProducts as $p) {
    $catName = $categoryNames[$p['category_id']] ?? 'Other';
    $catName = trim($catName);              // extra safety
    $productsByCategory[$catName][] = $p;
}

function slide_chunks($items, $perSlide = 6) {
    return array_chunk($items ?: [], $perSlide);
}
?>

<!-- Hero slider-->
<section class="tns-carousel tns-controls-lg mb-4 mb-lg-5">
    <div class="tns-carousel-inner" data-carousel-options="{&quot;mode&quot;: &quot;gallery&quot;, &quot;responsive&quot;: {&quot;0&quot;:{&quot;nav&quot;:true, &quot;controls&quot;: false},&quot;992&quot;:{&quot;nav&quot;:false, &quot;controls&quot;: true}}}">
        <!-- Item-->
        <div class="px-lg-5 hero-section" style="background-color: #f5b1b0;">
            <div class="d-lg-flex justify-content-between align-items-center ps-lg-4">
                <img class="hero-image d-block order-lg-2 flex-shrink-0" alt="">
                <div class="hero-text position-relative mx-auto py-5 px-4 mb-lg-5 order-lg-1" style="max-width: 42rem; z-index: 10;">
                    <div class="pb-lg-5 mb-lg-5 text-center text-lg-start text-lg-nowrap">
                        <h3 class="h2 text-light fw-light pb-1 from-bottom">Hurry up! Limited time offer.</h3>
                        <h2 class="text-light display-5 from-bottom delay-1">Peak Performance Gear</h2>
                        <p class="fs-lg text-light pb-3 from-bottom delay-2">Bicycles, Supplements, Running Shoes &amp; much more...</p>
                        <div class="d-table scale-up delay-4 mx-auto mx-lg-0">
                            <a class="btn btn-primary" href="shop.php">
                                Shop Now<i class="ci-arrow-right ms-2 me-n1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- CATEGORY 1: BICYCLES -->
<!-- ========================================== -->
<?php
$catName = 'Bicycles';
$slides  = slide_chunks($productsByCategory[$catName] ?? [], 6);
?>
<section class="container pt-lg-3 mb-4 mb-sm-5">
  <div class="row">
    <!-- Banner with controls-->
    <div class="col-md-5">
      <div class="d-flex flex-column h-100 overflow-hidden rounded-3" style="background-color: #f6f8fb;">
        <div class="d-flex justify-content-between px-grid-gutter py-grid-gutter">
          <div>
            <h3 class="mb-1"><?= htmlspecialchars($catName) ?></h3>
            <a class="fs-md" href="<?= urls('shop-grid-ls.php?cat=' . urlencode($catName)) ?>"></a>
          </div>
          <div class="tns-carousel-controls" id="for-women-1">
            <button type="button"><i class="ci-arrow-left"></i></button>
            <button type="button"><i class="ci-arrow-right"></i></button>
          </div>
        </div>
        <a class="d-none d-md-block mt-auto" href="<?= urls('shop-grid-ls.php?cat=' . urlencode($catName)) ?>">
          <img class="d-block w-100" src="<?= urls('img/home/categories/bicycles.jpg') ?>" alt="Bicycles">
        </a>
      </div>
    </div>

    <!-- Product grid (carousel)-->
    <div class="col-md-7 pt-4 pt-md-0">
      <div class="tns-carousel">
        <div class="tns-carousel-inner" data-carousel-options='{"nav": false, "controlsContainer": "#for-women-1"}'>
          <?php if (empty($slides)): ?>
            <div><div class="row mx-n2"><div class="col-12 p-4"><p class="text-muted mb-0">No products in this category yet.</p></div></div></div>
          <?php else: ?>
            <?php foreach ($slides as $slide): ?>
              <div>
                <div class="row mx-n2">
                  <?php foreach ($slide as $p) echo product_item_ui_1($p, $catName); ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================================== -->
<!-- CATEGORY 2: SUPPLEMENTS -->
<!-- ========================================== -->
<?php
$catName = 'Nutritional Supplements';
$slides  = slide_chunks($productsByCategory[$catName] ?? [], 6);
?>
<section class="container pt-lg-3 mb-4 mb-sm-5">
  <div class="row">
    <!-- Banner with controls-->
    <div class="col-md-5">
      <div class="d-flex flex-column h-100 overflow-hidden rounded-3" style="background-color: #f6f8fb;">
        <div class="d-flex justify-content-between px-grid-gutter py-grid-gutter">
          <div>
            <h3 class="mb-1"><?= htmlspecialchars($catName) ?></h3>
            <a class="fs-md" href="<?= urls('shop-grid-ls.php?cat=' . urlencode($catName)) ?>"></a>
          </div>
          <div class="tns-carousel-controls" id="for-women-2">
            <button type="button"><i class="ci-arrow-left"></i></button>
            <button type="button"><i class="ci-arrow-right"></i></button>
          </div>
        </div>
        <a class="d-none d-md-block mt-auto" href="<?= urls('shop-grid-ls.php?cat=' . urlencode($catName)) ?>">
          <img class="d-block w-100" src="<?= urls('img/home/categories/supplements.jpg') ?>" alt="Supplements">
        </a>
      </div>
    </div>

    <!-- Product grid (carousel)-->
    <div class="col-md-7 pt-4 pt-md-0">
      <div class="tns-carousel">
        <div class="tns-carousel-inner" data-carousel-options='{"nav": false, "controlsContainer": "#for-women-2"}'>
          <?php if (empty($slides)): ?>
            <div><div class="row mx-n2"><div class="col-12 p-4"><p class="text-muted mb-0">No products in this category yet.</p></div></div></div>
          <?php else: ?>
            <?php foreach ($slides as $slide): ?>
              <div>
                <div class="row mx-n2">
                  <?php foreach ($slide as $p) echo product_item_ui_1($p, $catName); ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================================== -->
<!-- CATEGORY 3: RUNNING SHOES -->
<!-- ========================================== -->
<?php
$catName = 'Running Shoes';
$slides  = slide_chunks($productsByCategory[$catName] ?? [], 6);
?>
<section class="container pt-lg-4 mb-4 mb-sm-5">
  <div class="row">
    <!-- Banner with controls (Reversed layout for variety) -->
    <div class="col-md-5 order-md-2">
      <div class="d-flex flex-column h-100 overflow-hidden rounded-3" style="background-color: #f6f8fb;">
        <div class="d-flex justify-content-between px-grid-gutter py-grid-gutter">
          <div class="order-md-2">
            <h3 class="mb-1"><?= htmlspecialchars($catName) ?></h3>
            <a class="fs-md" href="<?= urls('shop-grid-ls.php?cat=' . urlencode($catName)) ?>"></a>
          </div>
          <div class="tns-carousel-controls order-md-1" id="for-men-1">
            <button type="button"><i class="ci-arrow-left"></i></button>
            <button type="button"><i class="ci-arrow-right"></i></button>
          </div>
        </div>
        <a class="d-none d-md-block mt-auto" href="<?= urls('shop-grid-ls.php?cat=' . urlencode($catName)) ?>">
          <img class="d-block w-100" src="<?= urls('img/home/categories/running shoes.jpg') ?>" alt="Running Shoes">
        </a>
      </div>
    </div>

    <!-- Product grid (carousel)-->
    <div class="col-md-7 pt-4 pt-md-0 order-md-1">
      <div class="tns-carousel">
        <div class="tns-carousel-inner" data-carousel-options='{"nav": false, "controlsContainer": "#for-men-1"}'>
          <?php if (empty($slides)): ?>
            <div><div class="row mx-n2"><div class="col-12 p-4"><p class="text-muted mb-0">No products in this category yet.</p></div></div></div>
          <?php else: ?>
            <?php foreach ($slides as $slide): ?>
              <div>
                <div class="row mx-n2">
                  <?php foreach ($slide as $p) echo product_item_ui_1($p, $catName); ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================================== -->
<!-- CATEGORY 4: ACCESSORIES -->
<!-- ========================================== -->
<?php
$catName = 'Accessories';
$slides  = slide_chunks($productsByCategory[$catName] ?? [], 6);
?>
<section class="container pt-lg-4 mb-4 mb-sm-5">
  <div class="row">
    <!-- Banner with controls -->
    <div class="col-md-5 order-md-2">
      <div class="d-flex flex-column h-100 overflow-hidden rounded-3" style="background-color: #f6f8fb;">
        <div class="d-flex justify-content-between px-grid-gutter py-grid-gutter">
          <div class="order-md-2">
            <h3 class="mb-1"><?= htmlspecialchars($catName) ?></h3>
            <a class="fs-md" href="<?= urls('shop-grid-ls.php?cat=' . urlencode($catName)) ?>"></a>
          </div>
          <div class="tns-carousel-controls order-md-1" id="for-men-2">
            <button type="button"><i class="ci-arrow-left"></i></button>
            <button type="button"><i class="ci-arrow-right"></i></button>
          </div>
        </div>
        <a class="d-none d-md-block mt-auto" href="<?= urls('shop-grid-ls.php?cat=' . urlencode($catName)) ?>">
          <img class="d-block w-100" src="<?= urls('img/home/categories/accessories.jpg') ?>" alt="Accessories">
        </a>
      </div>
    </div>

    <!-- Product grid (carousel)-->
    <div class="col-md-7 pt-4 pt-md-0 order-md-1">
      <div class="tns-carousel">
        <div class="tns-carousel-inner" data-carousel-options='{"nav": false, "controlsContainer": "#for-men-2"}'>
          <?php if (empty($slides)): ?>
            <div><div class="row mx-n2"><div class="col-12 p-4"><p class="text-muted mb-0">No products in this category yet.</p></div></div></div>
          <?php else: ?>
            <?php foreach ($slides as $slide): ?>
              <div>
                <div class="row mx-n2">
                  <?php foreach ($slide as $p) echo product_item_ui_1($p, $catName); ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once('files/footer.php');
?>