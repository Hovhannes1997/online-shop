<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php require_once('layouts/default/inc/head.php');?>
        <title>Sub Category</title>
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
                    </div><!-- .search-box -->
                    <div class="extension-nav">
                        <ul>
                            <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                            <li>
                                <a href="/pages/cart">
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
        <section id="subCat">
            <div class="container">
                <h4 class="sub_cat_page_title">Sub category</h4>
                <div class="sub_cat_content">
                    <div class="row">
                       <?php
                        $cat_id = $_GET['id'];
                        $sql_sub_cat = $cnt->con->prepare("SELECT * FROM `sub_cats` WHERE `cat_id`=?");
                        $sql_sub_cat->execute(array($cat_id));
                        if($sql_sub_cat->rowCount() > 0) {
                            while($row_cats = $sql_sub_cat->fetch()) {
                                $sub_cat_id = $row_cats['id'];
                                $sub_cat_title = $row_cats['title'];
                                $sql_files = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
                                $sql_files->execute(array('sub_cats', $sub_cat_id, 'top'));
                                if($sql_files->rowCount() > 0) {
                                    $row_files = $sql_files->fetch();
                                    $sub_cat_img = '/public/photos/sub_cat_img/'.$row_files['name'].'.'.$row_files['type'];
                                } else {
                                    $sub_cat_img = '/public/img/no_photo.jpg';
                                }
                                echo '<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                    <div class="sub_cat_item">
                                        <div class="sub_cat_img_content">
                                            <a href="/pages/products?id='.$sub_cat_id.'">
                                                <div class="sub_cat_img" style="background-image: url('.$sub_cat_img.')"></div>
                                            </a>
                                        </div>
                                        <div class="sub_cat_title">
                                            <h3>'.$sub_cat_title.'</h3>
                                        </div>
                                    </div>
                                </div>';
                            }    
                        } else {
                            echo '<h3 class="pages_no_product_text">There is no product for this category<h3>';
                        }
                        ?>
                    </div>
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