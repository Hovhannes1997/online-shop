<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql_product = $cnt->con->prepare("SELECT * FROM `products` WHERE `id`=? AND `status`=?");
    $sql_product->execute(array($id, '1'));
    if ($sql_product->rowCount() > 0) {
        $row_product =  $sql_product->fetch();
        $product_id = $row_product['id'];
        $sub_cat_id = $row_product['sub_cat_id'];
        $product_title = $row_product['title'];
        $product_price = $row_product['price'];
        $product_discount = $row_product['discount'];
        $product_descr = htmlspecialchars_decode($row_product['descr']);
        $quantity = $row_product['quantity'];
        
        // check quantity
        if ($quantity > 0) {
            $show_quantity = 'Quantity: - '.$quantity;
        } else {
            $show_quantity = '';
        }
        
        if ($product_discount > 0) {
            $price_discounted = $product_price - ($product_price * $product_discount / 100);
            $price_show = '<del class="discount_color"><span class="discount_color"></span>'.$product_price.'</del> '.$price_discounted;
            $discount_show = '<div class="product_item_show_discount">'.$product_discount.'%</div>';
        } else {
            $discount_show = '';
            $price_show = 'Price: - '.$product_price;
        }
        
        $sql_files = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
        $sql_files->execute(array('products', $id, 'home'));
        
        if ($sql_files->rowCount() > 0) {
            $row_files = $sql_files->fetch();
            $product_img_small = '/public/photos/thumbs/'.$row_files['name'].'.'.$row_files['type'];
            $product_img_large = '/public/photos/large/'.$row_files['name'].'.'.$row_files['type'];
        } else {
            $product_img_small = '/public/img/no_photo.jpg';
            $product_img_large = '/public/img/no_photo.jpg';
        }
        
        $sql_cat = $cnt->con->prepare("SELECT * FROM `sub_cats` WHERE `id`=?");
        $sql_cat->execute(array($sub_cat_id));
        $row_cat = $sql_cat->fetch();
        $cat_title = $row_cat['title'];
    } else {
        exit;
    }
} else {
    exit;
}
?>
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
                    </div><!-- .search-box -->
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
        <section id="productItem">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-7">
                        <div class="slider_content">
                            <div class="slider_discount"><?=$discount_show?></div>
                            <ul id="imageGallery" class="product_item" data-id="<?=$product_id?>">
                                <li class="slider_large_photo" data-thumb="<?=$product_img_small?>">
                                    <div class="slider_photo photo slider_photo_large" style="background-image: url(<?=$product_img_large?>)"></div>
                                </li>
                                <?php
                                $sql_files = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
                                $sql_files->execute(array('products', $id, 'gallery'));
                                while($row_files = $sql_files->fetch()) {
                                    $name = $row_files['name'];
                                    $type = $row_files['type'];
                                    ?>
                                    <li class="slider_thumbs_photo" data-thumb="/public/photos/uppy/small/<?=$name?>.<?=$type?>">
                                        <div class="slider_photo" style="background-image: url(/public/photos/uppy/large/<?=$name?>.<?=$type?>)"></div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <div class="product_item_info">
                            <div class="info">
                                <div class="product_title"><?=$product_title?></div>
                                <div class="product_quantity"><?=$show_quantity?></div>
                                <div class="product_price"><?=$price_show?> AMD</div>
                                <?php
                                /* rate */
                                $product_review_count = 0;
                                $product_review_score = 0;
                                $sql_review_reting = $cnt->con->prepare("SELECT * FROM `review` WHERE `p_id`=?");
                                $sql_review_reting->execute(array($id));
                                while($row_review_reting = $sql_review_reting->fetch()) {
                                    $product_review_count++;
                                    $product_review_score += $row_review_reting['rate'];
                                }
                                $rate_count = [];
                                $rate_percent = [];
                                if ($product_review_count > 0) {
                                    $product_rate = round($product_review_score / $product_review_count, 1);
                                    $product_rate_percent = round(($product_rate / 5) * 100, 1);
                                    $product_rate_show = '<div class="reteYoStatic" data-rate="'.$product_rate.'"></div>'; 
                                    for ($s = 1; $s <= 5; $s++) {
                                        $sql_rate = $cnt->con->prepare("SELECT * FROM `review` WHERE `p_id`=? AND `rate`=?");
                                        $sql_rate->execute(array($id, $s));
                                        $rate_count[$s] = $sql_rate->rowCount();
                                        $rate_percent[$s] = round(($rate_count[$s] / $product_review_count) * 100, 1);
                                    }
                                    $product_rate_content = '<p>Number of appraisers: - '.$product_review_count.'</p>
                                    <p>Total points: - '.$product_review_score.'</p>
                                    <p class="stars_final">Rating: - '.$product_rate.' <i class="fa fa-star" aria-hidden="true"></i></p>';
                                    //show stars rate
                                    for ($sr = 5; $sr >= 1; $sr--) { 
                                        $product_rate_content .= '<div class="star_rate d-flex">
                                        <div class="stars_count">'.$sr.'<i class="fa fa-star" aria-hidden="true"></i></div>
                                        <div class="progress flex-fill flex-grow-1">
                                        <div class="progress-bar stars_'.$sr.'"
                                        role="progressbar"
                                        style="width:'.$rate_percent[$sr].'%;"
                                        aria-voluenow="'.$rate_percent[$sr].'%" aria-volumin="0"  
                                        aria-volumax="100">'.$rate_percent[$sr].'%</div>
                                        </div>
                                        <div class="count">'.$rate_count[$sr].'</div>
                                        </div>';
                                    }
                                        $product_rate_content .= '</div>';
                                } else {
                                    $product_rate = 0;
                                    $rate_percent = 0;
                                    $product_rate_show = '<div class="reteYoStatic" data-rate="0"></div>';
                                    $product_rate_content = '';
                                }

                                ?>
                                <div class="rate rate_cont d-inline-block" data-rate="<?=$product_rate?>"></div>
                                <?php
                                if ($product_rate_content != '') {
                                    ?>
                                    <button type="button" class="btn_modal" data-bs-toggle="tooltip" data-bs-placement="right" title="Tooltip on right" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-eye"></i></button>
                                <?php } ?>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Reting table</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?=$product_rate_content?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="add_cart">
                                    <p>
                                        <button class="add_icon_btn_card card_btn_color cardButton" data-id="<?=$id?>"><i class="fas fa-shopping-cart"></i></button>
                                        <button class="add_card_btn_heart wishlist_heart wishlist" data-id="<?=$id?>"><i class="fas fa-heart"></i></button>
                                    </p> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="reviw_content">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#description" role="tab" aria-controls="contact" aria-selected="false">Description</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Reviews</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div id="products">
                                            <div class="container p-0">
                                                <div class="row">
                                                    <?php
                                                    $sql_product = $cnt->con->prepare("SELECT * FROM `products` WHERE `sub_cat_id`=? AND `id`!=? ORDER BY `id` DESC");
                                                    $sql_product->execute(array($sub_cat_id, $product_id));
                                                    if ($sql_product->rowCount() > 0) {
                                                        while($row_product = $sql_product->fetch()) {
                                                            $product_id = $row_product['id'];
                                                            $product_title = $row_product['title'];
                                                            $product_price = $row_product['price'];
                                                            $product_discounted = $row_product['discount'];
                                                            $product_description = $row_product['descr'];

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

                                                            if($product_discounted > 0) {
                                                                $price_discount = $product_price - ($product_discounted * $product_price / 100);
                                                                $price_show = $price_discount;
                                                                $product_discount_show = '<div class="products_show_discount">'.$product_discounted.'%</div>';
                                                            } else {
                                                                $price_show = $product_price;
                                                                $product_discount_show = '';
                                                            }
                                                            echo '<div class="col col-12 col-lg-4 col-xl-3 col-md-6 col-sm-6">
                                                                <div class="product_item" data-id="'.$product_id.'">
                                                                    <div class="product_img">
                                                                        <a href="/pages/product_item?id='.$product_id.'">
                                                                            <div class="photo" style="background-image: url('.$product_img.')"></div>
                                                                        </a>
                                                                        <div class="discount">'.$product_discount_show.'</div>
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
                                                                                <div class="price">'.$price_show.'</div>
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
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="contact-tab">
                                        <p>
                                            <?=$product_description?>
                                        </p>
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"> 
                                       <?php
                                        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
                                            $user_email = $_SESSION['user_id'];
                                            $sql_user = $cnt->con->prepare("SELECT * FROM `users` WHERE `id`=?");
                                            $sql_user->execute(array($user_email));
                                            $row_users = $sql_user->fetch();
                                            $user_name = $row_users['name'];
                                        ?>
                                        <div class="add_reviews">
                                            <form id="formReview" data-id="<?=$id?>">
                                                <div class="form-group">
                                                    <label class="my-1 mr-2 form_title" for="inlineFormCustomSelectPref">Evaluate the product</label>
                                                    <div class="reting_review">
                                                        <div class="reting_stars" id="rateYo"></div>
                                                        <div>
                                                            <input type="hidden" name="rate">
                                                        </div>
                                                        <div class="user_name">
                                                            <input type="text" name="user_name" value="<?=$user_name?>" hidden>
                                                        </div>
                                                        <div class="review_text">
                                                            <span class="printEmpty"></span>
                                                            <textarea name="review_text" class="empty_text"></textarea>
                                                        </div>
                                                        <div class="review_btn">
                                                            <button type="submit">Send <span class="loading_content"></span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <?php } ?>
                                        <?php
                                        if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
                                        ?>
                                        <div class="add_reviews">
                                            <form id="formReview">
                                                <div>
                                                    <label class="my-1 mr-2 form_title" for="inlineFormCustomSelectPref">in order to write a review, you need to log in to your personal page</label>
                                                    <div class="reting_review">
                                                        <div class="reting_stars">
                                                            <img src="/public/img/rate.jpg" alt="">
                                                        </div>
                                                        <div>
                                                            <input type="hidden" disabled>
                                                        </div>
                                                        <div class="user_name">
                                                            <input type="text" placeholder="Name" disabled>
                                                        </div>
                                                        <div class="review_text">
                                                            <textarea disabled></textarea>
                                                        </div>
                                                        <div class="review_btn">
                                                            <button disabled>Send</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <?php } ?>
                                        <div class="review_content">
                                            <h3 class="review_content_title">Reviews</h3>
                                            <?php
                                            $sql_review = $cnt->con->prepare("SELECT * FROM `review` WHERE `p_id`=?");
                                            $sql_review->execute(array($id));
                                            while($row_review = $sql_review->fetch()) {
                                                $user_id = $row_review['id'];
                                                $rate = $row_review['rate'];
                                                $review_text = $row_review['review'];
                                                $user_name = $row_review['user_name'];
                                                $date_review = date('d.m.Y H:i', strtotime($row_review['date'])); 
                                                ?> 
                                                <div class="review_item">
                                                    <div class="user_name">
                                                        <div class="user_rate">
                                                            <span class="user_name"><?=$user_name?></span>
                                                            <span class="rate" data-rate="<?=$rate?>"></span>
                                                        </div>
                                                    </div>  
                                                    <div class="review_user">
                                                        <span class="span">Review: - <?=$review_text?></span>
                                                    </div>
                                                    <div class="review_date"><?=$date_review?></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
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