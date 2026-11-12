<?php
require_once('files/functions.php');
protected_area();


 $categories = db_select('categories', '1 ORDER BY id DESC');
//  echo"<pre>";
//  print_r($categories);
//  die();





require_once('files/header.php'); 
?>   


<div class="page-title-overlap bg-dark pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
          <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                <li class="breadcrumb-item"><a class="text-nowrap" href="index-2.html"><i class="ci-home"></i>Home</a></li>
                <li class="breadcrumb-item text-nowrap"><a href="#">Account</a>
                </li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Orders history</li>
              </ol>
            </nav>
          </div>
          <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Product Categories</h1>
          </div>
        </div>
      </div>
      <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
         <?php   require_once('files/account-sidebar.php');   ?>
           <!-- Content-->
            <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
              <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
                <!-- Title-->
                <div class="d-sm-flex flex-wrap justify-content-between align-items-center border-bottom">
                  <h2 class="h3 py-2 me-2 text-center text-sm-start">Products Categories<span class="badge bg-faded-accent fs-sm text-body align-middle ms-2">5</span></h2>
                  <div class="py-2">
                    <div class="d-flex flex-nowrap align-items-center pb-3">

                      
                      <button class="btn btn-outline-secondary btn-sm px-2" type="button"><i class="ci-arrow-up"></i></button>
                    </div>
                  </div>
                </div>

                <?php

                foreach ($categories as $key => $value){          
                ?>
                <!-- Product-->
                <div class="d-block d-sm-flex align-items-center py-4 border-bottom"><a class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" href="marketplace-single.html" style="width: 12.5rem;">
                  
                  <div class="text-center text-sm-start">
                    <h3 class="h6 product-title mb-2"><a href="product.php"><?= htmlspecialchars($value['name']) ?></a></h3>
                    <div class="d-inline-block text-accent"><?= htmlspecialchars($value['description'] ?? '') ?><small></small></div>
                    
                    <div class="d-flex justify-content-center justify-content-sm-start pt-3">
                      
                    </div>
                  </div>
                </div>

                <?php  }?>
               
                  
           
            <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
              <div class="d-flex align-items-center">
                     
                </div><a class="btn btn-primary btn-sm d-none d-lg-inline-block" href="logout.php"><i class="ci-sign-out me-2"></i>Sign out</a>
            </div>
          

          </section>
        </div>
      </div>


<?php
require_once('files/footer.php'); 
?>  