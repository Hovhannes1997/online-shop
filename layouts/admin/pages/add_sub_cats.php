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
                                    <a href="/admin/pages/add_sub_cats"><b>Add sub category</b></a>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="add_cats">
                                    <h1 class="text-center">Ավելացնել ենթաբաժին</h1>
                                    <form action="?cmd=addSubCats" method="post" name="addSubCats" enctype="multipart/form-data" class="add_sub_cats">
                                        <p>
                                            <select name="cat_id">
                                            <?php
                                            $sql_cat = $cnt->con->prepare("SELECT * FROM `cats`");
                                            $sql_cat->execute();
                                            while($row_cat = $sql_cat->fetch()) {
                                                $cat_id = $row_cat['id'];
                                                $cat_title = $row_cat['title'];
                                                echo '<option value="'.$cat_id.'">'.$cat_title.'</option>';
                                            }
                                            ?>
                                            </select>
                                            <span class="add_span">Ընտրել որ բաժնի համար</span>
                                        </p>
                                        <p>
                                            <input class="padding sub_cat_inp" type="text" name="title" placeholder="Վերնագիր*">
                                        </p>
                                         <p>
                                            <input class="padding" type="file" name="img">
                                        </p>
                                        <p class="action">
                                            <button class="add_sub_cats_btn" type="submit">Պահպանել</button>
                                        </p>
                                    </form>
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