$(document).ready(function () {
    $('#authForm').validate({
        rules   : {
            email   : {
                required: true,
                email   : true,
                remote: {
                    url: '/auth/checkabsence',
                    type: 'post'
                }
            },
            password: {
                required : true
            }
        },
        messages: {
            email   : {
                required: 'Введите email',
                email   : 'Введите корректный email',
                remote: 'Пользователь с таким email не зарегистрирован'
            },
            password: {
                required : 'Введите пароль'
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: '/auth/signin',
                type: 'post',
                enctype: 'multipart/form-data',
                success: function (data) {
                    console.log(data);
                    if(data.indexOf("true") < 0){
                        var el = document.getElementById('wrongPassword');
                        el.innerText = 'Неверный пароль!';
                        el.style.display = "block";
                        el.style.textAlign = "center";
                    } else location.replace("/");
                }
            });
        }
    });

    $('#RegistrationForm').validate({
        rules        : {
            firstname: {
                required: true,
                remote: {
                    url: '/auth/lettersonly',
                    type: 'post'
                }
            },
            lastname:{
                required: true,
                remote: {
                    url: '/auth/lettersonly',
                    type: 'post'
                }
            },
            email: {
                required: true,
                email   : true,
                remote: {
                    url: '/auth/check',
                    type: 'post'
                }
            },
            password:{
                required: true,
                minlength: 7
            }
        },
        messages     : {
            firstname: {
                required: 'Введите имя',
                remote   : 'Вы можете использовать только русские или английские буквы'
            },
            lastname: {
                required: 'Введите фамилию',
                remote: 'Вы можете использовать только русские или английские буквы'
            },
            email: {
                required: 'Введите email',
                email   : 'Введите корректный email',
                remote: 'Пользователь с таким email уже зарегистрирован'
            },
            password: {
                required: 'Введите пароль',
                minlength: 'Пароль должен содержать не менее 7 символов'
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: '/auth/signup',
                type: 'post',
                enctype: 'multipart/form-data',
                success: function (data) {
                    console.log(data);
                    if(data.indexOf("true") < 0){
                        var el = document.getElementById('registrationError');
                        el.innerText = 'Ошибка регистрации :(';
                        el.style.display = "block";
                        el.style.textAlign = "center";
                    } else {
                        var el = document.getElementById('registrationError');
                        el.innerText = 'Вы успешно зарегистрировались :)';
                        el.style.display = "block";
                        el.style.textAlign = "center";
                        setTimeout('location.replace("/")', 3000);
                    }
                }
            });
        }
    });

    $('#searchForm').validate({
        rules: {
            searchInput: {
                required: true
            }
        },
        messages:{
            searchInput: ''
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: '/main/search',
                type: 'post',
                enctype: 'multipart/form-data',
                success: function (data) {
                    $('#videoPage').html(data);
                    var page = Cookies.get('page');
                    if(~page.indexOf('N',page.indexOf('prevPageToken'))){
                        console.log('jhg');
                        $('.container.button #prevButton').css('display','none');
                    }
                }
            });
        }
    });

    $('body').on('click', '#nextButton', function () {
        $.ajax({
            url: '/main/getNextPage',
            enctype: 'multipart/form-data',
            success: function (data) {
                $('#videoPage').html(data);
                $('html').animate({scrollTop: 0}, 0);
                var page = Cookies.get('page');
                if(~page.indexOf('N',page.indexOf('nextPageToken')) && page.indexOf('N',page.indexOf('prevPageToken'))){
                    console.log('jhg');
                    $('.container.button #nextButton').css('display','none');
                }
            }
        });
    });

    $('body').on('click', '#prevButton', function () {
        $.ajax({
            url: '/main/getPrevPage',
            enctype: 'multipart/form-data',
            success: function (data) {
                $('#videoPage').html(data);
                $('html').animate({scrollTop: 0}, 0);
                var page = Cookies.get('page');
                if(~page.indexOf('N',page.indexOf('prevPageToken'))){
                    console.log('jhg');
                    $('.container.button #prevButton').css('display','none');
                }
            }
        });
    });

    $('body').on('click', '#likebutton', function () {
        $.ajax({
            url: '/main/addlike',
            enctype: 'multipart/form-data',
            success: function (data) {
               // console.log('dsds');

            }
        });
    })
});