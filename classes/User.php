<?php
class User extends Model {
    /* Sessions & Cookies */
    public function __construct() {
        parent::__construct();
        // check session
        if (!isset($_SESSION['user_id'])) {
            // check cookies
            if (isset($_COOKIE['user_id']) && isset($_COOKIE['user']) && !empty($_COOKIE['user_id']) && !empty($_COOKIE['user'])) {
                $cookie_user = $_COOKIE['user'];
                $cookie_user_id = $_COOKIE['user_id'];
                // check user
                $user_row = $this->selectDataAdmin("users", "WHERE `id`='$cookie_user_id' AND `status`='1'");
                if ($user_row) {
                    $user_email = $user_row['email'];
                    // check email on cookie
                    if (md5($cookie_user_id.$user_email) == $cookie_user) {
                        $_SESSION['user_id'] = $_COOKIE['user_id'];
                        $_SESSION['user_email'] = $user_email;
                    }
                }
            }
        }
        // check session
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && isset($_SESSION['user_email']) && !empty($_SESSION['user_email'])) {
            // user data
            $session_user_id = $_SESSION['user_id'];
            $session_user_email = $_SESSION['user_email'];
            $this->User = $this->selectDataUser("users", "WHERE `id`='$session_user_id' AND `email`='$session_user_email' AND `status`='1'");
            // check user
            if (empty($this->User['id'])) {
                // unset sessions & cookies
                $this->userLogout();
            }
        } else {
            // unset sessions & cookies
            $this->userLogout();
        }
    }
    /* Admin DB */
    public function selectDataUser($table = '', $query = '', $count = 1) {
        $sql = $this->con->prepare("SELECT * FROM `$table` $query");
        $sql->execute();
        // return row
        if ($count == 1) {
            return $sql->fetch();
        }
        // return rows
        else if ($count == 'all') {
            return $sql->fetchAll();  
        }
    }
    // admin regist
    public function userRegist () {
        // get data
        $name = mb_convert_case(htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8'), MB_CASE_TITLE, "UTF-8");
        $last_name = mb_convert_case(htmlspecialchars(trim($_POST['last_name']), ENT_QUOTES, 'UTF-8'), MB_CASE_TITLE, "UTF-8");
        $phone = mb_convert_case(htmlspecialchars(trim($_POST['phone']), ENT_QUOTES, 'UTF-8'), MB_CASE_TITLE, "UTF-8");
        $email = mb_strtolower(htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8'), 'UTF-8');
        $password = md5($_POST['password']);
        // check email validation
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $response = array('type' => 'warning', 'title' => 'Warning', 'message' => 'Email is not correct.', 'reload' => '0');
            echo json_encode($response);
            exit;
        }
        // check user
        $sql_user = $this->con->prepare("SELECT * FROM `users` WHERE `email`=?");
        $sql_user->execute(array($email));
        // exists
        if ($sql_user->rowCount() > 0) {
            $response = array('type' => 'warning', 'title' => 'Warning', 'message' => 'Email exists.', 'reload' => '0');
            echo json_encode($response);
        }
        // doesn't exists
        else {
            // reg user
            $insert_user = $this->con->prepare("INSERT INTO `users` (`name`, `last_name`, `phone`, `email`, `password`) VALUES (?, ?, ?, ?, ?)");
            $insert_user->execute(array($name, $last_name, $phone, $email, $password));
            //inserted
            if ($insert_user) {
                // get user id
                $user_id = $this->con->lastInsertId();
                // generate confiramtion code
                $confirm_code = md5($user_id.time());
                // generate confirmation link
                $confirm_link = 'http://mvc.loc/?cmd=userConfirmCode&code='.$confirm_code;
                $confirm_link_show = '<a href="'.$confirm_link.'" target="_blank">Հաստատել գրանցումը</a>';
                // generate email
                $e_subject = 'Հաստատեք գրանցումը';
                $e_message = '
                <html>
                    <body>
                        <div style="font: 14px/1.5 Arial, Tahoma, Verdana, sans-serif">
                            <p style="margin-bottom: 10px;">Գրանցումը հաջողությամբ կատարված է:</p>
                            <p style="margin-bottom: 10px;">Խնդրում ենք '.$confirm_link_show.':</p>
                            <p style="color:#666">Հարգանքներով` Galent.am™<br>Հեռախոս՝ (011) 22-03-44<br>Էլ. փոստ՝ hello@galent.am</p>
                        </div>
                    </body>
                </html>';
                $e_message_alt = 'Գրանցումը հաջողությամբ կատարված է: Խնդրում ենք հաստատել Ձեր գրանցումը տեղափոխվելով այս հղմամբ՝ '.$confirm_link_show;
                // send email
                $snd = sendEmail($email, $name, $e_subject, $e_message, $e_message_alt);
                // email sent
                if ($snd) {
                    // update confiramtion code
                    $update_user = $this->con->prepare("UPDATE `users` SET `confirm_code`=? WHERE `id`=?");
                    $update_user->execute(array($confirm_code, $user_id));
                    // updated
                    if ($update_user) {
                        // response
                        $response = array('type' => 'success', 'title' => 'Success', 'message' => 'Check your email.', 'reload' => '0');
                        echo json_encode($response);
                    }
                    // not updated
                    else {
                        $response = array('type' => 'danger', 'title' => 'Error', 'message' => 'Activation error, please reset your password.', 'reload' => '0');
                        echo json_encode($response);
                    }
                }
                // email not sent
                else {
                    $response = array('type' => 'danger', 'title' => 'Error', 'message' => 'Activation email error, please reset your password.', 'reload' => '0');
                    echo json_encode($response);
                }
            }
            //not inserted
            else {
                $response = array('type' => 'danger', 'title' => 'Error', 'message' => 'Server error, please try again.', 'reload' => '0');
                echo json_encode($response);
            }
        }
    }
    // confirm code
    public function userConfirmCode () {
        // check code
        if (isset($_GET['code']) && !empty($_GET['code'])) {
            // get code
            $confirm_code = htmlspecialchars(trim($_GET['code']), ENT_QUOTES, 'UTF-8');
            //update status
            $update_user = $this->con->prepare("UPDATE `users` SET `confirm_code`=?, `status`=? WHERE `confirm_code`=?");
            $update_user->execute(array($confirm_code, '1', $confirm_code));
            //result
            if ($update_user) {
                header('location: pages/confirm_code?activate_user=1');
                exit;
            } else {
                header('location: pages/confirm_code?activate_user=0');
                exit;
            }
            
        } else {
            header('location: /');
            exit;
        }
    }
    // admin login
    public function userLogin () {
        // get data
        $email = $_POST['emailLog'];
        $password = md5($_POST['passwordLog']);
        $remember = $_POST['renamberLog'];
        // check user
        $sql_user = $this->con->prepare("SELECT * FROM `users` WHERE `email`=?");
        $sql_user->execute(array($email));
        // exists
        if ($sql_user->rowCount() > 0) {
            $row_user = $sql_user->fetch();
            $id = $row_user['id'];
            $u_status = $row_user['status'];
            $u_password = $row_user['password'];
            // check status
            if ($u_status == 0) {
                // result
                $response = array('type' => 'warning', 'title' => 'Not active', 'message' => 'Please activate your account via your email.', 'reload' => '0');
                echo json_encode($response);
                exit;
            }
            // check password
            if ($password != $u_password) {
                // password is incoorect
                $response = array('type' => 'warning', 'title' => 'Warning', 'message' => 'Password is incorrect.', 'reload' => '0');
                echo json_encode($response);
                exit;
            }
            // session
            $_SESSION['user_id'] = $id;
            $_SESSION['user_email'] = $email;
            // cookies
            if ($remember == 1) {
                $admin = md5($id.$email);
                setcookie('user_id', $id, time() + 60 * 60 * 24 * 365, '/', 'mvc.loc');
                setcookie('user', $admin, time() + 60 * 60 * 24 * 365, '/', 'mvc.loc');
            }
            // result
            $response = array('type' => 'success', 'title' => 'Welcome!', 'message' => 'You are logged in.', 'reload' => 'http://login/index.php?page=profile');
            echo json_encode($response);
        }
        // doesn't exists
        else {
            $response = array('type' => 'danger', 'title' => 'Error', 'message' => 'Email is incorrect, user not found.', 'reload' => '0');
            echo json_encode($response);
        }
    }
    //admin reset password
    public function userResetPass () {
        if (empty($_POST['email'])) {
            $response = array('type' => 'warning', 'title' => 'Warning', 'message' => 'Enter the mail field.', 'reload' => '0');
            echo json_encode($response);
            exit;
        }
        //get data
        $email = mb_strtolower(htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8'), 'UTF-8');
        //sql db
        $u_sql = $this->con->prepare("SELECT * FROM `users` WHERE `email`=?");
        $u_sql->execute(array($email));

        if ($u_sql->rowCount() > 0) {
            $new_password = passwordGenerator(10);
            $md5_password = md5($new_password);
            //sql db
            $user_sql = $this->con->prepare("SELECT * FROM `users` WHERE `email`=?");
            $user_sql->execute(array($email));
            $row_user_sql = $user_sql->fetch();
            $u_name = $row_user_sql['name'];
            $last_name = $row_user_sql['last_name'];
            // email data
            $title = 'Գաղտնաբառի վերականգնում';
            $message = '
            <html>
                <body>
                    <div>
                        <p style="margin-bottom:10px;">Բարև ձեզ հարգելի '.$u_name.' '.$last_name.' ձեր նոր գաղտնաբառն է - <span style="font-weight: bold; font-size:18px;">'.$new_password.'</span></p>
                    </div>
                </body>
            </html>';
            // send email
            $send_email = sendEmail($email, $u_name, $title, $message, $u_name);
            if ($send_email) {
                $update_user_pass = $this->con->prepare("UPDATE `users` SET `password`=? WHERE `email`=?");
                $update_user_pass->execute(array($md5_password, $email));
                if ($update_user_pass) {
                    // response
                    $response = array('type' => 'success', 'title' => 'Success', 'message' => 'Check your email.', 'reload' => '0');
                    echo json_encode($response);
                } else {
                    $response = array('type' => 'danger', 'title' => 'Error', 'message' => 'There was no update', 'reload' => '0');
                    echo json_encode($response);
                }
            } else {
                $response = array('type' => 'danger', 'title' => 'Error', 'message' => 'Send email error.', 'reload' => '0');
                echo json_encode($response);
            } 
        } else {
            $response = array('type' => 'danger', 'title' => 'Error', 'message' => 'Data not found', 'reload' => '0');
            echo json_encode($response);
        }
    }
    //unset user session
    public function userLogout() {
        $this->userUnset();
    }
    //unset user session
    public function userUnset() {
        // unset sessions
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        // unset cookies
        setcookie('user_id', '', time() - 60 * 60 * 24 * 365, '/', 'mvc.loc');
        setcookie('user', '', time() - 60 * 60 * 24 * 365, '/', 'mvc.loc');
    }
    //update user profile
    public function UpdateUserProfile() {
        $user_id = $_SESSION['user_id'];
        if (empty($_POST['userName']) || empty($_POST['userLastName']) || empty($_POST['userEmail']) || empty($_POST['userPhone']) ) {
            echo 'Լրացրռք պարտադիր դաշտերը։';
            exit;
        }

        $u_name = trim(htmlspecialchars($_POST['userName']));
        $u_surname = trim(htmlspecialchars($_POST['userLastName']));
        $u_email = trim(htmlspecialchars($_POST['userEmail']));
        $u_tel = trim(htmlspecialchars($_POST['userPhone']));
        // check image
        if ($_FILES['img']['size'] > 0) {
            //image name
            $img_name = md5(round(microtime(true) * 1000));
            $img_ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $img_size = $_FILES['img']['size'];
            // image obekt
            $image = new Simpleimage();
            // smool
            $image->load($_FILES['img']['tmp_name']);
            $image->crop(600, 600);
            $image->save("public/photos/users/$img_name.$img_ext");
            // update image name
            $insert_cat = $this->con->prepare("INSERT INTO `files` (`table_name`, `row_id`, `name_used`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_cat->execute(array('users', $user_id, 'home', $img_name, $img_ext, $img_size));
        } 
        //update
        $update_us = $this->con->prepare("UPDATE `users` SET `name`=?, `last_name`=?, `email`=?, `phone`=? WHERE `id`=?");
        $update_us->execute(array($u_name, $u_surname, $u_email, $u_tel, $user_id));
        
        if ($update_us) {
            $_SESSION['user_id'] = $user_id;
            header('location: /default/profile');
        } else {
            header('location: /default/profile');
        }
        exit;
    }
    //update cart 
    public function updatCart() {
        $cardJson = $_POST['card'];
        $CardDom = '';
        $price_total = 0;
        if ($cardJson) {
            $cardArry = json_decode(htmlspecialchars_decode($cardJson), true);
//            print_r($cardArry);
//            exit;
            $cart_array_new = [];
            foreach($cardArry as $product_array) {
                $sqlCard = $this->con->prepare("SELECT * FROM `products` WHERE `id`=?");
                $sqlCard->execute(array($product_array['id']));
                $rowCard = $sqlCard->fetch();
                $id = $rowCard['id'];
                $productTitile = $rowCard['title'];
                $productDiscount = $rowCard['discount'];
                $productPrice = $rowCard['price'];
                $product_qty = $rowCard['quantity'];
                if ($productDiscount > 0) {
                    $priceDiscount = $productPrice - ($productPrice * $productDiscount / 100);
                    $product_price_show = '<del>'.$productPrice.'</del> <span style="color: #c60000;">'.$priceDiscount.'</span> AMD';
                    $discount_show = '<div class="cart_discount_show">'.$productDiscount.'%</div>';
                    $price_product_end = $priceDiscount;
                    $price_realy = $productPrice * $product_array['qty'];
                    $price_show_discounted = $priceDiscount * $product_array['qty'];
                } else {
                    $discount_show = '';
                    $product_price_show = $productPrice.' AMD';
                    $priceDiscount = '';
                    $price_product_end = $productPrice;
                    $price_show = $productPrice * $product_array['qty'];
                    $price_realy = '';
                    $price_show_discounted = $productPrice * $product_array['qty'];
                }
                
                if ($product_array['qty'] > $product_qty) {
                    $product_array['qty'] = $product_qty;
                }
                $price_total += $price_product_end * $product_array['qty'];

                array_push($cart_array_new, $product_array);

                //check img
                $sqlCardImg = $this->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
                $sqlCardImg->execute(array('products', $id, 'home'));
                if ($sqlCardImg->rowCount() > 0) {
                    $rowCardImg = $sqlCardImg->fetch();
                    $productImg = '/public/photos/thumbs/'.$rowCardImg['name'].'.'.$rowCardImg['type'];
                } else {
                    $productImg = '/public/img/no_photo.jpg';
                }

                // session
                if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
                    $buy_btn = '<a href="/pages/checkout"><button>Buy</button></a>';
                } else {
                    $buy_btn = '<a href="/pages/login"><button>Buy</button></a>';
                }
                $CardDom .= '<div class="cart_content" data-id="'.$product_array['id'].'">
                    <div class="row">
                        <div class="col-12 col-sm-2 col-md-2 col-lg-1 col-xl-2">
                            <div class="cart_img">
                                <img src="'.$productImg.'" alt="">
                                <div class="cart_discount">'.$discount_show.'</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <div class="cart_title">'.$productTitile.'</div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-2">
                            <div class="cart_count">
                                <button class="cart_minus qty_btns" data-id="'.$product_array['id'].'"><i class="fas fa-minus-circle"></i></button>
                                <input class="cart_inp" type="text" value="'.$product_array['qty'].'" data-id="'.$product_array['id'].'">
                                <button class="cart_plus qty_btns" data-id="'.$product_array['id'].'"><i class="fas fa-plus-circle"></i></button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2 col-md-2 col-lg-3 col-xl-2">
                            <div class="cart_price"><del>'.$price_realy.' </del>'.$price_show_discounted.' AMD</div>
                        </div>
                        <div class="col-12 col-sm-1 col-md-2 col-lg-2 col-xl-2">
                            <div class="cart_icon">
                                <button type="button" class="wishlist" data-id="'.$product_array['id'].'"><i class="fas fa-heart"></i></button>
                                <button data-id="'.$product_array['id'].'" class="removFromCard"><i class="fas fa-times-circle"></i></button>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            $CardDom .= '<div class="cart_general_total">
                <div class="cart_general_total_content">
                    <div class="row">
                        <div class="col-12 col-sm-8 col-md-6 text-left">
                            <span class="cart_general_title">Total amount - </span>
                            <span class="cart_general_price">'.$price_total.' AMD</span>
                        </div>
                        <div class="col-12 col-sm-3 col-md-6 text-right">
                            <div class="cart_buy">'.$buy_btn.'</div>
                        </div>
                    </div>
                </div>
            </div>';
            echo json_encode(array('dom' => $CardDom, 'cart' => json_encode($cart_array_new)));
        }
        else {
            echo 'empty cart';
        }
        
    }
    //update wishlist
    public function updateWishlist() {
        $wishlistJson = $_POST['wishlist'];
        $wishlistArry = json_decode($wishlistJson);
        $wishlistDom = '';
        foreach($wishlistArry as $id) {
            $sql_wishlist = $this->con->prepare("SELECT * FROM `products` WHERE `id`=?");
            $sql_wishlist->execute(array($id));
            $row_wishlist = $sql_wishlist->fetch();
            $id = $row_wishlist['id'];
            $product_title = $row_wishlist['title'];
            $product_discount = $row_wishlist['discount'];
            $product_price = $row_wishlist['price'];
            if ($product_discount > 0) {
                $price_discount = $product_price - ($product_price * $product_discount / 100);
                $price_show = '<del>'.$product_price.'</del> <span>'.$price_discount.'</span> AMD';
                $discount_show = '<div class="wishlist_discount_show">'.$product_discount.'%</div>';
            } else {
                $discount_show = '';
                $price_show = $product_price.' AMD';
                $price_discount = '';
            }
            //check img
            $sql_wishlist_img = $this->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
            $sql_wishlist_img->execute(array('products', $id, 'home'));
            if ($sql_wishlist_img->rowCount() > 0) {
                $row_wishlist_img = $sql_wishlist_img->fetch();
                $product_img = '/public/photos/thumbs/'.$row_wishlist_img['name'].'.'.$row_wishlist_img['type'];
            } else {
                $product_img = '/public/img/no_photo.jpg';
            }
            $wishlistDom .= '<div class="wishlist_content product_item" data-id="'.$id.'">
                <div class="row">
                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <div class="wishlist_img">
                            <a href="/pages/product_item?id='.$id.'">
                                <img class="photo" src="'.$product_img.'" alt="">
                            </a>
                        <div class="wishlist_discount">'.$discount_show.'</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5 col-md-5 col-lg-4 col-xl-5">
                        <div class="wishlist_title">'.$product_title.'</div>
                    </div>
                    <div class="col-12 col-sm-3 col-md-3 col-lg-4 col-xl-3">
                        <div class="wishlist_price">'.$price_show.'</div>
                    </div>
                    <div class="col-12 col-sm-2 col-md-2 col-lg-1 col-xl-2">
                        <div class="wishlist_icon">
                            <button type="button" class="cardButton" data-id="'.$id.'"><i class="fas fa-shopping-cart"></i></button>
                            <button data-id="'.$id.'" class="removWishlist"><i class="fas fa-times-circle"></i></button>
                        </div>
                    </div>
                </div>
            </div>';
        }
        echo $wishlistDom;
    }
    // review
    public function addReview() {
        $rate = trim(htmlspecialchars($_POST['rate']));
        $review = trim(htmlspecialchars($_POST['review_text']));
        $p_id = trim(htmlspecialchars($_GET['id']));
        $user_name = trim(htmlspecialchars($_POST['user_name']));
        //add
        $add_review = $this->con->prepare("INSERT INTO `review` (`p_id`, `rate`, `review`, `user_name`) VALUES (?,?,?,?)");
        $add_review->execute(array($p_id, $rate, $review, $user_name));
        if ($add_review) {
            echo '1';
//            header('location: ');
        } else {
//            header('location: ');
            echo '0';
        }
        exit;
    }
    //search
    public function search() {
        $text = trim(htmlspecialchars($_POST['text']));
        $search_data = "SELECT * FROM `products` WHERE `title` LIKE '%".$text."%'";
        $result = $this->con->prepare($search_data);
        $result->execute();
        echo '<table class="search_result">';
        while($search_row = $result->fetch()) {
            $id = $search_row['id'];

            $sql_files_product = $this->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
            $sql_files_product->execute(array('products', $id, 'home'));
            if ($sql_files_product->rowCount() > 0) {
                $row_files_product = $sql_files_product->fetch();
                $product_img = '/public/photos/thumbs/'.$row_files_product['name'].'.'.$row_files_product['type'];
            } else {
                $product_img = 'public/img/no_photo.jpg';
            }

            echo '<tr>';
            echo '<td><div class="search_photo" style="background: url('.$product_img.') no-repeat center/cover;"></td>';
            echo '<td class="text"><a href="/pages/product_item?id='.$id.'">'.$search_row['title'].'</a></td>';
            echo '</tr>';

        }
        echo '</table>';
        return true;
    }
}
?>