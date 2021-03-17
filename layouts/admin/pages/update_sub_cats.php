<?php
$id = $_GET['id'];
$sql_sub_cat = $cnt->con->prepare('SELECT * FROM `sub_cats` WHERE `id`=?');
$sql_sub_cat->execute(array($id));
while($row_sub_cat = $sql_sub_cat->fetch()) {
    $sub_cat_id = $row_sub_cat['id'];
    $sub_cat_title = $row_sub_cat['title'];
    
    $sql_files = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
    $sql_files->execute(array('sub_cats', $sub_cat_id, 'top'));
    
    if ($sql_files->rowCount() > 0) {
        $row_files = $sql_files->fetch();
        $sub_cat_img = '/public/photos/sub_cat_img/'.$row_files['name'].'.'.$row_files['type'];
    } else {
        $sub_cat_img = '/public/img/no_photo.jpg';
    }
}
?>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="update_category">
                                    <h1 class="text-center products_update_title"><?=$sub_cat_title?></h1>
                                    <div class="item_content">
                                        <form action="?cmd=updateSubCats&id=<?=$sub_cat_id?>" method="post" name="edit_cats" enctype="multipart/form-data">
                                            <p>
                                                <input class="padding" type="text" name="title" placeholder="Վերնագիր *" value="<?=$sub_cat_title?>">
                                            </p>
                                            <p>
                                                <img src="<?=$sub_cat_img?>">
                                            </p>
                                            <p>
                                                <input class="desing" type="file" name="img">
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
                </div>
            </div>
        </div>
    
        
        <?php require_once('layouts/admin/inc/scripts.php');?>
    </body>
</html>