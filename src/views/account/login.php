<div class="account">
    <h3>Авторизация</h3>
    <form action="/converter/account/login" method="post">
        <div class="error-message" style="color: red;"></div>
        <p>Логин</p>
        <p><input type="text" name="login" placeholder="Введите логин"></p>
        <p>Пароль</p>
        <p><input type="password" name="password" placeholder="Введите пароль"></p>
        <button type="submit">Войти</button>
        <p>Нет логина?-<a href="../account/register">Зарегистрируйся!</a></p>
    </form>
</div>
<script src="/converter/public/scripts/login.js"></script>
