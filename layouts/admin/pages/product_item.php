<?php
$id = $_GET['id'];
$sql_item = $cnt->con->prepare("SELECT * FROM `products` WHERE `id`=?");
$sql_item->execute(array($id));
if ($sql_item->rowCount() > 0) {
    $products =  $sql_item->fetch();
    $cur_cat_id = $products['sub_cat_id'];
    $cur_title = $products['title'];
    $cur_price = $products['price'];
    $cur_descr = $products['descr'];
    $cur_quantity = $products['quantity'];
    $cur_discount = $products['discount'];
    $cur_discount_start_date = $products['discount_start_date'];
    $cur_discount_end_date = $products['discount_end_date'];
    // img
    $sql_files_product = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
    $sql_files_product->execute(array('products', $id, 'home'));
    if ($sql_files_product->rowCount() > 0) {
        $row_files_product = $sql_files_product->fetch();
        $cur_img_product = '/public/photos/thumbs/'.$row_files_product['name'].'.'.$row_files_product['type'];
    } else {
        $cur_img_product = '/public/img/no_photo.jpg';
    }
} else {
    header('location: /admin/default');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php require_once('layouts/admin/inc/head.php');?>
        <title>Product</title>
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
                                    <a href="/admin/pages/products">products</a>
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
                        <div class="item_content">
                           <h1 class="text-center products_update_title">Փոփոխել ապրանքը</h1>
                            <form action="?cmd=updateProduct&id=<?=$id?>" method="post" name="edit_products" enctype="multipart/form-data">
                                <p>
                                    <select name="sub_cat_id">
                                        <?php
                                        $sql_cat = $cnt->con->prepare("SELECT * FROM `cats`");
                                        $sql_cat->execute();
                                        while($row_cat = $sql_cat->fetch()) {
                                            $cat_id = $row_cat['id'];
                                            $cat_title = $row_cat['title'];
                                            // print sub cat
                                            echo '<optgroup label="'.$cat_title.'">';
                                            $sql_sub_cats = $cnt->con->prepare("SELECT * FROM `sub_cats` WHERE `cat_id`=?");
                                            $sql_sub_cats->execute(array($cat_id));
                                            while($row_sub_cats = $sql_sub_cats->fetch()) {
                                                $sub_cat_id = $row_sub_cats['id'];
                                                $sub_cat_title = $row_sub_cats['title'];                   
                                                echo '<option value="'.$sub_cat_id.'">'.$sub_cat_title.'</option>';
                                              
                                            }
                                            echo '</optgroup>';
                                        }
                                        ?>
                                    </select>
                                </p>
                                <p>
                                    <select name="top_product">
                                        <option>ընտրել թոփ</option>
                                        <option value="1">այո</option>
                                        <option value="0">ոչ</option>
                                    </select>
                                </p>
                                <p>
                                    <select name="status_product">
                                        <option>ընտրել հասանելի կամ ոչ հասանելի</option>
                                        <option value="1">հասանելի</option>
                                        <option value="0">ոչ հասանելի</option>
                                    </select>
                                </p>
                                <p>
                                    <input class="padding" type="text" name="title" placeholder="Վերնագիր *" value="<?=$cur_title?>">
                                </p>
                                <div class="text-center">
                                    <img src="<?=$cur_img_product?>">
                                    <input class="desing" type="file" name="img">
                                </div>
                                <div class="uppyDashboard" data-id="<?=$id?>"></div>
                                <div class="row justify-content-center">
                                    <div class="ightslider_content">
                                        <ul id="lightSlider">
                                            <?php
                                            $sql_files = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
                                            $sql_files->execute(array('products', $id, 'gallery'));
                                            while($row_files = $sql_files->fetch()) {
                                                $file_id = $row_files['id'];
                                                $name = $row_files['name'];
                                                $type = $row_files['type'];
                                                ?>
                                                <a>
                                                    <li class="d-flex">
                                                        <img src="/public/photos/uppy/large/<?=$name?>">
                                                        <a href="?cmd=deleteUppy&id=<?=$file_id?>" class="delet_slider_img"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </li>
                                                </a>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <p>
                                    <input class="padding" type="text" name="price" placeholder="գին *" value="<?=$cur_price?>">
                                </p>
                                <p>
                                    <input class="padding" type="text" name="discount" placeholder="զաղչված գին գին *" value="<?=$cur_discount?>">
                                </p>
                                <p>
                                    <input class="padding" type="text" name="quantity" placeholder="քանակ *" value="<?=$cur_quantity?>">
                                </p>
                                <p>
                                    <input type="datetime-local" name="startDate" value="<?=$cur_discount_start_date?>">
                                </p>
                                <p>
                                    <input type="datetime-local" name="endDate" value="<?=$cur_discount_end_date?>">
                                </p>
                                <p>
                                    <textarea name="descr" id="summernote"><?=$cur_descr?></textarea>
                                </p>
                                <p class="action">
                                    <button type="submit">Պահպանել</button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php require_once('layouts/admin/inc/scripts.php');?>
    </body>
</html>