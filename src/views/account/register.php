<div class="account">
<h3>Регистрация</h3>
<form action="/converter/account/register" method="post" id="registration-form">
    <div id="error-container" style="color: red;"></div>
    <p>Имя<p>
    <p><input type="text" name="first_name" placeholder="Введите имя"></p>
    <p>Фамилия<p>
    <p><input type="text" name="last_name" placeholder="Введите фамилию"></p>
    <p>Логин<p>
    <p><input type="text" name="login" placeholder="Введите логин"></p>
    <p>Пароль<p>
    <p><input type="password" name="password" placeholder="Введите пароль"></p>
    <button type="submit">Зарегистрироваться</button>
    <p>У вас есть учетная запись?-<a href="../account/login">Авторизуйтесь!</a><p>
</form>
</div>
<script src="/converter/public/scripts/register.js"></script>
