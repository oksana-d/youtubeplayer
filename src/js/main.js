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
});