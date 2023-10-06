<html>
<head>
    <title>Курс валют</title>
</head>
<body>
    <div class="container">
    <h3>Актуальный курс валют на <?= $rates[0]['update_time'];?> МСК</h3>
    <table border="1">
        <tr>
            <th>Цифровой код</th>
            <th>Буквенный код</th>
            <th>Единиц</th>
            <th>Валюта</th>
            <th>Курс</th>
        </tr>
        <?php foreach ($rates as $value): ?>
        <tr>
            <td><?= $value['num_code']; ?></td>
            <td><?= $value['char_code']; ?></td>
            <td><?= $value['nominal']; ?></td>
            <td><?= $value['valute']; ?></td>
            <td><?= $value['rate']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <a href="../user/converter" class="next">Перейти в конвертер</a>
    <a href="../user/logout" class="logout">Выход</a>
</body>
</html>