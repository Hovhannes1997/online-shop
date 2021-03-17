<?php
abstract class Model {
    public $con;
    /* DB & Core settings */
    public function __construct() {
        // settings local
        $dsn = 'mysql:host=localhost;dbname=z_mvc';
        $username = 'root';
        $password = '';
        // PDO options
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8, time_zone = '+04:00'"
        );
        // connection
        try {
            $this->con = new PDO($dsn, $username, $password, $opt);
        } catch(PDOException $e) {
            echo 'Connection failed: '.$e->getMessage();
        }
    }
     // admin login
    public function adminLogin () {
        // get data
        $email = $_POST['emailLog'];
        $password = md5($_POST['passwordLog']);
        $remember = $_POST['renamberLog'];
        // check user
        $sql_user = $this->con->prepare("SELECT * FROM `admins` WHERE `email`=?");
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
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_email'] = $email;
            // cookies
            if ($remember == 1) {
                $admin = md5($id.$email);
                setcookie('admin_id', $id, time() + 60 * 60 * 24 * 365, '/admin', 'mvc.loc');
                setcookie('admin', $admin, time() + 60 * 60 * 24 * 365, '/admin', 'mvc.loc');
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
    // admin regist
    public function adminRegist () {
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
    //    $response = array('type' => 'success', 'title' => 'Success', 'message' => 'Email is correct.', 'reload' => '0');
    //    echo json_encode($response);
    //    exit;

        // check user
        $sql_user = $this->con->prepare("SELECT * FROM `admins` WHERE `email`=?");
        $sql_user->execute(array($email));
        // exists
        if ($sql_user->rowCount() > 0) {
            $response = array('type' => 'warning', 'title' => 'Warning', 'message' => 'Email exists.', 'reload' => '0');
            echo json_encode($response);
        }
        // doesn't exists
        else {
            // reg user
            $insert_user = $this->con->prepare("INSERT INTO `admins` (`name`, `last_name`, `phone`, `email`, `password`) VALUES (?, ?, ?, ?, ?)");
            $insert_user->execute(array($name, $last_name, $phone, $email, $password));

    //        $response = array('type' => 'success', 'title' => 'Success', 'message' => 'Email is correct.', 'reload' => '0');
    //        echo json_encode($response);
    //        exit;
            //inserted
            if ($insert_user) {
                // get user id
                $user_id = $this->con->lastInsertId();
                // generate confiramtion code
                $confirm_code = md5($user_id.time());
                // generate confirmation link
                $confirm_link = 'http://mvc.loc/admin/?cmd=confirmCode&code='.$confirm_code;
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
                    $update_user = $this->con->prepare("UPDATE `admins` SET `confirm_code`=? WHERE `id`=?");
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
    //admin reset password
    public function resetPass () {
        if (empty($_POST['email'])) {
            $response = array('type' => 'warning', 'title' => 'Warning', 'message' => 'Enter the mail field.', 'reload' => '0');
            echo json_encode($response);
            exit;
        }
        //get data
        $email = mb_strtolower(htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8'), 'UTF-8');
        //sql db
        $u_sql = $this->con->prepare("SELECT * FROM `admins` WHERE `email`=?");
        $u_sql->execute(array($email));

        if ($u_sql->rowCount() > 0) {
            $new_password = passwordGenerator(10);
            $md5_password = md5($new_password);
            //sql db
            $user_sql = $this->con->prepare("SELECT * FROM `admins` WHERE `email`=?");
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
                $update_user_pass = $this->con->prepare("UPDATE `admins` SET `password`=? WHERE `email`=?");
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
}
?>