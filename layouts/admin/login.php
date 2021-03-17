<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Մուտք</title>
        <?php require_once('inc/head.php');?>
    </head>
    <body>
        <div class="row">
            <div class="col-md-6">
                <h3 class="page_titler">Մուտք գործել անձնական էջ</h3>
                <div class="login">
                    <form id="login">
                        <div class="printEmpty"></div>
                        <p>
                            <input type="email" class="loginUserName" name="email" placeholder="Էլ․ փոստ">
                        </p>
                        <p>
                            <input type="password" class="loginUserPass" name="password" placeholder="Գաղտնաբառ">
                        </p>
                        <p>
                            <input id="checkbox" class="checkbox" type="checkbox" name="renamber" placeholder="ԳԱղտնաբառ">
                            <label for="checkbox">Հիշել</label>
                        </p>
                        <button  class="g-recaptcha" 
                        data-sitekey="reCAPTCHA_site_key" 
                        data-callback='onSubmit' 
                        data-action='submit'>Մուտք</button>
                    </form>
                </div>
            </div>
            
            <div class="col-6">
                <div class="reset">
                    <form id="reset">
                        <h3 class="title_reset_pass">Վերականգնել գաղտնաբառը</h3>
                        <p><input type="email" name="email" placeholder="էլ․ փոստ"></p>
                        <button>Ուղարկել</button>
                    </form>
                </div>
            </div>
 
        </div>
        <?php require_once('inc/scripts.php');?>
    </body>
</html>