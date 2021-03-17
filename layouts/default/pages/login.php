<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php require_once('layouts/default/inc/head.php');?>
        <title>Login</title>
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
                                    <a href="/pages/login"  style="color: #fff; background-color:#FF4C1E; border:1px solid #FF4C1E;"><i class="fas fa-sign-in-alt"></i>Login</a>
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
                                    <a href="/pages/login"  style="color: #fff; background-color:#FF4C1E; border:1px solid #FF4C1E;"><i class="fas fa-sign-in-alt"></i>Login</a>
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
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="login_img">
                            <img src="/public/img/undraw_unlock_24mb.svg" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="page_titler">Log in to your personal page</h3>
                        <div class="login">
                            <form id="login">
                                <div class="printEmpty"></div>
                                <p>
                                    <input type="email" class="loginUserName" name="email" placeholder="Email">
                                </p>
                                <p>
                                    <input type="password" class="loginUserPass" name="password" placeholder="Password">
                                </p>
                                <p>
                                    <input id="checkbox" class="checkbox" type="checkbox" name="renamber">
                                    <label for="checkbox">remember</label>
                                </p>
                                <p>
                                    <a href="/pages/resetpass">Reset password</a>
                                </p>
                                <button  class="g-recaptcha" 
                                data-sitekey="reCAPTCHA_site_key" 
                                data-callback='onSubmit' 
                                data-action='submit'>Login<span class="loading_content"></span></button>
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
        <?php require_once('layouts/default/inc/scripts.php');?>
    </body>
</html>