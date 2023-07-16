<?php
require_once '../../Controllers/DBController.php';
require_once '../../Controllers/ProductController.php';
require_once '../../Controllers/UserController.php';
require_once '../../Controllers/AuthController.php';
require_once '../../Variables/product.php';
require_once '../../Variables/user.php';
$DB = DBController::getInstance();
$product = new product;
$controller = new ProductController;
$auth = new AuthController;
$userCon = new UserController;
$user = new user;

session_start();
$user->email = $_SESSION['email'];
$userInfo = $userCon->getByEmail($user);
if(isset($_SESSION["roleID"])){
  if(!$auth->checkAdmin()){
    header("location:../Auth/login.php");
    exit();
  }
  else{
    
    if(isset($_POST['title']) && isset($_POST['price']) && isset($_POST['bio']) && isset($_POST['stock']) && isset($_POST['sizes'])){
      if(!empty($_POST['title'])  && !empty($_POST['price']) && !empty($_POST['bio']) && !empty($_POST['stock']) && !empty($_POST['sizes'])){
    $product->title = $_POST['title'];
    $product->price = $_POST['price'];
    $product->bio = $_POST['bio'];
    $product->stock = $_POST['stock'];
    $product->sizes=$_POST['sizes'];
    if (isset($_FILES['image'])) {
      $image = $_FILES['image']['tmp_name'];
      //$product->imgname = $_FILES['image']['name'];
      $product->image = base64_encode(file_get_contents($image));
      $product->imgname = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      //$product->image = $imageData;
      //$imageData=base64_encode(file_get_contents($_FILES['image']['tmp_name']));
  }
  
    else{
      //errmsg;
    }
    $result = $controller->addProduct($product);
    if($result){
      $alertMsg = 'Product Added';
      header("location:product.php");
      exit();
    }
    else{
      $alertMsg = 'Error while adding product!';
      return false;
    }
      }
      else{
        $alertMsg= 'Please fill all fields';
      }
  }
  
}
}
else{
  session_destroy();
  header("location:../Auth/login.php");
}



?>

<!DOCTYPE html>


<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Control Products</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
              <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                  <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                  <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                  <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                  <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                </defs>
                <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                      <g id="Mask" transform="translate(0.000000, 8.000000)">
                        <mask id="mask-2" fill="white">
                          <use xlink:href="#path-1"></use>
                        </mask>
                        <use fill="#696cff" xlink:href="#path-1"></use>
                        <g id="Path-3" mask="url(#mask-2)">
                          <use fill="#696cff" xlink:href="#path-3"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                        </g>
                        <g id="Path-4" mask="url(#mask-2)">
                          <use fill="#696cff" xlink:href="#path-4"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                        </g>
                      </g>
                      <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                        <use fill="#696cff" xlink:href="#path-5"></use>
                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                      </g>
                    </g>
                  </g>
                </g>
              </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2"> E-Store </span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">



          <!-- Tables -->
          <li class="menu-item active">
            <a href="index.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-table"></i>
              <div data-i18n="Tables">
                Dashboard
              </div>
            </a>
          </li>
          <li class="menu-item active">
          <a href="profile.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-table"></i>
            <div data-i18n="Tables">
              My Profile
            </div>
          </a>
        </li>
          <li class="menu-item active">
            <a href="user.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-table"></i>
              <div data-i18n="Tables">
                Manage Users
              </div>
            </a>
          </li>
          <li class="menu-item active">
            <a href="product.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-table"></i>
              <div data-i18n="Tables">
                Manage Products
              </div>
            </a>
          </li>
          <li class="menu-item active">
            <a href="../Auth/logout.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-table"></i>
              <div data-i18n="Tables">
                Logout
              </div>
            </a>
          </li>
        </ul>
      </aside>
      <div class="layout-container">
        
        
        <!-- Layout container -->
        
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
          
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                    <?php foreach ($userInfo as $user) {
                      if (isset($user['image']) && !empty($user['image'])) {
                        
                      echo '<img  class="d-block rounded" height="100px" width="100px" src="data:image;base64,'.$user['image'].'">'; 
                     }
                     else{
                      echo '<img  class="d-block rounded" height="100px" width="100px" src="../assets/img/avatars/default.png">'; 
                     }
                     } ?>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                          </div>
                          <div class="flex-grow-1">
                          <?php foreach ($userInfo as $user) { ?>
                            <span class="fw-semibold d-block">
                              <?php echo ucfirst($user['fname']) . '&nbsp;' . ucfirst($user['lname']); ?>
                            </span>
                          <?php } ?>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="profile.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../Auth/logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
            <?php if (!empty($alertMsg)) { ?>
          <div style="color: white;padding:8px;background-color: #D0BDF0;border-radius: 15px;color: white;margin-bottom: 5px;">
          <?php echo $alertMsg;} ?>
            <div class="card mb-4">
                    <h5 class="card-header">Add Product</h5>
                    <div class="card-body">
                    <form id="addProduct" class="mb-3" action="" method="post" enctype="multipart/form-data">
                      <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Title</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" placeholder="Ex: Boys Shirt" id="html5-text-input" name="title" />
                      </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-number-input" class="col-md-2 col-form-label">Price</label>
                        <div class="col-md-10">
                          <input class="form-control" type="number" placeholder="100" id="html5-number-input" name="price" />
                    </div>
                  </div>
                  <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Bio</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" placeholder="Boys shirt for boys" id="html5-text-input" name="bio" />
                      </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Sizes</label>
                        <div class="col-md-10">

                              <input name="small" class="form-check-input" type="checkbox" value="0"
                                id="small"><strong>S</strong></input>
                              <input name="medium" class="form-check-input" type="checkbox" value="1"
                                id="medium"><strong>M</strong></input>
                                <input name="large" class="form-check-input" type="checkbox" value="2"
                                id="large"><strong>L</strong></input>
                              <input name="xlarge" class="form-check-input" type="checkbox" value="3"
                                id="xlarge"><strong>XL</strong></input>
                                <input name="all" class="form-check-input" type="checkbox" value="4"
                                id="all"><strong>All Sizes</strong></input>
                            </div>
                      
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-number-input" class="col-md-2 col-form-label">Stock</label>
                        <div class="col-md-10">
                          <input class="form-control" type="number" placeholder="1000" id="html5-number-input" name="stock" />
                    </div>
                    
                  </div>
                  <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Product Image</label>
                        <div class="col-md-10">
                          <input class="form-control" type="file"  id="html5-text-input" name="image" />
                      </div>
                      </div>

                  <div class="card-body">
                      <div class="demo-inline-spacing">
                        <button class="btn rounded-pill btn-primary" >Submit</button>
                      </div>
                    </div>
                    </form>
              <!-- Layout Demo -->
              <div class="layout-demo-wrapper">
                <div class="layout-demo-placeholder">
                  
                </div>
              </div>
              <!--/ Layout Demo -->
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>