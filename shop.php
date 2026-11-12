

<?php
require_once('files/functions.php');
require_once('files/header.php');



if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = trim($_GET['search']);

    $products = db_select(
        'products',
        "name LIKE '%" . addslashes($search) . "%' ORDER BY id DESC"
    );
} else {
    $products = db_select('products', '1 ORDER BY id DESC');
}

// $pro = $products[0];

// $pic = get_product_thumb($pro['photos']);

// echo "<pre>";
// print_r($pic);
// die();
?>


<!-- Page Title-->
      <div class="page-title-overlap bg-dark pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
          <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                <li class="breadcrumb-item"><a class="text-nowrap" href="index.php"><i class="ci-home"></i>Home</a></li>
                </li>
              </ol>
            </nav>
          </div>
          <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Shop Products</h1>
          </div>
        </div>
      </div>

      <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
         
          <!-- Content  -->
          <section class="col-lg-8">
           
            <!-- Products grid-->
            <div class="row mx-n2">

           

            <?php foreach ($products as $pro) {
              echo product_item_ui_1($pro);


                      } ?>
            
            </div>
            
            <!-- Pagination-->
            <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#"><i class="ci-arrow-left me-2"></i>Prev</a></li>
              </ul>
              <ul class="pagination">
                <li class="page-item d-sm-none"><span class="page-link page-link-static">1 / 5</span></li>
                <li class="page-item active d-none d-sm-block" aria-current="page"><span class="page-link">1<span class="visually-hidden">(current)</span></span></li>
                <li class="page-item d-none d-sm-block"><a class="page-link" href="#">2</a></li>
                <li class="page-item d-none d-sm-block"><a class="page-link" href="#">3</a></li>
                <li class="page-item d-none d-sm-block"><a class="page-link" href="#">4</a></li>
                <li class="page-item d-none d-sm-block"><a class="page-link" href="#">5</a></li>
              </ul>
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#" aria-label="Next">Next<i class="ci-arrow-right ms-2"></i></a></li>
              </ul>
            </nav>
          </section>
        </div>
      </div>













 
<?php
require_once('files/footer.php');
?>
