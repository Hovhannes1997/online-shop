<?php
class Admin extends Model {
    /* Sessions & Cookies */
    public function __construct() {
        parent::__construct();
        // check session
        if (!isset($_SESSION['admin_id'])) {
            // check cookies
            if (isset($_COOKIE['admin_id']) && isset($_COOKIE['admin']) && !empty($_COOKIE['admin_id']) && !empty($_COOKIE['admin'])) {
                $cookie_admin = $_COOKIE['admin'];
                $cookie_admin_id = $_COOKIE['admin_id'];
                // check admin
                $admin_row = $this->selectDataAdmin("admins", "WHERE `id`='$cookie_admin_id' AND `status`='1'");
                if ($admin_row) {
                    $admin_email = $admin_row['email'];
                    // check email on cookie
                    if (md5($cookie_admin_id.$admin_email) == $cookie_admin) {
                        $_SESSION['admin_id'] = $_COOKIE['admin_id'];
                        $_SESSION['admin_email'] = $admin_email;
                    }
                }
            }
        }
        // check session
        if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']) && isset($_SESSION['admin_email']) && !empty($_SESSION['admin_email'])) {
            // admin data
            $session_admin_id = $_SESSION['admin_id'];
            $session_admin_email = $_SESSION['admin_email'];
            $this->Admin = $this->selectDataAdmin("admins", "WHERE `id`='$session_admin_id' AND `email`='$session_admin_email' AND `status`='1'");
            // check admin
            if (empty($this->Admin['id'])) {
                // unset sessions & cookies
                $this->adminUnset();
            }
        } else {
            // unset sessions & cookies
            $this->adminUnset();
        }
    }
    /* Admin DB */
    public function selectDataAdmin($table = '', $query = '', $count = 1) {
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
    /* Admin actions */
    public function adminLogout() {
        $this->adminUnset();
    }
    /* Admin actions */
    public function adminUnset() {
        // unset sessions
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
        // unset cookies
        setcookie('admin_id', '', time() - 60 * 60 * 24 * 365, '/admin', 'mvc.loc');
        setcookie('admin', '', time() - 60 * 60 * 24 * 365, '/admin', 'mvc.loc');
    }
    // add product
    public function addCats() {
        $title_nav = trim(htmlspecialchars($_POST['title']));
        $img = '';
        //add NavMEnu
        $add_nav_menu = $this->con->prepare("INSERT INTO `cats` (`title`) VALUES (?)");
        $add_nav_menu->execute(array($title_nav));
        $id = $this->con->lastInsertId();
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
            $image->save("public/photos/cat_img/$img_name.$img_ext");
            // update image name
            $insert_cat = $this->con->prepare("INSERT INTO `files` (`table_name`, `row_id`, `name_used`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_cat->execute(array('cats', $id, 'top', $img_name, $img_ext, $img_size));
        } 
        if ($add_nav_menu) {
            header('location: /admin/pages/cats');
        } else {
            header('location: /admin/pages/cats');
        }
        exit;
    }
    //add sub cat
    public function addSubCats() {
        $cat_id = trim(htmlspecialchars($_POST['cat_id']));
        $title = trim(htmlspecialchars($_POST['title']));
        $img = '';
        //add NavMEnu
        $add_sub_cat = $this->con->prepare("INSERT INTO `sub_cats` (`cat_id`, `title`) VALUES (?, ?)");
        $add_sub_cat->execute(array($cat_id, $title));
        $id = $this->con->lastInsertId();
        if ($_FILES['img']['size'] > 0) {
            //image name
            $img_name = md5(round(microtime(true) * 1000));
            $img_ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $img_size = $_FILES['img']['size'];
            // image obekt
            $image = new Simpleimage();
            // smool
            $image->load($_FILES['img']['tmp_name']);
            $image->crop(400, 400);
            $image->save("public/photos/sub_cat_img/$img_name.$img_ext");
            // update image name
            $insert_sub_cats = $this->con->prepare("INSERT INTO `files` (`table_name`, `row_id`, `name_used`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_sub_cats->execute(array('sub_cats', $id, 'top', $img_name, $img_ext, $img_size));
        } 
        if ($insert_sub_cats) {
            header('location: /admin/pages/sub_cats');
        } else {
            header('location: /admin/pages/sub_cats');
        }
        exit;
    }
    //add product
    public function addProducts() {
        $sub_cat_id = trim(htmlspecialchars($_POST['sub_cat_id']));
        $title = trim(htmlspecialchars($_POST['title']));
        $price = trim(htmlspecialchars($_POST['price']));
        $discount = trim(htmlspecialchars($_POST['discount']));
        $descr = trim(htmlspecialchars($_POST['descr']));
        $quantity = trim(htmlspecialchars($_POST['quantity']));
        $top = trim(htmlspecialchars($_POST['top_product']));
        $status = trim(htmlspecialchars($_POST['status_product']));
        $discount_start_date = trim(htmlspecialchars($_POST['startDate']));
        $discount_end_date = trim(htmlspecialchars($_POST['endDate']));
        //add
        $add = $this->con->prepare("INSERT INTO `products` (`sub_cat_id`, `title`, `price`, `discount`, `descr`, `quantity`, `top`, `status`, `discount_start_date`,`discount_end_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $add->execute(array($sub_cat_id, $title, $price, $discount, $descr, $quantity, $top, $status, $discount_start_date, $discount_end_date));
        $id = $this->con->lastInsertId();
        // check image
        if ($_FILES['img']['size'] > 0) {
            //image name
            $products_img_name = md5(round(microtime(true) * 1000));
            $products_img_ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $products_img_size = $_FILES['img']['size'];
            // image obekt
            $image = new Simpleimage();
            // smool
            $image->load($_FILES['img']['tmp_name']);
            $image->crop(400, 400);
            $image->save("public/photos/thumbs/$products_img_name.$products_img_ext");
            // large
            $image->load($_FILES['img']['tmp_name']);
            $image->crop(900, 900);
            $image->save("public/photos/large/$products_img_name.$products_img_ext");
            // update image name
            $insert_products = $this->con->prepare("INSERT INTO `files` (`table_name`, `row_id`, `name_used`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_products->execute(array('products', $id, 'home', $products_img_name, $products_img_ext, $products_img_size));
        }
        if ($add) {
            header('location: /admin/pages/products');
        } else {
            header('location: /admin/pages/products');
        }
        exit;
    }
    // uppy uplod img
    public function addUppy() {
        if (isset($_FILES['files'])) {
            if (is_array($_FILES['files']['name'])) {
                $image = new SimpleImage();
                // get files from array
                foreach($_FILES['files']['name'] as $key => $value) {
                    // get id
                    $id = '';
                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                        $id = $_GET['id'];
                    }
                    // options
                    $file_path = $_FILES['files']['name'];
                    $file_name_original = pathinfo($file_path[$key], PATHINFO_FILENAME);
                    $file_type = pathinfo($file_path[$key], PATHINFO_EXTENSION);
                    $file_name = md5($file_name_original.'_'.round(microtime(true) * 1000));
                    $file_size = $_FILES['files']['size'][$key];
                    // file name
                    if (isset($_POST['title']) && !empty($_POST['title'])) {
                        $file_preview = $_POST['title'].'.'.$file_type;
                    } else {
                        $file_preview = $file_name.'.'.$file_type;
                    }

                    $file_tmp_name = $_FILES['files']['tmp_name'][$key];
                    // crop save img
                    $image->load($file_tmp_name);
                    $image->crop(400, 400);
                    $image->save("public/photos/uppy/small/$file_preview");
                    $image->load($file_tmp_name);
                    $image->crop(900, 600);
                    $image->save("public/photos/uppy/large/$file_preview");

                    $insert_img = $this->con->prepare("INSERT INTO `files` (`table_name`,`row_id`, `name_used`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?, ?)");
                    $insert_img->execute(array('products', $id, 'gallery', $file_name, $file_type, $file_size));
                    // result
                    if (!$insert_img) {
                        $response = array('type' => 'danger', 'title' => 'Չհաջողվեց', 'message' => 'Կրկին փորձեք:');
                        echo json_encode($response);
                        exit;
                    } else {
                        $response = array('type' => 'success', 'title' => 'Հաջողվեց', 'message' => 'Նկարն ավելացված է:');
                        echo json_encode($response);
                        exit;
                    }
                }
            }

        }
        exit;
    }
    //update cats
    public function updateCats() {
        $cat_id = $_GET['id'];
        $title_cat = trim(htmlspecialchars($_POST['title']));
        // check image
        if ($_FILES['img']['size'] > 0) {
            $sql_files = $this->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
            $sql_files->execute(array('cats', $cat_id, 'top'));
            if ($sql_files->rowCount() > 0) {
                $row_files = $sql_files->fetch();
                $file_id = $row_files['id'];
                if (file_exists('public/photos/cat_img/'.$row_files['name'].'.'.$row_files['type'])) {
                    unlink('public/photos/cat_img/'.$row_files['name'].'.'.$row_files['type']);
                }
                $delete_img_product = $this->con->prepare("DELETE FROM `files` WHERE `id`=?");
                $delete_img_product->execute(array($file_id));
            }
            //image name
            $img_name = md5(round(microtime(true) * 1000));
            $img_ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $img_size = $_FILES['img']['size'];
            // image obekt
            $image = new Simpleimage();
            // smool
            $image->load($_FILES['img']['tmp_name']);
            $image->crop(400, 400);
            $image->save("public/photos/cat_img/$img_name.$img_ext");
            // update image name
            $insert_cats = $this->con->prepare("INSERT INTO `files` (`table_name`, `row_id`, `name_used`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_cats->execute(array('cats', $cat_id, 'top', $img_name, $img_ext, $img_size));        
        } 
        //update
        $update_cat = $this->con->prepare("UPDATE `cats` SET `title`=? WHERE `id`=?");
        $update_cat->execute(array($title_cat, $cat_id));
        if ($update_cat) {
            header('location: /admin/pages/update_cats?id='.$cat_id.'');
        } else {
            header('location: /admin/pages/update_cats?id='.$cat_id.'');
        }
        exit;
    }
    //update sub cat
    public function updateSubCats() {
        $id = $_GET['id'];
        $title_cat = trim(htmlspecialchars($_POST['title']));
        // check image
        if($_FILES['img']['size'] > 0) {
            $sql_files = $this->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
            $sql_files->execute(array('sub_cats', $id, 'top'));
            if($sql_files->rowCount() > 0) {
                $row_files = $sql_files->fetch();
                $file_id = $row_files['id'];
                if (file_exists('public/photos/sub_cat_img/'.$row_files['name'].'.'.$row_files['type'])) {
                    unlink('public/photos/sub_cat_img/'.$row_files['name'].'.'.$row_files['type']);
                }
                $delete_img_product = $this->con->prepare("DELETE FROM `files` WHERE `id`=?");
                $delete_img_product->execute(array($file_id));
            }
            //image name
            $img_name = md5(round(microtime(true) * 1000));
            $img_ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $img_size = $_FILES['img']['size'];
            // image obekt
            $image = new Simpleimage();
            // smool
            $image->load($_FILES['img']['tmp_name']);
            $image->crop(400, 400);
            $image->save("public/photos/sub_cat_img/$img_name.$img_ext");
            // update image name
            $insert_files = $this->con->prepare("INSERT INTO `files` (`table_name`, `row_id`, `name_used`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_files->execute(array('sub_cats', $id, 'top', $img_name, $img_ext, $img_size));
        } 
        //update
        $update_sub_cat = $this->con->prepare("UPDATE `sub_cats` SET `title`=?  WHERE `id`=?");
        $update_sub_cat->execute(array($title_cat, $id));
        if ($update_sub_cat) {
            header('location: /admin/pages/update_sub_cats?id='.$id.'');
        } else {
            header('location: /admin/pages/update_sub_cats?id='.$id.'');
        }
        exit;
    }
    //update product
    public function updateProduct() {
        $id = $_GET['id'];
        $sub_cat_id = trim(htmlspecialchars($_POST['sub_cat_id']));
        $title = trim(htmlspecialchars($_POST['title']));
        $price = trim(htmlspecialchars($_POST['price']));
        $discount = trim(htmlspecialchars($_POST['discount']));
        $quantity = trim(htmlspecialchars($_POST['quantity']));
        $p_top = trim(htmlspecialchars($_POST['top_product']));
        $p_status = trim(htmlspecialchars($_POST['status_product']));
        $discount_start_date = trim(htmlspecialchars($_POST['startDate']));
        $discount_end_date = trim(htmlspecialchars($_POST['endDate']));
        $descr = trim(htmlspecialchars($_POST['descr']));
        // check image
        if ($_FILES['img']['size'] > 0) {
            $sql_files_product = $this->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=? AND `name_used`=?");
            $sql_files_product->execute(array('products', $id, 'home'));
            if ($sql_files_product->rowCount() > 0) {
                $row_files_product = $sql_files_product->fetch();
                $product_file_id = $row_files_product['id'];
                if (file_exists('public/photos/thumbs/'.$row_files_product['name'].'.'.$row_files_product['type'])) {
                    unlink('public/photos/thumbs/'.$row_files_product['name'].'.'.$row_files_product['type']);
                }
                if (file_exists('public/photos/large/'.$row_files_product['name'].'.'.$row_files_product['type'])) {
                    unlink('public/photos/large/'.$row_files_product['name'].'.'.$row_files_product['type']);
                }
                $delete_product_img = $this->con->prepare("DELETE FROM `files` WHERE `id`=?");
                $delete_product_img->execute(array($product_file_id));
            }
            //image name
            $img_name = md5(round(microtime(true) * 1000));
            $img_ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $img_size = $_FILES['img']['size'];
            // image obekt
            $image = new Simpleimage();
            // thumbs
            $image->load($_FILES['img']['tmp_name']);
            $image->crop(400, 400);
            $image->save("public/photos/thumbs/$img_name.$img_ext");
            //large
            $image->load($_FILES['img']['tmp_name']);
            $image->crop(900, 900);
            $image->save("public/photos/large/$img_name.$img_ext");
            // update image name
            $insert_product = $this->con->prepare("INSERT INTO `files` (`table_name`, `row_id`, `name_used`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_product->execute(array('products', $id, 'home', $img_name, $img_ext, $img_size));
        }
        //update
        $update = $this->con->prepare("UPDATE `products` SET `sub_cat_id`=?, `title`=?, `price`=?, `discount`=?, `quantity`=?, `top`=?, `status`=?, `discount_start_date`=?, `discount_end_date`=?, `descr`=? WHERE `id`=?");
        $update->execute(array($sub_cat_id, $title, $price, $discount, $quantity, $p_top, $p_status, $discount_start_date, $discount_end_date, $descr, $id));
        if ($update) {
            header('location: /admin/pages/product_item?id='.$id.'&result=1');
            exit;
        } else {
            header('location: /admin/pages/product_item?id='.$id.'&result=0');
            exit;
        }
        exit;
    }
    //delete cat
    public function deleteCat() {
        $id = $_GET['id'];
        // delete
        $delete_navs = $this->con->prepare("DELETE FROM `cats` WHERE `id`=?");
        $delete_navs->execute(array($id));
        // result
        $sql_nav_file = $this->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=?");
        $sql_nav_file->execute(array('cats', $id));
        if ($sql_nav_file->rowCount() > 0) {
            while($row_nav_file = $sql_nav_file->fetch()) {
                $nav_file_id = $row_nav_file['id'];
                if ($row_nav_file['name_used'] == 'top') {
                    // small
                    if (file_exists('public/photos/cat_img/'.$row_nav_file['name'].'.'.$row_nav_file['type'])) {
                        unlink('public/photos/cat_img/'.$row_nav_file['name'].'.'.$row_nav_file['type']);
                    }
                }
                $delete_nav_files = $this->con->prepare("DELETE FROM `files` WHERE `id`=?");
                $delete_nav_files->execute(array($nav_file_id));
                if ($delete) {
                    header('location: /admin/pages/cats');
                } else {
                    header('location: /admin/pages/cats');
                }   
            }
        }
        if ($delete_navs) {
            header('location: /admin/pages/cats');
        } else {
            header('location: /admin/pages/cats');
        }
        exit;
    }
    // delete sub cats
    public function deleteSubCat() {
        $id = $_GET['id'];
        // delete
        $delete_sub_cat = $this->con->prepare("DELETE FROM `sub_cats` WHERE `id`=?");
        $delete_sub_cat->execute(array($id));
        // result
        $sql_file = $this->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=?");
        $sql_file->execute(array('sub_cats', $id));
        if ($sql_file->rowCount() > 0) {
            while($row_file = $sql_file->fetch()) {
                $file_id = $row_file['id'];
                if ($row_file['name_used'] == 'top') {
                    // small
                    if (file_exists('public/photos/cat_img/'.$row_file['name'].'.'.$row_file['type'])) {
                        unlink('public/photos/cat_img/'.$row_file['name'].'.'.$row_file['type']);
                    }
                }
                $delete_nav_files = $this->con->prepare("DELETE FROM `files` WHERE `id`=?");
                $delete_nav_files->execute(array($file_id));
                if ($delete) {
                    header('location: /admin/pages/sub_cats');
                } else {
                    header('location: /admin/pages/sub_cats');
                }   
            }
        }
        if ($delete_sub_cat) {
            header('location: /admin/pages/sub_cats');
        } else {
            header('location: /admin/pages/sub_cats');
        }
        exit;
    }
    //delete product
    public function deleteProduct() {
        $id = $_GET['id'];
        // check img
        $sql_file = $this->con->prepare("SELECT * FROM `files` WHERE `table_name`=? AND `row_id`=?");
        $sql_file->execute(array('products', $id));
        if ($sql_file->rowCount() > 0) {
            while($row_file = $sql_file->fetch()) {
                $file_id = $row_file['id'];
                if ($row_file['name_used'] == 'home') {
                    // small
                    if (file_exists('public/photos/thumbs/'.$row_file['name'].'.'.$row_file['type'])) {
                        unlink('public/photos/thumbs/'.$row_file['name'].'.'.$row_file['type']);
                    }
                    // large
                    if (file_exists('public/photos/large/'.$row_file['name'].'.'.$row_file['type'])) {
                        unlink('public/photos/large/'.$row_file['name'].'.'.$row_file['type']);
                    }
                }
                if ($row_file['name_used'] == 'gallery') {
                    // small
                    if (file_exists('public/photos/uppy/small/'.$row_file['name'].'.'.$row_file['type'])) {
                        unlink('public/photos/uppy/small/'.$row_file['name'].'.'.$row_file['type']);
                    }
                    // large
                    if (file_exists('public/photos/uppy/large/'.$row_file['name'].'.'.$row_file['type'])) {
                        unlink('public/photos/uppy/large/'.$row_file['name'].'.'.$row_file['type']);
                    }
                }
                $delete_files = $this->con->prepare("DELETE FROM `files` WHERE `id`=?");
                $delete_files->execute(array($file_id));
            }
        }
        // delete review
        $delete_reviews = $this->con->prepare("DELETE FROM `review` WHERE `p_id`=?");
        $delete_reviews->execute(array($id));
        // get cat_id
        $sql_product = $this->con->prepare("SELECT * FROM `products` WHERE `id`=?");
        $sql_product->execute(array($id));
        if ($sql_product->rowCount() > 0) {
            $row_product = $sql_product->fetch();
            $sub_cat_id = $row_product['sub_cat_id'];
            // delete
            $delete = $this->con->prepare("DELETE FROM `products` WHERE `id`=?");
            $delete->execute(array($id));
            // result
            if ($delete) {
                header('location: /admin/pages/products');
            } else {
                header('location: /admin/pages/products');
            }
        } else {
            header('location: /admin/pages/products');
        }
        exit;
    }
    // delete uppy img
    public function deleteUppy() {
        $id = $_GET['id'];
        $sql_files = $this->con->prepare("SELECT * FROM `files` WHERE `id`=?");
        $sql_files->execute(array($id));
        if ($sql_files->rowCount() > 0) {
            $row_files = $sql_files->fetch();
            $product_id = $row_files['row_id'];
            // small
            if (file_exists('public/photos/uppy/small/'.$row_files['name'].'.'.$row_files['type'])) {
                unlink('public/photos/uppy/small/'.$row_files['name'].'.'.$row_files['type']);
            }
            // large
            if (file_exists('public/photos/uppy/large/'.$row_files['name'].'.'.$row_files['type'])) {
                unlink('public/photos/uppy/large/'.$row_files['name'].'.'.$row_files['type']);
            }
             // delete
            $delete_img = $this->con->prepare("DELETE FROM `files` WHERE `id`=?");
            $delete_img->execute(array($id));
            // result
            if ($delete_img) {
                header('location: /admin/pages/products');
            } else {
                header('location: /admin/pages/product_item&result=0');
            }
        } else {
            header('location: /admin/pages/product_item&result=0'); 
        }
        exit;
    }
    //add uppy
    public function addProductGallery() {
        if (isset($_FILES['files'])) {
            if (is_array($_FILES['files']['name'])) {
                $image = new SimpleImage();
                // get files from array
                foreach($_FILES['files']['name'] as $key => $value) {
                    // get id
                    $id = '';
                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                        $id = $_GET['id'];
                    }
                    // options
                    $file_path = $_FILES['files']['name'];
                    $file_name_original = pathinfo($file_path[$key], PATHINFO_FILENAME);
                    $file_type = pathinfo($file_path[$key], PATHINFO_EXTENSION);
                    $file_name = md5($file_name_original.'_'.round(microtime(true) * 1000));
                    $file_size = $_FILES['files']['size'][$key];
                    // file name
                    if (isset($_POST['title']) && !empty($_POST['title'])) {
                        $file_preview = $_POST['title'].'.'.$file_type;
                    } else {
                        $file_preview = $file_name.'.'.$file_type;
                    }

                    $file_tmp_name = $_FILES['files']['tmp_name'][$key];
                    // crop save img
                    $image->load($file_tmp_name);
                    $image->crop(400, 400);
                    $image->save("public/photos/uppy/small/$file_preview");
                    $image->load($file_tmp_name);
                    $image->crop(900,900);
                    $image->save("public/photos/uppy/large/$file_preview");

                    $insert_img = $this->con->prepare("INSERT INTO `files` (`table_name`,`row_id`, `name_used`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?, ?)");
                    $insert_img->execute(array('products', $id, 'gallery', $file_name, $file_type, $file_size));
                    // result
                    if (!$insert_img) {
                        $response = array('type' => 'danger', 'title' => 'Չհաջողվեց', 'message' => 'Կրկին փորձեք:');
                        echo json_encode($response);
                        exit;
                    } else {
                        $response = array('type' => 'success', 'title' => 'Հաջողվեց', 'message' => 'Նկարն ավելացված է:');
                        echo json_encode($response);
                        exit;
                    }
                }
            }
            
        }
        exit;
    }
}
?>