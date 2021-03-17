$(document).ready(function () {
    // login admin
    updateWishlistdom();
    updateCard();
    $('#login').on("submit", function(log) {
        log.preventDefault();
        var formLogin = $(this),
            logBtn = formLogin.find('button[type=submit]'),
            logEmail = formLogin.find('input[name=email]').val(),
            logPassword = formLogin.find('input[name=password]').val(),
            logRenamber = formLogin.find('input[name=renamber]'),
            logRenamberVal = 0;
        if (logEmail == '') {
            $('.loginUserName').css({
                border: '1px solid red',
            });
        } else {
            $('.loginUserName').css({
                border: '1px solid green',
            });
        }
        if (logPassword == '') {
            $('.loginUserPass').css({
                border: '1px solid red',
            });
        } else {
            $('.loginUserPass').css({
                border: '1px solid green',
            });
        }
         if (logRenamber.is(':checked')) {
            logRenamberVal = 1;
        }
        
        if (logEmail == '' || logPassword == '') {
            $('.printEmpty').html('<div style="background: red; color: #fff; padding: 10px 15px; margin: 10px 0;">Fill in the required fields</div>');
            return false;
        } else {
             $('.printEmpty').html('');
        }
        
        //ajax
        $.ajax({
            url: '?cmd=userLogin',
            type: 'post',
            data: {
                emailLog: logEmail,
                passwordLog: logPassword,
                renamberLog: logRenamberVal
            },
            beforeSend: function() {
                logBtn.prop('disabled', true);
                $('.loading_content').html('<img src="/public/img/loadinf.svg" alt="">');
            },
            success: function(rensponse) {
                try {
                    var rensponseObj = JSON.parse(rensponse);
                } catch (e) {
                    alert('Սերվերի սխալ կրկին փորձեք։');
                    logBtn.prop('disabled', false);
                    return false;
                }
                setTimeout(function() {
                    showNotif(rensponseObj.type, rensponseObj.title, rensponseObj.message);
                    logBtn.prop('disabled', false);
                    location.reload();
                }, 1000);
                return false;
            },
            error: function() {
                alert('Կապի խափանում։');
                logBtn.prop('disabled', false);
                return false;
            }
        });
    });
    // regist form 
    $('#regist_form').on('submit', function(event) {
        event.preventDefault();
        //get data
        var regForm = $(this),
            name = regForm.find('input[name=name]').val(),
            lastName = regForm.find('input[name=last_name]').val(),
            phone = regForm.find('input[name=phone]').val(),
            email = regForm.find('input[name=email]').val(),
            password = regForm.find('input[name=password]').val(),
            passwordRepet = regForm.find('input[name=repeat_password]').val(),
            btn = regForm.find('button[type=submit]'),
            formData = new FormData(regForm[0]);
            //check data
        
        //name
        if (name == '') {
            $('.emptyUserName').css({
                border: '1px solid red',
            });
        } else {
            $('.emptyUserName').css({
                border: '1px solid green',
            });
        }
        //lastName
        if (lastName == '') {
            $('.emptyUserLAstName').css({
                border: '1px solid red',
            });
        } else {
            $('.emptyUserLAstName').css({
                border: '1px solid green',
            });
        }
         //phone
        if (phone == '') {
            $('.emptyUserPhone').css({
                border: '1px solid red',
            });
        } else {
            $('.emptyUserPhone').css({
                border: '1px solid green',
            });
        }
        // email
        if (email == '') {
            $('.emptyUserEmail').css({
                border: '1px solid red',
            });
        } else {
            $('.emptyUserEmail').css({
                border: '1px solid green',
            });
        }
        //password
        if (password == '') {
            $('.emptyUserPassword').css({
                border: '1px solid red',
            });
        } else {
            $('.emptyUserPassword').css({
                border: '1px solid green',
            });
        }
        //passwordRepeat
        if (passwordRepet == '') {
            $('.emptyUserRepeatPassword').css({
                border: '1px solid red',
            });
        } else {
            $('.emptyUserRepeatPassword').css({
                border: '1px solid green',
            });
        }
        
        if (name == '' || lastName == '' || phone == '' || email == '' || password == '' || passwordRepet == '') {
            $('.printEmpty').html('<div style="background: red; color: #fff; padding: 10px 15px; margin: 10px 0;">Fill in the required fields</div>');
            return false;
        } else {
            $('.printEmpty').html('');
        }
            
        //ajax
        $.ajax({
            url: '?cmd=userRegist',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                btn.prop('disabled', true);
                $('.loading_content').html('<img src="/public/img/loadinf.svg" alt="">');
            },
            success: function(rensponse) {
                try {
                    var rensponseObj = JSON.parse(rensponse);
                } catch (e) {
                    alert('Սերվերի սխալ կրկին փորձեք։');
                    btn.prop('disabled', false);
                    return false;
                }    
                setTimeout(function() {
                    showNotif(rensponseObj.type, rensponseObj.title, rensponseObj.message);
                    regForm.slideUp(500, function () {
                        regForm.after('<div class="col-12 regist_info">'+rensponseObj.message+'</div>')
                    });
                    btn.prop('disabled', false);
                }, 2000);
                return false;
            },
            error: function() {
                alert('Կապի խափանում։');
                btn.prop('disabled', false);
                return false;
            }
        });
    });
    // reset password 
    $('#reset').on("submit", function(reset) {
        reset.preventDefault();
        var formReset = $(this),
            resetBtn = formReset.find('button[type=submit]'),
            resetEmail = formReset.find('input[name=email]').val();
        // check email
        if (resetEmail == '') {
            $('.emptyUserName').css({
                border: '1px solid red',
            });
        } else {
            $('.emptyUserName').css({
                border: '1px solid green',
            });
        }
        if (resetEmail == '') {
            $('.printEmpty').html('<div style="background: red; color: #fff; padding: 10px 15px; margin: 10px 0;">Fill in the required fields</div>');
            return false;
        } else {
            $('.printEmpty').html('');
        }
        //ajax
        $.ajax({
            url: '?cmd=userResetPass',
            type: 'post',
            data: {
                email: resetEmail,
            },
            beforeSend: function() {
                resetBtn.prop('disabled', true);
                $('.loading_content').html('<img src="/public/img/loadinf.svg" alt="">');
            },
            success: function(rensponse) {
                try {
                     var rensponseObj = JSON.parse(rensponse);
                } catch(i) {
                    showNotif('danger', 'Սխալ', 'տեղի ունեցավ սխալ, կրկին փորձեք։');
                    resetBtn.prop('disabled', false);
                }
                setTimeout(function() {
                    showNotif(rensponseObj.type, rensponseObj.title, rensponseObj.message);
                    resetBtn.prop('disabled', false);
                    formReset.slideUp(500, function () {
                        formReset.after('<div class="regist_info">'+rensponseObj.message+'</div>')
                    });
                }, 2000);
                return false;
            },
            error: function() {
                alert('Կապի խափանում։');
                resetBtn.prop('disabled', false);
                return false;
            }
        });
    });
    //confirm code
    $('.confirm_close').on('click', function() {
        window.location.href = '/pages/login';
    });
    // update profile 
    $('#update_profile').on("submit", function(loginUser) {
        loginUser.preventDefault();
        var loginUser = $(this),
            loginUserBtn = loginUser.find('button[type=submit]'),
            logUserNAme = loginUser.find('input[name=userName]').val(),
            logUserLAstName= loginUser.find('input[name=userLastName]').val(),
            logUserEmail = loginUser.find('input[name=userEmail]').val(),
            logUserPhone = loginUser.find('input[name=userPhone]').val(),
            loginFormData = new FormData(loginUser[0]);
        // name
        if (logUserNAme == '') {
            $('.empty_update_user_name').css({
                border: '1px solid red',
            })
        } else {
            $('.empty_update_user_name').css({
                border: '1px solid green',
            })
        }
        //last name
        if (logUserLAstName == '') {
            $('.empty_update_user_last_name').css({
                border: '1px solid red',
            })
        } else {
            $('.empty_update_user_last_name').css({
                border: '1px solid green',
            })
        }
        //email
        if (logUserEmail == '') {
           $('.empty_update_user_email').css({
                border: '1px solid red',
            })
        } else {
            $('.empty_update_user_email').css({
                border: '1px solid green',
            })
        }
        //phone
        if (logUserPhone == '') {
            $('.empty_update_user_phone').css({
                border: '1px solid red',
            })
        } else {
            $('.empty_update_user_phone').css({
                border: '1px solid green',
            })
        }
        
        if (logUserNAme == '' || logUserLAstName == '' || logUserEmail == '' || logUserPhone == ''){
            $('.empty_form_update_user').html('<div style="margin: 20px 0; background-color: red; color: #fff; padding: 15px;">Լրացնել պարտադիր դաշտերը</div>');
            return false;
        }
        //ajax
        $.ajax({
            url: '?cmd=UpdateUserProfile',
            type: 'post',
            data: loginFormData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                loginUserBtn.prop('disabled', true);
                $('.loading_content').html('<img src="/public/img/loadinf.svg" alt="">');
            },
            success: function(user) {
                setTimeout(function() {
                    if (user == 1) {
                        location.reload();
                    } else {
                        $('.empty_form_update_user').html('<div style="color:green;padding: 15px 0;border: 1px solid;text-align: center;margin: 0 0 30px;">Data successfully verified</div>');
                        setTimeout(function() {
                            location.reload();
                        },3000);
                    }
                    loginUserBtn.prop('disabled', false);   
                }, 2000);
                return false;
            },
            error: function() {
                alert('Կապի խափանում։');
                loginUserBtn.prop('disabled', false);
                return false;
            }
        });
    });
    //lightslider
    $('#imageGallery').lightSlider({
        gallery:true,
        item:1,
        loop:true,
        thumbItem:8,
        slideMargin:5,
        enableDrag: false,
        currentPagerPosition:'left',
       
    });  
    //elevate zoom
    $("#zoom_05").elevateZoom({
      zoomType: "inner",
      cursor: "crosshair"
    });
    // add review
    $("#rateYo").rateYo({
        fullStar: true,
        onSet: function (rating, rateYoInstance) {
            $('input[name=rate]').val(rating);
        }
    });
    // coment review
    $(".rate").each(function() {
        var rate = $(this).data("rate");
        $(this).rateYo({
            starWidth: '25px',
            rating: Number(rate),
            readOnly: true
        })
    });
    //add card
    $('body').on('click', ".cardButton", function() {
        var btn = $(this),
            productId = btn.data("id");
        
        var cardJson = localStorage.getItem('card'),
            cardArray = [];
        // check wishlist
        if (cardJson != null) {
            cardArray = JSON.parse(cardJson);
        }
        if (cardArray.length > 0) {
            var index = cardArray.indexOf(productId);
            if (index == -1) {
                cardArray.push(productId);
                showNotif("success", "", "The product has been added to the cart.");
            } else {
                cardArray.splice(index, 1);
                showNotif("success", "", "The product has been added to the cart.");
            }
        } else {
            cardArray.push(productId);
            showNotif("success", "", "The product has been added to the cart.");
        }
        if (cardArray.length > 0) {
            cardJson = JSON.stringify(cardArray);
            localStorage.setItem("card", cardJson);
        } else {
            localStorage.removeItem("card");
        }
        //update wishlist dom
       cartUpdateStorage(productId, 'add');
    });
    //remove card
    $('body').on("click", ".removFromCard", function() {
        var productId = $(this).data('id');
        //get wishlit
        var cardJson = localStorage.getItem('card'),
        cardArray = [];
        // check wishlist
        if (cardJson != null) {
            cardArray = JSON.parse(cardJson);
            cardArray.splice(cardArray.indexOf(productId), 1);
            //check wishlist arry
            if (cardArray.length > 0) {
                //update wishlist
                cardJson = JSON.stringify(cardArray);
                localStorage.setItem("card", cardJson);
            } else {
                //clear wishlist
                localStorage.removeItem("card");
            }
            //hide product
            $('.cart_content[data-id='+productId+']').fadeOut(700, function () {
                cartUpdateStorage(productId, 'remove');
            });
        }
    });
    // cart input
    $('body').on("change paste", '.cart_inp', function() {
        var input = $(this),
            value = Number(input.val()),
            id = input.data('id');
          
        if (value == '') {
            input.val(1);
            value = 1;
        }
        cartUpdateStorage(id, 'input', value);
    });
    //cart btn
    $('body').on('click', '.qty_btns', function() {
       var btn = $(this),
           parent = btn.parent(),
           input = parent.find('input'),
           id = btn.data('id'),
           qty = Number(input.val()),
           action;
        if (btn.hasClass('cart_minus')) {
            if (qty == 1) {
                return false;
            }
            qty-- ;
            action = 'minuse';
        }
        
        if (btn.hasClass('cart_plus')) {
            qty++;
            action = 'pluse';
        }
        input.val(qty);
        cartUpdateStorage(id, action);
    });
    //cart input event
    $('body').on('keypress', '.cart_inp', function(e) {
//        console.log(e.charCode);
        if (e.charCode < 48 || e.charCode > 57) {
            e.preventDefault()
            return false
        }
        
//        var input = $(this),
//            value = input.val(),
//            id = input.data('id');
//        console.log(value);
//        console.log(id);
//          
//        if (value == '') {
//            input.val(1);
//            value = 1;
//        }
//        
//        cartUpdateStorage(id, 'input', value);
    });
    // add wishlist
    $('body').on('click', ".wishlist", function() {
        var btn = $(this),
            id = btn.data("id");
        
        var wishlistJson = localStorage.getItem('wishlist'),
            wishlistArray = [];
        // check wishlist
        if (wishlistJson != null) {
            wishlistArray = JSON.parse(wishlistJson);
        }
        if (wishlistArray.length > 0) {
            var index = wishlistArray.indexOf(id);
            if (index == -1) {
                wishlistArray.push(id);
                //notifay avelacnel
                showNotif("success", "", "The product has been added to the list of favorites.");
            } else {
                wishlistArray.splice(index, 1);
                //notifay heracnel
                showNotif("info", "", "The product has been removed from the favorites list.");
            }
        } else {
            wishlistArray.push(id);
            //notifay avelacnel
            showNotif("success", "", "The product has been added to the list of favorites.");
        }
        if (wishlistArray.length > 0) {
            wishlistJson = JSON.stringify(wishlistArray);
            localStorage.setItem("wishlist", wishlistJson);
        } else {
            localStorage.removeItem("wishlist");
        }
        //update wishlist dom
        updateWishlistdom();
    });
    //remove wishlist
    $('body').on("click", ".removWishlist", function() {
        var id = $(this).data('id');
        //get wishlit
        var wishlistJson = localStorage.getItem('wishlist'),
        wishlistArray = [];
        // check wishlist
        if (wishlistJson != null) {
            wishlistArray = JSON.parse(wishlistJson);
            wishlistArray.splice(wishlistArray.indexOf(id), 1);
            ///notifay heracvac
            showNotif("info", "", "The product has been removed from the favorites list.");
            //check wishlist arry
            if (wishlistArray.length > 0) {
                //update wishlist
                wishlistJson = JSON.stringify(wishlistArray);
                localStorage.setItem("wishlist", wishlistJson);
            } else {
                //clear wishlist
                localStorage.removeItem("wishlist");
            }
            //hide product
            $('.wishlist_content[data-id='+id+']').fadeOut(800, function () {
                //update wishlist dom
                updateWishlistdom();
            });
        }
    });
    //fliptimer
    $(".DateCountdown").each(function() {
        var elem = $(this);
        elem.TimeCircles({
            "animation": "smooth",
            "bg_width": 0.3,
            "fg_width": 0.03,
            "circle_bg_color": "#fff",
            "time": {
                "Days": {
                "text": "DAYS",
                "color": "#fff",
                "show": true
                },
                "Hours": {
                "text": "HOURS",
                "color": "#fff",
                "show": true
                },
                "Minutes": {
                "text": "MINUTES",
                "color": "#fff",
                "show": true
                },
                "Seconds": {
                "text": "SECONDS",
                "color": "#fff",
                "show": true
                }
            }
        });
    });
    //review
    $('#formReview').on("submit", function (event) {
        event.preventDefault();
        var formReview = $(this),
            rate = formReview.find('input[name=rate]').val(),
            name = formReview.find('input[name=user_name]').val(),
            text = formReview.find('textarea[name=review_text]').val(),
            btn = formReview.find('button[type=submit]'),
            id = formReview.data('id'),
            review = new FormData(formReview[0]);
         
         if (text == '') {
            $('.empty_text').css({
                border: '1px solid red',
            });
        } else {
            $('.empty_text').css({
                border: '1px solid green',
            });
        }
        if (text == '') {
            $('.printEmpty').html('<div style="background: red; color: #fff; padding: 10px 15px; margin: 10px 0; width:255px;">you did not write an opinion</div>');
            return false;
        } else {
            $('.printEmpty').html('');
        }
        //ajax
        $.ajax({
            url: '?cmd=addReview&id=' +id,
            type: 'post',
            data: review,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                btn.prop('disabled', true);
                $('.loading_content').html('<img src="/public/img/loadinf.svg" alt="">');
            },
            success: function(user) {
               try {
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
               } catch (r) {
                   alert('no');
                   return false;
               }
            },
            error: function() {
                alert('Կապի խափանում։');
                loginUserBtn.prop('disabled', false);
                return false;
            }
        });
    });
    //discount date
    $("#DateCountdown").each(function() {
         var elem = $(this);
         elem.TimeCircles({
            "animation": "smooth",
            "bg_width": 0.2,
            "fg_width": 0.03,
            "circle_bg_color": "#90989F",
            "time": {
                "Days": {
                    "text": "Days",
                    "color": "#40484F",
                    "show": true
                },
                "Hours": {
                    "text": "Hours",
                    "color": "#40484F",
                    "show": true
                },
                "Minutes": {
                    "text": "Minutes",
                    "color": "#40484F",
                    "show": true
                },
                "Seconds": {
                    "text": "Seconds",
                    "color": "#40484F",
                    "show": true
                }
            }
        });
     });
    // search
    $('#search').on('input', function() {
        var search = $('#search').val();
        $.ajax ({
            url: '?cmd=search',
            type: 'POST',
            data:{
                text: search
            },
            success:function(data) {
                if (search != '') {
                    $('.liveSearch').html(data).show();
                } else {
                    $('.liveSearch').fadeOut();
                } 
            }
        });
        
    });
    $('body').on('click', function(event) {
        if (!$(event.target).hasClass('liveSearch')) {
            $('.liveSearch').fadeOut();
        }
    });
});

