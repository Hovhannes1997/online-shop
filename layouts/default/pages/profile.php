<?php
$user_id = $_SESSION['user_id'];
$sql_user = $cnt->con->prepare("SELECT * FROM `users` WHERE `id`=?");
$sql_user->execute(array($user_id));
$row_user = $sql_user->fetch();
$user_name = $row_user['name'];
$user_last_name = $row_user['last_name'];
$user_email = $row_user['email'];
$user_phone = $row_user['phone'];
$user_password = $row_user['password'];

//check img
$sql_files_user = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
$sql_files_user->execute(array('users', $user_id, 'home'));
if ($sql_files_user->rowCount() > 0) {
    $row_files_user = $sql_files_user->fetch();
    $user_img = '/public/photos/users/'.$row_files_user['name'].'.'.$row_files_user['type'];
} else {
    $user_img = '/public/img/no_photo.jpg';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php include_once('layouts/default/inc/head.php');?>
        <title>Գլխավոր</title>
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
                                    <a href="/pages/regist" style="color: #fff; background-color:#FF4C1E; border:1px solid #FF4C1E;"><i class="fas fa-user-plus"></i>Sign up</a>
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
                                    <a href="/pages/profile" style="color: #fff; background-color:#FF4C1E; border:1px solid #FF4C1E;"><i class="fas fa-user-tie"></i>Profile</a>
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
                                    <a href="/pages/profile" style="color: #fff; background-color:#FF4C1E; border:1px solid #FF4C1E;"><i class="fas fa-user-tie"></i>Profile</a>
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
        <section id="profile">
            <div class="container">
                <div class="row">
                    <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-3">
                        <div class="user_photo">
                            <img src="<?=$user_img?>" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                        <div class="content_user">
                            <form id="update_profile">
                                <div class="empty_form_update_user"></div>
                                <h5 class="form_title text-left">Personal information</h5>
                                <p class="form_p_flex">
                                    <label>
                                        <span class="form_title_block">Name</span>
                                        <input class="us_inp empty_update_user_name" type="text" name="userName" value="<?=$user_name?>">
                                    </label>
                                    <label>
                                        <span class="form_title_block">Last name</span>
                                        <input class="us_inp empty_update_user_last_name" type="text" name="userLastName" value="<?=$user_last_name?>">
                                    </label>
                                </p>
                                <p class="form_p_flex">
                                    <label>
                                        <span class="form_title_block">Email</span>
                                        <input class="us_inp empty_update_user_email" type="email" name="userEmail" value="<?=$user_email?>">
                                    </label>
                                    <label>
                                        <span class="form_title_block">Phone</span>
                                        <input class="us_inp empty_update_user_phone" type="tel" name="userPhone" value="<?=$user_phone?>">
                                    </label>
                                </p>
                                <p>
                                    <span class="form_title_block">Add photo</span>
                                    <input type="file" name="img">
                                </p>
                                <div class="us_page_btn">
                                    <button type="submit" class="button_action">save<span class="loading_content"></span></button>
                                </div>
                            </form>
                        </div> 
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
         <?php include_once('layouts/default/inc/scripts.php');?>
    </body>
</html>