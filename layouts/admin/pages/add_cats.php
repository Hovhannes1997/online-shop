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
                                    <a href="/admin/pages/add_cats"><b>Add category</b></a>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="add_cats">
                                    <h1 class="text-center">Ավելացնել Բաժին</h1>
                                    <form action="?cmd=addCats" method="post" name="add_cats_menu" enctype="multipart/form-data" class="add_form">
                                        <p>
                                            <input class="padding" type="text" name="title" placeholder="Վերնագիր*">
                                        </p>
                                        <p>
                                            <input class="padding" type="file" name="img">
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
        
        <?php require_once('layouts/admin/inc/scripts.php');?>
    </body>
</html>