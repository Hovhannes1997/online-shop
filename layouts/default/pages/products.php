<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php require_once('layouts/default/inc/head.php');?>
        <title>Products</title>
    </head>
    <body>
        <header>
            <nav class="sina-nav mobile-sidebar navbar-fixed" data-top="0">
                <div class="container">
                    <div class="search-box">
                        <form role="search">
                            <span class="search-addon close-search"><i class="fa fa-times"></i></span>
                            <div class="search-input">
                                <input type="search" id="search" class="form-control" placeholder="Search here" value="" name="">
                                <div class="liveSearch"></div>
                            </div>
                            <span class="search-addon search-icon"><i class="fa fa-search"></i></span>
                        </form>
                    </div>
                    <div class="extension-nav">
                        <ul>
                            <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                            <li>
                                <a href="/pages/cart" class="cart_menu">
                                    <i class="fa fa-shopping-bag"></i>
                                </a>
                            </li>
                            <li>
                                <a href="/pages/wishlist">
                                    <i class="fas fa-heart"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav_right">
                            <?php
                            if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) { 
                                ?>
                                <li class="sign-up">
                                    <a href="/pages/regist"><i class="fas fa-user-plus"></i>Sign up</a>
                                </li>
                            <?php } ?>

                            <?php 
                            if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) { 
                                ?>
                                <li class="sign-up">
                                    <a href="/pages/login"><i class="fas fa-sign-in-alt"></i>Login</a>
                                </li>
                            <?php } ?>
                            <?php 
                            if(isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
                                ?>
                                <li class="sign-up">
                                    <a href="/pages/profile"><i class="fas fa-user-tie"></i>Profile</a>
                                </li>
                            <?php } ?>
                            <?php 
                            if(isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
                                ?>
                                <li class="sign-up">
                                    <a href="?cmd=userLogout"><i class="fas fa-sign-out-alt"></i>Logaut</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="sina-nav-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="sina-brand social-on" href="/">
                            <img src="/public/img/pngwing.com%20(4).png" alt="">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="sina-menu" data-in="fadeInLeft" data-out="fadeInOut">
                            <li><a href="/">Home</a></li>
                            <li><a href="/pages/shop">Shop</a></li>
                            <li><a href="/pages/contact">Contact</a></li>
                        </ul>
                        <ul class="nav_right_mobile">
                            <?php
                            if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) { 
                                ?>
                                <li class="sign-up">
                                    <a href="/pages/regist"><i class="fas fa-user-plus"></i>Sign up</a>
                                </li>
                            <?php } ?>

                            <?php 
                            if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) { 
                                ?>
                                <li class="sign-up">
                                    <a href="/pages/login"><i class="fas fa-sign-in-alt"></i>Login</a>
                                </li>
                            <?php } ?>
                            <?php 
                            if(isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
                                ?>
                                <li class="sign-up">
                                    <a href="/pages/profile"><i class="fas fa-user-tie"></i>Profile</a>
                                </li>
                            <?php } ?>
                            <?php 
                            if(isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
                                ?>
                                <li class="sign-up">
                                    <a href="?cmd=userLogout"><i class="fas fa-sign-out-alt"></i>Logaut</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <section id="products">
            <div class="container">
               <div class="product_page_title">Products</div>
                <div class="row">
                   <?php
                    $sub_cat_id = $_GET['id'];
                    $sql_product = $cnt->con->prepare("SELECT * FROM `products` WHERE `sub_cat_id`=?");
                    $sql_product->execute(array($sub_cat_id));
                    if ($sql_product->rowCount() > 0) {
                        while($row_product = $sql_product->fetch()) {
                            $product_id = $row_product['id'];
                            $product_title = $row_product['title'];
                            $product_price = $row_product['price'];
                            $product_discount = $row_product['discount'];
                            
                            //check img
                            $sql_files_product = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
                            $sql_files_product->execute(array('products', $product_id, 'home'));
                            if ($sql_files_product->rowCount() > 0) {
                                $row_files_product = $sql_files_product->fetch();
                                $product_img = '/public/photos/thumbs/'.$row_files_product['name'].'.'.$row_files_product['type'];
                            } else {
                                $product_img = '/public/img/no_photo.jpg';
                            }
                            
                            // rate
                            $sql_rate = $cnt->con->prepare("SELECT * FROM `review` WHERE `p_id`=?");
                            $sql_rate->execute(array($product_id));
                            $row_rate = $sql_rate->fetch();
                            $rate = $row_rate['rate'];
                            
                            if($product_discount > 0) {
                                $price_discount = $product_price - ($product_discount * $product_price / 100);
                                $price_show = $price_discount;
                                $discount_show = '<div class="products_show_discount">'.$product_discount.'%</div>';
                            } else {
                                $price_show = $product_price;
                                $discount_show = '';
                            }
                            echo '<div class="col col-12 col-lg-4 col-xl-3 col-md-6 col-sm-6">
                                    <div class="product_item" data-id="'.$product_id.'">
                                        <div class="product_img">
                                            <a href="/pages/product_item?id='.$product_id.'">
                                                <div class="photo" style="background-image: url('.$product_img.')"></div>
                                            </a>
                                            <div class="discount">'.$discount_show.'</div>
                                        </div>
                                       <div class="product_item_info">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="product_title">
                                                        <div class="title">'.$product_title.'</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="price">'.$price_show.' AMD</div>
                                                </div>
                                                <div class="col-6">
                                                     <div class="product_icon">
                                                        <button type="button" class="cardButton" data-id="'.$product_id.'"><i class="fas fa-shopping-cart"></i></button>
                                                        <button type="button" class="wishlist" data-id="'.$product_id.'"><i class="fas fa-heart"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="products_rate">
                                                 <div class="rate rate_cont" data-rate="'.$rate.'"></div>
                                            </div>
                                       </div>
                                    </div>
                                </div>';
                        }   
                    } else {
                        echo '<h3 class="pages_no_product_text">There are no products for this category<h3>';
                    }
                    ?>
                </div>
            </div>
        </section>
        <section id="footer">
            <div class="footer_content">
                <div class="icon_content">
                    <i class="fab fa-facebook-square"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-linkedin"></i>
                    <i class="fab fa-pinterest-square"></i>
                </div>
                <div class="copyright">
                    Copyright © 2021 by Hovhannes Mkrrtchyan
                </div>
            </div>
        </section>
         <?php require_once('layouts/default/inc/scripts.php');?>
    </body>
</html>