<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Վերականգնել գաղտնաբառը</title>
        <?php require_once('inc/head.php');?>
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
                                    <a href="/admin/pages/cats">Sub category</a>
                                </li>
                                <li>
                                    <a href="/admin/pages/products">products</a>
                                </li>
                                <li>
                                    <a href="/admin/regist"><b>Regist admin</b></a>
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
                            <div class="col-md-12">
                                <h3 class="page_title">Գրանցվել</h3>
                                <div class="regist">
                                    <form id="regist">
                                        <div class="printEmpty"></div>
                                        <p>
                                            <input type="text" class="emptyUserName" name="name" placeholder="Անուն">
                                        </p>
                                        <p>
                                            <input type="text" class="emptyUserLAstName" name="last_name" placeholder="Ազգանւն">
                                        </p>
                                        <p>
                                            <input type="tel" class="emptyUserPhone" name="phone" placeholder="Հեռախոսահամար">
                                        </p>
                                        <p>
                                            <input type="email" class="emptyUserEmail" name="email" placeholder="Էլ․ Փոստ">
                                        </p>
                                        <p>
                                            <input type="password" class="emptyUserPassword" name="password" placeholder="Գաղտնաբառ">
                                        </p>
                                        <p>
                                            <input type="password" class="emptyUserRepeatPassword" name="repeat_password" placeholder="Հաստատել գաղտնաբառը">
                                        </p>
                                        <button type="submit">Գրանցվել</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        
        <?php require_once('inc/scripts.php');?>
    </body>
</html>