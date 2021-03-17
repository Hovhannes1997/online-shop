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
                                    <a href="/admin/pages/cats"><b>Category</b></a>
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
                        <div class="admin_cats_content">
                            <div class="cat_title">
                                <h1 class="text-center">Բաժիններ</h1>
                            </div>
                            <?php
                            $sql_cats = $cnt->con->prepare("SELECT * FROM `cats`");
                            $sql_cats->execute();
                            while($row_cats = $sql_cats->fetch()) {
                                $cat_id = $row_cats['id'];
                                $cat_title = $row_cats['title'];
                                $sql_files = $cnt->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
                                $sql_files->execute(array('cats', $cat_id, 'top'));
                                if ($sql_files->rowCount() > 0) {
                                    $row_files = $sql_files->fetch();
                                    $cat_img = '/public/photos/cat_img/'.$row_files['name'].'.'.$row_files['type'];
                                } else {
                                    $cat_img = '/public/img/no_photo.jpg';
                                }
                                ?>
                                <div class="admin_cats">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="photo" style="background: url('<?=$cat_img?>') no-repeat center/cover;"></div>
                                        </div>
                                        <div class="col-6">
                                            <div class="title"><?=$cat_title?></div>
                                        </div>
                                        <div class="col-2">
                                            <div class="update_cat">
                                                <p>
                                                    <a href="/admin/pages/update_cats?id=<?=$cat_id?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                </p>
                                                <p>
                                                    <a href="?cmd=deleteCat&id=<?=$cat_id?>" class="delet_slider_cat">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>
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
        <?php require_once('layouts/admin/inc/scripts.php');?>
    </body>
</html>