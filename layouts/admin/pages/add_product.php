<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php require_once('layouts/admin/inc/head.php');?>
        <title>Document</title>
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
                                    <a href="/admin/pages/add_product"><b>Add product</b></a>
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
                                <div class="add_products">
                                    <h1 class="text-center">Ավելացնել ապրանքներ</h1>
                                    <form  action="?cmd=addProducts" method="post" name="addProducts" enctype="multipart/form-data" class="add_form">
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
                                        <p><input class="padding" type="text" name="title" placeholder="Վերնագիր*"></p>
                                        <p><input class="padding" type="text" name="price" placeholder="գին *"></p>
                                        <p><input class="padding" type="text" name="discount" placeholder="զաղչված գին գին *"></p>
                                        <p><input class="padding" type="number" name="quantity" placeholder="քանակ *"></p>
                                        <p><input type="datetime-local" name="startDate" paceholder="նշել ամիս ամսաթիվ սկզբնաժամկետ *"></p>
                                        <p><input type="datetime-local" name="endDate" paceholder="նշել ամիս ամսաթիվ վերջնաժամկետ *"></p>
                                        <p><textarea name="descr" id="summernote"></textarea></p>
                                        <p><input class="desing" type="file" name="img"></p>
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
        
        <?php require_once('layouts/admin/inc/scripts.php');?>
    </body>
</html>