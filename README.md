## Конвертер валют

Конвертер валют 

## Требования

1. PHP 8.2
2. Apache
3. MySQL

## Настройка 

В src/config/db.php впишите данные для подключения к БД.

## Cron

Относительный путь к скрипту обновления данных к БД src/cron/cron.php

1. Запустите cron в терминале
+ crontab -e

2. Впишите инструкцию
+  * */3 * * * [путь к интерпретатору] [абсолютный путь к исполняемому файлу] данный скрипт будет выполняться каждые 3 часа
