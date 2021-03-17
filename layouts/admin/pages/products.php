<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Վերականգնել գաղտնաբառը</title>
        <?php require_once('layouts/admin/inc/head.php');?>
    </head>
    <body>
        <div class="wrapper">
            <div class="row">
                <div class="col-2">
                    <div class="content_left">
                       <div class="user_img text-center">
                           <a href="">
                                <img src="/public/img/kisspng-web-development-php-software-developer-programmer-computer-user-icon-svg-5ab0fde96b26b1.0935145915215487774389.png" alt="">
                            </a>
                       </div>
                        <nav>
                            <ul class="text-center">
                               <li>
                                    <a href="/admin/default">Home</a>
                                </li>
                                <li>
                                    <a href="/admin/pages/add_cats">Add category</a>
                                </li>
                                <li>
                                    <a href="/admin/pages/add_sub_cats">Add sub category</a>
                                </li>
                                <li>
                                    <a href="/admin/pages/add_product">Add product</a>
                                </li>
                                <li>
                                    <a href="/admin/pages/cats">Category</a>
                                </li>
                                <li>
                                    <a href="/admin/pages/sub_cats">Sub category</a>
                                </li>
                                <li>
                                    <a href="/admin/pages/products"><b>products</b></a>
                                </li>
                                <li>
                                    <a href="/admin/regist">Regist admin</a>
                                </li>
                                <li class="logaut text-center">
                                    <a href="?cmd=adminLogout">
                                        <button class="btn btn-outline-success my-2 my-sm-0">Դուրս գալ</button>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-10">
                    <div class="content_right">
                        <div class="products_content"> 
                            <div class="row">
                                <?php 
                                $sql_products = $cnt->con->prepare("SELECT * FROM `products` ORDER BY `id` DESC");
                                $sql_products->execute();
                                while($row_products = $sql_products->fetch()) {
                                    $id = $row_products['id'];
                                    $title = $row_products['title'];
                                    $price = $row_products['price'];
                                    $discount = $row_products['discount'];
                                    $descr = htmlspecialchars_decode($row_products['descr']);
                                    $price_show = $price;
                                    $discount_show = "";
                                    $date = $row_products['date'];
                                    $date_show = date('d.m.Y H:i', strtotime($date));
                                    $discount_start_date = $row_products['discount_start_date'];
                                    $discount_end_date = $row_products['discount_end_date'];
                                    // img
                                    $sql_files_product = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
                                    $sql_files_product->execute(array('products', $id, 'home'));
                                    if ($sql_files_product->rowCount() > 0) {
                                        $row_files_product = $sql_files_product->fetch();
                                        $product_img = '/public/photos/thumbs/'.$row_files_product['name'].'.'.$row_files_product['type'];
                                    } else {
                                        $product_img = '/public/img/no_photo.jpg';
                                    }
                                    // date
                                    $data_timer = '';
                                    if ($date_show >= $discount_start_date && $date_show < $discount_end_date) {
                                        // check discount
                                        if ($discount > 0) {
                                            $price_discounted = $price - ($price * $discount / 100);
                                            $price_show = '<del>'.$price.'</del> '.$price_discounted;
                                            $discount_show = '<div class="discount_show">'.$discount.'%</div>';
                                        }
                                    }
                                    ?>
                                    <div class="cont_product">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="photo" style="background: url(<?=$product_img?>) no-repeat center/cover;"></div>
                                            </div>
                                            <div class="col-4">
                                                <div class="title">
                                                    <h2><?=$title?></h2>
                                                </div>
                                                <div class="descr"><?=$descr?></div>
                                            </div>
                                            <div class="col-2">
                                            <div class="row p-0">
                                                <p>Զեղչի ժամանակացույց</p>
                                                <div class="col-12 date" data-toggle="tooltip" title="Սկզբնաժամկետ"><?=$discount_start_date?></div>
                                                <div class="col-12 date" data-toggle="tooltip" title="Վերջնաժամկետ"><?=$discount_end_date?></div>
                                                <div class="col-12 date" data-toggle="tooltip" title="տեղադրման ժամանակ"><?=$date_show?></div>
                                                <div><?=$discount_show?></div>
                                            </div>
                                            </div>
                                            <div class="col-1">
                                                <p>Գինը</p>
                                                <div class="price"><?=$price_show.' դր'?></div>
                                            </div>
                                            <div class="col-1">

                                            </div>
                                            <div class="col-2">
                                                <div class="update_products">
                                                    <p>
                                                        <a href="/admin/pages/product_item?id=<?=$id?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                    </p>
                                                    <p>
                                                        <a href="?cmd=deleteProduct&id=<?=$id?>" class="delet_products"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        
        <?php require_once('layouts/admin/inc/scripts.php');?>
    </body>
</html>