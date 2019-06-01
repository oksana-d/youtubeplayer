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
});