<div class="container">
    <div class="container col-sm-10 col-md-8 col-lg-5 col-xl-5">
        <ul class="nav nav-tabs" role="tablist">
            <li><a class="active" href="#signin" role="tab" data-toggle="tab">Авторизация</a></li>
            <li><a href="#signup" role="tab" data-toggle="tab">Регистрация</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active fade show" id="signin">
                <form class="form-horizontal" id="authForm" action="/auth/signin" method="post">
                    <div class="form-group">
                        <label for="EmailAuth">Email</label>
                        <input name="email" type="email" class="form-control" id="EmailAuth">
                    </div>
                    <div class="form-group">
                        <label for="PasswordAuth">Пароль</label>
                        <input name="password" type="password" class="form-control" id="PasswordAuth">
                        <p class="wrongpassword error" id="wrongPassword"></p>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark">Войти</button>
                    </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="signup">
                <form class="form-horizontal" id="RegistrationForm" action="/auth/signup" method="post">
                    <div class="form-group">
                        <label for="Firstname">Имя</label>
                        <input name="firstname" type="text" class="form-control" id="Firstname">
                    </div>
                    <div class="form-group">
                        <label for="Lastname">Фамилия</label>
                        <input name="lastname" type="text" class="form-control" id="Lastname">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input name="email" type="email" class="form-control" id="Email">
                    </div>
                    <div class="form-group">
                        <label for="Password">Пароль</label>
                        <input name="password" type="password" class="form-control" id="Password">
                        <p class="registrationerror error" id="registrationError"></p>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>