function showNotif (type, title, message, url = '') { 
    var iconClass;
    if (type == 'info') {
        iconClass = 'fas fa-info';
    }
    if (type == 'success') {
        iconClass = 'far fa-check-circle';
    }
    if (type == 'warning') {
        iconClass = 'fas fa-exclamation-triangle';
    }
    if (type == 'danger') {
        iconClass = 'fas fa-exclamation-triangle';
    }
    $.notify({
        // options
        icon: iconClass,
        title: title,
        message: message,
        url: url,
        target: '_blank'
    },{
        // settings
        element: 'body',
        position: null,
        type: type,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: true,
        placement: {
            from: "bottom",
            align: "right"
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animate__animated animate__fadeInDown',
            exit: 'animate__animated animate__fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-10 col-sm-10 col-md-6 col-lg-5 col-xl-3 alert alert-{0} notify" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss"><i class="far fa-times-circle"></i></button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<div data-notify="message" style="margin-bottom: 5px">{2}</div>' +
            '<div class="progress" data-notify="progressbar" style="height: 3px">' +
                '<div class="progress-bar bg-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 3px"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>' 
    });
}
//swiper slider
var swiper = new Swiper('.swiper-container', {
    spaceBetween: 30,
    pagination: {
    el: '.swiper-pagination',
    clickable: true,
    },
    autoplay: {
    delay: 5000,
    },
});

function cartUpdateStorage(id, action, values = 1) {
    // localstorage
    var cartJson = localStorage.getItem('cart'),
        cartArray = [];
    // check whishlist
    if (cartJson != null) {
        cartArray = JSON.parse(cartJson);
    }
    if (action == "add" || action == "pluse") {
        //product
        var product = {
            id: id,
            qty: 1
        }
        // check array
        if (cartArray.length > 0) {
            var exis = false;
            for (i = 0; i < cartArray.length; i++) {
                if (cartArray[i]["id"] == id) {
                    cartArray[i]["qty"] += 1
                    exis = true
                }
                
            }
            if (exis == false) {
                cartArray.push(product);
            }
        } else {
            cartArray.push(product);
        }
    }
    if (action == "input") {
        for (i = 0; i < cartArray.length; i++) {
            if (cartArray[i]["id"] == id) {
                cartArray[i]["qty"] = values
            }
        }
    }
    if (action == "minuse") {
        for (i = 0; i < cartArray.length; i++) {
            if (cartArray[i]["id"] == id) {
                cartArray[i]["qty"] -= 1
            }
            if (cartArray[i]["qty"] < 1) {
                cartArray[i]["qty"] = 1
                
            }

        }
    }
    if (action == "remove") {
        for (i = 0; i < cartArray.length; i++) {
            if (cartArray[i]["id"] == id) {
                cartArray.splice(i, 1);
                showNotif("info", "", "The item has been removed from the cart.");
            }
        }
    }
    if (action == "add") {
        var cartIcon = $('.cart_menu'),
            imgtodrag = $('.product_item[data-id=' + id + '] .photo').eq(0);
        // animate when img is founded
        if (imgtodrag.length > 0) {
            var imgclone = imgtodrag.clone()
            .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
            .css({
                'opacity': '0.6',
                'position': 'absolute',
                'height': imgtodrag[0].clientHeight,
                'width': imgtodrag[0].clientWidth,
                'z-index': '100000'
            })
            .appendTo($('body'))
            .animate({
                'opacity': '0.7',
                'top': cartIcon.offset().top + 20,
                'left': cartIcon.offset().left + 20,
                'width': 75,
                'height': 75
            }, 1000);
            imgclone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach();
            });
        }
    } else {
        
    }
    // check array
    if (cartArray.length > 0) {
        // update localstorage
        
        cartJsonNew = JSON.stringify(cartArray);
        localStorage.setItem('cart', cartJsonNew);
    } else {
        localStorage.removeItem("cart")
    }
    updateCard();
}
// update card
function updateCard () {
     var cartJson = localStorage.getItem('cart'),
     cartArray = [];
     if (cartJson != null) {
          cartArray = JSON.parse(cartJson);
     }
    // check wishlist
   
    if (cartArray.length > 0) {
        //get cart products
        $.ajax({
            url: '?cmd=updatCart',
            type: 'post',
            data: {
                card: cartJson,
            },
            success: function(response) {
                try {
                    var cart = JSON.parse(response);
                } catch (e) {
                    alert('error');
                }
                if ($('.shopping_cart')[0]) {
                    $('.shopping_cart').html(cart["dom"]);
                    localStorage.setItem('cart', cart["cart"]);
                }
                updateWishlistdom();
            },
            error: function() {
                alert('Կապի խափանում։');
                btn.prop('disabled', false);
                return false;
            }
        });
    } else {
        $('.shopping_cart').html('<div class="card_text" style="text-align: center; margin: 100px 0; font-size:26px;">Your cart is empty.</div>');
    }
    // wishlist active class
//    $('.cardButton').each(function() {
//        $(this).removeClass('active');
//    })
//    for(i = 0; i < cartArray.length; i++) {
//        var productId = cartArray[i];
//        // active class for products
//        if ($('.cardButton[data-id='+productId+']')[0]) {
//            $('.cardButton[data-id='+productId+']').addClass('active');
//        }
//    }
}
// update wishlist
function updateWishlistdom () {
    var wishlistJson = localStorage.getItem('wishlist'),
        wishlistArray = [];
    // check wishlist
    if (wishlistJson != null) {
        wishlistArray = JSON.parse(wishlistJson);
        //get wishlist products
        $.ajax({
            url: '?cmd=updateWishlist',
            type: 'post',
            data: {
                wishlist: wishlistJson,
            },
            success: function(response) {
                if ($('.wishlist_head')[0]) {
                    $('.wishlist_head').html(response);
                }
            },
            error: function() {
                alert('Կապի խափանում։');
                btn.prop('disabled', false);
                return false;
            }
        });
    } else {
        $('.wishlist_head').html('<div class="text-center" style="font-size: 26px; margin: 100px 0;">The list of your favorite products is empty.</div>');
    }
    // wishlist active class
    $('.wishlist').each(function() {
        $(this).removeClass('active');
    })
    for(i = 0; i < wishlistArray.length; i++) {
        var id = wishlistArray[i];
        // active class for products
        if ($('.wishlist[data-id='+id+']')[0]) {
            $('.wishlist[data-id='+id+']').addClass('active');
        }
    }
}




