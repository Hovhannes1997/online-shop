<?php
session_start();

// display all errors
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// abstract functions
require_once('inc/functions.php');


// check secure data
if(!empty($_POST)) {
    $_POST = checkVariable($_POST);
}
if(!empty($_GET)) {
    $_GET = checkVariable($_GET);
}

// load class by name
spl_autoload_register(function ($class) {
    if (strpos($class, '\\')) {
        $class_array = explode('\\', $class);
        $class_name = array_pop($class_array);
        $class_path = str_replace('\\', '/', $class).'.php';
    } else {
        $class_name = $class;
        $class_path = $class.'.php';
    }
    if (is_file("classes/$class_path")) {
        require "classes/$class_path";
    } else if (is_file("inc/lib/$class_path")) {
       require "inc/lib/$class_path";
    } else {
        exit("Error loading: $class_name");
    }
});

// url settings
$url = new Url();
// pages
if (is_dir("layouts/".$url->PATH) && !is_file("layouts/".$url->PATH.".php") && !empty($url->PAGE)) {
    header("Location: /".$url->PATH."/");
    exit;
}

if (isset($url->DIR[0]) && $url->DIR[0] == "admin") {
    $cnt = new Admin();
    if (isset($url->GET['cmd']) && ((!isset($_SESSION['admin_id']) && ($url->GET['cmd'] == 'adminRegist' || $url->GET['cmd'] == 'adminLogin' || $url->GET['cmd'] == 'resetPass' || $url->GET['cmd'] == 'confirmCode')) || (isset($_SESSION['admin_id']) && isset($_SESSION['admin_email'])))) {
        // check method
        if ((int)method_exists($cnt, $url->GET['cmd'])) {
            $cnt->{$url->GET['cmd']}();
        }
        if (isset($url->GET['backUrl'])) {
            header("Location: ".urldecode($url->GET['backUrl']));
            exit;
        } else if ($url->type=='ajax'){
            exit;
        } else {
            header("Location: /".$url->PATH."");
            exit;
        }
    }
    // session
    if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
        // check page
        if (!is_file("layouts/".$url->PATH.".php")) {
            $url->PAGE = 'default';
            require 'layouts/admin/'.$url->PAGE.'.php';
        } else {
            require "layouts/".$url->PATH.".php";
        }
    } else {
        require 'layouts/admin/login.php';
    }
} else {
    $cnt = new User();
    if (isset($url->GET['cmd'])) {
        // check method
        if ((int)method_exists($cnt, $url->GET['cmd'])) {
            $cnt->{$url->GET['cmd']}();
        }
        if (isset($url->GET['backUrl'])) {
            header("Location: ".urldecode($url->GET['backUrl']));
            exit;
        } else if ($url->type=='ajax'){
            exit;
        } else {
            header("Location: /".$url->PATH."");
            exit;
        }
    }
    // session
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        //check login
        if($url->PAGE == 'login' || $url->PAGE == 'regist' || $url->PAGE == 'resetpass') {
            require "layouts/default/default.php";
            exit;
        }
    } else {
        if ($url->PAGE == 'profile') {
            require "layouts/default/default.php";
            exit;
        }
    }
    // check page
    if (!is_file("layouts/default/".$url->PATH.".php")) {
        $url->PAGE = 'default';
        require 'layouts/default/'.$url->PAGE.'.php';
    } else {
        require "layouts/default/".$url->PATH.".php";
    }
}

?>