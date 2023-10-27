<html>
<head>
    <title>Конвертер валют</title>
</head>
<body>
    <div class='container'>
        <form action='/converter/user/converter' method='post'>
            <p>Из валюты</p>
            <select name='from_currency' required id='fromCurrency'>
                <option value='643'>Российский рубль</option>
                <?php foreach ($valutes as $value):?>
                    <option value='<?php echo($value['num_code']);?>'><?php echo($value['valute']);?></option>
                <?php endforeach;?>
            </select>
            <p>Сумма для конвертации</p>
            <input type='text' name='from' id='fromAmount' required pattern='^\d+(\.\d{1,8})?$'>
                <p><small>Разделитель допускается только в виде точки.<br>
                        Максимальная длина дробной части 8 символов после разделителя.</small></p>
            <p>В валюту</p>
            <select name='to_currency' required id='toCurrency'>
                <option value='643'>Российский рубль</option>
                <?php foreach ($valutes as $value):?>
                    <option value='<?php echo($value['num_code']);?>'><?php echo($value['valute']);?></option>
                <?php endforeach;?>
            </select>
            <p>Результат</p>
            <input type='text' name='to' id='amount'readonly>
            <button type='submit'>Конвертировать</button>
        </form>
        <a href="../user/rate" class='back'>Вернуться к курсу валют</a>
        <a href="../user/logout" class='logout'>Выход</a>
        <script src="/converter/public/scripts/converter.js"></script>
    </div>
</body>
</html>
