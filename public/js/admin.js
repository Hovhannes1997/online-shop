$(document).ready(function () {
    // uppy
    if ($('.uppyDashboard')[0]) {
        // get id
        var id = $('.uppyDashboard').data('id');
        // init uppy
        var uppy = Uppy.Core();
        uppy.use(Uppy.Dashboard, {
            inline: true,
            target: '.uppyDashboard',
            replaceTargetContent: true,
            showProgressDetails: true,
            note: 'Images and video only, 2–3 files, up to 1 MB',
            height: 470,
            metaFields: [
                { id: 'title', name: 'Title', placeholder: 'File title' }
            ],
            browserBackButtonClose: true
        });
        uppy.use(Uppy.XHRUpload, {
            endpoint: '?cmd=addProductGallery&id=' + id,
            method: 'post',
            formData: true,
            fieldName: 'files[]',
            metaFields: null
        });
        uppy.on('upload-success', (file, response) => {
            console.log(response.body);
            notify('', response.body.title, response.body.message, response.body.type);
        });
    };
    // login admin
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
            $('.printEmpty').html('<div style="background: red; color: #fff; padding: 10px 15px; margin: 10px 0;">Լրացնել պարտադիր դաշտերը</div>');
            return false;
        } else {
             $('.printEmpty').html('');
        }
        
        //ajax
        $.ajax({
            url: '?cmd=adminLogin',
            type: 'post',
            data: {
                emailLog: logEmail,
                passwordLog: logPassword,
                renamberLog: logRenamberVal
            },
            beforeSend: function() {
                logBtn.prop('disabled', true);
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
    $('#regist').on('submit', function(event) {
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
            $('.printEmpty').html('<div style="background: red; color: #fff; padding: 10px 15px; margin: 10px 0;">Լրացնել պարտադիր դաշտերը</div>');
            return false;
        } else {
            $('.printEmpty').html('');
        }
            
        //ajax
        $.ajax({
            url: '?cmd=adminRegist',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                btn.prop('disabled', true);
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
                        regForm.after('<div class="regist_info">Շնուրհավորում ենք գրանցումը հաջողությամբ ստացվեծ, գրանցումը հաստատելու համար մտեք նշված էլ․ փոստը և սեղմեք հաստատել կոճակը։</div>')
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
            alert('Լրացնել էլ․ փոստը');
            return false;
        }
        //ajax
        $.ajax({
            url: '?cmd=resetPass',
            type: 'post',
            data: {
                email: resetEmail,
            },
            beforeSend: function() {
                resetBtn.prop('disabled', true);
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
                        formReset.after('<div class="regist_info">Շնորհավորում ենք ձեր գաղտնաբառը թարմացվել է, ստուգեք ձեր էլ․ փոստը։</div>')
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
})

function showNotif (type, title, message, url = '') { 
    var iconClass;
    if (type == 'info') {
        iconClass = 'fa fa-bell-o';
    }
    if (type == 'success') {
        iconClass = 'fa fa-exclamation-triangle';
    }
    if (type == 'warning') {
        iconClass = 'fa fa-exclamation-triangle';
    }
    if (type == 'danger') {
        iconClass = 'fa fa-exclamation-triangle';
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
            from: "top",
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
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss"><i class="material-icons">close</i></button>' +
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
